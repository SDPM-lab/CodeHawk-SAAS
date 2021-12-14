<?php
    session_start();
    if( isset($_SESSION['id']) && isset($_SESSION['username']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) ){
        include_once('../db/dbUsers.php');
        $db = new dbUsers();

        $account = array(
            "id" => $_SESSION['id'],
            "username" => $_SESSION['username']
        );
        $infoArr = array(
            "id" => $_SESSION['id'],
            "username" => $_POST['username'],
            "password" => $_POST['password'],
            "email" => $_POST['email']
        );

        if($result = $db->getUser($account)){
            if($result->username != $infoArr['username']){
                if($db->checkUser($infoArr['username'])){
                    echo json_encode(array("status" => 2,
                                            "msg" => "帳號已有人使用"));
                    exit();
                }else{
                    echo json_encode(array("status" => 2,
                                            "msg" => "系統錯誤，請重新再試"));
                }
            }
        }

        if($db->updateUser($infoArr)){
            $_SESSION['id'] = $infoArr['id'];
            $_SESSION['username'] = $infoArr['username'];
			echo json_encode(array("status" => 1));
        }else{
            echo json_encode(array("status" => 2,
                                    "msg" => "系統錯誤，請重新再試"));
        }
    }

?>