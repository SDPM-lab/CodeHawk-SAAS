<?php
    session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Software Measure</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/index.js"></script>
</head>

<body>
    <?php
        include_once("header.php");
    ?>
    <div class="container">
        <div class="row">
            <div class="card w-25" style="margin-top: 100px; text-align: center">
                <div style="margin-top: 10px;">
                    <h5 class="card-title"><img src="img/SM.png" class="card-top" width="160" height="160" alt="Software Measure"></h5>
                </div>
                <div class="card-body">
                    <button type="button" class="btn  btn-outline-dark btn-lg" onclick="start()">開始使用</button>
                </div>
                <div class="card-footer">
                    <p class="card-text">開始你的軟體度量</p>
                </div>
            </div>
        </div>
</body>
<?php
    include_once("footer.php");
?>
</html>