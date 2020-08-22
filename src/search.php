<?php
    session_start();
    if(isset($_GET['search'])){
        include_once './connect.php';
        $contact ='';
        $search = mysqli_real_escape_string($conn,$_GET['search']);
        $sql = "SELECT * FROM contacts WHERE cName LIKE '%$search%' OR cPhone LIKE '%$search%'";
        $result = mysqli_query($conn,$sql);
        $queryResult = mysqli_num_rows($result);
        if($queryResult>0){
            while($row = mysqli_fetch_assoc($result)){
                $contact.= "<tr id='contact".$row['cID']."'><td id='cName'>".$row['cName']."</td><td id='cEmail'>".$row['cEmail']."</td><td id='cPhone'>".$row['cPhone']."</td><td id='cBday'>";
                if($row['cBday']!="0000-00-00"){
                    $contact.= $row['cBday'];
                }
                $contact.= "</td></tr>";
            }
            echo $contact;
        }else{
            echo "There are no results matching your search!";
        }
    }
