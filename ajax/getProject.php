<?php
    session_start();
    if( isset($_SESSION['id']) ){
        include_once('../db/dbProject.php');
        $db = new dbProject();
        $outPutArray = array();
        if($result = $db->getProject($_SESSION['id']) ){
            while($obj = $result->fetch_object()){
                $outPutArray[] = array(
                    "projectId" => $obj->projectId,
                    "projectName" => $obj->projectName,
                    "numberOfFile" => $obj->numberOfFile,
                    "initiateDate" => $obj->initiateDate
                );
            }
            echo json_encode($outPutArray);
        }
    }
    
?>