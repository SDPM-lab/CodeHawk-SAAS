<?php
    session_start();
    if( isset($_SESSION['id']) && isset( $_POST['projectName'] ) ){
        include_once("../db/dbProject.php");
        $db = new dbProject;

        $ownerId = $_SESSION['id'];
        $projectName = "";
        // 驗證使用者輸入資料
        if (empty($_POST["projectName"]) && $_POST["projectName"] != 0) {
            echo json_encode(array("status" => 2,
                                    "msg" => "專案名稱不能為空"));
            exit();
        } 
        else {
            $projectName = test_input($_POST["projectName"]);
        }

        date_default_timezone_set("Asia/Taipei");

        $infoArr = array(
            "ownerId" => $ownerId,
            "projectName" => $projectName,
            "initiateDate" => date("Y-m-d H:i:s")
        );

        if($db->checkProjectName($infoArr)){
            echo json_encode(array("status" => 2,
                                    "msg" => "專案已存在"));
            exit();
        }

        if($insert_id = $db->addProject($infoArr)){
            if(!mkdir("../upload/" . $ownerId . "/" . $insert_id) ){
                echo json_encode(array("status" => 2,
                                        "msg" => "系統錯誤，請稍後再試"));
                exit();
            }else{
                echo json_encode(array("status" => 1));
                exit();
            }
        }else{
            echo json_encode(array("status" => 2,
                                    "msg" => "系統錯誤，請稍後再試"));
            exit();
        }

    }

    function test_input($data)
    {
        $data = trim($data);                //刪除字串前後空白區域
        $data = stripslashes($data);        //去除多餘反斜線
        $data = htmlspecialchars($data);    //轉換 HTML 特殊符號為僅能顯示用的編碼
        return $data;
    }
?>