<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('mysqli_connect.php');
    
    $errors = []; // Array to store error messages

    // Validate email
    if (!empty($_POST['email'])) {
        $e = trim($_POST['email']);
    } else {
        $errors[] = 'Enter your email.';
        $e = NULL;
    }

    // Validate password
    if (!empty($_POST['psword'])) {
        $p = hash('md5', mysqli_real_escape_string($dbcon, trim($_POST['psword']))); 
    } else {
        $errors[] = 'Enter your password.';
        $p = NULL;
    }

    // Check for errors before querying the database
    if (empty($errors)) {
        $q = "SELECT user_id, fname, user_level FROM users WHERE email = '$e' AND psword = '$p'";
        $result = mysqli_query($dbcon, $q);

        if ($result) {
            if (mysqli_num_rows($result) == 1) {
                session_start();
                $_SESSION = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $_SESSION['user_level'] = (int) $_SESSION['user_level'];

                $url = ($_SESSION['user_level'] === 1) ? 'admin_page.php' : 'members_page.php';
                header('Location: ' . $url);
                exit();
            } else {
                $errors[] = 'Email or password is incorrect.';
            }
        } else {
            $errors[] = 'System error: ' . mysqli_error($dbcon);
        }
    }

    mysqli_close($dbcon);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="css/style.css?v=1.0">
    <meta charset="utf-8">
</head>
<body>
    <?php include('nav.php'); ?>
    <div id="content">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <!-- Display error messages -->
            <?php
            if (!empty($errors)) {
                echo '<div class="error">';
                foreach ($errors as $error) {
                    echo "<p>$error</p>";
                }
                echo '</div>';
            }
            ?>
            <p>
                <label class="label" for="email">Email Address:</label>
                <input type="text" id="email" name="email" value="<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>">
            </p>
            <p>
                <label class="label" for="psword">Password:</label>
                <input type="password" id="psword" name="psword">
            </p>
            <p>
                <input type="submit" id="submit" name="submit" value="Login">
            </p>
        </form>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
