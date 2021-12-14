<header>    
    <div class="pos-f-t">
        <nav class="navbar fixed-top navbar-expand-lg">
            <a class="navbar-brand" href="index.php">
                <img id="SMlogo" src="img/SM.png" class="d-inline-block align-top" alt="Software Measure"> Software Measure
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse"  data-hover="dropdown" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="team.php">Our team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="projectPage.php">Project</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" type="button" data-toggle="dropdown" data-hover="dropdown">
                            File
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item nav-link" href="filePage.php">View file</a>
                            <a class="dropdown-item nav-link" href="recordPage.php">Analyze record</a>
                        </div>
                    </li>
                </ul>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#accountNavDropdown" aria-controls="accountNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse justify-content-end" id="accountNavDropdown">
                <ul class="navbar-nav">
                    <?php
                        if(isset($_SESSION['id'])){
                            echo "<li class='navbar' style='color:#F1FAEE'>";
                            echo "你好！{$_SESSION['username']}</li>";
                            echo "<li class='nav-item dropdown active'>";
                            echo "<a class='nav-link dropdown-toggle' href='#' id='accountDropdownMenuLink' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
                            echo "<img id='userIcon' src='img/user.png' class='d-inline-block align-top' alt='Software Measure'></a>";
                            echo "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='accountDropdownMenuLink'>";
                            echo "<a class='dropdown-item nav-link' href='account.php'>Manage account</a>";
                            echo "<div class='dropdown-divider'></div>";
                            echo "<a class='dropdown-item nav-link' href='signout.php'>Sign out</a>";
                            echo "</div></li>";
                        }else{
                            echo "<li class='nav-item'><a class='navbar-brand' href='signin.php'>Sign In</a></li>";
                        }
                    ?>
                </ul>
            <div>
        </nav>
    </div>
</header>