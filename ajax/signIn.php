<?php
    session_start();
    if ( isset( $_POST['username'] ) && isset( $_POST['password'] )) {
        include_once("../db/dbUsers.php");
        $db = new dbUsers;

        $infoArr = array(
            "username" => $_POST['username'],
            "password" => $_POST['password']
        );

        if($result = $db->userLogin($infoArr)){
            $_SESSION['id'] = $result->id;
            $_SESSION['username'] = $result->username;
            $_SESSION['authority'] = $result->authority;
            echo json_encode(array("status" => 1));
        }else{
            echo json_encode(array("status" => 2,
                                    "msg" => "帳號或密碼錯誤"));
        }
    }
?>