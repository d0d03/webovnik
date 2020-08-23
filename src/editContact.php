<?php
    session_start();
    if(isset($_POST['btnEdit'])){
        include_once './connect.php';
        $cName = mysqli_real_escape_string($conn,$_POST['cname']);
        $cEmail = mysqli_real_escape_string($conn,$_POST['email']);
        $cPhone = mysqli_real_escape_string($conn,$_POST['pnum']);
        $cBday = mysqli_real_escape_string($conn,$_POST['bday']);
        $cID = mysqli_real_escape_string($conn,$_POST['contactID']);

        if(isset($_SESSION['uname'])){
            $sql = "UPDATE contacts SET cName = '{$cName}', cEmail ='{$cEmail}', cPhone = '{$cPhone}', cBday ='{$cBday}' WHERE cID='{$cID}' AND userID='{$_SESSION['uname']}'";
            mysqli_query($conn,$sql);
            header("Location: ../phone.php");
            exit();
        }
    }else if(isset($_POST['btnRemove'])){
        if(isset($_SESSION['uname'])){
            include_once './connect.php';
            $cID = mysqli_real_escape_string($conn,$_POST['contactID']);
            $sql = "DELETE FROM contacts WHERE cID='{$cID}' AND  userID ='{$_SESSION['uname']}'";
            mysqli_query($conn,$sql);
            header("Location: ../phone.php?cID=$cID&uid={$_SESSION['uname']}");
            exit();
        }
    }else{
        header("Location: ../error.php");
        exit();
    }

