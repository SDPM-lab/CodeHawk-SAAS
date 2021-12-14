<?php
    session_start();
    include_once("database_field.php");
    include_once("project.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["operation"]) && $_POST["operation"] == "delete") {  // 刪除專案
            include_once("db/dbProject.php");
            $db = new dbProject;
            $projectId = $_POST["projectId"];
            $ownerId = $_SESSION["id"];

            $infoArr = array(
                "projectId" => $projectId,
                "ownerId" => $ownerId
            );

            if($result = $db->deleteProjectById($infoArr)){
                deldir("upload/" . $ownerId . "/" . $projectId . "/");

                echo "delete success";
                exit;
            }else{
                echo "delete fail";
            }        

        } else if (isset($_POST["operation"]) && $_POST["operation"] == "add") {  // 新增專案
            include_once("db/dbProject.php");
            $db = new dbProject;
            $ownerId = $_SESSION["id"];

            $projectName = "";
            // 驗證使用者輸入資料
            if (empty($_POST["projectName"]) && $_POST["projectName"] != "0") {
                echo "專案名稱不能為空";
                exit;
            } else {
                $projectName = test_input($_POST["projectName"]);
            }

            date_default_timezone_set("Asia/Taipei");

            $infoArr = array(
                "ownerId" => $ownerId,
                "projectName" => $projectName,
                "initiateDate" => date("Y-m-d H:i:s")
            );

            if($insert_id = $db->addProject($infoArr)){
                if (!mkdir("upload/" . $ownerId . "/" . $insert_id)) {  /// 這樣寫好嗎？ + dbFunctions/addProject()
                    echo "建立專案資料夾失敗";
                    exit;
                }else{
                    echo "add success";
                    exit;
                }
            }else{
                echo "add fail";
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {  // 取得專案資料
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT project.projectId, projectName, initiateDate, COUNT(filePath) AS fileNumber
        FROM project LEFT JOIN file 
        ON project.ownerId = file.ownerId
        AND project.projectId = file.projectId 
        WHERE project.ownerId = " . $_SESSION["id"] . " GROUP BY projectId";

        $result = $conn->query($sql);

        $projectAry = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $project = new Project();
                $project->ownerId = $_SESSION["id"];
                $project->projectId = $row["projectId"];
                $project->projectName = $row["projectName"];
                $project->numberOfFiles = $row["fileNumber"];
                $project->initiateDate = $row["initiateDate"];
                array_push($projectAry, $project);
            }
        }

        $conn->close();
        echo json_encode($projectAry);
    }


    function test_input($data)
    {
        $data = trim($data);            //刪除字串前後空白區域
        $data = stripslashes($data);    //去除多餘反斜線
        $data = htmlspecialchars($data);//轉換 HTML 特殊符號為僅能顯示用的編碼
        return $data;
    }

    // 刪除資料夾
    function deldir($path)
    {
        if (is_dir($path)) {
            $p = scandir($path);
            foreach ($p as $val) {
                if ($val != "." && $val != "..") {
                    if (is_dir($path . $val)) {
                        deldir($path . $val . '/');
                        rmdir($path . $val . '/');
                    } else {
                        unlink($path . $val);
                    }
                }
            }
            rmdir($path);
        }
    }
?>