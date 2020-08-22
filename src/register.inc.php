<?php
    session_start();
    if(isset($_POST['submit'])){
        include_once "connect.php";
        $uid =  mysqli_real_escape_string($conn, $_POST['uname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
        $confirm = mysqli_real_escape_string($conn, $_POST['rpwd']);

        //Error handlers
        //check for empty fields
        if(empty($uid) || empty($email) || empty($pwd) || empty($confirm)){
            if(!empty($uid) && !empty($email)){
                header("Location: ../register.php?signup=empty&uid=$uid&email=$email");
                exit();
            }else if(!empty($uid)){
                header("Location: ../register.php?signup=empty&uid=$uid");
                exit();
            }else if(!empty($email)){
                header("Location: ../register.php?signup=empty&email=$email");
                exit();
            }else{
                header("Location: ../register.php?signup=empty");
                exit();
            }
        }else{
            //check if input characters are valid
            if(!preg_match("/^[a-zA-Z]*$/",$uid)){
                header("Location: ../register.php?signup=char&email=$email");
                exit();
            }else {
                //check if email is valid
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    header("Location: ../register.php?signup=invalidemail&uid=$uid");
                    exit();
                } else {
                    //check if passwords match
                    if ($pwd != $confirm) {
                        header("Location: ../register.php?signup=nomatchpwd&uid=$uid&email=$email");
                        exit();
                    } else {
                        $sql = "SELECT * FROM users WHERE username='$uid'";
                        $result = mysqli_query($conn, $sql);
                        $resultCheck = mysqli_num_rows($result);
                        if($resultCheck > 0){
                            header("Location: ../register.php?signup=usertaken&email=$email");
                            exit();
                        }else{
                            //hashing the password
                            $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
                            //insert the user into the databse
                            $sql = "INSERT INTO users (username,email,pwd) VALUES ('$uid','$email','$hashedPwd');";
                            mysqli_query($conn,$sql);
                            $_SESSION['uname'] = $uid;
                            $_SESSION['email'] = $email;
                            header("Location: ../home.php?signin=success&uid=$uid");
                            exit();
                        }
                    }
                }
            }
        }
    }else{
        header("Location: ../register.php?signup=error");
        exit();
    }


