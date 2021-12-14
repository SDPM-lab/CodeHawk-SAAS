<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location: login.php");
    }else{
        session_destroy();
        header("Location: index.php");
    }
?>