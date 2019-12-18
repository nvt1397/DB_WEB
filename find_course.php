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
    if(isset($_POST["course_id"])) { $input = $_POST['course_id'];}      
}

$sql = "exec p_view_information_course '$input'";
$result =sqlsrv_query($conn, $sql);
$row = sqlsrv_fetch_array($result);
if( $result === false ) {
    if( ($errors = sqlsrv_errors() ) != null) {
        foreach( $errors as $error ) {
            echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
            echo "code: ".$error[ 'code']."<br />";
            echo "message: ".$error[ 'message']."<br />";
        }
    }
}
?>
<table class="table table-hover table-bordered" >
<thead>
        <tr class="info">
            <th>CourseID</th>
            <th>Course Name</th>
            <th>Course Price</th>
            <th>Category</th>
            <th style="width: 5%">Numbers of Participants</th>
            <th style="width: 25%">Description</th>
            <th style="width: 15%">Release Date</th>
            <th>Total time</th>
            <th>Level</th>
            <th>State</th>
            <th>Tutor</th>
            <th>Number of Lessons</th>
        </tr>
    </thead>
    <tbody>
        <?php  ?>
               <tr>
                <td><?php echo $row[0]; ?></td>
                <td><?php echo $row[1]; ?></td>
                <td><?php echo $row[2]; ?></td>
                <td><?php echo $row[3]; ?></td>
                <td><?php echo $row[4]; ?></td>
                <td><?php echo $row[5]; ?></td>
                <td><?php $result = $row[6]->format('Y-m-d H:i:s'); if ($result) {echo $result;} else { echo "Unknown Time";} ?></td>
                <td><?php echo $row[7]; ?></td>
                <td><?php echo $row[8]; ?></td>
                <td><?php echo $row[9]; ?></td>
                <td><?php echo $row[10]; ?></td>
                <td><?php echo $row[11]; ?></td>
            </tr> 
        <php?>
    </tbody>
</table>
<button type="button" class="btn btn-warning"><a href="index.php" class="index">RETURN</a></button>

</body>
</html>