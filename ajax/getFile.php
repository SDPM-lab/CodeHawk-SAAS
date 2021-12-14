<?php
    session_start();
    if (isset($_SESSION['id']) && isset($_SESSION['projectId'])) {
        include_once('../db/dbFile.php');
        $db = new dbFile();

        $infoArr = array(
            'ownerId' => $_SESSION['id'],
            'projectId' => $_SESSION['projectId']
        );

        $outPutArray = array();
        if ($result = $db->getFile($infoArr)) {
            while($obj = $result->fetch_object()){
                $outPutArray[] = array(
                    "fileName" => $obj->fileName,
                    "fileId" => $obj->fileId,
                    "uploadDate" => $obj->uploadDate
                );
            }

            echo json_encode($outPutArray);
			exit();
        }
    }
?>