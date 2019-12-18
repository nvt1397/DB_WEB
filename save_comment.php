<!DOCTYPE html>
<html>
<body>
<?php
$commentID = "";
$content = "";
$date = date('m/d/Y h:i:s a', time());
$topicID="";
$lessonID="";
$userID="";

require('connect_db.php');
if ($_SERVER['REQUEST_METHOD'] != 'POST')
    die('Invalid HTTP method!');
else {
    if(isset($_POST["commentID"])) { $commentID = $_POST['commentID']; }
    if(isset($_POST["content"])) { $content = $_POST['content']; }
    if(isset($_POST["topicID"])) { $topicID = $_POST['topicID']; } 
    if(isset($_POST["lessonID"])) { $lessonID = $_POST['lessonID']; } 
    if(isset($_POST["userID"])) { $userID = $_POST['userID']; }
}

$sql = "UPDATE comments SET comments_content = '$content', comments_date_post = '$date'  WHERE comments_id ='$commentID'";
sqlsrv_query($conn, $sql);
 $indexURL = 'index.php';
 header('Location: '.$indexURL);
?>
</body>
</html>