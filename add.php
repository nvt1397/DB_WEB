<!DOCTYPE html>
<html>
<head>
<title>Add User</title>
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
<nav class="navbar navbar-transparent navbar-color-on-scroll fixed-top navbar-expand-lg" color-on-scroll="100"
    id="sectionsNav">
<div class="container">
<div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white">

<div class="col-sm-3">
</div>
<div class="col-sm-4">
<h2>Add User</h2>
<?php
    require('connect_db.php');
?>
<form method="POST" action="store.php" role="form">
<div class="col-lg-6">
    <div class="form-group">
        <label for="userID">UserID:</label>
        <input id="userID" name="userID" type="text" value="" required="true">
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input id="email" name="email" type="email" value="" required="true">
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input id="password" name="password" type="text" value="" required="true">
    </div>
   <div class="form-group">
        <label for="name">Full name:</label>
        <input id="name" name="name" type="text" value="" required="true">
    </div>
    <div class="form-group">
        <label for="age">Age:</label>
        <input id="age" name="age" type="text" value="" required="true">
    </div>
    <div class="form-group">
        <label for="sex">Sex:</label>
        <select name="sex">
            <option value="">Select...</option>
            <option value="1">Male</option>
            <option value="0">Female</option>
        </select> 
    </div>
    <div class="form-group">
        <label for="job">Job:</label>
        <input id="job" name="job" type="text" value="">
   </div>
    <div class="form-group">
        <label for="tel">Telephone Number:</label>
        <input id="tel" name="tel" type="text" value="">
    </div>
    <div class="form-group">
        <label for="district">District:</label>
        <input id="district" name="district" type="text" value="">
    </div>
     <div class="form-group">
        <label for="city">City:</label>
        <input id="city" name="city" type="text" value="">
   </div>
    <div class="form-group">
        <label for="type_users">User Type:</label>
        <select name="type_users" required="true">
            <option value="">Select...</option>
            <option value="0">Employee</option>
            <option value="1">Student</option>
            <option value="2">Teacher</option>
        </select>
    </div>    
    <p>
        <input type="submit" value="Add" class="btn btn-info">
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