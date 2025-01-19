<?php
session_start();
include("connection.php");

//if the session is destroyes or not existing, redirect to the login page
if (!isset($_SESSION["loggedUser"])) {
    header("location: login.php?error=You're not logged in");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
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
            width: 80%;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .navbar {
            overflow: hidden;
            background-color: white;
        }

        .navbar h3 {
            float: left;
            font-size: 150%;
            color: black;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            margin: 0;
        }

        .dropdown {
            float: right;
            overflow: hidden;
        }

        .dropdown .dropbtn {
            font-size: 16px;
            border: none;
            outline: none;
            color: black;
            padding: 14px 16px;
            background-color: inherit;
            font-family: inherit;
            margin: 0;
        }

        .dropdown-content {
            display: none;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 9999999;
        }

        .dropdown-show {
            display: block !important;
        }

        .dropdown-content a {
            float: none;
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>

<body>

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

    <div class="wrapper">
        <div class="navbar">
            <h3>Dashboard</h3>
            <div class="dropdown">
                <button class="dropbtn"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $_SESSION["loggedUser"]; ?>
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="logout.php" class="logout"><i class="fa fa-power-off"></i> Log Out</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table-striped table-bordered col-md-12">
                <thead>
                    <tr>
                        <th class="text-center">Full Name</th>
                        <th class="text-center">Gender</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">Birthday</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = $pdo->query("select * from users;");
                    ?>
                    <?php if ($query->rowCount() > 0) : ?>
                        <?php while ($row = $query->fetch()) : ?>
                            <?php if ($row->id == $_SESSION["loggedID"]) : ?>
                                <tr>
                                    <td>
                                        <center>
                                            <?php if ($row->gender == 'Male') {
                                                echo 'Mr. ' . $row->name . " ";
                                                echo $row->lname . " ";
                                                echo "<i> (Me)</i>";
                                            } else {
                                                echo 'Ms. ' . $row->name . " ";
                                                echo $row->lname . " ";
                                                echo "<i> (Me)</i>";
                                            }
                                            ?>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <?php echo $row->gender; ?>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <?php echo $row->address; ?>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <?php echo $row->birthday; ?>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <?php echo $row->username; ?>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <a class="btn btn-primary" href="edit_user.php?edit_id=<?php echo $row->id; ?>">Edit</a>
                                        </center>
                                    </td>
                                </tr>
                            <?php else : ?>
                                <tr>
                                    <td>
                                        <center>
                                            <?php if ($row->gender == 'Male') {
                                                echo 'Mr. ' . $row->name . " ";
                                                echo $row->lname . " ";
                                            } else {
                                                echo 'Ms. ' . $row->name . " ";
                                                echo $row->lname . " ";
                                            }
                                            ?>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <?php echo $row->gender; ?>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <?php echo $row->address; ?>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <?php echo $row->birthday; ?>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <?php echo $row->username; ?>
                                        </center>
                                    </td>
                                    <td>
                                        <center>
                                            <a class="btn btn-primary" href="edit_user.php?edit_id=<?php echo $row->id; ?>">Edit</a>
                                            <a class="btn btn-danger" href="delete.php?delete_id=<?php echo $row->id; ?>">Delete</a>
                                        </center>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="3" rowspan="1" headers="">No Data Found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <footer>
        <p>Powered by: Jezi Anne P. Tobio | Eastern Visayas State University - Main Campus</p>
    </footer>
    </div>
</body>
