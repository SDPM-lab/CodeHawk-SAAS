<?php
    session_start();
    if ( isset($_SESSION['id']) &&isset($_POST['projectId'])) {
        include_once("../db/dbProject.php");
        include_once("../db/dbFile.php");
        $dbProject = new dbProject;
        $dbFile = new dbFile;
        $projectId = $_POST["projectId"];
        $ownerId = $_SESSION["id"];

        $infoArr = array(
            "projectId" => $projectId,
            "ownerId" => $ownerId
        );

        if($dbProject->deleteProjectById($infoArr) && $dbFile->deleteFileByProject($infoArr)){
            // deldir("../upload/" . $ownerId . "/" . $projectId . "/");
            echo json_encode(array("status" => 1));
            exit();
        }else{
            echo json_encode(array("status" => 2,
                                    "msg" => "系統錯誤，請重新再試"));
            exit();
        }
    }

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