<?php
    session_start(); 

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

    if ($_SESSION['user_level'] !== 1) {
        header('Location: members_page.php'); 
        exit();
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Page</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css?v=1.0">
</head>
<body>
    <div id="container">
        <?php include('header.php'); ?>
    </div>

    <?php include('admin_nav.php'); ?>

    <div id="content1">
        <img src="img/dash.png" alt="dashboard" width="1200" height="500">
    </div>
    <div id="content1">
        <img src="img/final.png" alt="dashboard" width="1200" height="600">
    </div>

    <?php include('footer.php'); ?>
</body>
</html>