<?php
    session_start();
    if( isset($_SESSION['id']) && isset($_SESSION['projectId']) && isset($_FILES['file']) ){
        include_once("../db/dbFile.php");
        $db = new dbFile;

        $ownerId = $_SESSION['id'];
        $projectId = $_SESSION['projectId'];
        $fileName = $_FILES['file']['name'];

        date_default_timezone_set("Asia/Taipei");
        $timestamp = microtime(true);   // Return current Unix timestamp with microseconds
        $time = floor($timestamp);
        $millisecond = round(($timestamp - $time) * 1000);

        $target_dir = "../upload/" . $ownerId . "/" . $projectId . "/" . date("Y-m-d H-i-s.", $time) . $millisecond;

        $target_file = $target_dir . "/" . basename($fileName);   //v
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));    // pathinfo 返回有關文件路徑的信息

        // 檢查檔案格式是否為 xml or xmi
        if ($imageFileType != "xml" && $imageFileType != "xmi") {
            echo json_encode(array("status" => 2,
                                   "msg" => "不支援的檔案格式"));
            exit();
        }
        // 檢查檔案大小是否大於 500000 KB
        if ($_FILES["file"]["size"] > 500000) {
            echo json_encode(array("status" => 2,
                                   "msg" => "檔案過大"));
            exit();
        }
        // 檢查檔案是否已存在
        if (file_exists($target_file)) {
            echo json_encode(array("status" => 2,
                                   "msg" => "檔案已存在"));
            exit();
        }
        if (!mkdir($target_dir)) {
            echo json_encode(array("status" => 2,
                                    "msg" => "系統錯誤，請重新再試"));
            exit();
        }

        $infoArr = array(
            "ownerId" => $ownerId,
            "projectId" => $projectId,
            "fileName" => $fileName,
            "filePath" => $target_file,
            "uploadDate" => date("Y-m-d H:i:s", $time) . $millisecond
        );

        // move_uploaded_file 會覆蓋已存在的檔案； tmp_name：上傳檔案後的暫存資料夾位置
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            if($db->addFile($infoArr)){
                echo json_encode(array("status" => 1));
            }else{
                echo json_encode(array("status" => 2,
                                        "msg" => "資料庫連線失敗，請稍後再試"));
            }
        }
    }
?>