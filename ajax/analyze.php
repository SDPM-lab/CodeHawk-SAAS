<?php
    include "xml.php";
    $Xml= new _Xml();

    $lastTag = "";
    $currentElement = 0;        //用來判斷目前位於第幾個元件 Component(0) Interface(1) Class(2)
    $currentOperation = 0;      //用來判斷目前位於component/class中，第幾個operation
    $functionPoint = 0;

    function startElement($parser, $name, $attribs){
        if($GLOBALS["lastTag"] != "UML:PARAMETER.TYPE") {
            switch($name){
                case "UML:COMPONENT":
                    if(!empty($attribs["XMI.ID"])){
                        echo "</div><div><ul><h4>◎ " . $attribs["NAME"] . "</h4>";
                        $Element = new _Element();
                        $Element->type = 0;
                        $Element->Name = $attribs["NAME"];
                        $Element->id = $attribs["XMI.ID"];
                        $GLOBALS["Xml"]->Element[] = $Element;
                    }
                    break;
                case "UML:INTERFACE":
                    if(!empty($attribs["XMI.ID"])){
                        echo "</div><div><ul><h4> ◇ " . $attribs["NAME"] . "</h4>";
                        $Element = new _Element();
                        $Element->type = 1;
                        $Element->Name = $attribs["NAME"];
                        $Element->id = $attribs["XMI.ID"];
                        $GLOBALS["Xml"]->Element[] = $Element;
                    }
                    break;
                case "UML:CLASS":
                    if(!empty($attribs["XMI.ID"])){
                        echo "</div><div><ul><h4> ○ " . $attribs["NAME"] . "</h4>";
                        $Element = new _Element();
                        $Element->type = 2;
                        $Element->Name = $attribs["NAME"];
                        $Element->id = $attribs["XMI.ID"];
                        $GLOBALS["Xml"]->Element[] = $Element;
                    }
                    break;
                case "UML:OPERATION":
                    echo "<li>　　" . $attribs["VISIBILITY"] . " ";
                    $Operation = new _Operation();
                    $Operation->Name = $attribs["NAME"];
                    $Operation->visibility = $attribs["VISIBILITY"];
                    $GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[] = $Operation;
                    break;
                case "UML:PARAMETER":
                    //in：即代表函式/方法的parameter list
                    if ($attribs["KIND"] == "in"){  //判斷參數類別-作為回傳類別或是使用參數
                        $GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->kind[] = "in";
                    } else if($attribs["KIND"] == "return") {  //存在return，則表示是函式，而非方法
                        $GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->kind[] = "return";
                        $GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->isVoid = false;
                    }
                    $GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->Parameter[] = $attribs["NAME"];  //參數名稱
                    break;
            }
        }else{
            switch ($name) {
                case "UML:DATATYPE":
                case "UML:ENUMERATION":
                    if ($attribs["HREF"] == "http://argouml.org/profiles/uml14/default-uml14.xmi#-84-17--56-5-43645a83:11466542d86:-8000:000000000000087C") {
                        $GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->DataType[] = "Integer";
                    } elseif ($attribs["HREF"] == "http://argouml.org/profiles/uml14/default-uml14.xmi#-84-17--56-5-43645a83:11466542d86:-8000:0000000000000880") {
                        $GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->DataType[] = "Boolean";
                    } elseif ($attribs["HREF"] == "http://argouml.org/profiles/uml14/default-uml14.xmi#-84-17--56-5-43645a83:11466542d86:-8000:000000000000087E") {
                        $GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->DataType[] = "String";
                    } elseif ($attribs["HREF"] == "http://argouml.org/profiles/uml14/default-uml14.xmi#-84-17--56-5-43645a83:11466542d86:-8000:000000000000087D") {
                        $GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->DataType[] = "UnlimitedInteger";
                    } else {
                        $GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->DataType[] = "Unknown";
                    }
                    break;
                case "UML:Class":
                    $flag = false;  //判斷 是否為存在/可知的 Class
                    for($i = 0; $i < count($GLOBALS["Xml"]->Element); $i++){
                        if($GLOBALS["Xml"]->Element[$i]->type == 2){
                            if($attribs["xmi.idref"] == $GLOBALS["Xml"]->Element[$i]->id){
                                $GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->DataType[] = $GLOBALS["Xml"]->Element[$i]->Name;
                                $flag = true;
                            }
                        }

                    }
                    if(!$flag){
                        $GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->DataType[] = "Unknown";
                    }
                    break;
            }
        }
        $GLOBALS["lastTag"] = $name;
    }

    function stopElement($parser, $name){
        switch($name){
            case "UML:COMPONENT":
                echo "</ul></div><br>";
                $GLOBALS["currentElement"]++;
                $GLOBALS["currentOperation"] = 0;
                break;
            case "UML:Class":
                echo "</ul></div><br>";
                $GLOBALS["currentElement"]++;
                $GLOBALS["currentOperation"] = 0;
                break;
            case "UML:INTERFACE":
                echo "</ul></div><br>";
                $GLOBALS["currentElement"]++;
                $GLOBALS["currentOperation"] = 0;
                break;
            case "UML:OPERATION":                
                if( $GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->isVoid ){
                    echo "void ";
                    $GLOBALS["functionPoint"]++;
                }else{
                    $returnIndex = array_search("return", $GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->kind);
                    if( isset($GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->DataType[$returnIndex]) ){
                        echo $GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->DataType[$returnIndex] . " ";
                        $GLOBALS["functionPoint"]+=2;
                    }
                }
                echo $GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->Name . " ( ";

                $otherParameter = 0;
                for($i = 0; $i < count($GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->kind) ; $i++ ){
                    if( $GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->kind[$i] == "in" ){
                        if($otherParameter == 1){
                            echo ", ";
                        }
                        if( isset($GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->DataType[$i]) && 
                        isset($GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->Parameter[$i])){
                            echo $GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->DataType[$i] . " " . 
                            $GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->Parameter[$i];
                            $GLOBALS["functionPoint"]++;
                        }
                    }
                    $otherParameter == 1;
                }
                
                $GLOBALS["currentOperation"]++;
                echo " )</li><br>";
                echo "<li>　　功能點：{$GLOBALS["functionPoint"]}</li><br>";
                $GLOBALS["functionPoint"] = 0;
                break;
            case "UML:Parameter.type":
                break;
        }   
    }

    function characterData($parser, $data){
        // echo $data;
        // echo "<br>";
    }

    function getPoint(){
        // if(isset($_SESSION["id"]) && isset($_SESSION["projectId"])){
            include_once("analyze_record.php");
            date_default_timezone_set("Asia/Taipei");
            $timestamp = microtime(true);
            $time = floor($timestamp);
            $millisecond = round(($timestamp - $time) * 1000);
            $record = new Record;
            // $record->ownerId = $_SESSION["id"];
            // $record->projectId = $_SESSION["projectId"];
            $record->recordDate = date("Y-m-d H:i:s.", $time) . $millisecond;

            include_once("db/dbFunctions.php");
            $db = new dbFunctions;
            if(count($GLOBALS["Xml"]->Element)>0){
                for($i = 0; $i < count($GLOBALS["Xml"]->Element); $i++){
                    $record->elementType = $GLOBALS["Xml"]->Element[$i]->type;
                    $record->elementName = $GLOBALS["Xml"]->Element[$i]->Name;
                    $functionPoint = 0;
                    for($j = 0 ; $j < count($GLOBALS["Xml"]->Element[$i]->Operaion); $j++){
                        if($GLOBALS["Xml"]->Element[$i]->Operaion[$j]->isVoid){
                            $functionPoint++;
                        }else{
                            $functionPoint += 2;
                        }
                        for($k = 0; $k < count($GLOBALS["Xml"]->Element[$i]->Opration[$j]->kind); $k++){
                            if($GLOBALS["Xml"]->Element[$i]->Opration[$j]->kind[$i] == "in"){
                                $functionPoint++;
                            }
                        }
                        $record->functionName = $GLOBALS["Xml"]->Element[$i]->Opration[$j]->Name;
                        $record->functionPoint = $functionPoint;
                        // if(!$db->addRecord($record)){
                        //     echo "資料庫錯誤。";
                        //     exit();
                        // }
                    }
                }
            }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $filePath = $_POST["filePath"];
        
        $parser = xml_parser_create(); // Initialize the XML parser

        // $caseFold = xml_parser_get_option($xmlParser,XML_OPTION_CASE_FOLDING);
        // $targetEncoding = xml_parser_get_option($xmlParser,XML_OPTION_TARGET_ENCODING);
        // if ($caseFold == 1) {
        //     xml_parser_set_option($xmlParser, XML_OPTION_CASE_FOLDING, false);
        // }

        // Specify data handler
        xml_set_character_data_handler($parser, "characterData");
        // Specify element handler
        xml_set_element_handler($parser, "startElement", "stopElement");
        
        // Open XML file
        if(!($file = fopen($filePath, "r"))){
            die("Cannot open XML data file: $filePath");
        }

        while($data = fread($file, 4096)){
            // feof() 函数檢測是否已到達文件末尾 (eof)。
            xml_parse($parser, $data, feof($file)) or
            // die() 函數輸出一條消息，並退出當前腳本
            // sprintf() 函數把格式化的字符串寫入一個變量中。
            die(sprintf("XML Error: %s at line %d",
                xml_error_string(xml_get_error_code($parser)),
                xml_get_current_line_number($parser)));
        }
        xml_parser_free($parser);       // Free the XML parser
        fclose($file);
        // print($GLOBALS["Xml"]->Interface[0]->Operation[0]->Name);
        // getPoint();
    }

?>