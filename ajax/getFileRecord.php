<?php
    session_start();
    if ( isset($_SESSION['id']) && isset($_POST['projectId']) ) {
        include_once("../db/dbFunctionPointRecord.php");
        $db = new dbFunctionPointRecord;
        $infoArr = array(
            "ownerId" => $_SESSION['id'],
            "projectId" => $_POST['projectId']
        );

        $outPutArray = array();
        if ($result = $db->getFileRecord($infoArr)) {
            while($obj = $result->fetch_object()){
                $outPutArray[] = array(
                    "fileId" => $obj->fileId,
                    "fileName" => $obj->fileName
                );
            }

            echo json_encode($outPutArray);
			exit();
        }
    }

?>