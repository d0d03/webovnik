<?php
    session_start();

    if(isset($_POST['submit'])){
        include "./connect.php";

        $uid = mysqli_real_escape_string($conn, $_POST['uname']);
        $pwd = mysqli_real_escape_string($conn,$_POST['pwd']);
        $check = mysqli_real_escape_string($conn,$_POST['remember']);

        //Error handlers
        //check if inputs are empty
        if(empty($uid) || empty($pwd)){
            header("Location: ../login.php?signin=empty");
            exit();
        }else{
            $sql = "SELECT * FROM users WHERE username='$uid' or email='$uid'";
            $result = mysqli_query($conn,$sql);
            $resultCheck = mysqli_num_rows($result);
            if($resultCheck < 1){
                header("Location: ../login.php?signin=userunknown");
                exit();
            }else{
                if($row = mysqli_fetch_assoc($result)){
                    //De-hasing the password
                    $hasshedPwdCheck = password_verify($pwd, $row['pwd']);
                    if($hasshedPwdCheck == false){
                        header("Location: ../login.php?signin=wrongpwd&uid=$uid");
                        exit();
                    }else if($hasshedPwdCheck == true){
                        //Log in the user here
                        $_SESSION['uname'] = $row['username'];
                        $_SESSION['email'] = $row['email'];
                        if(!empty($check)){
                            setcookie('username',$row['username'],time() + (86400 * 7),"/");
                            setcookie('pwd',$pwd,time() + (86400 * 7),"/");
                        }
                        header("Location: ../home.php");
                        exit();
                    }
                }
            }
        }
    }else{
        header("Location: ../login.php?signin=error");
        exit();
    }

