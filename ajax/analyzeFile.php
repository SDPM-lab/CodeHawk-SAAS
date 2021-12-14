<?php
    session_start();
    if( isset($_SESSION['id']) && isset($_SESSION['projectId']) && isset($_POST['fileId']) ){
        include_once("../db/dbFile.php");
        $db = new dbFile;
        $fileId = $_POST['fileId'];
        $filePath = ""; //欲分析之檔案路徑

        if($result = $db->getFilePath($fileId)){
            $filePath = $result;
        }else{
            echo json_encode(array("status" => 2));
            exit();
        }

        include_once("xml.php");
        $Xml= new _Xml();

        $lastTag = "";
        //用來判斷目前位於第幾個元件 Component(0) Interface(1) Class(2)
        $currentElement = 0;
        //用來判斷目前位於component/class中，第幾個operation
        $currentOperation = 0;

        // Initialize the XML parser
        $parser = xml_parser_create();
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
        // Free the XML parser
        xml_parser_free($parser);       
        fclose($file);

        if (count($Xml->Element)>0) {
            $outPutArray = array();
            $i = 0;
            foreach ($Xml->Element as $element){
                foreach($element->Operation as $operation){   
                    $functionPoint = 0;
                    if($operation->isVoid){
                        $functionPoint++;
                    }else{
                        $functionPoint += 2;
                    }
                    foreach($operation->kind as $kind){
                        if($kind == "in"){
                            $functionPoint++;
                        }
                    }
                    $outPutArray[] = array(
                        "elementType" => $element->type ?? "Unknow",
                        "elementName" => $element->Name ?? "Unknow",
                        "functionName" => $operation->Name,
                        "visibility" => $operation->Visibility,
                        "isVoid" => $operation->isVoid,
                        "parameter" => $operation->Parameter,
                        "parameterKind" => $operation->kind,
                        "parameterDataType" => $operation->DataType,
                        "functionPoint" => $functionPoint
                    );

                }
            }
            echo json_encode($outPutArray);
            // exit();
        }
        
    }

    function startElement($parser, $name, $attribs){
        if($GLOBALS["lastTag"] != "UML:PARAMETER.TYPE") {
            switch($name){
                case "UML:COMPONENT":
                    if(!empty($attribs["XMI.ID"])){
                        $Element = new _Element();
                        $Element->type = 0;
                        $Element->Name = $attribs["NAME"];
                        $Element->id = $attribs["XMI.ID"];
                        $GLOBALS["Xml"]->Element[] = $Element;
                    }
                    break;
                case "UML:INTERFACE":
                    if(!empty($attribs["XMI.ID"])){
                        $Element = new _Element();
                        $Element->type = 1;
                        $Element->Name = $attribs["NAME"];
                        $Element->id = $attribs["XMI.ID"];
                        $GLOBALS["Xml"]->Element[] = $Element;
                    }
                    break;
                case "UML:CLASS":
                    if(!empty($attribs["XMI.ID"])){
                        $Element = new _Element();
                        $Element->type = 2;
                        $Element->Name = $attribs["NAME"];
                        $Element->id = $attribs["XMI.ID"];
                        $GLOBALS["Xml"]->Element[] = $Element;
                    }
                    break;
                case "UML:OPERATION":
                    $Operation = new _Operation();
                    $Operation->Name = $attribs["NAME"];
                    $Operation->Visibility = $attribs["VISIBILITY"];
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
                    // foreach($GLOBALS["Xml"]->Element as $element){
                    //     if($element->type = 2){
                    //         if($attribs["xmi.idref"] == $element->id){
                    //             $GLOBALS["Xml"]->Element[$GLOBALS["currentElement"]]->Operation[$GLOBALS["currentOperation"]]->DataType[] = $element->Name;
                    //             $flag = true;
                    //         }
                    //     }
                    // }
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
                $GLOBALS["currentElement"]++;
                $GLOBALS["currentOperation"] = 0;
                break;
            case "UML:Class":
                $GLOBALS["currentElement"]++;
                $GLOBALS["currentOperation"] = 0;
                break;
            case "UML:INTERFACE":
                $GLOBALS["currentElement"]++;
                $GLOBALS["currentOperation"] = 0;
                break;
            case "UML:OPERATION":
                
                $GLOBALS["currentOperation"]++;
                break;
            case "UML:Parameter.type":
                break;
        }   
    }

    function characterData($parser, $data){
        // echo $data;
        // echo "<br>";
    }
?>