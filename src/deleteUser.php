<?php
session_start();
if(isset($_POST['delete'])) {
    include_once "./connect.php";

    $uid = mysqli_real_escape_string($conn, $_SESSION['uname']);
    $pwd = mysqli_real_escape_string($conn,$_POST['pwd']);

    if(empty($uid) || empty($pwd)) {
        header("Location: ../settings.php?change=empty");
        exit();
    }else{
        $sql = "SELECT * FROM users WHERE username = '{$uid}'";
        $result = mysqli_query($conn,$sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck < 1){
            header("Location: ../login.php?signin=userunknown");
            exit();
        }else{
            if($row = mysqli_fetch_assoc($result)){
                $hashedPwdCheck = password_verify($pwd,$row['pwd']);
                if($hashedPwdCheck == false){
                    header("Location: ../settings.php?change=wrongpwd");
                    exit();
                }else if($hashedPwdCheck == true){
                    $sqlDeleteEvents="DELETE FROM events WHERE userID = '$uid';  ";
                    mysqli_query($conn,$sqlDeleteEvents);
                    $sqlDeleteContacts="DELETE FROM contacts WHERE userID = '$uid';  ";
                    mysqli_query($conn,$sqlDeleteContacts);
                    $sqlDeleteAcc="DELETE FROM users WHERE username = '$uid';  ";
                    mysqli_query($conn,$sqlDeleteAcc);
                    header("Location: ../index.html?deleted=success");
                    exit();
                }
            }
        }
    }
}else{
    echo "error! you shouldn't be here";
}

