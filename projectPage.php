<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header("Location: signin.php");
    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>Project - Software Measure</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/project.js"></script>
</head>

<body>
    <?php
        include_once("header.php");
    ?>
    <main>
        <div class="container">
            <div style="text-align: left; margin-bottom: 20px;">
                <h3>新增專案</h3>
                <form id="projectForm" action="" method="post">
                    <div class="form-group row">
                        <label for="projectName" class="col-lg-1 col-form-label">專案名稱</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="projectName" placeholder="專案名稱..." required>
                        </div>
                        <div class="col-sm-1">
                            <button class="btn btn-primary" type="submit">新增</button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <h7 id="errorText"></h7>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">專案名稱</th>
                            <th scope="col">檔案個數</th>
                            <th scope="col">建立時間</th>
                            <th scope="col">　</th>
                            <th scope="col">　</th>
                        </tr>
                    </thead>
                    <tbody id="projectTable">

                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
<?php
    include_once("footer.php");
?>
</html>