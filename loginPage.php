<!DOCTYPE html>

<head>
    <title>Login Page</title>
    <link href="/normalize.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">
    <style>
        .error {color: #FF0000;}
        body {
            background: url('http://localhost/Events%20project/Background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: 0px 0px;
        }
        h1{
            color: black;
            text-align: center;
            font-family: 'Permanent Marker', cursive;
            font-size: 100px;
            margin-top: 75px;
        }
        .loginBox {
            position: fixed;
            top: 50%;
            left: 50%;
            margin-top:-100px;
            margin-left:-125px;
            height: 200px;
            width: 250px;
            background: ghostwhite;
            border-radius: 12px;
        }
        .subBox{
            position: fixed;
            top: 50%;
            left: 50%;
            margin-top:-80px;
            margin-left:-75px;
            height: 180px;
            width: 150px;
        }
        #loginButton{
            width: 70px;
            position: fixed;
            margin-top: 10px;
            left: 50%;
            margin-left:-35px;
        }
        .message{
            text-align: center;
            color: red;
        }
        a{
            text-decoration: none;
            color: black;
        }
        #newUser{
            position: fixed;
            left: 50%;
            margin-top: 200px;
            margin-left: -110px;
        }
        #lostPassword{
            color: black;
            position: fixed;
            left: 50%;
            margin-top: 200px;
            margin-left: -10px;
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
// define variables and set to empty values
$passwordErr = $emailErr = "";
$password = $email = "";
$message = "";
$firstName="";
$login="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["email"])) { //test for input in the input box: email; this process is repeated for all variables
        $emailErr = "*Email is required"; //display corresponding error message; this process is repeated for all variables
    }
    else{
        $email = test_input($_POST["email"]); //associate the variable $email with the input; this process is repeated for all variables
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "*Invalid email format";
        }
        else{
            if (empty($_POST["password"])){
                $passwordErr = "*Password is required";
            }
            else{
                $password = test_input($_POST["password"]);
                $connection = connect();
                $sql = "SELECT first_name, last_name, user_id FROM `user` WHERE email='$email' AND `password`='$password'";
                $result = mysqli_query($connection, $sql);
                $row = mysqli_fetch_array($result);
                if (mysqli_num_rows($result) === 0) {
                    $message = "*Sorry, your email or password is incorrect";
                }
                else {
                    $firstName = $row['first_name'];
                    $userID = $row['user_id'];
                    setcookie("firstName","$firstName",0,'/');
                    setcookie("userID", "$userID",0,'/');
                    header("Location: home.php");
                    die();
                }
            }
        }
    }
    mysqli_free_result($result);
    mysqli_close($connection);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<h1>
    Welcome!
</h1>

<div class="loginBox">
    <div class="subBox">
        <form method="post" id="loginForm" action="loginPage.php">
            <?php echo "Email:"?>
            <br>
            <input type="text" name="email" value="<?php echo $email;?>">
            <span class="error"><?php echo $emailErr?></span>
            <br>
            <br>
            <?php echo "Password:"?>
            <br>
            <input type="text" name="password" value="<?php echo $password;?>">
            <span class="error"><?php echo $passwordErr?></span>
            <br>
            <input type="submit" name="submit" id="loginButton" value="Log In">
        </form>
        <br><br>
        <div class="message"><?php echo $message?></div>
    </div>
</div>

<div id="newUser"><a href="signupPage.php">New User</a></div>
<div id="lostPassword">Lost your password?</div>

</body>