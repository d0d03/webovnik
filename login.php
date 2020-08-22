<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/sign.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title>Login</title>
</head>

<body>
<div class="h-100 row align-items-center">
    <div class="col">
        <form action="src/login.inc.php" method="POST" class="shadow container rounded bg-dark text-white p-5" style="width: 450px;">
            <nav>
                <ul>
                    <li><a href="login.php" class="act">LOG IN</a></li>
                    <li><a href="register.php">REGISTER</a></li>
                </ul>
            </nav>
            <p>
                <label for="uname">Username: </label>
                    <?php
                    if(isset($_GET['uid'])){
                        $uid = $_GET['uid'];
                        echo '<input class="form-control" type="text" name="uname" id="uname" value="'.$uid.'"/>';
                    }else if(isset($_COOKIE['username'])){
                        echo'<input class="form-control" type="text" name="uname" id="uname" value="'.$_COOKIE['username'].'"/>';
                    }else{
                        echo'<input class="form-control" type="text" name="uname" id="uname"/>';
                    }
                    ?>
            </p>
            <p>
                <label for="pwd">Password: </label>
                <?php
                    if(isset($_COOKIE['pwd'])){
                        echo'<input class="form-control" type="password" name="pwd" id="pwd" value="'. $_COOKIE['pwd'].'"/>';
                    }else{
                        echo '<input class="form-control" type="password" name="pwd" id="pwd"/>';
                    }
                ?>
            </p>
            <p class="border border-left-0 border-right-0 border-top-0 border-primary">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember me</label>
            </p>
            <button type="submit" id="login" name="submit" value="login" class="btn btn-primary btn-block">Sign in</button>
            <?php
            if(!isset($_GET['signin'])){
                exit();
            }else{
                $signinCheck = $_GET['signin'];
                switch ($signinCheck){
                    case 'empty':
                        echo "<br/><p style='color:red;margin-left:25%;'>You did not fill in all fields!</p>";
                        exit();
                        break;
                    case 'wrongpwd':
                        echo "<br/><p style='color:red;margin-left:25%;'>Wrong password!</p>";
                        exit();
                        break;
                    case 'success':
                        echo "<br/><p style='color:green;margin-left:25%;'>You have been signed in!</p>";
                        exit();
                        break;
                    case 'remember':
                        echo "<br/><p style='color:green;margin-left:25%;'>I will remember you</p>";
                        exit();
                    default:
                        echo "<br/><p style='color:red;margin-left:25%;'>User doesn't exist</p>";
                        exit();
                }
            }
            ?>
        </form>
    </div>
</div>
</body>
</html>