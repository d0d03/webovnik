<?php
    session_start();
    if(isset($_POST['submit'])){
        include_once './connect.php';
        $start = mysqli_real_escape_string($conn,$_POST['start']);
        $end = mysqli_real_escape_string($conn,$_POST['end']);
        $task = mysqli_real_escape_string($conn,$_POST['task']);

        $date = substr($start,0,10);
        $start = str_replace("T"," ",$start) . ":00";
        $end = str_replace("T"," ",$end) . ":00";

        if(isset($_SESSION['uname'])){
            $sql = "INSERT INTO events(title,date,start,end,status,userID) VALUES ('{$task}','{$date}','{$start}','{$end}','1','{$_SESSION['uname']}')";
            mysqli_query($conn,$sql);
            header("Location: ../home.php");
            exit();
        }
    }else{
        header("Location: ../error.php");
        exit();
    }
