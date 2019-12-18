<!DOCTYPE html>
<html>
<body>
<?php
 
// SQL Server Extension Sample Code:
$connectionInfo = array("UID" => "trantham", "pwd" => "Db123456", "Database" => "elearning", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
$serverName = "tcp:dbelearning.database.windows.net,1433";
$conn = sqlsrv_connect($serverName, $connectionInfo);
?>
</body>
</html>