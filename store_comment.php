<!DOCTYPE html>
<html>
<body>
<?php
$commentID = "";
$content = "";
$topicID = "";
$lessonID = "";
$userID = "";

require('connect_db.php');
if ($_SERVER['REQUEST_METHOD'] != 'POST')
    die('Invalid HTTP method!');
else {
    if(isset($_POST["commentID"])) { $commentID = $_POST['commentID']; }
    if(isset($_POST["content"])) { $courseID = $_POST['content']; }
    if(isset($_POST["topicID"])) { $topicID = $_POST['topicID']; } 
    if(isset($_POST["lessonID"])) { $lessonID = $_POST['lessonID']; } 
    if(isset($_POST["userID"])) { $userID = $_POST['userID']; }
}

$sql = "exec add_new_comment '$commentID', '$content', '$topicID', '$lessonID', '$userID' ";
$result=sqlsrv_query($conn, $sql);
if( $result === false ) {
    if( ($errors = sqlsrv_errors() ) != null) {
        foreach( $errors as $error ) {
            echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
            echo "code: ".$error[ 'code']."<br />";
            echo "message: ".$error[ 'message']."<br />";
            echo "<button type=";echo"button";echo" class=";echo "btn btn-warning"; echo "><a href="; echo"index.php"; echo " class="; echo"index";echo ">RETURN</a></button>";
        }
    }
}else{
$indexURL = 'index.php';
header('Location: '.$indexURL);
}
?>
</body>
</html>