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

            height: 600px;

        }

        .Selection{
            font-family: 'Permanent Marker', cursive;
            border: 2px solid black;
            padding: 20px;
            width:250px;
            clear: left;
            float:left;
            margin:5px;
            text-align: center;
            border-radius: 10px;
        }



        input{

            font-size: 20px;

            margin-bottom:20px;

            border-radius: 10px;

            background-color: whitesmoke;

            align: center;

        }



        .YourSearch{

            margin-top: -110px;

            font-size: 30px;

            margin-left: 5px;

            border: inset;

            border-radius: 10px;

            background-color: transparent;

            float: left;

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

    <form id='Searchbox' method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h1>Search for events</h1>
        <br>
        <input type="text" placeholder="Search" name="find" value="<?php echo $find; ?>">
        <br>
        <input type="date" name="EventDate" id="EventDate" value="<?php echo $EventDate; ?>"/>
        <br>
        <label for="classical"><input type="checkbox" name="Category[]" value="Classical"/>Classical</label>
        <br>
        <label for="rock"><input type="checkbox" name="Category[]" value="Rock"/>Rock</label>
        <br>
        <label for="pop"><input type="checkbox" name="Category[]"value="Pop"/>Pop</label>
        <br>
        <label for="jazz"><input type="checkbox" name="Category[]" value="Jazz"/>Jazz</label>
        <br>
        <label for="EDM"><input type="checkbox" name="Category[]"value="EDM"/>EDM</label>
        <br>
        <label for="rap"><input type="checkbox" name="Category[]" value="Rap"/>Rap</label>
        <br>

        <input type="submit" value="search"/>
        <br>
    </form>

    <br>

    <input type="button" value="Your Events" id="YourEvents" onclick="location.href = 'YourEvents.php';" >

</div>

<div class="YourSearch">

    <?php
    include 'dbconnect.php';
    $connection = connect();
    // define variables and set to empty values
    $Err = "";
    $find = "";
    $TitleResult = "";
    $ButtonName = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $Category = $_POST['Category'];
        $EventDate = test_input($_POST["EventDate"]);
        $find = test_input($_POST["find"]);


        //if no criteria is selected
        if (empty($_POST["find"]) && empty($_POST["EventDate"]) && empty($Category)) {
            echo "Please enter a search criteria";
        } else {

            //if no categories were selected
            //only title submit
            if (empty($Category)) {
                if (empty($_POST["EventDate"])) {

                    $sql = "SELECT Title, Description FROM event 
                                WHERE Title  LIKE '%$find%'";
                    $result = mysqli_query($connection, $sql);

                    if (mysqli_num_rows($result) === 0) {
                        echo "Sorry, there are no events that match your search criteria";
                    } else {
                        while ($row = mysqli_fetch_array($result)) {
                            $TitleName = $row['Title'];
                            ?>
                            <form action="ViewEvent.php" method="post">
                                <input type="submit" value="<?php echo $row['Title'] ?>" name="book">
                            </form>
                            <?php
                            echo $row['Description'];
                            echo "<br><br><br>";
                        };
                    }
                }
                //only date submit
                else if (empty($_POST["find"])) {

                    $sql = "SELECT DISTINCT `event`.`Title`, `event`.`Description` FROM `event`
                                    JOIN `show` ON `show`.`Event_id`=`event`.`Event_id`
                                    JOIN `show_details` ON `show_details`.`Show_id`=`show`.`Show_id`
                                    WHERE `show_details`.`Date` >= '$EventDate'";
                    $result = mysqli_query($connection, $sql);

                    if (mysqli_num_rows($result) === 0) {
                        echo "Sorry, there are no events that match your search criteria";
                    } else {
                        while ($row = mysqli_fetch_array($result)) {
                            $TitleName = $row['Title'];
                            ?>
                            <form action="ViewEvent.php" method="post">
                                <input type="submit" value="<?php echo $row['Title'] ?>" name="book">
                            </form>
                            <?php
                            echo $row['Description'];
                            echo "<br><br><br>";
                        };
                    }
                }
                //only date and title
                else if (!empty($_POST["EventDate"]) && !empty($_POST["find"])) {
                    $sql = "SELECT DISTINCT `event`.`Title`, `event`.`Description` FROM `event`
                                    JOIN `show` ON `show`.`Event_id`=`event`.`Event_id`
                                    JOIN `show_details` ON `show_details`.`Show_id`=`show`.`Show_id`
                                    WHERE `show_details`.`Date` >= '$EventDate' 
                                    AND `event`.`Title` LIKE '%$find%'";
                    $result = mysqli_query($connection, $sql);

                    if (mysqli_num_rows($result) === 0) {
                        echo "Sorry, there are no events that match your search criteria";
                    } else {
                        while ($row = mysqli_fetch_array($result)) {
                            $TitleName = $row['Title'];
                            ?>
                            <form action="ViewEvent.php" method="post">
                                <input type="submit" value="<?php echo $row['Title'] ?>" name="book">
                            </form>
                            <?php
                            echo $row['Description'];
                            echo "<br><br><br>";
                        };
                    }
                }
            }

            //if categories were selected
            //generate sql search criteria for category
            $CategoryString = "";
            for ($i = 0; $i < 6; $i++) {
                if (isset($Category[$i])) {
                    if ($CategoryString == "") {
                        $CategoryString .= "'" . $Category[$i] . "'";
                    } else {
                        $CategoryString .= ",'" . $Category[$i] . "'";
                    }
                }
            }

            //only category selected
            if (empty($_POST["EventDate"]) && empty($_POST["find"])) {

                $sql = "SELECT `event`.`Title`, `event`.`Description` FROM `event`
                                JOIN `category` ON `category`.`Category_id`=`event`.`Category_id`
                                WHERE `category`.`Category` IN ($CategoryString)";
                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) === 0) {
                    echo "Sorry, there are no events that match your search criteria";
                } else {
                    while ($row = mysqli_fetch_array($result)) {
                        $TitleName = $row['Title'];
                        ?>
                        <form action="ViewEvent.php" method="post">
                            <input type="submit" value="<?php echo $row['Title'] ?>" name="book">
                        </form>
                        <?php
                        echo $row['Description'];
                        echo "<br><br><br>";
                    };
                }
            }
            //category and title selected
            else if (empty($_POST["EventDate"])) {
                $sql = "SELECT `event`.`Title`, `event`.`Description` FROM `event`
                                JOIN `category` ON `category`.`Category_id`=`event`.`Category_id`
                                WHERE `category`.`Category` IN ($CategoryString)
                                AND `event`.`Title` LIKE '%$find%'";

                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) === 0) {
                    echo "Sorry, there are no events that match your search criteria";
                } else {
                    while ($row = mysqli_fetch_array($result)) {
                        $TitleName = $row['Title'];
                        ?>
                        <form action="ViewEvent.php" method="post">
                            <input type="submit" value="<?php echo $row['Title'] ?>" name="book">
                        </form>
                        <?php
                        echo $row['Description'];
                        echo "<br><br><br>";
                    };
                }
            }
            //category and date selected
            else if (empty($_POST["find"])) {
                $sql = "SELECT DISTINCT `event`.`Title`, `event`.`Description` FROM `event`
                                JOIN `category` ON `category`.`Category_id`=`event`.`Category_id`
                                JOIN `show` ON `show`.`Event_id`=`event`.`Event_id`
                                JOIN `show_details` ON `show_details`.`Show_id`=`show`.`Show_id`
                                WHERE `category`.`Category` IN ($CategoryString)
                                AND `show_details`.`Date` >= '$EventDate'";
                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) === 0) {
                    echo "Sorry, there are no events that match your search criteria";
                } else {
                    while ($row = mysqli_fetch_array($result)) {
                        $TitleName = $row['Title'];
                        ?>
                        <form action="ViewEvent.php" method="post">
                            <input type="submit" value="<?php echo $row['Title'] ?>" name="book">
                        </form>
                        <?php
                        echo $row['Description'];
                        echo "<br><br><br>";
                    }
                }
            }
            //all the search criterias are selected
            else {
                $sql = "SELECT DISTINCT `event`.`Title`, `event`.`Description` FROM `event`
                                JOIN `category` ON `category`.`Category_id`=`event`.`Category_id`
                                JOIN `show` ON `show`.`Event_id`=`event`.`Event_id`
                                JOIN `show_details` ON `show_details`.`Show_id`=`show`.`Show_id`
                                WHERE `category`.`Category` IN ($CategoryString)
                                AND `show_details`.`Date` >= '$EventDate'
                                AND `event`.`Title` LIKE '%$find%'";
                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) === 0) {
                    echo "Sorry, there are no events that match your search criteria";
                } else {
                    while ($row = mysqli_fetch_array($result)) {
                        $TitleName = $row['Title'];
                        ?>
                        <form action="ViewEvent.php" method="post">
                            <input type="submit" value="<?php echo $row['Title'] ?>" name="book">
                        </form>
                        <?php
                        echo $row['Description'];
                        echo "<br><br><br>";
                    };
                }
            }

        }
    }
    mysqli_close($connection);

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $ok_button  =  newt_button(5,  12);
    ?>
</div>

</body>

</html>