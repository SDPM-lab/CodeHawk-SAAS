<?php
    session_start();
    if( !isset($_SESSION['id']) ){
        header("Location: signin.php");
    }else if( !isset($_SESSION['projectId']) ){
        header("Location: projectPage.php");
    }
?>

<!DOCTYPE html>
<html>

<head>
    <title>File - Software Measure</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/file.js"></script>
</head>

<body>
    <?php
        include_once("header.php");
    ?>
    <main>
        <div class="container">
            <div style="text-align: left; margin-bottom: 20px;">
                <h3>上傳檔案</h3>
                <input type="hidden">
                <form id="fileForm" action="" method="post">
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <input type="file" class="btn btn-outline-dark form-control" name="files" required>
                        </div>
                        <div class="col-sm-4">
                            <button class="btn btn-primary" type="submit">新增</button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <h7 id="errorText"></h7>
                        </div>
                        <div class="col-sm-4">
                            <a href="projectPage.php" type="button" class="btn btn-secondary" style="float:right">返回</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <!-- <caption id="caption"></caption> -->
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">檔案名稱</th>
                            <th scope="col">上傳時間</th>
                            <th scope="col">　</th>
                            <th scope="col">　</th>
                        </tr>
                    </thead>
                    <tbody id="fileTable"></tbody>
                </table>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="analyzeResultModal" tabindex="-1" role="dialog" aria-labelledby="analyzeResultModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="analyzeResultModalTitle">Analyze Result</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="analyzeResultGrid" class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button id="saveRecord_btn" type="button" class="btn btn-primary">Save result</button>
                        <button id="closeModal_btn" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
<?php
    include_once("footer.php");
?>
</html>