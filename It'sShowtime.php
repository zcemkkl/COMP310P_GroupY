<!DOCTYPE html>

<head>
    <title>It's Showtime</title>
    <link href="/normalize.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">
    <style>
        body {
            text-align: center;
            background: url('http://localhost/Events%20project/Background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: 0px 0px;
        }
        p{
            font-family: 'Permanent Marker', cursive;
            font-size: 100px;
            margin-top: 320px;
        }
        #loginButton{
            position: fixed;
            height: 45px;
            width: 100px;
            font-size: 25px;
            margin-top: -60px;
            margin-left: -250px;
        }
        #signupButton{
            position: fixed;
            height: 45px;
            width: 100px;
            font-size: 25px;
            margin-top: -60px;
            margin-left: 150px;
        }
    </style>

</head>

<body>
<p>It's Showtime</p>
<form>
    <input formaction="loginPage.php" type="submit" id="loginButton" value="Login">
    <input formaction="signupPage.php" type="submit" id="signupButton" value="Sign Up">
</form>

</body>