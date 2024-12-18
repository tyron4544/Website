
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Delete User</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css?v=1.0">
</head>
<body>
    
    <?php include('admin_nav.php'); ?>
    <div id="content">
    <h2>Delete User</h2>
        <?php
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            require('mysqli_connect.php');

            if ((isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]))) {
                $id = $_GET['id'];
            } elseif ((isset($_POST['id']) && filter_var($_POST['id'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]))) {
                $id = $_POST['id'];
            } else {
                echo '<p>Error: Invalid access. Please return to the main page.</p>';
                echo '<p><a href="register-view-user.php">Return to View Register</a></p>';
                exit();
            }

            echo "<p>User ID: $id</p>";

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ($_POST['sure'] === 'Yes') {
                    $q = "DELETE FROM users WHERE user_id = ?";
                    $stmt = mysqli_prepare($dbcon, $q);
                    mysqli_stmt_bind_param($stmt, 'i', $id);
                    mysqli_stmt_execute($stmt);

                    if (mysqli_stmt_affected_rows($stmt) === 1) {
                        echo '<p class="success">The user has been successfully deleted.</p>';
                        echo '<p><a href="register-view-user.php">Return to View Register</a></p>';
                    } else {
                        echo '<p class="error">Error: The user could not be deleted. Please try again later.</p>';
                        echo '<p><a href="register-view-user.php">Return to View Register</a></p>';
                    }

                    mysqli_stmt_close($stmt);
                } else {
                    echo '<p class="info">The deletion has been canceled.</p>';
                    echo '<p><a href="register-view-user.php">Return to View Register</a></p>';
                }
            } else {
                // Confirm the deletion
                $q = "SELECT CONCAT(fname, ' ', lname) FROM users WHERE user_id = ?";
                $stmt = mysqli_prepare($dbcon, $q);
                mysqli_stmt_bind_param($stmt, 'i', $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) === 1) {
                    mysqli_stmt_bind_result($stmt, $user_name);
                    mysqli_stmt_fetch($stmt);
                    echo "<h3>Are you sure you want to delete the user: $user_name?</h3>";
                    echo '
                    <form action="delete_user.php" method="post">
                        <input id="Submit-yes" type="submit" name="sure" value="Yes" <br> ㅤ
                        <input id="Submit-no" type="submit" name="sure" value="No">
                        <input type="hidden" name="id" value="' . htmlspecialchars($id) . '">
                    </form>';
                } else {
                    echo "<p class='error'>Error: No user found with the provided ID.</p>";
                    echo '<p><a href="register-view-user.php">Return to View Register</a></p>';
                }
                mysqli_stmt_close($stmt);
            }

            mysqli_close($dbcon);
        ?>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
