<?php
    session_start();
    if(isset($_SESSION['id'])){
        header("Location: index.php");
    }
?>

<!doctype html>
<html>
    <head>
        <title>Login Page</title>
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
                    <div class="card">
                        <h1 class="text-center py-4"><b>會員登入</b></h1>
                        <div class="card-body px-lg-5 pt-0">
                            <form action="" method="POST">
                                <label for="uname">帳號</label><br>
                                <input type="text" class="form-control mb-2 mr-sm-2" name="username" placeholder="請輸入帳號" required>
                                <label for="pwd">密碼</label><br>
                                <input type="password" class="form-control mb-2 mr-sm-2" name="password" placeholder="請輸入密碼" required><br>
                                <div class="row">
                                    <div class="col-sm-5">
                                        <p style="color: red" id="errorText"></p>
                                    </div>
                                    <div class="col-sm-7 text-right">
                                        <div>
                                            <p>還不是會員? <a href="register.php">加入會員</a></p>
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-info my-4 btn-block btn-lg" value="登入">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        </div>
    </body>
</html>

<?php
    if ( isset( $_POST['username'] ) && isset( $_POST['password'] )) {
        include_once("db/dbUsers.php");
        $db = new dbUsers;

        $infoArr = array(
            "username" => $_POST['username'],
            "password" => $_POST['password']
        );

        if($result = $db->userLogin($infoArr)){
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['id'] = $result->id;
            $_SESSION['username'] = $result->username;
            header("Location: index.php");
        }else{
			echo "<script>";
			echo "	$('#errorText').html('帳號或密碼錯誤');";
			echo "</script>";
        }
    }
?>