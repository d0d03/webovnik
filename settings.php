<?php
    session_start();
    if(!isset($_SESSION['uname'])){
        header("Location: ./error.php");
    }
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title>Settings</title>
</head>

<body>

    <header class="jumbotron text-center" style="margin-bottom: 0;">
        <h1>SETTINGS</h1>
    </header>

    <nav class="navbar navbar-expand-sm bg-primary navbar-light">
        <a class="navbar-brand" href="#">MENU : </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./home.php">SCHEDULE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./phone.php">PHONE BOOK</a>
                </li>
                <li class="nav-item" style="position: absolute; right:50px;">
                    <div class="dropdown dropleft float-right">
                        <button class="btn btn-dark dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear" style="font-size: 25px"></i></button>
                        <div class="dropdown-menu">
                            <h5 class="dropdown-header">Username: </h5>
                            <span class="dropdown-item-text"><?=$_SESSION['uname']?></span>
                            <h5 class="dropdown-header">e-Mail: </h5>
                            <span class="dropdown-item-text"><?=$_SESSION['email']?></span>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Settings</a>
                            <form action="src/logout.inc.php" method="POST"><button type="submit" name="submit" class="dropdown-item">Log out</button></form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <main class="container" style="margin-top:30px">
        <div class="row">
            <p class="col-sm-7">If you want to deactivate your account please enter your password here: </p>
            <form action="./src/deleteUser.php" method="post">
                <input class="form-control" name="pwd" type="password" placeholder="password:">
                <br/>
                <button type="submit" name="delete" class="btn btn-danger">DELETE</button>
            </form>
        </div>
        <br/>
        <div class="row">
            <p class="col-sm-7">If you want to change your password, first enter your old one then your new: </p>
            <form action="./src/changePwd.php" method="post">
                <input name="oldpwd" type="password" class="form-control" placeholder="old password:">
                <br/>
                <input name="newpwd" type="password" class="form-control" placeholder="new password:">
                <br/>
                <input type="hidden" name="uid" value="<?=$_SESSION['uname']?>">
                <button type="submit" name="change" class="btn btn-warning">CHANGE</button>
            </form>
        </div>
        <?php
        if(isset($_GET['change'])){
            if($_GET['change']=='empty'){
                echo "<p style='color:red;'>You did not fill in all fields!</p>";
            }else if($_GET['change'] == 'wrongpwd'){
                echo "<p style='color:red;'>Please enter the correct password!</p>";
            }else if($_GET['change'] == 'success'){
                echo "<p style='color:green;'>You have successfully changed your password!</p>";
            }
        }
        ?>
    </main>
</body>
</html>

