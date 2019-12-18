<!DOCTYPE html>
<html>
<body>

<?php
$lesson_id="";
require('connect_db.php');
if ($_SERVER['REQUEST_METHOD'] != 'GET')
    die('Invalid HTTP method!');
if(isset($_GET["lesson_id"])) { $lesson_id = $_GET['lesson_id']; }
echo $lesson_id;
$lesson_id=(string)$lesson_id;
$sql = "DELETE FROM lessons WHERE lessons_id = '$lesson_id'";
sqlsrv_query($conn, $sql);
$indexURL = 'index.php';
header('Location: '.$indexURL);
?>
</body>
</html>