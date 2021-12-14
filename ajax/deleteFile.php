<?php
    session_start();
    if( isset($_SESSION['id']) && isset($_SESSION['projectId']) && $_POST['fileId']) {
        include_once("../db/dbFile.php");
        $db = new dbFile;
        $fileId = $_POST['fileId'];
        // $deleteFile = "";   // 欲刪除的檔案
        // if($result = $db->getFilePath($fileId)){
            // $deleteFile = $result;  // 欲刪除的檔案之路徑
            // $filePath = explode("/", $deleteFile, -1);
            // $deleteDir = $filePath[0] . "/" . $filePath[1] . "/" . $filePath[2] . "/" . $filePath[3] . "/" . $filePath[4];  //欲刪除的檔案目錄
        // }else{
        //     echo json_encode(array("status" => 3,
        //                             "msg" => "系統錯誤，為你重新載入頁面"));
        //     exit();
        // }

        if($db->deleteFile($fileId)){
            // unlink 用於刪除檔案； rmdir用於刪除空目錄
            // if( unlink($deleteFile) && rmdir($deleteDir) ){
            echo json_encode(array("status" => 1));
            // }else{
            //     echo json_encode(array("status" => 2,
            //                             "msg" => "系統錯誤，請重新再試"));
            // }
        }else{
            echo json_encode(array("status" => 2,
                                    "msg" => "刪除檔案失敗，請重新再試"));
        }
        

    }
?>