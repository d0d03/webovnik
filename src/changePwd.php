<?php
    session_start();
    if(isset($_POST['change'])){
        include_once "./connect.php";

        $uid = mysqli_real_escape_string($conn, $_POST['uid']);
        $oldPwd = mysqli_real_escape_string($conn,$_POST['oldpwd']);
        $newPwd = mysqli_real_escape_string($conn,$_POST['newpwd']);

        if(empty($uid) || empty($oldPwd) || empty($newPwd)) {
            header("Location: ../settings.php?change=empty");
            exit();
        }else{
            $sql = "SELECT * FROM users WHERE username = '$uid'";
            $result = mysqli_query($conn,$sql);
            $resultCheck = mysqli_num_rows($result);
            if($resultCheck < 1){
                header("Location: ../login.php?signin=userunknown");
                exit();
            }else{
                if($row = mysqli_fetch_assoc($result)){
                    $hashedPwdCheck = password_verify($oldPwd,$row['pwd']);
                    if($hashedPwdCheck == false){
                        header("Location: ../settings.php?change=wrongpwd");
                        exit();
                    }else if($hashedPwdCheck == true){
                        $hashedPwd = password_hash($newPwd, PASSWORD_DEFAULT);
                        $sql = "UPDATE users SET pwd='{$hashedPwd}' WHERE username='{$uid}'";
                        mysqli_query($conn,$sql);
                        header("Location: ../settings.php?change=success");
                        exit();
                    }
                }
            }
        }
    }else{
        echo "error! you shouldn't be here";
    }
