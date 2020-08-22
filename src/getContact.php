<?php
    include './connect.php';
    session_start();

    if(isset($_SESSION['uname'])){
        $sql = "SELECT * FROM contacts WHERE userID ='{$_SESSION['uname']}'";
        $result = mysqli_query($conn,$sql);
        $queryResults = mysqli_num_rows($result);

        $contact='';

        if($queryResults > 0) {
            while($row = mysqli_fetch_assoc($result)){
                $contact.= "<tr id='contact".$row['cID']."'><td id='cName'>".$row['cName']."</td><td id='cEmail'>".$row['cEmail']."</td><td id='cPhone'>".$row['cPhone']."</td><td id='cBday'>";
                if($row['cBday']!="0000-00-00"){
                    $contact.= $row['cBday'];
                }
                    $contact.="</td></tr>";
            }
            echo $contact;
        }else{
            echo "<p style='padding: 5px;color:red'>You have no contacts!</p>";
        }
    }
