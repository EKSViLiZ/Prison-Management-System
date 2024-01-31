<?php
    session_start();
    
    if (isset($_SESSION['user'])){
        header("Location: ../main/home.php");
    }
    
    require_once "../index/index.php";
    
    if (isset($_POST['signup'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repeat_password = $_POST['repeat_password'];
        
        $password_hash = PASSWORD_HASH($password, PASSWORD_DEFAULT);
        
        $query = "SELECT * FROM `user` WHERE email = '$email'";
        $result = MYSQLI_QUERY($conn, $query);
        $num_rows = MYSQLI_NUM_ROWS($result);
        
        if (empty($username) OR empty($email) OR empty($password) OR empty($repeat_password)) {
            echo("All fields are required!");
        } elseif ($num_rows > 0) {
            echo("Email already exists!");
        } elseif (strlen($password) < 8) {
            echo("Password must atleast be 8 characters.");
        } else {
            $query = "INSERT INTO `user` (username, email, password) VALUES (?, ?, ?)";
            $stmt = MYSQLI_STMT_INIT($conn);
            $prepare_stmt = MYSQLI_STMT_PREPARE($stmt, $query);
            if ($prepare_stmt) {
                MYSQLI_STMT_BIND_PARAM($stmt, "sss", $username, $email, $password);
                MYSQLI_STMT_EXECUTE($stmt);
                echo("You are registered!");
            } else {
                die("Something went wrong!");
            }
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    
    <link rel="stylesheet" href="registry.css">
</head>
<body>
    <form action="" class="container" method="POST">
        <label for="title" class="title">Sign Up</label>
        
        <label for="username" class="header">Username:</label>
        <input type="text" class="txt-box" name="username" id="username">
        <label for="email" class="header">Email:</label>
        <input type="email" class="txt-box" name="email" id="email">
        <label for="password" class="header">Password:</label>
        <input type="password" class="txt-box" name="password" id="password">
        <div class="show-password">
            <label for="show_pass" class="paragraph" style="margin-top: 3px;">Show Password</label><input type="checkbox" class="show_pass" onclick="show_password()">
        </div>
        <label for="repeat_password" class="header" style="margin-top: -10px;">Repeat Password:</label>
        <input type="password" class="txt-box" name="repeat_password" id="repeat_password" style="margin-bottom: 15px;">
        <div class="container-action">
            <div class="container-action-account">
                <label for="account_signup" class="paragraph" style="text-align: center;">Already have an Account?</label>
                <label for="account_signup" class="paragraph" style="text-align: center;"><a href="login.php" class="">Login</a></label>
            </div>
            <input  class="btn" type="submit" value="Sign Up" name="signup">
        </div>
    </form>
    
    <script class="">
        function show_password() {
            var x = document.getElementById("password")
            if (x.type === "password") {
                x.type = "text"
            } else {
                x.type = "password"
            }
        }
    </script>
</body>
</html>