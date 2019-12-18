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
    if(isset($_POST["courses_responsible"])) { $courses_responsible = $_POST['courses_responsible']; }
}
$date = date('m/d/Y h:i:s a', time());
$sql = "exec p_create_courses '$courseID','$name','$price', '$category', '0', '$des', '$date' , '$total', '$level','$state','$courses_responsible'";
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