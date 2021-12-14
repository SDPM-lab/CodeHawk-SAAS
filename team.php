<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Team - Software Measure</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <?php
        include_once("header.php");
    ?>

    <div>
        <div class="leftcolumn float-left">
            <div class="row">
                <div class="col col-lg-6">
                    <div class="card" style="width: 20rem;">
                        <div class="card-header">指導教授</div>
                        <img src="img/wtlee.jpg" class="card-img-top" alt="Wen-Tin Lee">
                        <div class="card-body">
                            <h4 class="card-text">李文廷（Wen-Tin Lee）</h4>
                            <p class="card-text">信箱：wtlee@nknu.edu.tw</p>
                            <p class="card-text">電話：07-7172930 分機 8009</p>
                        </div>
                    </div>
                </div>
                <div class="col col-lg-6">
                    <div class="card" style="width: 20rem;">
                        <div class="card-header">專長</div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">軟體工程</li>
                            <li class="list-group-item">軟體程序管理與成熟度整合模式</li>
                            <li class="list-group-item">軟體度量與分析</li>
                            <li class="list-group-item">軟體測試</li>
                            <li class="list-group-item">物件導向技術</li>
                            <li class="list-group-item">服務導向架構與運算</li>
                        </ul>
                    </div>
                    <div class="card" style="width: 20rem;">
                        <div class="card-header">經歷</div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">國立中央大學 資訊工程研究所博士</li>
                        </ul>
                    </div>
                    <div class="card" style="width: 20rem;">
                        <div class="card-body">
                            <p class="card-text">詳情見 <a href="https://se.nknu.edu.tw/index.php/faculty/31-%E6%9D%8E%E6%96%87%E5%BB%B7">高師大</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col col-lg-6">
                    <div class="card" style="width: 20rem;">
                        <div class="card-header">學生</div>
                        <img src="img/pclin.jpg" class="card-img-top" alt="Po-Cheng Lin">
                        <div class="card-body">
                            <h4 class="card-text">林柏呈（Po-Cheng Lin）</h4>
                            <p class="card-text">信箱：410677003@mail.nknu.edu.tw</p>
                            <p class="card-text">電話：0979685630</p>
                        </div>
                    </div>
                </div>
                <div class="col col-lg-6">
                    <div class="card" style="width: 20rem;">
                        <div class="card-header">擅長程式語言</div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Java</li>
                            <li class="list-group-item">Python</li>
                            <li class="list-group-item">C#</li>
                            <li class="list-group-item">JavaScript</li>
                            <li class="list-group-item">HTML</li>
                            <li class="list-group-item">C</li>
                        </ul>
                    </div>
                    <div class="card" style="width: 20rem;">
                        <div class="card-header">經歷</div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">國立高雄師範大學 軟體工程與管理學系在學</li>
                            <li class="list-group-item">叡揚資訊 助理程式設計師 （2019.7~2019.12）</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="rightcolumn float-right">
            <div class="card">
                <div class="card-header">使用技術</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">HTML5</li>
                    <li class="list-group-item">CSS 3</li>
                    <li class="list-group-item">JavaScript</li>
                    <li class="list-group-item">jQuery</li>
                    <li class="list-group-item">PHP</li>
                    <li class="list-group-item"><a href="https://getbootstrap.com/" target="_blank">Bootstrap 4</a></li>
                </ul>
            </div>
            <div class="card">
                <div class="card-header">使用工具</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="https://code.visualstudio.com/" target="_blank">Visual Studio Code</a></li>
                    <li class="list-group-item">Chrome</li>
                    <li class="list-group-item">Apache</li>
                    <li class="list-group-item">MySQL</li>
                    <li class="list-group-item">GitLab</li>
                </ul>
            </div>
            <div class="card">
                <div class="card-header">資料來源</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="https://www.w3schools.com/default.asp" target="_blank">W3School</a></li>
                    <li class="list-group-item"><a href="https://getbootstrap.com/" target="_blank">Bootstrap 4</a></li>
                    <li class="list-group-item"><a href="https://coolors.co/" target="_blank">coolors</a></li>
                </ul>
            </div>
        </div>
    </div>
</body>
<?php
    include_once("footer.php");
?>
</html>