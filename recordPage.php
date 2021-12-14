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
    <title>Record - Software Measure</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/record.js"></script>
</head>

<body>
    <?php
        include_once("header.php");
    ?>
    <main>
        <div class="container">
            <div>
                <form>
                    <div class="form-group row">
                        <label for="project_select"></label>
                        <div class="col-sm-4">
                            <select id="project_select" class="form-control">
                                <option value="" disabled selected>選擇一個專案</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    </div>
                </div>
                <div class="col-9">
                    <div class="tab-content" id="v-pills-tabContent">
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