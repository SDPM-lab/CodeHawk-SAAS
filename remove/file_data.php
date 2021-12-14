<?php
include "database_field.php";
include "file.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["operation"]) && $_POST["operation"] == "delete") {  // 刪除檔案
        $deleteFile = $_POST["filePath"];
        $filePath = explode("/", $deleteFile, -1);
        $deleteDir = $filePath[0] . "/" . $filePath[1] . "/" . $filePath[2] . "/" . $filePath[3];

        if (unlink($deleteFile) && rmdir($deleteDir)) {
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("DELETE FROM file WHERE projectId = ? AND ownerId = ? AND filePath = ?");
            $projectId = $_POST["projectId"];
            $ownerId = $_SESSION["id"];
            $stmt->bind_param("iis", $projectId, $ownerId, $deleteFile);
            $stmt->execute();

            $stmt->close();
            $conn->close();
            echo "delete success";
        } else {
            echo "delete failed";
        }
    } else {  // 上傳檔案
        date_default_timezone_set("Asia/Taipei");
        $timestamp = microtime(true);
        $time = floor($timestamp);
        $millisecond = round(($timestamp - $time) * 1000);

        $target_dir = "upload/" . $_SESSION["id"] . "/" . $_POST["projectId"] . "/" . date("Y-m-d H-i-s.", $time) . $millisecond;
        if (!mkdir($target_dir)) {
            echo "檔案資料夾新增失敗";
            exit;
        }
        $target_file = $target_dir . "/" . basename($_FILES["files"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (file_exists($target_file)) {
            echo "檔案已存在";
            exit;
        }
        if ($_FILES["files"]["size"] > 500000) {
            echo "檔案過大";
            exit;
        }
        if ($imageFileType != "xml" && $imageFileType != "xmi") {
            echo "不支援的檔案格式";
            exit;
        }
        if (move_uploaded_file($_FILES["files"]["tmp_name"], $target_file)) {
            $conn = new mysqli($servername, $username, $password, $dbname);
            mysqli_set_charset($conn, "utf8");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $stmt = $conn->prepare("INSERT INTO file (ownerId, projectId, filePath, uploadDate) VALUES (?, ?, ?, ?)");
            $ownerId = $_SESSION["id"];
            $projectId = $_POST["projectId"];
            $uploadDate = date("Y-m-d H:i:s.", $time) . $millisecond;
            $stmt->bind_param("iiss", $ownerId, $projectId, $target_file, $uploadDate);
            $stmt->execute();

            $stmt->close();
            $conn->close();
        } else {
            echo "上傳時發生錯誤";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {  // 取得檔案資料
    $conn = new mysqli($servername, $username, $password, $dbname);
    mysqli_set_charset($conn, "utf8");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT filePath, uploadDate FROM file WHERE projectId = " . $_GET["projectId"] . " AND ownerId = " . $_SESSION["id"];
    $result = $conn->query($sql);

    $fileAry = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $file = new File();
            $file->ownerId = $_SESSION["id"];
            $file->projectId = $_GET["projectId"];

            $filePath = explode("/", $row["filePath"]);
            $length = count($filePath);
            $fileName = $filePath[$length - 1];
            $file->fileName = $fileName;

            $file->filePath = $row["filePath"];
            $file->uploadDate = $row["uploadDate"];
            array_push($fileAry, $file);
        }
    }

    $conn->close();
    echo json_encode($fileAry);
}
