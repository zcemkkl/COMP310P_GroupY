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
?>

<html>

<head>

    <title>ViewEventAsHost</title>

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

            height: 250px;

        }



        input{

            font-size: 25px;

            margin-bottom:20px;

            border-radius: 10px;

            background-color: whitesmoke;

        }



        .YourEvents{

            font-size: 30px;

            margin:5px;

            border: inset;

            border-radius: 10px;

            height: 420px;

            background-color: transparent;

        }



    </style>

</head>

<body>

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
    $CurrentEvent = $_POST['book'];

    echo "Welcome " . $user;
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

    <input type="button" value="Order History" id="OrderHistory" onclick="location.href = 'orderHistory.php';" >

    <br>

    <input type="button" value="Your Events" id="YourEvents" onclick="location.href = 'YourEvents.php';" >



</div>



<div class="YourEvents">


    <?php
    //get event details
    include 'dbconnect.php';

    $connection = connect();
    $sql = "SELECT `event`.`Description` FROM `event`
                    WHERE `title` = '$CurrentEvent'";
    $result = mysqli_query($connection, $sql);
    $row = mysqli_fetch_array($result);
    $TitleDescription = $row['Description'];
    ?>
    <!-- Each event only contains one of the following variables -->
    <h1><?php echo $CurrentEvent ?></h1>
    <br>
    <p>Description : <?php echo $row['Description'] ?></p>
    <br>
    <p>Review : </p>
    <br>
    <!--Display multiple review of the event  -->
    <?php
    $sql2 = "SELECT `review`.`Description` FROM `review`
                    JOIN `event` ON `event`.`Event_id`=`review`.`Event_id`
                    WHERE `title` = '$CurrentEvent'";
    $result = mysqli_query($connection, $sql2);
    if (mysqli_num_rows($result) === 0) {
        echo "You have no reviews";
    } else {
        while ($row = mysqli_fetch_array($result)) {
            $TitleReview = $row['Description'];
            echo $TitleReview;
            echo "<br><br>";
        }
    }
    ?>
    <!--Display buying options for each individual show  -->
    <?php
    //for each show there will be a seperate buying option generated
    $sql3 = "SELECT `show_details`.`Venue`, `show_details`.`Start_time`, `show_details`.`End_time`, `show_details`.`Date`,
                     `show_details`.`Ticket_Num`,`ticket`.`Sold_tickets`, `ticket`.`Price`, `show`.`Show_id`
                     FROM `show_details`
                     JOIN `show` ON `show`.`Show_id`=`show_details`.`Show_id`
                     JOIN `event` ON `event`.`Event_id`=`show`.`Event_id`
                     JOIN `ticket` ON `ticket`.`Show_id`=`show_details`.`Show_id`
                     WHERE `Title` = '$CurrentEvent'";
    $result = mysqli_query($connection, $sql3);


    while ($row = mysqli_fetch_array($result)) {

    ?>
    <form action="ListSales.php" method="post">
        <?php  $ShowID = $row['Show_id']; ?>

        <p>Show Date: <?php echo $row['Date'] ?></p>

        <p>Start time: <?php echo $row['Start_time'] ?></p>

        <p>End time: <?php echo $row['End_time'] ?></p>

        <p>Venue: <?php echo $row['Venue'] ?></p>

        <p>Total Amount of tickets: <?php echo $row['Ticket_Num'] ?></p>

        <p>Avaliable Tickets: <?php echo $row['Ticket_Num']-$row['Sold_tickets'] ?></p>

        <button name="SeeSales" value="<?php echo $ShowID ?>" type="submit">See Sales</button>

        <br><br>
        
        <?php

        }

        ?>



</div>



</body>

</html>