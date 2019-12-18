<!DOCTYPE html>
<html>
<body>
<?php
$userID="";
$email="";
$password="";
$name="";
$age="";
$sex="";
$job="";
$tel="";
$district="";
$city="";
$type_users="";
$money="0";


require('connect_db.php');
if ($_SERVER['REQUEST_METHOD'] != 'POST')
    die('Invalid HTTP method!');
else {
    if(isset($_POST["userID"])) { $userID = $_POST['userID']; }
    if(isset($_POST["email"])) { $email = $_POST['email']; }
    if(isset($_POST["password"])) { $password = $_POST['password']; }
    if(isset($_POST["name"])) { $name = $_POST['name']; }
    if(isset($_POST["age"])) { $age = $_POST['age']; }
    if(isset($_POST["sex"])) { $sex = $_POST['sex']; }
    if(isset($_POST["job"])) { $job = $_POST['job']; }
    if(isset($_POST["tel"])) { $tel = $_POST['tel']; }
    if(isset($_POST["district"])) { $district = $_POST['district']; }
    if(isset($_POST["city"])) { $city = $_POST['city']; }
    if(isset($_POST["type_users"])) { $type_users = $_POST['type_users']; }
}

$userID=(string)$userID;
$email=(string)$email;
$password=(string)$password;
$name=(string)$name;
$age=(string)$age;
$sex=(string)$sex;
$job=(string)$job;
$tel=(string)$tel;
$district=(string)$district;
$city=(string)$city;
$type_users=(string)$type_users;

$sql = "exec p_add_users '$userID','$password','$email', '$name', '$age', '$sex', '$job', '$tel', '$district','$city', '$type_users', '$money'";
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