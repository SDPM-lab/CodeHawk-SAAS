<?php
    session_start();
    if(isset($_SESSION['id'])){
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Register Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

        <!-- Icon library -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/form_style.css">
    </head>

    <body style="background-color:whitesmoke;">
        <header>
            <div class="header-title"><a class="navbar-brand" href="index.php"><h2>軟體分析</h2></a></div>
            <div class="header-en">SOFTWARE ANALYSIS</div>
        </header><hr>
        <div class="container">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6 center">
                    <!-- Material form login -->
                    <div class="card">
                        <h1 class="text-center py-4"><b>加入會員</b></h1>
                        <div class="card-body px-lg-5 py-0">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                                <label for="uname">電子郵件</label><span id = "must">*</span><br>
                                <input type="email" class="form-control mb-2 mr-sm-2" name="email" placeholder="請輸入電子郵件" required>
                                <label for="uname">帳號</label><span id = "must">*</span><br>
                                <input type="text" class="form-control mb-2 mr-sm-2" name="username" placeholder="請輸入帳號" required>
                                <label for="pwd">密碼</label><span id = "must">*</span><br>
                                <input type="password" class="form-control mb-2 mr-sm-2" name="password" placeholder="請輸入密碼" required><br>
                                <div class="row">
                                    <div class="col-sm-5"></div>
                                    <div class="col-sm-7 text-right">
                                        <div>
                                            <a href="login.php">回到會員登入</a>
                                        </div>
                                    </div>
                                </div>

                                <input type="submit" class="btn btn-success my-4 btn-block btn-lg" value="加入"><br>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </body>
</html>

<?php
    if ( isset( $_POST['email'] ) && isset( $_POST['username'] ) && isset( $_POST['password'] )) {
        include_once("db/dbUsers.php");
        $db = new dbUsers;

        $infoArr = array(
            "email" => $_POST['email'],
            "username" => $_POST['username'],
            "password" => $_POST['password']
        );

        if($db->checkUser($infoArr['username'])){
            echo "<script type='text/javascript'>";
            echo " alert('Username has been used!')";
            echo "</script>";
            exit();
        }

        if($insert_id = $db->addUser($infoArr)){
            mkdir("upload/" . $insert_id);  // 建立資料夾，用來存放該使用者上傳的檔案

        	echo "<script>";
			echo "	alert('註冊成功，為您轉跳登入畫面!');";
			echo "	window.location.href='login.php';";
			echo "</script>";
        }
    }
?>