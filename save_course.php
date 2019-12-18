<!DOCTYPE html>
<html>
<body>
<?php
$courseID = "";
$name="";
$price="";
$category="";
$des="";
$total="";
$level="";
$state="";
$courses_responsible="";

require('connect_db.php');
if ($_SERVER['REQUEST_METHOD'] != 'POST')
    die('Invalid HTTP method!');
else {
    if(isset($_POST["courseID"])) { $courseID = $_POST['courseID']; }
    if(isset($_POST["name"])) { $name = $_POST['name']; }
    if(isset($_POST["price"])) { $price = $_POST['price']; }
    if(isset($_POST["category"])) { $category = $_POST['category']; }
    if(isset($_POST["des"])) { $des = $_POST['des']; }
    if(isset($_POST["total"])) { $total = $_POST['total']; }
    if(isset($_POST["level"])) { $level = $_POST['level']; }
    if(isset($_POST["state"])) { $state = $_POST['state']; }
    if(isset($_POST["courses_responsible"])) { $courses_responsible = $_POST['courses_responsible']; }
}

$sql = "UPDATE courses SET courses_id = '$courseID', courses_name = '$name', courses_prices = '$price', courses_category = '$category', courses_description = '$des', courses_total_time = '$totaltime', courses_level = '$level', courses_state='$state', courses_responsible ='$courses_responsible' WHERE courses_id ='$courseID'";

sqlsrv_query($conn, $sql);
 $indexURL = 'index.php';
 header('Location: '.$indexURL);
?>
</body>
</html>