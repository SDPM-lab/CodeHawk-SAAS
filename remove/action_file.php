<?php
session_start();

if (isset($_SESSION["id"])) {
    header("Location: ./index.html");
    exit;
} else {
    echo "<script type='text/javascript'> alert('請先登入'); location.href='login.php'; </script>";
}

?>