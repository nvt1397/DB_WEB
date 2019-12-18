<!DOCTYPE html>
<html>
<head>
<title>Edit Lesson</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
    name='viewport' />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
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
</head>
<body class="login-page sidebar-collapse">
<?php
    $lesson_id='';
    require('connect_db.php');
    if (isset($_GET['lesson_id']))
        $lesson_id = $_GET['lesson_id'];
    else
        die('Thiếu lessonid!');
        $lesson_id=(string)$lesson_id;
    $sql = "SELECT * FROM lessons where lessons_id= '$lesson_id'";

    $result = sqlsrv_query($conn, $sql);

    if(!$result) {
        die('Query error');
    }
    $row = sqlsrv_fetch_array($result,SQLSRV_FETCH_NUMERIC);

    if (!$row)
        die('Không có lessonid');
?>
<nav class="navbar navbar-transparent navbar-color-on-scroll fixed-top navbar-expand-lg" color-on-scroll="100"
    id="sectionsNav">
<div class="container">
<div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white">

<div class="col-sm-3">
</div>
<div class="col-sm-4">
<h2>Edit Lesson</h2>
<?php
    require('connect_db.php');
?>
<form method="POST" action="save_lesson.php" role="form">
<div class="col-lg-6">
    <div class="form-group">
        <label for="lessonID">LessonID:</label>
        <input id="lessonID" name="lessonID" type="text" value="<?php echo $row[0]; ?>" readonly>
    </div>
    <div class="form-group">
        <label for="courseID">CourseID:</label>
        <input id="courseID" name="courseID" type="text" value="<?php echo $row[1]; ?>" required="true">
    </div>
    <div class="form-group">
        <label for="ordinal">Ordinal number:</label>
        <input id="ordinal" name="ordinal" type="number" value="<?php echo $row[2]; ?>" required="true">
    </div>
   <div class="form-group">
        <label for="name">Name:</label>
        <input id="name" name="name" type="text" value="<?php echo $row[3]; ?>" required="true">
    </div>
    <div class="form-group">
        <label for="level">Level:</label>
        <input id="level" name="level" type="number" value="<?php echo $row[4]; ?>" required="true">
    </div>
    <div class="form-group">
        <label for="des">Description:</label>
        <input id="des" name="des" type="text" value="<?php echo $row[6]; ?>">
    </div>    
    <p>
        <input type="submit" value="Submit" class="btn btn-info">
    </p>
    </div>
</form>
</div>
</div>
</div>
</div>
</nav>
</body>
</html>