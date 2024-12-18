
<?php
$dbcon = @mysqli_connect('localhost', 'tyronriman', 'tyronriman', 'members_riman')
OR die('Could not connect to the MySQL Server: '. mysqli_connect_error());
mysqli_set_charset($dbcon, 'utf8');
