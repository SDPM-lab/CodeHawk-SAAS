<?php
    if ( isset( $_POST['email'] ) && isset( $_POST['username'] ) && isset( $_POST['password'] )) {
        include_once("../db/dbUsers.php");
        $db = new dbUsers;

        $infoArr = array(
            "email" => $_POST['email'],
            "username" => $_POST['username'],
            "password" => $_POST['password']
        );

        if($db->checkUser($infoArr['username'])){
			echo json_encode(array("status" => 2,
                                    "msg" => "帳號已有人使用"));
            exit();
        }

        if($insert_id = $db->addUser($infoArr)){
            mkdir("../upload/" . $insert_id);  // 建立資料夾，用來存放該使用者上傳的檔案
        	echo json_encode(array("status" => 1));
			exit();
        }
        
    }
?>