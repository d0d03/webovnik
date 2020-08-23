<?php
    session_start();
    if(isset($_POST['submit'])){
        session_unset();
        session_destroy();
        header("Location: ../index.html");
        exit();
    }else{
        header("Location: ../error.php");
        exit();
    }