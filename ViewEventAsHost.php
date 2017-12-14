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
            height: 200px;
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
            background-color: transparent;
            float: left;
        }

        table{
            width:800px;
        }
        td, th {
            border: 1px solid Black;
            text-align: center;
            padding: 10px;
            font-size: 20px;
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
    $user = $_COOKIE["firstName"]; //get cookie of user from Login Page
    $CurrentEvent = $_POST['book']; //get variable $currentEvent from yourEvents.php
    echo "Welcome " . $user;
    ?>

    <br>
    <form action="It'sShowtime(Start Point).php"> <!-- Link to main page after Log out -->
        <input type="submit" value="Log Out" id="Logout">
        <?php
        setcookie("firstName", "", time() - 1); //reset Cookie
        setcookie("userID","",time()-1); //reset Cookie
        ?>
    </form>
    <input type="button" onclick="location.href='yourEvents.php'" value="Back"> <!-- link to go back to yourEvents.php page-->


</div>

<div class="YourEvents">

    <?php
    //get event details
    include 'dbconnect.php';
    $connection = connect();
    $sql = "SELECT `event`.`Description`, `event`.`Event_id` FROM `event`
                    WHERE `title` = '$CurrentEvent'";
    $result1 = mysqli_query($connection, $sql);
    $row1 = mysqli_fetch_array($result1);
    $TitleDescription = $row1['Description'];
    ?>
    <!-- Each event only contains one of the following variables -->
    <h1><?php echo $CurrentEvent ?></h1>
    <br>
    <p>Description : <?php echo $row['Description'] ?></p>
    <br>
    <h2>Review : </h2>
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
    <h2>Shows for <?php echo $CurrentEvent ?></h2>
    <?php
    //for each show there will be a seperate buying option generated
    $sql3 = "SELECT `show_details`.`Venue`, `show_details`.`Start_time`,`show_details`.`End_time`, `show_details`.`Date`,
                     `show_details`.`Ticket_Num`,`ticket`.`Sold_tickets`, `ticket`.`Price`, `show`.`Show_id`
                     FROM `show_details`
                     JOIN `show` ON `show`.`Show_id`=`show_details`.`Show_id`
                     JOIN `event` ON `event`.`Event_id`=`show`.`Event_id`
                     JOIN `ticket` ON `ticket`.`Show_id`=`show_details`.`Show_id`
                     WHERE `Title` = '$CurrentEvent'";
    $result = mysqli_query($connection, $sql3);

    if (mysqli_num_rows($result)==0){
        echo "Sorry, you do not have any shows added";
        setcookie("eventID", $row1['Event_id'], 0,'/');
        echo "<br><br>";
        echo "<form action='addshow.php'><input type='submit' value='Add Show'></form>";
    }
    else{
    setcookie("eventID", $row1['Event_id'], 0,'/');
    echo "<form action='addshow.php'><input type='submit' value='Add Show'></form>";
        while ($row = mysqli_fetch_array($result)) {

        ?>
        <form action="ListSales.php" method="post">
        <?php  $ShowID = $row['Show_id']; ?>


        <table>
            <tr>
                <th>Show Date: </th>
                <th><?php echo $row['Date'] ?></th>
            </tr>
            <tr>
                <th>Start time: </th>
                <th><?php echo $row['Start_time'] ?></th>
            </tr>
            <tr>
                <th>End time: </th>
                <th><?php echo $row['End_time'] ?></th>
            </tr>
            <tr>
                <th>Venue: </th>
                <th><?php echo $row['Venue'] ?></th>
            </tr>
            <tr>
                <th>Total Amount of tickets: </th>
                <th><?php echo $row['Ticket_Num'] ?></th>
            </tr>
            <tr>
                <th>Avaliable Tickets: </th>
                <th><?php echo $row['Ticket_Num']-$row['Sold_tickets'] ?></th>
            </tr>
        </table>


        <button name="SeeSales" value="<?php echo $ShowID ?>" type="submit">See Sales</button>

        <br><br>



        <?php

        }
    }
    ?>


</div>

</body>
</html>

