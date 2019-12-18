<!DOCTYPE html>
<html>
<body>

<?php
$courses_id="";
require('connect_db.php');
if ($_SERVER['REQUEST_METHOD'] != 'GET')
    die('Invalid HTTP method!');
if(isset($_GET["courses_id"])) { $courses_id = $_GET['courses_id']; }
echo $courses_id;
$courses_id=(string)$courses_id;
$sql = "DELETE FROM courses WHERE courses_id = '$courses_id'";
sqlsrv_query($conn, $sql);
$indexURL = 'index.php';
header('Location: '.$indexURL);
?>
</body>
</html>