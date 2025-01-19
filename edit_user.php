<?php
session_start();
include("connection.php");

if (!isset($_SESSION["loggedUser"])) {
    header("location: login.php?error=You're not logged in.");
    exit;
}

$months = array(
    "1" => "January", "2" => "February", "3" => "March", "4" => "April", "5" => "May", "6" => "June",
    "7" => "July", "8" => "August", "9" => "September", "10" => "October", "11" => "November", "12" => "December"
);


if (isset($_POST["save-btn"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $lname = $_POST["last_name"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];

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

    if (
        empty($name) || empty($lname) || empty($gender) || empty($address)
        || empty($month) || empty($day) || empty($year) || empty($username) 
    ) {

        header("location: edit_user.php?error=All fields are required.");
    } else {
        if ($username == $username) {
            $stmt = $pdo->prepare("update users set name=?, lname=?, gender=?, address=?, birthday=?, username=?
                                    where id = ?;");
            $stmt->execute([$name, $lname, $gender, $address, $birthday, $username, $id]);

            

            header("location: edit_user.php?success=User information was udpated successfully.");
            header("location: welcome.php?success=User information was udpated successfully.");
        } else {
            header("location: edit_user.php?error=Something went wrong. Try again.");
        }
    }
}

if(isset($_POST["back-btn"])) {
    header("location: welcome.php");
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
    <div class="wrapper">
        <h2>Edit Account</h2>

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

        <?php if (isset($_GET["edit_id"])) : ?>
            <?php
            $stmt = $pdo->query("select * from users where id = '" . $_GET["edit_id"] . "';");
            $row = $stmt->fetch();
            ?>
            <form action="edit_user.php" method="post">
                <table>
                    <tr>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $row->id; ?>">
                        </td>
                        <td>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo $row->name; ?>">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="<?php echo $row->lname; ?>">
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender" class="form-control" value="">
                        <?php if ($row->gender == "Male") : ?>
                            <option disabled>Select Gender</option>
                            <option value="Male" selected>Male</option>
                            <option value="Female">Female</option>
                        <?php elseif ($row->gender == "Female") : ?>
                            <option disabled>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female" selected>Female</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control" value="<?php echo $row->address; ?>">
                </div>
                <div class="form-group">
                    <label>Birthday</label>
                    <table>
                        <tr>
                            <td>
                                <select name="month" id="months" class="form-control" style="width: 150px !important;">
                                    <?php
                                    $selectedMonth = substr($row->birthday, 0, strpos($row->birthday, " "));
                                    ?>
                                    <option disabled>Month</option>
                                    <?php foreach ($months as $k => $v) : ?>
                                        <?php if ($v == $selectedMonth) : ?>
                                            <option selected value="<?php echo $k; ?>"><?php echo $k; ?></option>
                                        <?php endif; ?>
                                        <option value="<?php echo $k; ?>"><?php echo $k; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <select name="day" id="days" class="form-control" style="width: 90px !important;">
                                    <?php
                                    $selectedDay = substr($row->birthday, strpos($row->birthday, " "), -6);
                                    ?>
                                    <option disabled>Day</option>
                                    <?php for ($i = 1; $i <= 31; $i++) : ?>
                                        <?php if ($i == $selectedDay) : ?>
                                            <option selected value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php endif; ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </td>
                            <td>
                                <select name="year" id="years" class="form-control" style="width: 110px !important;">
                                    <?php
                                    $selectedYear = substr($bday, strrpos($bday, " "));
                                    ?>
                                    <option disabled>Year</option>
                                    <?php for ($i = 2022; $i >= 2000; $i--) : ?>
                                        <?php if ($i == $selectedYear) : ?>
                                            <option selected value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php endif; ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo $row->username; ?>">
                </div>
                <div class="form-group">
                    <input type="submit" name="save-btn" class="btn btn-primary btn-lg btn-block" value="Save">
                    <input type="submit" name="back-btn" class="btn btn-secondary btn-md btn-block" value="Go Back">
                </div>
            </form>
        <?php else : ?>
            <form action="edit_user.php" method="post">
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
                    <input type="submit" name="save-btn" class="btn btn-primary btn-lg btn-block" value="Save">
                    <input type="submit" name="back-btn" class="btn btn-secondary btn-md btn-block" value="Go Back">
                </div>
            </form>
        <?php endif; ?>

    </div>
</body>

</html>