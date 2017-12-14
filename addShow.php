<!DOCTYPE html>

<html>
<head>
    <title>Add Show</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">

    <style>
        .error {color: #FF0000;}
        body {
            background: url('http://localhost/Events%20project/Background2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: 0px 0px;
        }
        header{
            text-align: center;
            color: white;
            font-size: 50px;
            padding-top:30px;
            padding-bottom: 30px;
            margin:5px;
            border-radius: 10px;
            border: inset 5px;
            background-color: #A0793D;
        }
        .homeLinkBackgroundPad{

            margin-top: 10px;

            float: left;

            margin-left: 20px;

            border-top: 85px solid black;

            border-left: 70px solid transparent;

            border-right: 85px solid transparent;

            height: 0;

            width: 225px;

            transform: skew(-20deg);

        }

        .homeLinkPad{

            float: left;

            margin-top: 15px;

            margin-left: -370px;

            border-top: 75px solid #502900;

            border-left:65px solid transparent;

            border-right: 80px solid transparent;

            height: 0;

            width: 215px;

            transform: skew(-20deg);

        }

        .homeLink{

            float: left;

            margin-top: 16px;

            margin-left: -320px;

            font-family: 'Permanent Marker', cursive;

            font-size: 38px;

            transform: skew(-20deg);

        }
        a{
            color: ghostwhite;
            text-decoration: none;
        }

        .Account{
            font-family: "Brush Script MT";
            font-size: 35px;
            text-align: center;
            vertical-align: middle;
            width:290px;
            float:left;
            margin:5px;
            border-radius: 10px;
            background-color: #C8A165;
            border: inset;
            color: white;
            height: 100px;
        }

        .Selection{
            padding: 20px;
            width:250px;
            clear: left;
            float:left;
            margin:5px;
            text-align: center;
            border-radius: 10px;
            background-color: #E6BF83;
            border: inset;
            height: 200px;
        }

        input{
            font-size: 25px;
            margin-bottom:20px;
            border-radius: 10px;
            background-color: whitesmoke;
        }

        .addShow{
            font-size: 20px;
            margin:5px;
            border: inset;
            border-radius: 10px;
            height: 370px;
            background-color: transparent;
            line-height: 30px;
        }
        select{
            font-size: 20px;
        }
        #submitButton{font-size:15px;}
        #startTimeBox{font-size:15px;}
        #endTimeBox{font-size:15px;}
        #venueBox{font-size:15px;}
        #dateBox{font-size:15px;}
        #ticketBox{font-size:15px;}

    </style>
</head>
<body>

<?php

function connect() {
    $dbuser = 'root';
    $dbpass = 'root';
    $dbname = 'events';
    $dbhost = 'localhost';

    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    if (!$connection) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    return $connection;
}

$connection = connect();
$userID=$_COOKIE["userID"];
$eventID=$_COOKIE["eventID"];

$showID = $venue = $startTime = $endTime = $date = $ticketAvailable ="";
$venueErr = $startTimeErr = $endTimeErr = $dateErr = $ticketAvailableErr ="";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["venue"])) {
        $venueErr = "* Please enter a venue for your show";
    } else {
        $venue = $_POST["venue"];
        if (empty($_POST["startTime"])) {
            $startTimeErr = "* Please enter a start time for your show";
        } else {
            $startTime = $_POST["startTime"];
            if (empty($_POST["endTime"])) {
                $endTimeErr = "* Please enter a end time for your show";
            } else {
                $endTime = $_POST["endTime"];
                if (empty($_POST["date"])) {
                    $dateErr = "* Please enter a date for your show";
                } else {
                    $date = $_POST["date"];
                    if (empty($_POST["ticketAvailable"])) {
                        $dateErr = "* Please enter the total number of tickets available for your show";
                    } else {
                        $ticketAvailable = $_POST["ticketAvailable"];
                        $sql1 = "SELECT Show_id FROM `show` ORDER BY Show_id DESC LIMIT 1";
                        $result1 = mysqli_query($connection, $sql1);
                        $row1 = mysqli_fetch_array($result1);
                        $showID = $row1['Show_id'] + 1;
                        $sql2 = "INSERT INTO `show_details`(`Show_id`, `Venue`, `Start_time`, `End_time`, `Date`, `Ticket_Num`)" . " VALUES ('$showID','$venue','$startTime','$endTime','$date','$ticketAvailable')";
                        $result2 = mysqli_query($connection, $sql2);
                        $sql3 = "INSERT INTO `show`(`Event_id`, `Show_id`)" . " VALUES ('$eventID','$showID')";
                        $result3 = mysqli_query($connection, $sql3) or die('Error making saveToDatabase query');
                        $showID = $venue = $startTime = $endTime = $date = $ticketAvailable = "";
                        $message = "Thank You for adding a show, you can fill in the form again to add another show";
                    }
                }
            }
        }
    }
}

mysqli_close($connection)
?>

<div class="homeLinkBackgroundPad"></div>
<div class="homeLinkPad"></div>
<div class="homeLink">
    <a href="home.php">It's Showtime</a>
</div>
<header>
    Manage, Create and join events here!
</header>


<div class='Account'>
    <?php
    $user = $_COOKIE["firstName"];
    echo "Welcome ".$user;
    ?>
    <br>
    <form action="It'sShowtime.php">
        <input type="submit" value="Log Out" id="Logout">
        <?php
        setcookie("firstName", "", time() - 1);
        setcookie("userID","",time()-1);
        ?>
    </form>


</div>

<div class='Selection'>
    <input type="button" value="Search Events" id="SearchEvents" onclick="location.href = 'home.php';" >
    <br>
    <input type="button" value="Your Events" id="YourEvents" onclick="location.href = 'yourEvents.php';" >
    <br>
    <input type="button" value="Your Account" id="YourAccount" onclick="location.href = 'account.php';" >
    <br>
    <input type="button" value="Your Orders" id="YourOrders" onclick="location.href = 'yourOrders.php';" >

</div>

<div class="addShow">
    <h3>Add Show</h3>
    <form method="post">
        Venue:
        <input type="text" name="venue" value="<?php echo $venue; ?>" id="venueBox">
        <span class="error"><?php echo $venueErr ?></span>
        <br>
        Start Time:
        <input type="time" name="startTime" value="<?php echo $startTime ?>" id="startTimeBox">
        <span class="error"><?php echo $startTimeErr ?></span>
        <br>
        End Time:
        <input type="time" name="endTime" value="<?php echo $endTime;?>" id="endTimeBox">
        <span class="error"><?php echo $endTimeErr ?></span>
        <br>
        Date:
        <input type="date" name="date" value="<?php echo $date;?>" id="dateBox">
        <span class="error"><?php echo $dateErr ?></span>
        <br>
        Total Tickets Available:
        <input type="number" name="ticketAvailable" value="<?php echo $ticketAvailable;?>" id="ticketBox">
        <span class="error"><?php echo $ticketAvailableErr ?></span>
        <br>
        <input type="submit" value="Add Show" id="submitButton">
    </form>
    <span class="error"><?php echo $message?></span>
</div>

</body>
</html>