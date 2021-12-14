<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location: signin.php");
    }else{
        session_destroy();
        header("Location: index.php");
    }
?>