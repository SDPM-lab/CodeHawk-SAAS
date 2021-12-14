<?php
    include_once("dbFunctions.php");
    class dbFunctionPointRecord extends dbFunctions{

        //紀錄 Function Point
        public function addRecord($info){
            $sql = "INSERT INTO function_point_record(fileId,recordDate,elementType,elementName,functionName,functionPoint)
                    VALUES('{$info['fileId']}','{$info['recordDate']}','{$info['elementType']}'
                            ,'{$info['elementName']}','{$info['functionName']}','{$info['functionPoint']}')";
            if($this->sqlQuery($sql)){
                return true;
            }else{
                return false;
            }
        }

        //取得具有分析檔案的專案資料
        public function getProjectRecord($info){
            $sql = "SELECT project.projectName,file.projectId
                    FROM file LEFT JOIN project
                        ON file.projectId = project.projectId
                    INNER JOIN function_point_record AS FPR
                        ON file.fileId = FPR.fileId
                    WHERE file.ownerId = '{$info}' AND file.deleted = 0
                    GROUP BY  project.projectName
                    ORDER BY file.projectId";
            if($result = $this->sqlQuery($sql)){
                return $result;
            }else{
                return false;
            }
        }

        //取得分析結果
        public function getFileRecord($info){
            $sql = "SELECT file.fileId, file.fileName
                    FROM file INNER JOIN function_point_record AS FPR
                        ON file.fileId = FPR.fileId
                    WHERE file.ownerId = '{$info['ownerId']}' AND file.projectId = '{$info['projectId']}' AND file.deleted = 0
                    GROUP BY file.fileId";
            if($result = $this->sqlQuery($sql)){
                return $result;
            }else{
                return false;
            }
        }//取得分析結果
        public function getRecord($info){
            $sql = "SELECT file.fileId, file.fileName, FPR.elementType, FPR.elementName, FPR.functionName,
                            FPR.functionPoint,FPR.recordDate
                    FROM file INNER JOIN function_point_record AS FPR
                        ON file.fileId = FPR.fileId
                    WHERE file.ownerId = '{$info['ownerId']}' AND file.projectId = '{$info['projectId']}' 
                        file.fileId = '{$info['fileId']}' AND file.deleted = 0";
            if($result = $this->sqlQuery($sql)){
                return $result;
            }else{
                return false;
            }
        }
        
    }

?>