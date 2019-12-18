<!DOCTYPE html>
<html>
<head>
<title>Trang Index</title>
    <meta charset="utf-8">
    <response.charset = utf-8>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
   <!--  <script>
    function AmountBranch(str) { 
        alert("Hello");
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert("Hello");
                // document.getElementById("AmountBranch").innerHTML = 'adv';
                // document.getElementById("AmountBranch").innerHTML = this.responseText;
            }
        };
        document.getElementById("AmountBranch").innerHTML = 'adv';
        xmlhttp.open("GET","AmountBranch.php?pmanufac="+str,true);
        xmlhttp.send();
    }
}
</script> -->
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
<body>

<?php  
    require("connect_db.php");
    // Tạo bảng
    if($conn == false)  
        echo("error");
    $sql='SELECT * FROM users';
    $query=sqlsrv_query($conn,$sql);
    $sql_cs='SELECT * FROM courses';
    $query_cs=sqlsrv_query($conn,$sql_cs);
    $sql_ls='SELECT * FROM lessons';
    $query_ls=sqlsrv_query($conn,$sql_ls);
    $sql_cmt='SELECT * FROM comments';
    $query_cmt=sqlsrv_query($conn,$sql_cmt);

    $sql_user_1='SELECT dbo.rate_male_in_user_type(2)';
    $query_user_1=sqlsrv_query($conn,$sql_user_1);
    
?>

<div class="container-fluid ">
<!-- Bảng Users -->
<div class="col-sm-12">
<h1>USERS</h1>
<button type="button" class="btn btn-warning"><a href="add.php" class="add">ADD</a></button>
<table class="table table-hover table-bordered text-justify">
    <thead>
        <tr class="text-justify success ">
            <th>UserID</th>
            <th style="width: 10%">Email</th>
            <th>Password</th>
            <th>Full Name</th>
            <th>Age</th>
            <th>Sex</th>
            <th>Job</th>
            <th>Telephone</th>
            <th style="width: 10%">District</th>
            <th style="width: 10%">City</th>          
            <th>Type</th>
            <th>Money</th>
            <th style="width: 10%">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = sqlsrv_fetch_array($query,SQLSRV_FETCH_NUMERIC)) : ?>
                <tr>
                <td><?php echo $row[0]; ?></td>
                <td><?php echo $row[2]; ?></td>
                <td><?php echo $row[1]; ?></td>
                <td><?php echo $row[3]; ?></td>
                <td><?php echo $row[4]; ?></td>
                <td><?php echo $row[5]; ?></td>
                <td><?php echo $row[6]; ?></td>
                <td><?php echo $row[7]; ?></td>
                <td><?php echo $row[8]; ?></td>
                <td><?php echo $row[9]; ?></td>
                <td><?php echo $row[10]; ?></td>
                <td><?php echo $row[11]; ?></td>
                <td><button type="button" class="btn btn-danger"><a href="delete.php?users_id=<?php echo $row[0]; ?>" class="delete">Delete</a></button>     <button type="button" class="btn btn-info"><a href="edit.php?users_id=<?php echo $row[0]; ?>" class="edit">Edit</a></button></td>
                </tr> 
        <?php endwhile; ?> 
    </tbody>
</table>

<div class="col-sm-2">
</div>
<div class="col-sm-10">
    <h3>Statistic</h3>
    <tr class="text-justify success ">
        <th>Percentage of male/female students:  <?php $per = sqlsrv_fetch_array($query_user_1,SQLSRV_FETCH_NUMERIC); echo $per[0]; echo " / "; echo (1.0-$per[0]); ?></th>
    </tr>
</div>
<div class="col-sm-2">
</div>
<div class="col-sm-10">
    <h3>Find student user by job: </h3>
</div>
<div class="col-sm-2">
</div>
<div class="col-sm-4 text-center">
    <form method="POST" action="find_student_by_job.php" role="form">
    <div class="form-group">
            <label for="job_input">Job:</label>
            <input id="job_input" name="job_input" type="text" value="" required="true">
        </div>
        <p>
        <input type="submit" value="Find" class="btn btn-info">
        </p>  
    </form>
</div>
<br>
<br>
</div>







<!-- Bảng COURSE -->
<div class="col-sm-12">
<h1>COURSES</h1>
<button type="button" class="btn btn-warning"><a href="add_course.php" class="add_product">ADD</a></button>
<table class="table table-hover table-bordered">
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
            <th style="width: 10%">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = sqlsrv_fetch_array($query_cs,SQLSRV_FETCH_NUMERIC)) : ?>
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
                <td><button type="button" class="btn btn-danger"><a href="delete_course.php?courses_id=<?php echo $row[0]; ?>" class="delete">Delete</a></button>      <button type="button" class="btn btn-info"><a href="edit_course.php?courses_id=<?php echo $row[0]; ?>" class="edit">Edit</a></button></td>
            </tr> 
        <?php endwhile; ?>
    </tbody>
</table>
</div>
<div class="col-sm-2">
</div>
<div class="col-sm-10">
    <h3>Find course: </h3>
</div>
<div class="col-sm-2">
</div>
<div class="col-sm-4 text-center">
    <form method="POST" action="find_course.php" role="form">
    <div class="form-group">
            <label for="course_id">CourseID:</label>
            <input id="course_id" name="course_id" type="text" value="" required="true">
        </div>
        <p>
        <input type="submit" value="Find" class="btn btn-info">
        </p>  
    </form>
</div>
<br>
<br>
</div>











<!-- Bảng LESSON -->
<div class="col-sm-12">
<h1>LESSONS</h1>
<button type="button" class="btn btn-warning"><a href="add_lesson.php" class="add">ADD</a></button>
<table class="table table-hover table-bordered">
    <thead>
        <tr class="success">
            <th>lessonID</th>
            <th style="width: 10%">courseID</th>
            <th style="width: 10%">Ordinal number</th>
            <th style="width: 20%">Name</th>
            <th style="width: 10%">Level</th>
            <th>Release Date</th>
            <th>Description</th>
            <th>Number of Comments</th>
            <th style="width: 10%">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = sqlsrv_fetch_array($query_ls,SQLSRV_FETCH_NUMERIC)) : ?>
            <tr>
                <td><?php echo $row[0]; ?></td>
                <td><?php echo $row[1]; ?></td>
                <td><?php echo $row[2]; ?></td>
                <td><?php echo $row[3]; ?></td>
                <td><?php echo $row[4]; ?></td>
                <td><?php $result = $row[5]->format('Y-m-d H:i:s'); if ($result) {echo $result;} else { echo "Unknown Time";} ?></td>
                <td><?php echo $row[6]; ?></td>
                <td><?php echo $row[7]; ?></td>
                <td><button type="button" class="btn btn-danger"><a href="delete_lesson.php?lesson_id=<?php echo $row[0]; ?>" class="delete">Delete</a></button>      <button type="button" class="btn btn-info"><a href="edit_lesson.php?lesson_id=<?php echo $row[0]; ?>" class="edit">Edit</a></button></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<div class="col-sm-2">
</div>
<div class="col-sm-10">
    <h3>Display all lessons of course: </h3>
</div>
<div class="col-sm-2">
</div>
<div class="col-sm-4 text-center">
    <form method="POST" action="display_lesson_of_course.php" role="form">
    <div class="form-group">
            <label for="course_id">Course:</label>
            <input id="course_id" name="course_id" type="text" value="" required="true">
        </div>
        <p>
        <input type="submit" value="Find" class="btn btn-info">
        </p>  
    </form>
</div>

<br>
<br>
</div>



<div class="col-sm-12">
<!-- Bảng Comment -->
<h1>COMMENT</h1>
<button type="button" class="btn btn-warning"><a href="add_comment.php" class="add">ADD</a></button>
<table class="table table-hover table-bordered">
    <thead>
        <tr class="info">
            <th>Comment ID</th>
            <th style="width: 30%">Comment</th>
            <th>Day</th>
            <th>TopicID</th>
            <th>LessonID</th>
            <th>UserID</th>
            <th style="width: 10%">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = sqlsrv_fetch_array($query_cmt,SQLSRV_FETCH_NUMERIC)) : ?>
           <tr>
                <td><?php echo $row[0]; ?></td>
                <td><?php echo $row[1]; ?></td>
                <td><?php $result = $row[2]->format('Y-m-d H:i:s'); if ($result) {echo $result;} else { echo "Unknown Time";} ?></td>
                <td><?php echo $row[3]; ?></td>
                <td><?php echo $row[4]; ?></td>
                <td><?php echo $row[5]; ?></td>
                <td><button type="button" class="btn btn-danger"><a href="delete_comment.php?comment_id=<?php echo $row[0]; ?>" class="delete">Delete</a></button>      <button type="button" class="btn btn-info"><a href="edit_comment.php?comment_id=<?php echo $row[0]; ?>" class="edit">Edit</a></button></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<div class="col-sm-2">
</div>
<div class="col-sm-10">
    <h3>Find Comment:</h3>
</div>
<div class="col-sm-2">
</div>
<div class="col-sm-4 text-center">
    <form  method="POST" action="find_comment.php" role="form">
    <div class="form-group">
            <label for="cm_id">CommentID:</label>
            <input id="cm_id" name="cm_id" type="text" value="" required="true">
        </div>
        <p>
        <input type="submit" value="Find" class="btn btn-info">
        </p>    
    </form>
</div>
</body>
</html>
</div>
