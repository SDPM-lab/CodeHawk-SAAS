<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/kendo.common-material.min.css">
    <link rel="stylesheet" href="./css/kendo.material.min.css">
    <link rel="stylesheet" href="./css/uikit.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>軟體分析</title>
</head>

<body>
    <header>
        <ul class="navbar">
            <li style="float: left;"><a class="navbar-title" href="index.php">軟體分析</a></li>
            <li style="float: right;"><a class="navbar-logout" href="logout.php">登出</a></li>
        </ul>
    </header>
    <main>
        <div class="uk-container align-center">
            <div style="text-align: left; margin-bottom: 20px;">
                <h3><?php echo $_GET["projectName"] ?> 上傳檔案</h3>
                <input type="hidden" id="projectId" value=<?php echo $_GET["projectId"] ?>>
                <div>
                    <div style="width:40%; display: inline-block;">
                        <input name="files" id="files" type="file" />
                    </div>
                    <div style="width:40%; display: inline-block;">
                        <p id="errorMsg" style="margin-left: 10px;"></p>
                    </div>
                    <button id="back" class="k-button k-primary" style="float:right">返回</button>
                </div>
            </div>

            <div id="view_window" class="uk-card" style="display:none;">
                <div id="analyze_result" style="overflow:auto;"></div>
                <div style="text-align: right;">
                    <button id="confirm_btn" class="k-button k-primary btn-add-book">確定</button>
                </div>
            </div>
            <div id="file_grid">
            </div>
        </div>
    </main>

    <footer>
    </footer>
</body>
<script src="./js/jquery-2.1.4.min.js"></script>
<script src="./js/kendo.all.min.js"></script>
<script src="./js/uikit.min.js"></script>

<script src="./js/file/dataOperation.js"></script>
<script src="./js/file/init.js"></script>


</html>