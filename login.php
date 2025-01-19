<?php 
session_start();

//database connection file
include("connection.php");


//login button is clicked
if(isset($_POST["log-btn"])) {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if(empty($username) || empty($password)) {  //if fields are empty, show an error message
        header("location: login.php?error=All fields are required.");
    } else {

        //if record exists in the database, log the user and redirect to welcome.php
        $stmt = $pdo->query("select * from users where username = '$username' and password = password('$password');");

        if($stmt->rowCount() == 1) {
            $row = $stmt->fetch();

            header("location: welcome.php?success=You're currently logged in.");

            $_SESSION["loggedUser"] = $row->name;   //logged name  
            $_SESSION["loggedID"] = $row->id;       //logged user's ID

            $_SESSION["id"] = $row->id;
            $_SESSION["name"] = $row->name;
            $_SESSION["lname"] = $row->lname;
            $_SESSION["gender"] = $row->gender;
            $_SESSION["address"] = $row->address;
            $_SESSION["birthday"] = $row->birthday;
            $_SESSION["username"] = $row->username;
        } else {
            header("location: login.php?error=User not found. Try again or create an account instead.");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="jquery-3.5.1.min.js"></script>
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: url(blue.jpg);
            background-size: cover;
            font: 14px sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .wrapper {
            width: 400px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .success {
            background: #D4EDDA;
            color: #40754C;
            text-align: center;
            padding: 10px;
            width: 95%;
            margin: 20px auto;
        }

        h2,
        p {
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- popup messages for errors and successful operations -->
    <!-- error popup message -->
    <?php if (isset($_GET["error"])) : ?>
        <p class="alert alert-danger err" title="Click this message to close."><?php echo $_GET["error"]; ?></p>

        <script>
            $(document).ready(function() {
                $(".err").click(function() {
                    $(".err").fadeOut("fast");
                });
            });
        </script>
    <?php endif; ?>

    <!-- success popup message -->
    <?php if (isset($_GET["success"])) : ?>
        <p class="alert alert-success succ" title="Click this message to close."><?php echo $_GET["success"]; ?></p>

        <script>
            $(document).ready(function() {
                $(".succ").click(function() {
                    $(".succ").fadeOut("fast");
                });
            });
        </script>
    <?php endif; ?>

    <!-- login form -->
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <form action="login.php" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" name="log-btn" class="btn btn-primary btn-lg btn-block" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>

</body>
</html>