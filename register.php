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
    <title>Register</title>
</head>
<body>
<div class="h-100 row align-items-center">
    <div class="col">
        <form action="src/register.inc.php" method="POST" class="shadow container rounded bg-dark text-white p-5" style="width: 450px;">
            <nav>
                <ul>
                    <li><a href="login.php">LOG IN</a></li>
                    <li><a href="register.php" class="act">REGISTER</a></li>
                </ul>
            </nav>
            <p>
                <label for="uname">Username: </label>
                <?php
                if(isset($_GET['uid'])){
                    $uid = $_GET['uid'];
                    echo '<input class="form-control" type="text" name="uname" id="uname" value="'.$uid.'"/>';
                    }else{
                    echo'<input class="form-control" type="text" name="uname" id="uname"/>';
                }
                ?>
            </p>
            <p>
                <label for="email">e-Mail: </label>
                <?php
                if(isset($_GET['email'])){
                    $email = $_GET['email'];
                    echo '<input class="form-control" type="text" name="email" id="email" value="'.$email.'"/>';
                }else{
                    echo'<input class="form-control" type="text" name="email" id="email"/>';
                }
                ?>
            </p>
            <p>
                <label for="pwd">Password: </label>
                <input class="form-control" type="password" name="pwd" id="pwd"/>
            </p>
            <p class="border border-left-0 border-right-0 border-top-0 border-primary">
                <label for="rpwd">Repeat password: </label>
                <input class="form-control" type="password" name="rpwd" id="rpwd"/>
                <br/>
            </p>
            <button type="submit" name="submit" class="btn btn-primary btn-block">Sign up</button>
            <?php
            if(!isset($_GET['signup'])){
                exit();
            }else{
                $signupCheck = $_GET['signup'];
                switch ($signupCheck){
                    case 'empty':
                        echo "<br/><p style='color:red;margin-left:25%;'>You did not fill in all fields!</p>";
                        exit();
                        break;
                    case 'char':
                        echo "<br/><p style='color:red;margin-left:25%;'>You used invalid characters!</p>";
                        exit();
                        break;
                    case 'invalidemail':
                        echo "<br/><p style='color:red;margin-left:25%;'>You used invalid email!</p>";
                        exit();
                        break;
                    case 'nomatchpwd':
                        echo "<br/><p style='color:red;margin-left:25%;'>Passwords don't match!</p>";
                        exit();
                        break;
                    case 'usertaken':
                        echo "<br/><p style='color:red;margin-left:25%;'>User already exists!</p>";
                        exit();
                        break;
                    case 'success':
                        echo "<br/><p style='color:green;margin-left:25%;'>You have been signed up!</p>";
                        exit();
                        break;
                    default:
                        echo "<br/><p style='color:red;margin-left:25%;'>You shouldn't be here, something went wrong!</p>";
                        exit();
                }
            }
            ?>
        </form>
    </div>
</div>
</body>
</html>