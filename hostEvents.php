<!DOCTYPE html>

<html>
<head>
    <title>Host Events</title>
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

        .HostEvents{
            font-size: 30px;
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

$titleErr = $artistErr = $descriptionErr ="";
$connection = connect();
$userID=$_COOKIE["userID"];

$title = $categoryID = $artist = $description ="";

$sql1 = "SELECT Category_id, Category FROM `category`";
$result1 = mysqli_query($connection, $sql1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["title"])){
        $titleErr = "* Please enter a Title for your event";
    }
    else{
        $title = $_POST["title"];
        $categoryID = $_POST["categoryID"];
        if (empty($_POST["artist"])){
            $artistErr = "* Please enter Artist name for your event";
        }
        else {
            $artist = $_POST["artist"];
            if(empty($_POST["description"])){
                $descriptionErr = "* Please enter a description for your event";
            }
            else{
                $description = $_POST["description"];
                $sql2 = "SELECT Event_id FROM `event` ORDER BY Event_id DESC LIMIT 1";
                $result2 = mysqli_query($connection, $sql2);
                $row2 = mysqli_fetch_array($result2);
                $eventID=$row2['Event_id']+1;
                $sql3 = "INSERT INTO `event`(`Title`, `Event_id`, `Category_id`, `Artist`, `Description`)"." VALUES ('$title','$eventID','$categoryID','$artist','$description')";
                $result3 = mysqli_query($connection,$sql3) or die('Error making saveToDatabase query');
                setcookie("eventID", "$eventID",0,'/');
                $sql4 = "INSERT INTO `organiser`(`Event_id`, `User_id`)"." VALUES ('$eventID','$userID')";
                $result4 = mysqli_query($connection,$sql4) or die('Error making saveToDatabase query');
                header("location: addShow.php");
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

<div class="HostEvents">
    <h3>Host Event</h3>
    <form method="post">
        Title:
        <input type="text" name="title" value="<?php echo $title;?>">
        <span class="error"><?php echo $titleErr ?></span>
        <br>
        Category:
        <?php
        echo '<select name ="categoryID">';
        while ($row1=mysqli_fetch_array($result1)){
            $category=$row1['Category'];
            $categoryID=$row1['Category_id'];
            echo '<option value='.$categoryID.';>'.$category.'</option>';
        }
        echo '</select>';
        ?>
        <br><br>
        Artist:
        <input type="text" name="artist" value="<?php echo $artist;?>">
        <span class="error"><?php echo $artistErr ?></span>
        <br>
        Description:
        <input type="text" name="description" value="<?php echo $description;?>">
        <span class="error"><?php echo $descriptionErr ?></span>
        <br>
        <input type="submit" value="Next">
    </form>
</div>

</body>
</html>