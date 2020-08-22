<?php
    include './connect.php';
    session_start();

    if(isset($_GET['date'])) {
        $currentDay = $_GET['date'];
        $dayEvents = '';
        $dayEvents .= "<h4 class='card-title' id='".$currentDay."'>" . date("l", strtotime($currentDay)) . " <br/>" . date("F d, Y", strtotime($currentDay)) . "</h4>";
        $dayEvents .= "<section class='row'><p class='card-text col-sm-9' style='border-bottom: 2px solid red;'>EVENTS</p><button id='btnAdd' class='btn btn-secondary col-sm-3' data-toggle='modal' data-target='#addModal'>+ add</button></section><table class='table'>";

        $result = $conn->query("SELECT * FROM events WHERE date='" . $currentDay . "' AND status=1 AND userID='" . $_SESSION['uname'] . "'");
        if ($result->num_rows > 0) {
            $dayEvents .= "<tr><th style='text-align:left ;'>&#128338;</th><th style='text-align: left'>Task</th></tr>";
            $i = 0;
            while ($row = $result->fetch_assoc()) {
                $dayEvents .= "<tr><td id='time".$row['id']."' style='text-align: left;'>" . date('H:i', strtotime($row['start'])) . " - " . date('H:i', strtotime($row['end'])) . "</td><td id='title".$row['id']."'  style='text-align: left;'>" . $row['title'] . "</td><td><a href='#editModal' class='btnEdit' id='" . $row['id'] . "'>Edit</a><br/><a href='#removeModal' class='btnRemove' id='" . $row['id'] . "'>Remove</a></td></tr>";
            }
        }
        $dayEvents .= "</table>";

        echo $dayEvents;
    }

