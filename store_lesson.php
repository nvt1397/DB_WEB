<!DOCTYPE html>
<html>
<body>
<?php
$lessonID = "";
$courseID = "";
$ordinal="";
$name="";
$des="";
$level="";

require('connect_db.php');
if ($_SERVER['REQUEST_METHOD'] != 'POST')
    die('Invalid HTTP method!');
else {
    if(isset($_POST["lessonID"])) { $lessonID = $_POST['lessonID']; }
    if(isset($_POST["courseID"])) { $courseID = $_POST['courseID']; }
    if(isset($_POST["ordinal"])) { $ordinal = $_POST['ordinal']; }
    if(isset($_POST["name"])) { $name = $_POST['name']; }
    if(isset($_POST["des"])) { $des = $_POST['des']; }
    if(isset($_POST["level"])) { $level = $_POST['level']; }
}

$courseID=(string)$courseID;
$name=(string)$name;
$lessonID=(string)$lessonID;
$ordinal=(string)$ordinal;
$des=(string)$des;
$level=(string)$level;
$date = date('m/d/Y h:i:s a', time());
$sql = "exec add_new_lesson '$lessonID','$courseID','$ordinal', '$name', '$level', '$date', '$des'";
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