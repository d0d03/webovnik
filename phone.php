<?php
    session_start();
    if(!isset($_SESSION['uname'])){
        header("Location: ./error.php");
    }
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title>Phone Book</title>
</head>

<body>

    <header class="jumbotron text-center" style="margin-bottom: 0;">
        <h1>PHONE BOOK </h1>
    </header>

    <nav class="navbar navbar-expand-sm bg-primary navbar-light">
        <a class="navbar-brand" href="#">MENU : </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./home.php">SCHEDULE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">PHONE BOOK</a>
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
        <div class="container">
            <section class="card bg-primary text-white">
                <div class="card-body clearfix">
                    <input type="text" name="search" id="search" onchange="search();"/>
                    <button type="submit" id="btnSearch" name="submit_search" onclick="show();" class="btn btn-dark">Search</button>
                    <button class="float-right btn btn-dark" id="btnAddContact" data-target="#contactModal" data-toggle="modal">+ add</button>
                </div>
            </section>
            <div class="modal fade" id="searchModal">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Search results</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <thead class="text-info">
                                    <tr>
                                        <th>Contact name</th>
                                        <th>e-Mail</th>
                                        <th>Phone number</th>
                                        <th>Birthday</th>
                                    </tr>
                                </thead>
                                <tbody id="searchBody">
                                    <script>
                                        function search(){
                                            var txt = $("#search").val();
                                            var searchXmlhttp = new XMLHttpRequest();
                                            searchXmlhttp.onreadystatechange = function () {
                                                if (this.readyState == 4 && this.status == 200) {
                                                    document.getElementById("searchBody").innerHTML = this.responseText;
                                                }
                                            }
                                            searchXmlhttp.open("GET", "./src/search.php?search="+txt, true);
                                            searchXmlhttp.send();
                                        }
                                        function show(){
                                            if($("#search").val()==""){
                                                alert("You need to enter something to search for!")
                                            }else{
                                                $("#searchModal").modal('show');
                                            }
                                        }
                                    </script>
                                </tbody>
                            </table>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-danger' data-dismiss='modal'>Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <form class="modal fade" id="contactModal" action="./src/saveContact.php" method="POST">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="addTitle">Contact info</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <label for="cname">Contact name:</label>
                            <input class="form-control" id="modalCName" name="cname" type="text" required/>
                            <label for="email">e-Mail:</label>
                            <input class="form-control" name="email" id="modalCEmail" type="email"/>
                            <div class="form-row">
                                <div class="col">
                                    <label for="pnum">Phone number:</label>
                                    <input class="from-control-plaintext" id="modalCPhone" name="pnum" type="tel"/>
                                </div>
                                <div class="col">
                                    <label for="bday">Birthday: </label>
                                    <input class="from-control" id="modalCBirthday" name="bday" type="date"/>
                                </div>
                            </div>
                            <input type="hidden" id="contactID" name="contactID"/>
                        </div>
                        <div class="modal-footer d-flex">
                            <button type="submit" name="btnEdit" class="p-1 btn btn-success">Save</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" name="btnRemove" id="btnRemove" class="btn btn-link" style="position: absolute; left:0;">Remove</button>
                        </div>
                    </div>
                </div>
            </form>
            <table class="table table-hover table-dark table-striped">
                <thead class="text-info">
                <tr>
                    <th>Contact name</th>
                    <th>e-Mail</th>
                    <th>Phone number</th>
                    <th>Birthday</th>
                </tr>
                </thead>
                <tbody id="cTableBody">
                    <script>
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function () {
                            if(this.readyState == 4 && this.status==200){
                                document.getElementById("cTableBody").innerHTML=this.responseText;
                            }
                            $(document).ready(function(){
                                $("#cTableBody tr").click(function(event){
                                    event.preventDefault();
                                    $("#contactModal").attr("action","./src/editContact.php");
                                    $("#modalCName").val(this.children['cName'].innerText);
                                    $("#modalCEmail").val(this.children['cEmail'].innerText);
                                    $("#modalCPhone").val(this.children['cPhone'].innerText);
                                    $("#modalCBirthday").val(this.children['cBday'].innerText);
                                    $("#contactID").val(this.id.substr(7,(this.id.length - 6)));
                                    $("#btnRemove").show();
                                    $("#contactModal").modal('show');
                                });
                                $("#btnAddContact").click(function(event){
                                    event.preventDefault();
                                    $("#contactModal").attr("action","./src/saveContact.php");
                                    $("#modalCName").val("");
                                    $("#modalCEmail").val("");
                                    $("#modalCPhone").val("");
                                    $("#modalCBirthday").val("");
                                    $("#contactID").val();
                                    $("#btnRemove").hide();
                                });
                                $("btnSearch").click(function(event){
                                    event.preventDefault();
                                    $("#searchModal").modal('show');
                                })
                            })
                        }
                        xmlhttp.open("GET","./src/getContact.php",true);
                        xmlhttp.send();

                    </script>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="jumbotron text-center" style="margin-bottom:0">
        <?php
        if(isset($_SESSION['uname'])){
            echo '<form action="src/logout.inc.php" method="POST"><button type="submit" name="submit" class="btn btn-primary">LOG OUT</button></from>';
        }
        ?>
    </footer>
</body>
</html>
