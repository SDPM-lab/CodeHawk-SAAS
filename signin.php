<?php
    session_start();
    if(isset($_SESSION['id'])){
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Sign In - Software Measure</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="js/signin.js"></script>
    </head>

    <body>
        <header>
            <div class="pos-f-t">
                <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="index.php">
                        <img id="SMlogo" src="img/SM.png" class="d-inline-block align-top" alt="Software Measure"> Software Measure
                    </a>
                </nav>
            </div>
        </header>

        <div class="row justify-content-center align-items-center">
            <div class="card al text-center" style="width: 30rem; margin-top: 20px;">
                <div style="margin-top: 10px;">
                    <img src="img/SM.png" class="card-top" width="160" height="160" alt="Software Measure">
                </div>
                <div class="card-body">
                    <form id="signInForm" action="" method="post">
                        <h4 class="card-title">登入</h4>
                        <p class="card-text">使用您的帳號</p>
                        <div class="form-group row">
                            <label for="username" class="col-sm-3 col-form-label">帳號</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="username" placeholder="輸入帳號" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label">密碼</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="password" placeholder="輸入密碼" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-9">
                                <h7 id="errorText"></h7>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">登入</button>
                    </form>
                </div>
                <div class="card-footer ">
                    <p>還不是會員？ <a href="signup.php">建立帳戶</a></p>
                </div>
            </div>
        </div>
    </body>
</html>