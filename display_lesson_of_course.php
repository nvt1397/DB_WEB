<!DOCTYPE html>
<html>
<style>
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    .row.content {height: 450px}
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: auto;
    }
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 5px;
      }
      .row.content {height:auto;}
    }
    .h3{

        border-radius: 5px;
    }
    .col-sm-4{
        border: 10px solid white;
    }
    .col-sm-2 a{
        color: #213921;
        padding:20px;
    }
    .col-sm-2 div{
        color:white;
        background-color:#B4F7B4;
        border-radius: 5px;
        font-family:Georgia;
    }
    .col-sm-2 p{
        margin:15px;
        padding:0;
        border-bottom: 1px solid #B4F7B4;
        border-left: 3px solid #B4F7B4;
        border-radius: 5px;
    }
    .col-sm-4 p{
        font-family:Verdana;
        font-style: oblique;
    }
    table tr td {
        border-bottom: 2px solid #ccc;
        padding-left: 15px;
        padding-right: 15px;
    }
    a:hover{
        color:white;
        text-decoration: none;
        display: inline-block;
    }
    a{
        color:white;
        text-decoration: none;
        display: inline-block;
    }
</style>
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

$sql = "exec display_all_lessons_of_course '$input'";
$result =sqlsrv_query($conn, $sql);

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
            <th>LessonID</th>
            <th>Ordinal Number</th>
            <th>Name</th>
            <th style="width: 10%">Level</th>
            <th style="width: 25%">Release Date</th>
            <th>Description</th>
            <th>Number of Comments</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_NUMERIC)) : ?>
               <tr>
                <td><?php echo $row[0]; ?></td>
                <td><?php echo $row[2]; ?></td>
                <td><?php echo $row[3]; ?></td>
                <td><?php echo $row[4]; ?></td>
                <td><?php $date = $row[5]->format('Y-m-d H:i:s'); if ($date) {echo $date;} else { echo "Unknown Time";} ?></td>
                <td><?php echo $row[6]; ?></td>
                <td><?php echo $row[7]; ?></td>
            </tr> 
        <?php endwhile; ?>
    </tbody>
</table>
<button type="button" class="btn btn-warning"><a href="index.php" class="index">RETURN</a></button>

</body>
</html>