<?php
    include_once("dbFunctions.php");
    class dbFile extends dbFunctions{
        //新增檔案
        public function addFile($info){
            $sql = "INSERT INTO file (ownerId, projectId, fileName, filePath, uploadDate) 
                    VALUES ('{$info['ownerId']}','{$info['projectId']}','{$info['fileName']}','{$info['filePath']}','{$info['uploadDate']}')";
            if($this->sqlQuery($sql)){
                return $this->db->insert_id;
            }else{
                return false;
            }
        }


        //取得專案檔案
        public function getFile($info){
            $sql = "SELECT fileName, fileId, uploadDate 
                    FROM file
                    WHERE deleted = FALSE AND ownerId = '{$info['ownerId']}' AND projectId = '{$info['projectId']}'";
            if($result = $this->sqlQuery($sql)){
                return $result;
            }else{
                return false;
            }
        }

        //取得檔案路徑
        public function getFilePath($fileId){
            $sql = "SELECT filePath 
                    FROM file
                    WHERE fileId = '{$fileId}'";
            if($result = $this->sqlQuery($sql)->fetch_object()){
                return $result->filePath;
            }else{
                return false;
            }
        }

        //刪除檔案
        public function deleteFile($fileId){
            $sql = "UPDATE file
                    SET deleted = TRUE
                    WHERE fileId = $fileId";
            if($this->sqlQuery($sql)){
                return true;
            }else{
                return false;
            }
        }
        
        //刪除專案檔案
        public function deleteFileByProject($info){
            $sql = "UPDATE file
                    SET deleted = TRUE
        WHERE ownerId = '{$info['ownerId']}' AND projectId = '{$info['projectId']}'";
            if($this->sqlQuery($sql)){
                return true;
            }else{
                return false;
            }
        }

    }

?>