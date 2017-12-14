<!DOCTYPE html>

<head>
    <title>Sign Up Page</title>
    <link href="/normalize.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">
    <style>
        .error {color: #FF0000;}
        body{
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
        .signupBox {
            position: fixed;
            top: 50%;
            left: 50%;
            margin-top:-150px;
            margin-left:-250px;
            height: 360px;
            width: 500px;
            background: ghostwhite;
            border-radius: 12px;
        }
        .subBox{
            font-size: 20px;
            position: fixed;
            top: 50%;
            left: 50%;
            margin-top:-130px;
            margin-left:-200px;
            height: 320px;
            width: 400px;
        }
        input{
            font-size: 20px;
        }
        #firstNameBox{
            text-align: center;
            width: 155px;
        }
        #lastNameBox{
            text-align: center;
            width: 155px;
        }
        #emailBox{
            text-align: center;
            width: 320px;
        }
        #passwordBox{
            text-align: center;
            width: 290px;
        }

        #accountTypeBox{
            text-align: center;
            width: 270px;
        }
        #signupButton{
            width: 100px;
            position: fixed;
            left: 50%;
            margin-left:-50px;
        }
        a{
            color: red;
            text-decoration: none;
        }
        .loginPage{
            font-size: 16px;
            position: fixed;
            margin-top: 280px;
            left: 50%;
            margin-left: 160px;
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

$firstName = $lastName = $email = $password = $userID = "";
$nameErr = $emailErr = $passwordErr = "";
$errorMessage = $message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["firstName"]) OR empty($_POST["lastName"])){
        $nameErr = "* Plase enter your name";
    }
    else{
        $firstName = test_input($_POST["firstName"]);
        $lastName = test_input($_POST["lastName"]);
        if (!preg_match('/^[a-zA-Z\s]+$/',$firstName) OR !preg_match('/^[a-zA-Z\s]+$/',$lastName)){
            $nameErr="* Error, please enter your name with letters only.";
        }
        else{
            if (empty($_POST["email"])){
                $emailErr="* Please enter a valid email";
            }
            else{
                $email = test_input($_POST["email"]);
                // check if e-mail address is well-formed
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "* Invalid email format";
                }
                elseif(empty($_POST["password"])) {
                        $passwordErr = "* Password is required";
                }
                else{
                    $password = test_input($_POST["password"]);
                    $connection = connect();
                    $sql1 = "SELECT email FROM `user` WHERE email = '$email'";
                    $result1 = mysqli_query($connection, $sql1);
                    $row1 = mysqli_fetch_array($result1);
                    if (mysqli_num_rows($result1) === 1) {
                        $errorMessage = "* Sorry, you already have an account";
                    }
                    else{
                        $sql2 = "SELECT user_id FROM `user` ORDER BY user_id DESC LIMIT 1";
                        $result2 = mysqli_query($connection, $sql2);
                        $row2 = mysqli_fetch_array($result2);
                        $userID=$row2['user_id']+1;
                        $sql3 ="INSERT INTO `user`(`User_id`, `First_name`, `Last_name`, `Password`, `Email`, `Account_type`)"." VALUES ('$userID','$firstName','$lastName','$password','$email','2')";
                        $result3 = mysqli_query($connection,$sql3) or die('Error making saveToDatabase query');
                        $message="Thank You for signing up, please go to the Login page to Login.";
                    }
                }
            }
        }
    }
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
<div class="signupBox">
    <div class="subBox">
        <form method="post">
            <?php echo "* Name: "?>
            <input type="text" name="firstName" placeholder="First" value="<?php echo $firstName;?>" id="firstNameBox">
            <input type="text" name="lastName" placeholder="Last" value="<?php echo $lastName;?>" id="lastNameBox">
            <span class="error"><?php echo $nameErr?></span>
            <br><br>
            <?php echo "* Email: "?>
            <input type="text" name="email" value="<?php echo $email;?>" id="emailBox">
            <span class="error"><?php echo $emailErr?></span>
            <br><br>
            <?php echo "* Password: "?>
            <input type="text" name="password" value="<?php echo $password;?>" id="passwordBox">
            <span class="error"><?php echo $passwordErr?></span>
            <br><br>
            <?php echo "Account Type: "?>
            <input type="text" name="accountType" value="Standard User" id="accountTypeBox">
            <br><br>
            <input type="submit" name="signup" value="Sign Up" id="signupButton">
            <br><br>
            <span class="error"><?php echo $errorMessage?></span>
            <?php echo $message ?>
        </form>
    </div>
</div>
<div class="loginPage"><a href="loginPage.php">Login Page</a></div>
</body>