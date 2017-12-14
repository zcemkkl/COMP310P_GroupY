<!DOCTYPE html>

<html>
<head>
    <title>Your Events</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">

    <style>
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
            position: fixed;
            margin-top: -123px;
            margin-left: 20px;
            border-top: 85px solid black;
            border-left: 70px solid transparent;
            border-right: 85px solid transparent;
            height: 0;
            width: 225px;
            transform: skew(-20deg);
        }
        .homeLinkPad{
            position: fixed;
            margin-top: -118px;
            margin-left: 30px;
            border-top: 75px solid #502900;
            border-left:65px solid transparent;
            border-right: 80px solid transparent;
            height: 0;
            width: 215px;
            transform: skew(-20deg);
        }
        .homeLink{
            position: fixed;
            margin-top: -119px;
            margin-left: 80px;
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

        .YourOrders{
            font-size: 30px;
            margin:5px;
            border: inset;
            border-radius: 10px;
            height: 370px;
            background-color: transparent;
        }

    </style>
</head>
<body>

<header>
    Manage, Create and join events here!
</header>
<div class="homeLinkBackgroundPad"></div>
<div class="homeLinkPad"></div>
<div class="homeLink">
    <a href="home.php">It's Showtime</a>
</div>

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
    <input type="button" value="Your Account" id="YourAccount" onclick="location.href = 'account.php';" >
    <br>
    <input type="button" value="Host Events" id="HostEvents" onclick="location.href = 'hostEvents.php';" >
    <br>
    <input type="button" value="Your Orders" id="YourOrders" onclick="location.href = 'yourOrders.php';" >

</div>

<div class="YourOrders">
    Your Orders:
    <br>
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

    $message="";

    $connection = connect();
    $userID=$_COOKIE["userID"];

    $sql = "SELECT `event`.Title, `show_details`.Venue, `show_details`.Start_time, `show_details`.Duration, `show_details`.date, `sales`.Tickets_brought FROM `event`
JOIN `show` ON `show`.`Event_id` = `event`.`Event_id`
JOIN `show_details` ON `show_details`.`Show_id` = `show`.`Show_id`
JOIN `sales` ON `show_details`.`Show_id` = `sales`.Show_id
WHERE `sales`.User_id = '$userID'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($result);

    if (mysqli_num_rows($result) === 0) {
        $message = "*Sorry, you are currently not hosting any events";
    }
    else {
        echo '<table border="1">';
        while ($row = mysqli_fetch_array($result)) {
            echo '<tr><td>' . $row['Title']. '</td><td>'. $row['Venue'].'</td><td>'. $row['date'].'</td><td>'. $row['Start_time']. '</tr></td>';
        }
        echo '</table>';
    }

    mysqli_free_result($result);
    mysqli_close($connection);

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    echo $message;
    ?>
</div>

</body>
</html>