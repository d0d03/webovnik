<?php
    include_once './src/connect.php';
    session_start();

    if(!isset($_SESSION['uname'])){
        header("Location: ./error.php");
    }

    date_default_timezone_set('Europe/Zagreb');

    if(isset($_GET['ym'])){
        $ym = $_GET['ym'];
    }else{
        $ym = date('Y-m');
    }

    $timestamp = strtotime($ym,"-01");
        if($timestamp === false){
        $timestamp = time();
    }

    $today = date('Y-m-d',time());
    if(isset($_GET['currentDay'])){
        $currentDay = $_GET['currentDay'];
    }else{
        $currentDay = $today;
    }

    $html_title = date('Y / m',$timestamp);
    $prev = date('Y-m',mktime(0,0,0,date('m',$timestamp)-1,1,date('Y',$timestamp)));
    $next = date('Y-m',mktime(0,0,0,date('m',$timestamp)+1,1,date('Y',$timestamp)));

    $day_count = date('t',$timestamp);

    $str = date('w',mktime(0,0,0,date('m',$timestamp),1,date('Y',$timestamp)));

    $weeks = array();
    $week = '';

    $week .= str_repeat('<td></td>',$str);

    for($day = 1;$day <= $day_count;$day++,$str++) {
        $date = $ym . '-' . $day;
        $c = date('Y-m-d', mktime(0, 0, 0, date('m', $timestamp), $day, date('Y', $timestamp)));
        $eventNum = 0;
        if (isset($_SESSION['uname'])) {
            $result = $conn->query("SELECT title FROM events WHERE date='" . $date . "' AND status=1 AND userID='" . $_SESSION['uname'] . "'");
            $eventNum = $result->num_rows;
        }
        if (strtotime($today) === strtotime($date)) {
            $week .= '<td class="today monthDay" id="' . $c . '" onclick="create(this.id);">' . $day . '<br/>';
            for ($i = 0; $i < $eventNum; $i++) {
                $week .= '&#9900;';
            }
            $week .= '</td>';
        } else {
            $week .= '<td class="monthDay" id="' . $c . '"onclick="create(this.id);">' . $day . '<br/>';
            for ($i = 0; $i < $eventNum; $i++) {
                $week .= '&#9900;';
            }
            $week .= '</td>';
        }

        if ($str % 7 == 6 || $day == $day_count) {
            if ($day == $day_count) {
                $week .= str_repeat('<td></td>', 6 - ($str % 7));
            }
            $weeks[] = '<tr>' . $week . '</tr>';
            $week = '';
        }
    }
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/calendar.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title>Home</title>
</head>

<body onload="create('<?=$currentDay?>')">
<header class="jumbotron text-center" style="margin-bottom:0">
    <h1>SCHEDULE</h1>
</header>

<nav class="navbar navbar-expand-sm bg-primary navbar-light">
    <a class="navbar-brand" href="#">MENU : </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">SCHEDULE</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./phone.php">PHONE BOOK</a>
            </li>
            <li class="nav-item" style="position: absolute; right:50px;">
                <div class="dropdown dropleft float-right">
                    <button class="btn btn-dark dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear" style="font-size: 25px"></i></button>
                    <div class="dropdown-menu">
                        <h5 class="dropdown-header">Username: </h5>
                        <span class="dropdown-item-text"><?=$_SESSION['uname']?></span>
                        <h5 class="dropdown-header">e-Mail: </h5>
                        <span class="dropdown-item-text"><?=$_SESSION['email']?></span>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="settings.php">Settings</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>

<main class="container" style="margin-top:30px">
    <div class="row">
        <aside class="col-sm-6">
            <div class="card">
                <div id="dayEvents" class="card-body">
                    <script>
                        function create (day) {
                            Array.from(document.querySelectorAll(".monthDay")).forEach(d=>{
                                if(d.id == day){
                                    d.style="border: 2px outset green";
                                }else{
                                    if(d.id==<?=$today?>){
                                        d.style= "background: green;opacity: 0.7;";
                                    }else{
                                        d.style="none";
                                    }
                                }
                            });

                            var xmlhttp = new XMLHttpRequest();
                            xmlhttp.onreadystatechange= function(){
                                if(this.readyState == 4 && this.status==200){
                                    document.getElementById("dayEvents").innerHTML=this.responseText;
                                }
                                $(document).ready(function(){
                                    $(".btnEdit").click(function(event){
                                        event.preventDefault();
                                        $("#start").val(($(".card-title").attr('id') + "T" + ($("#time"+event.target.id).text().substr(0,5))));
                                        $("#end").val(($(".card-title").attr('id') + "T" + ($("#time"+event.target.id).text().substr(8,12))));
                                        $("#task").val($("#title"+event.target.id).text());
                                        $("#edit").val(event.target.id);
                                        $("#editModal").modal('show');
                                    });

                                    $(".btnRemove").click(function(event){
                                        event.preventDefault();
                                        $("#remove").val(event.target.id);
                                        $("#removeModal").modal('show');
                                    });
                                });
                            }
                            xmlhttp.open("GET","./src/getDaySchedule.php?date="+day,true);
                            xmlhttp.send();
                        }
                    </script>
                </div>
            </div>
        </aside>
        <section class="col-sm-6">
            <div class="calendar">
                <h3><a href="?ym=<?php echo $prev; ?>">&lt;</a> <?php echo $html_title; ?> <a href="?ym=<?php echo $next; ?>">&gt;</a></h3>
                <br>
                <table class="table">
                    <tr>
                        <th>Su</th>
                        <th>Mo</th>
                        <th>Tu</th>
                        <th>We</th>
                        <th>Th</th>
                        <th>Fr</th>
                        <th>Sa</th>
                    </tr>
                    <?php
                    foreach($weeks as $week){
                        echo $week;
                    }
                    ?>
                </table>
            </div>
        </section>
    </div>

    <form class="modal fade" id="addModal" action="./src/setTask.php" method="POST">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addTitle">Add task</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label for="start">Start</label>
                    <input class="form-control" name="start" type="datetime-local" value="<?php echo date("Y-m-d\TH:i", strtotime($currentDay)); ?>" required/>
                    <label for="end">End</label>
                    <input class="form-control" name="end" type="datetime-local" value="<?php echo date("Y-m-d\TH:i", strtotime($currentDay)); ?>" required/>
                    <label for="task">Task</label>
                    <input class="form-control" name="task" type="text" required/>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" class="btn btn-success">Set</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </form>

    <form class="modal fade" id="editModal" action="./src/editTask.php" method="POST">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editTitle">Edit task</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <label for="start">Start</label>
                    <input class="form-control" id="start" name="start" type="datetime-local" required/>
                    <label for="end">End</label>
                    <input class="form-control" id="end" name="end" type="datetime-local" required/>
                    <label for="task">Task</label>
                    <input class="form-control" name="task" type="text" id="task" required/>
                    <input type="hidden" id="edit" name="edit" />
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </form>

    <form class="modal fade" id="removeModal" action="./src/removeTask.php" method="POST">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Remove task</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to remove this task?</p>
                    <input id="remove" name="remove" type="hidden" />
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" class="btn btn-success">Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </form>
</main>

<footer class="jumbotron text-center" style="margin-bottom:0">
    <?php
        if(isset($_SESSION['uname'])){
            echo '<form action="src/logout.inc.php" method="POST"><button type="submit" name="submit" class="btn btn-primary">LOG OUT</button></from>';
            echo '';
        }
    ?>
</footer>
</body>
</html>