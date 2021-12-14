<?php
    include_once("dbFunctions.php");
    class dbProject extends dbFunctions{
        //檢查是否有專案是否存在
        public function checkProject($info){
            $sql = "SELECT projectName FROM project
                    WHERE ownerId = '{$info['ownerId']}' AND
                            projectId = '{$info['projectId']}'";
            if($this->sqlQuery($sql)->fetch_object()){
                return true;
            }else{
                return false;
            }
        }

        //檢查是否有專案名稱是否存在
        public function checkProjectName($info){
            $sql = "SELECT projectName FROM project
                    WHERE deleted = FALSE AND ownerId = '{$info['ownerId']}' AND
                            projectName = '{$info['projectName']}'";
            if($this->sqlQuery($sql)->fetch_object()){
                return true;
            }else{
                return false;
            }
        }

        //新增專案
        public function addProject($info){
            $sql = "INSERT INTO project (ownerId, projectName, initiateDate) 
                    VALUES ('{$info['ownerId']}','{$info['projectName']}','{$info['initiateDate']}')";
            if($this->sqlQuery($sql)){
                return $this->db->insert_id;        
            }else{
                return false;
            }
        }

        //刪除專案
        public function deleteProjectById($info){
            $sql = "UPDATE project
                    SET deleted = TRUE
                    WHERE projectId = '{$info['projectId']}' AND ownerId = '{$info['ownerId']}'";
            if($this->sqlQuery($sql)){
                return true;
            }else{
                return false;
            }
        }

        //取得專案
        public function getProject($ownerId){
            $sql = "SELECT project.projectId, projectName, count(filePath) AS numberOfFile, initiateDate
                    FROM project LEFT JOIN file
                        ON project.ownerId = file.ownerId AND project.projectId = file.projectId AND project.deleted = file.deleted
                    WHERE project.ownerId = '{$ownerId}' AND project.deleted = FALSE
                    GROUP BY project.projectId
                    ORDER BY initiateDate DESC";
            if($result = $this->sqlQuery($sql)){
                return $result;
            }else{
                return false;
            }
        }
    }

?>