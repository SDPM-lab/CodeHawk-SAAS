<?php
    session_start();
    if ( isset($_SESSION['id']) && isset($_POST['projectId']) ){
        include_once("../db/dbProject.php");
        $db = new dbProject;

        $infoArr = array(
            "ownerId" => $_SESSION['id'],
            "projectId" => $_POST['projectId']
        );

        if($db->checkProject($infoArr)){
            $_SESSION['projectId'] = $_POST['projectId'];
            echo json_encode(array("status" => 1));
            exit();
        }

    }
?>