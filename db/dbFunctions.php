<?php
    class dbFunctions{
        
        private $host;
        private $username;
        private $password;
        private $dbname;
        protected $db;
        private $connectError;
        private $queryError;

        function __construct()
        {
            $this->host = "localhost";
            $this->username = "root";
            $this->password = "";
            $this->dbname = "software_measure";
            $this->connectError = "";
            $this->queryError = "";
            $this->sqlConnect();
        }

        function __destruct(){
            $this->db->close();
            $this->connectError = "";
            $this->queryError = "";
        }

        //連結到資料庫
        private function sqlConnect(){
            try{
                $this->db = new mysqli(
                    $this->host,
                    $this->username,
                    $this->password,
                    $this->dbname
                );
                if($this->db->connect_errno){
                    throw new Exception("無法連線到資料庫: ". $this->db->connect_errno);
                }else{
                    $this->db->set_charset("utf8");
                    return true;
                }
            }catch(Exception $e){
                $this->connectError = $e->getMessage();
                return false;
            }
        }

        //資料庫操作
        protected function sqlQuery($sql){
            if($result = $this->db->query($sql)){
                return $result;
            }else{
                $this->queryError = "query 錯誤: ".$this->db->error;
                return false;
            }
        }

    }

?>