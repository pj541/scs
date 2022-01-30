<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['lssemsaid']!=0) && $_SESSION['login']=='admin') {
  header('location:dashboard.php');
  }
  else if(strlen($_SESSION['lssemsaid']!=0) && $_SESSION['login']!='admin')
  {
      header('location:user-profile.php');
  }
if(isset($_POST['submit']))
{
$email=$_POST['email'];
$mobile=$_POST['mobile'];
$newpassword=md5($_POST['newpassword']);
$sql ="SELECT Email FROM tbladmin WHERE Email=:email and MobileNumber=:mobile";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
$con="update tbladmin set Password=:newpassword where Email=:email and MobileNumber=:mobile";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':email', $email, PDO::PARAM_STR);
$chngpwd1-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();
echo "<script>alert('Your Password succesfully changed');
window.location.href='logindashboard.php';
</script>";
}
else {
echo "<script>alert('Email id or Mobile no is invalid');</script>"; 
}
}

?>
    
<!DOCTYPE html>
<html>
<head>
 
  <title>Local Services Search Engine Mgmt System | Forgot Password</title>
 

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
  <script type="text/javascript">
function valid()
{
if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)
{
alert("New Password and Confirm Password Field do not match  !!");
document.chngpwd.confirmpassword.focus();
return false;
}
return true;
}
</script>
</head>
<body class="hold-transition login-page" style="background-image: url(https://assets.website-files.com/5f204aba8e0f187e7fb85a87/5f210a533185e7434d9efcab_hero%20img.jpg); background-repeat: no-repeat; background-attachment: fixed; background-size: cover;">
<div class="login-box">
  <div class="login-logo" style="margin-top: 35px;">
    <a href="forgot-password.php"><b></b> Forgot Password? | Admin </a>
  </div>
  <!-- /.login-logo -->
  <div class="card" style="background: inherit; backdrop-fliter:blur(15px); box-shadow: 0 0 10px; border-radius: 5%;">
    <div class="card-body login-card-body" style="background: linear-gradient(45deg, #edb0f5f2, #8efdffed); border-radius: 5%;">
      <p class="login-box-msg">Get your new Password</p>

      <form action="" method="post" name="chngpwd" onSubmit="return valid();">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Email Address" required="true" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope" ></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control"  name="mobile" placeholder="Mobile Number" required="true">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-mobile" style="font-size:20px;color:red"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input class="form-control" type="password" name="newpassword" placeholder="New Password" required="true"/>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input class="form-control" type="password" name="confirmpassword" placeholder="Confirm Password" required="true" />
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
           <a href="logindashboard.php">Sign-in</a>
             
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Reset</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

     
    </div>
    <!-- /.login-card-body -->
  </div>
  <div class="container" style="padding: 70px 0 0;">
</div>
<!-- /.login-box -->
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
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
