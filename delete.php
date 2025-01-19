<?php
session_start();
include("connection.php");

if (isset($_POST["delete-btn"])) {
    $stmt = $pdo->query("delete from users where id = '" . $_POST["id"] . "';");
    header("location: welcome.php?success=User information was deleted.");
}

if (isset($_POST["cancel-btn"])) {
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
            width: 460px;
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

    <?php if (isset($_GET["delete_id"])) : ?>
        <?php
        $stmt = $pdo->query("select * from users where id = '" . $_GET["delete_id"] . "';");
        $row = $stmt->fetch();
        ?>
        <div class="wrapper">
            <center>
                <h3>Delete Account?</h3>
                <p>You are about to delete <?php echo "<b>" . $row->name . " " . $row->lname . "</b>'s " ?> account. Proceed?</p>

                <form action="delete.php" method="post">
                    <div class="form-group">
                        <input type="hidden" name="id" value="<?php echo $row->id; ?>">
                        <input type="submit" name="delete-btn" class="btn btn-danger btn-lg btn-block" value="Delete">
                        <input type="submit" name="cancel-btn" class="btn btn-primary btn-md btn-block" value="Cancel">
                    </div>
                </form>
        </div>
    <?php endif; ?>

</body>

</html>