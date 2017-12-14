<!DOCTYPE html>

<html>
<head>
    <title>Feedback</title>
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

            color: ghostwhite;

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

        .feedback{
            font-size: 30px;
            margin:5px;
            border: inset;
            border-radius: 10px;
            height: 370px;
            background-color: transparent;
        }
        select{
            font-size: 20px;
        }
        #submitButton{
            background: red;
            color: white;
        }
        .message{
            color: red;
        }

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

$message="";
$comments=$eventID=$rating="";

$connection = connect();
$userID=$_COOKIE["userID"];

$sql1 = "SELECT DISTINCT `event`.Title,`event`.`Event_id` FROM `event`
JOIN `show` ON `show`.`Event_id` = `event`.`Event_id`
JOIN `show_details` ON `show_details`.`Show_id` = `show`.`Show_id`
JOIN `sales` ON `show_details`.`Show_id` = sales.Show_id
WHERE sales.User_id = '$userID'";
$result1 = mysqli_query($connection, $sql1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventID = $_POST["eventID"];
    $rating = $_POST["rating"];
    $comments = $_POST["comments"];
    $date = date("Y/m/d");
    $sql2 = "INSERT INTO `review`(`Event_id`, `User_id`, `Rating`, `Description`, `Review_date`)"." VALUES ('$eventID','$userID','$rating','$comments', '$date')";
    $result2 = mysqli_query($connection,$sql2) or die('Error making saveToDatabase query');
    $message="Thank You for the feedback";
}
mysqli_close($connection);

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
<div class="homeLinkBackgroundPad"></div>
<div class="homeLinkPad"></div>
<div class="homeLink">
    It's Showtime
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
    <input type="button" value="Host Events" id="HostEvents" onclick="location.href = 'hostEvents.php';" >
</div>

<div class="feedback">
    Feedback
    <br><br>
    <form method="post">
        <?php
        echo "Event: ";
        echo '<select name="eventID">';
        while ($row1=mysqli_fetch_array($result1)){
            $title=$row1['Title'];
            $eventID=$row1['Event_id'];
            echo '<option value='.$eventID.';>'.$title.'</option>';
        }
        echo '</select>';
        ?>
        <br>
        <?php
        echo "Rating: ";
        echo '<select name="rating">';
        for ($rating=0; $rating <= 10; $rating++){
            echo '<option value='.$rating.';>'.$rating.'</option>';
        }
        echo'</select>';
        ?>
        <br>
        <?php echo "Comments: "?>
        <input type="text" name="comments" value="<?php echo $comments;?>" id="commentsBox">
        <br>
        <input type="submit" name="submit" id="submitButton">
    </form>
    <span class ="message"><?php echo $message ?></span>
    <br>
    <input type="button" value="back" onclick="location.href ='yourOrders.php'">
</div>

</body>
</html>