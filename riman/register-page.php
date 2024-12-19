<?php
// Start the PHP logic to handle the form submission and database interaction
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();

    // Validate first name
    if (empty($_POST['fname'])) {
        $errors[] = "Please Enter Your First Name.";
    } else {
        $fn = trim($_POST['fname']);
    }

    // Validate last name
    if (empty($_POST['lname'])) {
        $errors[] = "Please Enter Your Last Name.";
    } else {
        $ln = trim($_POST['lname']);
    }

    // Validate email
    if (empty($_POST['email'])) {
        $errors[] = "Please Enter Your Email.";
    } else {
        $e = trim($_POST['email']);
    }

    // Validate password
    if (empty($_POST['psword1'])) {
        $errors[] = "Please Enter Your Password.";
    } elseif ($_POST['psword1'] !== $_POST['psword2']) {
        $errors[] = "Your Passwords Do Not Match.";
    } else {
        $p = hash('md5', trim($_POST['psword1']));
    }

    // If there are no errors, proceed to insert into the database
    if (empty($errors)) {
        // Connect to the database
        require('mysqli_connect.php');

        // Insert user into database
        $q = "INSERT INTO users (fname, lname, email, psword, registration_date, user_level) 
            VALUES ('$fn', '$ln', '$e', '$p', NOW(), 0)";

        $result = @mysqli_query($dbcon, $q);
        
        if ($result) {
            // Redirect to a success page if registration is successful
            header("Location: register-thanks.php");
            exit();
        } else {
            // Display an error if the registration failed
            echo '<h2>System Error</h2>
                  <div class="error">
                  <p>You could not be registered due to a system error. We apologize for any inconvenience.</p>
                  <p>' . mysqli_error($dbcon) . '</p>
                  </div>';
        }

        mysqli_close($dbcon);
    } else {
        // Display the errors if validation failed
        echo '<h2>Error!</h2>
              <div class="error">
              <p>The Following Error(s) Occurred:</p>
              <ul>';
        foreach ($errors as $msg) {
            echo "<center><li>$msg</li></center>";
        }
        echo '</ul>
              <p>Please Try Again.</p>
              </div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register Page</title>
    <link rel="stylesheet" type="text/css" href="css/style.css?v=1.0">
    <meta charset="utf-8">
    
</head>

<body>

        <?php include('nav.php'); ?>

    <div id="content">
        <h2>Register</h2>
        <form action="register-page.php" method="post">
            <p>
                <label class="label" for="fname">First Name:</label>
                <input type="text" id="fname" name="fname" size="30" maxlength="40" value="<?php if (isset($_POST['fname'])) echo htmlspecialchars($_POST['fname']); ?>">
            </p>
            
            <p>
                <label class="label" for="lname">Last Name:</label>
                <input type="text" id="lname" name="lname" size="30" maxlength="40" value="<?php if (isset($_POST['lname'])) echo htmlspecialchars($_POST['lname']); ?>">
            </p>
            
            <p>
                <label class="label" for="email">Email Address:</label>
                <input type="email" id="email" name="email" size="30" maxlength="50" value="<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>">
            </p>
            
            <p>
                <label class="label" for="psword1">Password:</label>
                <input type="password" id="psword1" name="psword1" size="20" maxlength="40">
            </p>
            
            <p>
                <label class="label" for="psword2">Confirm Password:</label>
                <input type="password" id="psword2" name="psword2" size="20" maxlength="40">
            </p>
            
            <p>
                <input type="submit" id="submit" name="submit" value="Register">
            </p>
        </form>
    </div>
    
    <?php include('footer.php'); ?>
</body>
</html>
