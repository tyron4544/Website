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
    <title>Register View User</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css?v=1.0">
    
</head>
<body>

        <?php include('admin_nav.php'); ?>

    <div id="content">
        <h2>Registered Users</h2>
        <p>
            <?php 
                require("mysqli_connect.php");
                $q = "SELECT fname, lname, email, DATE_FORMAT(registration_date, '%M %D %Y') AS regdat, user_id FROM users 
                ORDER BY user_id ASC";
                $result = @mysqli_query($dbcon, $q);
                if ($result) {
                    echo '<table>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Registered Date</th>
                        <th>Actions</th>
                    </tr>';
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        echo '<tr>
                            <td>' . htmlspecialchars($row['fname']) . ' ' . htmlspecialchars($row['lname']) . '</td>
                            <td>' . htmlspecialchars($row['email']) . '</td>
                            <td>' . htmlspecialchars($row['regdat']) . '</td>
                            <td class="action-icons">
                                <a href="edit_user.php?id=' . $row['user_id'] . '" class="edit"><span>📝</span></a>
                                <a href="delete_user.php?id=' . $row['user_id'] . '" class="delete" title="Delete User"><span>⛔</span></a>
                            </td>
                        </tr>';
                    }
                    echo '</table>';
                    mysqli_free_result($result);
                } else {
                    echo '<p class="error">The current users could not be retrieved. Contact the system administrator.</p>';
                }
                mysqli_close($dbcon);
            ?>
        </p>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
