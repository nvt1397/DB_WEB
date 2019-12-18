<!DOCTYPE html>
<html>
<body>
<?php
$userID = "";
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
$userID = (string)$userID;
$sql = "UPDATE users SET users_password = '$password', users_email = '$email', users_display_name = '$name', users_age = '$age', users_sex = '$sex', users_job = '$job', users_phone_number = '$tel', users_address_district='$district', users_address_city ='$city', users_type='$type_users' WHERE users_id ='$userID'";

$result= sqlsrv_query($conn, $sql);
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
