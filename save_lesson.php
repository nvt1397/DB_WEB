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
$sql = "UPDATE lessons SET lessons_courses_id = '$courseID', lessons_ordinal_number = '$ordinal', lessons_name = '$name', lessons_description = '$des', lessons_level = '$level' WHERE lessons_id ='$lessonID'";
sqlsrv_query($conn, $sql);
 $indexURL = 'index.php';
 header('Location: '.$indexURL);
?>
</body>
</html>