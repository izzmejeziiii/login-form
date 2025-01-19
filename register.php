<?php
session_start();
include("connection.php");

$months = array(
    "1" => "January", "2" => "February", "3" => "March", "4" => "April", "5" => "May", "6" => "June",
    "7" => "July", "8" => "August", "9" => "September", "10" => "October", "11" => "November", "12" => "December"
);

//register button is clicked
if (isset($_POST["register-btn"])) {
    $name = trim($_POST["name"]);
    $lname = trim($_POST["last_name"]);
    $gender = trim($_POST["gender"]);
    $address = trim($_POST["address"]);

    $month = $_POST["month"];

    switch ($month) {
        case 1:
            $month = "January";
            break;
        case 2:
            $month = "February";
            break;
        case 3:
            $month = "March";
            break;
        case 4:
            $month = "April";
            break;
        case 5:
            $month = "May";
            break;
        case 6:
            $month = "June";
            break;
        case 7:
            $month = "July";
            break;
        case 8:
            $month = "August";
            break;
        case 9:
            $month = "September";
            break;
        case 10:
            $month = "October";
            break;
        case 11:
            $month = "November";
            break;
        case 12:
            $month = "December";
            break;
    }

    $day = $_POST["day"];
    $year = $_POST["year"];
    $birthday = $month . " " . $day . ", " . $year;

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $confirm_pass = trim($_POST["confirm_password"]);

    // if fields are empty, show an error message
    if (
        empty($name) || empty($lname) || empty($gender) || empty($address)
        || empty($month) || empty($day) || empty($year) || empty($username) || empty($password) || empty($confirm_pass)
    ) {

        header("location: register.php?error=All fields are required.");
    } else { // no empty fields

        // checking and verifying passwords
        //inserting data to database
        if ($password == $confirm_pass) {
            if (strlen($password) >= 8 && strlen($confirm_pass >= 8)) {
                $stmt = $pdo->prepare("insert into users(name, lname, gender, address, birthday, username, password) 
                                     values(?, ?, ?, ?, ?, ?, password(?));");
                $stmt->execute([$name, $lname, $gender, $address, $birthday, $username, $password]);

                $query = $pdo->query("select id from users where username = '$username' and password = password('$password');");
                $row = $query->fetch();

                $_SESSION["loggedUser"] = $name;
                $_SESSION["loggedID"] = $row->id;

                // $_SESSION["id"] = $row->id;
                // $_SESSION["name"] = $row->name;
                // $_SESSION["lname"] = $row->lname;
                // $_SESSION["gender"] = $row->gender;
                // $_SESSION["address"] = $row->address;
                // $_SESSION["birthday"] = $row->birthday;
                // $_SESSION["username"] = $row->username;

                //redirect to the user's list page and show a popup message
                header("location: login.php?success=Your account has been created. Log in!");
            } else {
                header("location: register.php?error=Password must be 8 characters long.");
            }
        } else {
            header("location: register.php?error=Passwords do not match.");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <title>Sign Up</title>
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
    <br><br><br><br><br>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>

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

        <!-- register form -->
        <form action="register.php" method="post">
            <table>
                <tr>
                    <td>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control">
                        </div>
                    </td>
                </tr>
            </table>
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" class="form-control" value="">
                    <option value="">Select...</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="">
            </div>
            <div class="form-group">
                <label>Birthday</label>
                <table>
                    <tr>
                        <td>
                            <select name="month" id="months" class="form-control" style="width: 150px !important;">
                                <option disabled selected>Month</option>
                                <?php foreach ($months as $k => $v) : ?>
                                    <option value="<?php echo $k; ?>"><?php echo $k; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <select name="day" id="days" class="form-control" style="width: 90px !important;">
                                <option disabled selected>Day</option>
                                <?php for ($i = 1; $i <= 31; $i++) : ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                        <td>
                            <select name="year" id="years" class="form-control" style="width: 110px !important;">
                                <option disabled selected>Year</option>
                                <?php for ($i = 2022; $i >= 2000; $i--) : ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="">
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="">
            </div>
            <div class="form-group">
                <input type="submit" name="register-btn" class="btn btn-primary btn-lg btn-block" value="Submit">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div><br><br><br><br><br>

</body>

</html>