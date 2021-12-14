<?php
    session_start();
    if( isset($_SESSION['id']) && isset($_SESSION['projectId']) && isset($_POST['fileId']) && isset($_POST['analyzeResult']) ){
        include_once("../db/dbFunctionPointRecord.php");
        $db = new dbFunctionPointRecord;
        $fileId = $_POST['fileId'];

        // echo json_encode(array("msg" => $_POST['analyzeResult'][0]["elementType"] ));
        $analyzeResult = $_POST['analyzeResult'];

        date_default_timezone_set("Asia/Taipei");
        $timestamp = microtime(true);   // Return current Unix timestamp with microseconds
        $time = floor($timestamp);
        $millisecond = round(($timestamp - $time) * 1000);
        
        $outPutArray = array();
        foreach ($analyzeResult as $record){
            $infoArr = array(
                "fileId" => $fileId,
                "recordDate" => date("Y-m-d H:i:s", $time) . $millisecond,
                "elementType" => $record["elementType"],
                "elementName" => $record["elementName"],
                "functionName" => $record["functionName"],
                "functionPoint"=> $record["functionPoint"]
            );

            if(!$db->addRecord($infoArr)){
                echo json_encode(array("status" => 2,
                                        "msg" => "系統錯誤，請稍後再試"));
                exit();
            }
        }
        echo json_encode(array("status" => 1));
    }
?>