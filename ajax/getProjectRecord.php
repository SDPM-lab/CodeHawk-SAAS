<?php
    session_start();
    if (isset($_SESSION['id'])) {
        include_once("../db/dbFunctionPointRecord.php");
        $db = new dbFunctionPointRecord;
        $ownerId = $_SESSION['id'];

        if ($result = $db->getProjectRecord($ownerId)) {
            while($obj = $result->fetch_object()){
                $outPutArray[] = array(
                    "projectName" => $obj->projectName,
                    "projectId" => $obj->projectId
                );
            }

            echo json_encode($outPutArray);
			exit();
        }
    }

?>