<?php
    session_start();
    if( isset($_SESSION['id']) && isset($_SESSION['username'])){
        include_once('../db/dbUsers.php');
        $db = new dbUsers();

        $infoArr = array(
            "id" => $_SESSION['id'],
            "username" => $_SESSION['username']
        );

        if($result = $db->getUser($infoArr)){
            $outPutArray = array(
                "username" => $result->username,
                "password" => $result->password,
                "email" => $result->email
            );
            echo json_encode(array("status" => 1,
                                    "user" => $outPutArray));
        }else {
            echo json_encode(array("status" => 2,
                                    "msg" => "系統錯誤，請重新再試"));
        }
    }
?>