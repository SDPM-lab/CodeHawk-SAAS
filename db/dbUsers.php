<?php
    include_once("dbFunctions.php");
    class dbUsers extends dbFunctions{

        //使用者登入
        public function userLogin($info){
            $sql = "SELECT * FROM users
                    WHERE username = '{$info['username']}'
                        AND password = '{$info['password']}'";
            if($result = $this->sqlQuery($sql)->fetch_object()){
                return $result;
            }else{
                return false;
            }
        }
        
        //取得使用者資訊
        public function getUser($info){
            $sql = "SELECT * FROM users
                    WHERE id = '{$info['id']}'
                        AND username = '{$info['username']}'";
            if($result = $this->sqlQuery($sql)->fetch_object()){
                return $result;
            }else{
                return false;
            }
        }

        //檢查是否有使用者名稱是否存在
        public function checkUser($username){
            $sql = "SELECT username FROM users 
                    WHERE username = '{$username}'";
            if($this->sqlQuery($sql)->fetch_object()){
                return true;
            }else{
                return false;
            }
        }

        //新增使用者
        public function addUser($info){
            $sql = "INSERT INTO users (email, username, password) 
                    VALUES ('{$info['email']}','{$info['username']}','{$info['password']}')";
            if($this->sqlQuery($sql)){
                return $this->db->insert_id;
            }else{
                return false;
            }
        }

        //更新使用者資訊
        public function updateUser($info){
            $sql = "UPDATE users
                    SET email = '{$info['email']}',username = '{$info['username']}',password = '{$info['password']}'
                    WHERE id = '{$info['id']}'";
            if($this->sqlQuery($sql)){
                return true;
            }else{
                return false;
            }
        }

    }

?>