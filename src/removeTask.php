<?php
    session_start();
if(isset($_POST['submit'])){
    include_once './connect.php';
    $taskID = mysqli_real_escape_string($conn,$_POST['remove']);
    if(isset($_SESSION['uname'])){
        $result = $conn->query("SELECT date FROM events WHERE id='{$taskID}' AND userID='{$_SESSION['uname']}'");
        $row =  mysqli_fetch_assoc($result);
        $currentDay = $row['date'];
        $sql = "DELETE FROM events WHERE id='{$taskID}' AND  userID ='{$_SESSION['uname']}'";
        mysqli_query($conn,$sql);
        header("Location: ../home.php?currentDay=$currentDay");
        exit();
    }
}else{
    header("Location: ../error.php");
    exit();
}