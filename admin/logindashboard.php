<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['lssemsaid']!=0) && $_SESSION['login']=="admin") {
    header('location:dashboard.php');
    }
else if(strlen($_SESSION['lssemsaid']!=0) && $_SESSION['login']!='admin')
{
    header('location:user-profile.php');
}
?>
    
<!DOCTYPE html>
<html>
<head>
 
  <title>Local Services Search Engine Mgmt System | Log in</title>
  <style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background: inherit;
  backdrop-filter: blur(15px);
  border-radius: 10px;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 20px;
  border-radius: 10px;
  letter-spacing: 2px;
}

.topnav a.active {
  background-color: #520c0c78;
  color: white;
}

.topnav a:hover {
  background-color: #9d7cc9;
  color: black;
}
</style>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page" style="background-image:url(https://assets.website-files.com/5f204aba8e0f187e7fb85a87/5f210a533185e7434d9efcab_hero%20img.jpg);
background-repeat: no-repeat; background-attachment: fixed; background-size: cover;">
    <div class="topnav">
  <a class="active" href="../index.php"> HOME </a>
</div>


    <div class="container">
        <div class="row">
            <div class="col-sm-4" style="padding-left: 50px; padding-right: 50px; border-radius: 5%;">
                
                <div class="card" style="text-align:center; background: inherit; backdrop-filter: blur(15px); border-radius: 5%;">
                    <img src="dist/img/avatar04.png" class="img-circle elevation-2" alt="...">
                    <div class="login-logo">
                        <a href="login.php"><b style="color: black;">Admin</b></a>
                    </div>
                    <div class="card-body">
                        <a href="login.php" class="btn btn-primary" style="letter-spacing: 2px;">LOGIN HERE</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-4" style="padding-left: 50px; padding-right: 50px; border-radius: 5%;">
                
                <div class="card" style="text-align:center; background: inherit; backdrop-filter: blur(15px); border-radius: 5%;">
                    
                    <img src="dist/img/avatar.png" class="img-circle elevation-2" alt="...">
                    <div class="login-logo">
                        <a href="loginuser.php"><b style="color: black;">Service Provider</b></a>
                    </div>
                    <div class="card-body">
                        <a href="loginuser.php" class="btn btn-primary" style="letter-spacing: 2px;">LOGIN HERE</a>
                    </div>
                </div>
            </div>

            <div class="col-sm-4" style="padding-left: 50px; padding-right: 50px; border-radius: 5%;">
                
                <div class="card" style="text-align:center; background: inherit; backdrop-filter: blur(15px); border-radius: 5%;">
                    
                    <img src="dist/img/avatar.png" class="img-circle elevation-2" alt="...">
                    <div class="login-logo">
                        <a href="loginuser.php"><b style="color: black;">Service Provider</b></a>
                    </div>
                    <div class="card-body">
                        <a href="loginuser.php" class="btn btn-primary" style="letter-spacing: 2px;">LOGIN HERE</a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="topnav">
  <a class="active" href="../index.php"> HOME </a>
</div>
<footer class="text-center text-white fixed-bottom" style="background-color: transparent;">
  <!-- Grid container -->
  <!-- Grid container -->

  <!-- Copyright -->
  <div class="text-center p-3" style="background: linear-gradient(45deg, #edb0ff7d, #8efdff7d); backdrop-filter: blur(100px); color: black;">
    © 2020 Copyright:
    <a href="../index.php" style="color:inherit;">Smart City Services</a>
  </div>
  <!-- Copyright -->
</footer>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
