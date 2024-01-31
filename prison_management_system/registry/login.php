<?php
    if (isset($_SESSION['user'])) {
        header("Location: ../main/home.php");
    }
    
    require_once "../index/index.php";
    
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $query = "SELECT * FROM user WHERE email = '$email'";
        $result = MYSQLI_QUERY($conn, $query);
        $user = MYSQLI_FETCH_ARRAY($result, MYSQLI_ASSOC);
        
        if (empty($email) OR empty($password)){
            echo("All fields are required!");
        } elseif ($user) {
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['id'] = $user['id'];
                header("Location: login.php");
                die();
            } else {
                echo("Password does not match!");
            }
        } else {
            echo("Email does not exist!");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    
    <link rel="stylesheet" href="registry.css">
</head>
<body>
    <form action="login.php" class="container" method="POST">
        <label for="title" class="title">Login</label><br>
        
        <label for="email_address" class="header">Email Address:</label>
        <input type="text" class="txt-box" name="email" id="email">
        <label for="password" class="header">Password:</label>
        <input type="password" class="txt-box" name="password" id="password">
        <div class="show-password">
            <label for="show_pass" class="paragraph">Show Password</label><input type="checkbox" class="show_pass" onclick="show_password()">
        </div>
        <div class="container-action">
            <div class="container-action-account">
                <label for="account_signup" class="paragraph" style="text-align: center;">Don't have an Account?</label>
                <label for="account_signup" class="paragraph" style="text-align: center;"><a href="signup.php" class="">Sign Up</a></label>
            </div>
            <input  class="btn" type="submit" value="Login" name="login">
        </div>
    </form>

    <script class="">
        function show_password() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>
</html>