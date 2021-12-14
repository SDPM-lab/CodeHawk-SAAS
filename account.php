<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location: signin.php");
    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Account - Software Measure</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/account.js"></script>
</head>

<body>
    <?php
        include_once("header.php");
    ?>
    <main>
    <div class="row justify-content-center align-items-center">
        <div class="card al text-center" style="width: 30rem; margin-top: 20px;">
            <div class="card-body">
                <form id="accountForm" action="" method="post">
                    <h4 class="card-title">個人資訊</h4>
                    <p class="card-text" style="color:gray">您在 Software Measure 服務使用的帳號資訊</p>
                    <div class="form-group row">
                        <label for="username" class="col-sm-4 col-form-label">帳號</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="username" placeholder="輸入帳號" required readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-4 col-form-label">密碼</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="password" placeholder="輸入密碼" required readonly>
                        </div>
                    </div>
                    <div id="repassword_div" class="form-group row" style="display: none;">
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-4 col-form-label">電子郵件</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" name="email" placeholder="輸入電子郵件" required readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <h7 id="hintText" style="color:gray">點擊已欄位以更改資料</h7>
                            <h7 id="errorText"></h7>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">儲存變更</button>
                    <button id="cancel_btn" class="btn btn-secondary" type="button">取消</button>
                </form>
            </div>
        </div>
    </div>
    </main>
</body>
<?php
    include_once("footer.php");
?>
</html>