<!DOCTYPE html>
<html>
<body>
<?php
$input = "";
$sql = "";
require('connect_db.php');
if ($_SERVER['REQUEST_METHOD'] != 'POST')
    die('Invalid HTTP method!');
else {
    if(isset($_POST["cm_id"])) { $input = $_POST['cm_id'];}      
}

$sql = "exec showcomment '$input'";
$result =sqlsrv_query($conn, $sql);
$obj = sqlsrv_fetch_array($result);

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
    if($obj[1] == NULL) echo "Cant find this comment!!!";
    else {echo "Name: "; echo $obj[0]; echo "<br>\n";  
        echo "Date: "; echo $result = $obj[1]->format('Y-m-d H:i:s'); if ($result) {echo $result;} else { echo "Unknown Time";};  echo "<br>\n";  
        echo "Content: ";  echo $obj[2];} echo "<br>\n";  
    echo "<div class=\"col-sm-2\"></div><button type=";echo"button";echo" class=";echo "btn btn-warning"; echo "><a href="; echo"index.php"; echo " class="; echo"index";echo ">RETURN</a></button>";
}
?>
</body>
</html>