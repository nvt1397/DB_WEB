<!DOCTYPE html>
<html>
<body>

<?php
$users_id="";
require('connect_db.php');
if ($_SERVER['REQUEST_METHOD'] != 'GET')
    die('Invalid HTTP method!');
if(isset($_GET["users_id"])) { $users_id = $_GET['users_id']; }
echo $users_id;
$users_id=(string)$users_id;
$sql = "DELETE FROM users WHERE users_id = '$users_id'";
sqlsrv_query($conn, $sql);
$indexURL = 'index.php';
header('Location: '.$indexURL);
?>
</body>
</html>