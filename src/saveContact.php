<?php
    session_start();
    if(isset($_POST['btnEdit'])){
        include_once './connect.php';
        $cName = mysqli_real_escape_string($conn,$_POST['cname']);
        $cEmail = mysqli_real_escape_string($conn,$_POST['email']);
        $cPhone = mysqli_real_escape_string($conn,$_POST['pnum']);
        $cBday = mysqli_real_escape_string($conn,$_POST['bday']);

        if(isset($_SESSION['uname'])){
            $sql = "INSERT INTO contacts(cName,cEmail,cPhone,cBday,userID) VALUES ('{$cName}','{$cEmail}','{$cPhone}','{$cBday}','{$_SESSION['uname']}')";
            mysqli_query($conn,$sql);
            header("Location: ../phone.php");
            exit();
        }
    }
