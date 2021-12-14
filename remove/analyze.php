<?php
$parser = xml_parser_create(); // Initialize the XML parser
$component = 0;
$index = 0;
$parameters = array();
$dataType = array();
$kind = array();
$operationName = "";
$functionPoint = 0;

// Function to use at the start of an element
function start($parser, $element_name, $element_attrs)
{
    switch ($element_name) {
        case "UML:COMPONENT":
            if (!empty($element_attrs["XMI.ID"])) {
                echo "<div><h4>" . $element_attrs["NAME"] . "</h4><ul>";
            }
            break;
        case "UML:OPERATION":
            $GLOBALS["operationName"] = $element_attrs["NAME"];
            echo "<li>" . $element_attrs["VISIBILITY"] . " ";
            break;
        case "UML:PARAMETER":
            if ($element_attrs["KIND"] == "in") {
                $GLOBALS["kind"][$GLOBALS["index"]] = "in";
            } else if ($element_attrs["KIND"] == "return") {
                $GLOBALS["kind"][$GLOBALS["index"]] = "return";
            }
            $GLOBALS["parameters"][$GLOBALS["index"]] = $element_attrs["NAME"];
            break;
        case "UML:DATATYPE":
        case "UML:ENUMERATION":
            if ($element_attrs["HREF"] == "http://argouml.org/profiles/uml14/default-uml14.xmi#-84-17--56-5-43645a83:11466542d86:-8000:000000000000087C") {
                $GLOBALS["dataType"][$GLOBALS["index"]] = "Integer";
            } else if ($element_attrs["HREF"] == "http://argouml.org/profiles/uml14/default-uml14.xmi#-84-17--56-5-43645a83:11466542d86:-8000:0000000000000880") {
                $GLOBALS["dataType"][$GLOBALS["index"]] = "Boolean";
            } else if ($element_attrs["HREF"] == "http://argouml.org/profiles/uml14/default-uml14.xmi#-84-17--56-5-43645a83:11466542d86:-8000:000000000000087E") {
                $GLOBALS["dataType"][$GLOBALS["index"]] = "String";
            } else if ($element_attrs["HREF"] == "http://argouml.org/profiles/uml14/default-uml14.xmi#-84-17--56-5-43645a83:11466542d86:-8000:000000000000087D") {
                $GLOBALS["dataType"][$GLOBALS["index"]] = "UnlimitedInteger";
            } else {
                $GLOBALS["dataType"][$GLOBALS["index"]] = "Unknown";
            }
            $GLOBALS["index"]++;
            break;
    }
}

// Function to use at the end of an element
function stop($parser, $element_name)
{
    switch ($element_name) {
        case "UML:COMPONENT":
                echo "</ul></div><br>";
            break;
        case "UML:OPERATION":
            if (in_array("return", $GLOBALS["kind"])) {
                $returnIndex = array_search("return", $GLOBALS["kind"]);
                echo $GLOBALS["dataType"][$returnIndex] . " " . $GLOBALS["operationName"] . " ( ";
                $GLOBALS["functionPoint"]+=2;
            } else {
                echo "void " . $GLOBALS["operationName"] . " ( ";
                $GLOBALS["functionPoint"]++;
            }

            $otherParameter = 0;
            for ($x = 0; $x < $GLOBALS["index"]; $x++) {
                if ($GLOBALS["kind"][$x] == "in") {
                    if ($otherParameter == 1) {
                        echo ", ";
                    }
                    echo $GLOBALS["dataType"][$x] . " " . $GLOBALS["parameters"][$x];
                    $GLOBALS["functionPoint"]++;
                    $otherParameter = 1;
                }
            }
            echo " )</li><br>";
            $GLOBALS["index"] = 0;
            $GLOBALS["parameters"] = array();
            $GLOBALS["kind"] = array();
            $GLOBALS["dataType"] = array();
            $GLOBALS["operationName"] = "";
            break;
    }
}

// Function to use when finding character data
function char($parser, $data)
{
    //echo $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filePath = $_POST["filePath"];
    // Specify element handler
    xml_set_element_handler($parser, "start", "stop");

    // Specify data handler
    xml_set_character_data_handler($parser, "char");

    // Open XML file
    $fp = fopen($filePath, "r");

    // Read data
    while ($data = fread($fp, 4096)) {
        xml_parse($parser, $data, feof($fp)) or
            die(sprintf(
                "XML Error: %s at line %d",
                xml_error_string(xml_get_error_code($parser)),
                xml_get_current_line_number($parser)
            ));
    }

    // Free the XML parser
    xml_parser_free($parser);
    echo "功能點：{$GLOBALS["functionPoint"]}";
    $GLOBALS["functionPoint"] = 0;
}
