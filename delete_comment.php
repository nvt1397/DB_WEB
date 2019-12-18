<!DOCTYPE html>
<html>
<body>

<?php
$comment_id="";
require('connect_db.php');
if ($_SERVER['REQUEST_METHOD'] != 'GET')
    die('Invalid HTTP method!');
if(isset($_GET["comment_id"])) { $comment_id = $_GET['comment_id']; }
echo $comment_id;
$comment_id=(string)$comment_id;
$sql = "DELETE FROM comments WHERE comments_id = '$comment_id'";
sqlsrv_query($conn, $sql);
$indexURL = 'index.php';
header('Location: '.$indexURL);
?>
</body>
</html>