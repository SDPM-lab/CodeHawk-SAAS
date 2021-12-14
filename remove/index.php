<?php

session_start();
?>

<html>
    <head>
        <title>Main Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

        <!-- Icon library -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/index_style.css">
        <script type="text/javascript">
            $(function () {
                $("img.dialog").click(function() {
                    var large_image = '<img src= ' + $(this).attr("src") + '></img>';
                    $('#dialog_large_image').html($(large_image).animate({ height: '80%', width: '100%' }, 500));
                });
            });
        </script>
    </head>
    <body>
        <header>
            <div>
                <div class="header-title"><a class="navbar-brand" href="index.php"><h2>軟體分析</h2></a></div>
                <div class="header-en">SOFTWARE ANALYSIS</div>
            </div>
        </header>
        
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="#theme">系統主題</a></li>
                <li class="nav-item"><a class="nav-link" href="#analysis">系統分析與設計</a></li>
                <li class="nav-item"><a class="nav-link" href="#source">使用技術&工具&資料來源</a></li>
                <li class="nav-item"><a class="nav-link" href="#code">程式碼</a></li>
            </ul>
            
            <ul class="navbar-nav ml-auto">
                <?php
                if ( isset($_SESSION['loggedin']) ) {
                    if ( $_SESSION['loggedin'] ) {
                        echo '<li class="navbar-text"><i class="fa fa-user fa-1x mr-1"></i>';
                        echo "你好! ";
                        echo '<b>';
                        echo "{$_SESSION['username']}";
                        echo '</b></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="logout.php"><i class="fa fa-sign-out fa-1x mr-1"></i>登出</a></li>';
                    }
                } else { 
                    echo '<li class="nav-item"><a class="nav-link" href="login.php"><i class="fa fa-sign-in fa-1x mr-1"></i>登入</a></li>';
                }
                ?>
            </ul>
        </nav>
        
        <!-- section1 -->
        <div class="container-fluid" id="theme">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-4">
                    <br><br><p><img class="dialog" src="img/新增專案.png" style="width:400px; height:220px; margin-top:7px; border:2px grey solid;"></p>
                </div>
                <div class="col-md-4">
                    <br><br><p><img class="dialog" src="img/2.png" style="width:400px; height:220px; margin-top:7px; border:2px grey solid;"></p>
                    <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-outline-warning btn-lg" onclick="start()">開始使用</button>
                </div>
                <div class="col-md-3">
                    <br><br><p><img class="dialog" src="img/3.png" style="width:250px; height:300px; margin-top:7px; border:2px grey solid;"></p>
                </div>
            </div>
        </div><hr class="section-divider">

        <!-- section2 -->
        <div class="container-fluid" id="analysis">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-2 text-center">
                    <br><h4><b>系統架構圖</b></h4><br>
                    <div style="border:2px grey solid; width: 210px; height: 120px;"><img class="dialog" src="img/系統架構圖.png" alt="點擊圖片放大" style="width:200px; height:100px; margin-top:7px;"></div><br>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-6">
                    <br><br><div id="dialog_large_image"></div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div><hr class="section-divider">

        <!-- section3 -->
        <div class="container-fluid" id="source">
            <!-- Grid row -->
            <div class="row">
                <div class="col-md-2"></div>
                <!-- Grid column -->
                <div class="col-md-3">

                    <!-- Content -->
                    <br><h4 class="font-weight-bold"><i class="fa fa-cog fa-1x mr-1"></i>使用技術</h4>
                    <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">

                    <p>HTML5</p>
                    <p>CSS 3</p>
                    <p>JavaScript</p>
                    <p>jQuery</p>
                    <p>PHP</p>
                    <p><a href="https://getbootstrap.com/" target="_blank">Bootstrap 4</a></p>
                    <p><a href="https://www.telerik.com/kendo-ui" target="_blank">Kendo UI</a></p>


                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-3">

                    <!-- Links -->
                    <br><h4 class="font-weight-bold"><i class="fa fa-wrench fa-1x mr-1"></i>使用工具</h4>
                    <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                    <p><a href="https://code.visualstudio.com/" target="_blank">Visual Studio Code</a></p>
                    <p>Chrome</p>
                    <p>Apache</p>
                    <p>MySQL</p>
                    <p>GitHub</p>

                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-4">

                    <!-- Links -->
                    <br><h4 class="font-weight-bold"><i class="fa fa-map-pin fa-1x mr-1"></i>資料來源</h4>
                    <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                    <p><a href="https://www.w3schools.com/default.asp" target="_blank">W3School</a></p>
                    <p><a href="https://fontawesome.com/" target="_blank">Font Awesome</a></p>
                    <br><br>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div><hr class="section-divider">

        <!-- section4 -->
        <div class="container-fluid" id="code">
            <div class="row">
                <div class="col-md-3">
                    <br><h4><i class="fa fa-folder fa-1x mr-1"></i><b>新增專案</b></h4><br>
                    <p><img src="img/code_new.png" style="width:300px; height:160px;"></p><br>
                    <p><i class="fa fa-arrow-right fa-1x mr-1"></i>在server建立一個資料夾存放上傳的檔案</p>
                </div>
                <div class="col-md-3">
                    <br><h4><i class="fa fa-file fa-1x mr-1"></i><b>上傳檔案</b></h4><br>
                    <p><img src="img/code_upload.png" style="width:300px; height:160px;"></p><br>
                    <p><i class="fa fa-arrow-right fa-1x mr-1"></i>把上傳的檔案放進專案的資料夾</p>
                </div>
                <div class="col-md-3">
                    <br><h4><i class="fa fa-search-plus fa-1x mr-1"></i><b>剖析-start()</b></h4><br>
                    <p><img src="img/code_analyze.png" style="width:300px; height:160px;"></p><br>
                    <p><i class="fa fa-arrow-right fa-1x mr-1"></i>遇到xml檔開頭標籤就開始進行剖析</p>
                </div>
                <div class="col-md-3">
                    <br><h4><i class="fa fa-search-minus fa-1x mr-1"></i><b>剖析-stop()</b></h4><br>
                    <p><img src="img/code_analyze_stop.png" style="width:300px; height:160px;"></p><br>
                    <p><i class="fa fa-arrow-right fa-1x mr-1"></i>遇到xml檔結束標籤時進行動作</p>
                </div>
            </div>
            
        </div>

        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">&copy; 2019 Copyright</a></div>
        <!-- Copyright -->
        <script>
            function start() {
                location.href='action_file.php';
            }
        </script>
    </body>
</html>