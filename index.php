<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/links.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title>WEBOVNIK</title>
</head>
<body>

<header class="jumbotron text-center" style="margin-bottom: 0;">
    <h1>WELCOME TO WEBOVNIK</h1>
    <p>Early is on time, on time is late and late is unacceptable!</p>
</header>
<main class="container">
    <div class="row">
        <aside id="info" class="col-sm-6">
            <?php
            if(isset($_GET['deleted'])){
                echo "<h2>You've deleted your account successfuly!</h2>
                <p>We're sorry if this site didn't met your expectations. If you have any suggestions on how to improve it please contact us:</p>
                <label for='message'>Message:</label><textarea class='form-control' id='message' name='message' onchange='messageMe();'></textarea>
                <a id='myMail' href='mailto:dbosnjak@etfos.hr?subject=Webovnik%20suggestions&body='>Send mail</a>";
            }else{
                echo "<h2>Website info</h2>
            <p>Webovnik is a great site for keeping track of your schedule and appointments.
                User friendly interface provides you with quick and easy way for setting up your schedule like
                appointments, work meetings, birthdays, grocery lists so you can always be early and prepared
                because on time is late!</p>
            <p>Furthermore you can also keep a record of your contacts, and important information about them like their
                e-mail address, phone number and even their birthday so you never forget to buy a present</p>
            <p>Site is made for a web-programming project and it contains a view of day tasks and a calendar. Other then that
                you have access to your contacts list, which you can edit and search so your access of information is quicker and easier
            </p>";
            }
            ?>
        </aside>
        <section class="col-sm-6">
            <a href="login.php">LOGIN</a>
            <br/>
            <a href="register.php">MAKE ACCOUNT</a>
        </section>
    </div>

    <script>
        function messageMe(){
            let message = (document.getElementById("message").value);
            let url = document.getElementById("myMail").href + message;
            document.getElementById("myMail").href = url;
        }
    </script>
</main>
</body>
</html>