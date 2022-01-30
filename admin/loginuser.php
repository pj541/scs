<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['lssemsaid']!=0) && $_SESSION['login']!='admin') {
    header('location:user-profile.php');
    }
    else if(strlen($_SESSION['lssemsaid']!=0) && $_SESSION['login']=='admin'){
      header('location:dashboard.php');
    }
if(isset($_POST['login'])) 
  {
    $username=$_POST['username'];
    $password=md5($_POST['password']);
    $sql ="SELECT ID FROM tblperson WHERE AdCard=:username and Password=:password";
    $query=$dbh->prepare($sql);
    $query-> bindParam(':username', $username, PDO::PARAM_STR);
    $query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
{   $val=0;
  $con="update tblperson set DEACTIVES='$val' where AdCard=:username and Password=:password";
  $deac= $dbh->prepare($con);
  $deac-> bindParam(':username', $username, PDO::PARAM_STR);
  $deac-> bindParam(':password', $password, PDO::PARAM_STR);
  $deac->execute();
foreach ($results as $result) {
$_SESSION['lssemsaid']=$result->ID;
}

  if(!empty($_POST["remember"])) {
//COOKIES for username
setcookie ("user_login",$_POST["username"],time()+ (10 * 365 * 24 * 60 * 60));
//COOKIES for password
setcookie ("userpassword",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));
} else {
if(isset($_COOKIE["user_login"])) {
setcookie ("user_login","");
if(isset($_COOKIE["userpassword"])) {
setcookie ("userpassword","");
        }
      }
}
$_SESSION['login']=$_POST['username'];
echo "<script type='text/javascript'> document.location ='user-profile.php'; </script>";
} else{
echo "<script>alert('Wrong User-Id or Password');</script>";
}
}

?>
    
<!DOCTYPE html>
<html>
<head>
 
  <title>Local Services Search Engine Mgmt System | Log in</title>
  <style>
  .topnav {
  overflow: hidden;
  background: initial;
  backdrop-filter: blur(15px);
  border-radius: 50px;
  padding: 20px 20px 20px;
  text-align: center;
}

.topnav a {
  color: #f2f2f2;
  text-align: center;
  text-decoration: none;
  font-size: 20px;
  border-radius: 19px;
  letter-spacing: 2px;
  padding: 14px 14px 14px;
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
<div class="login-box">
  <div class="login-logo"style="margin-top: 66px;">
    <a href="loginuser.php"><b>Service Provider</b> | LOGIN </a>
  </div>
  <!-- /.login-logo -->
  <div class="card" style=" background: inherit; backdrop-filter: blur(15px); box-shadow: 0 0 10px; border-radius:5%;">
    <div class="card-body login-card-body" style="background: linear-gradient(45deg, #edb0f5f2, #8efdffed); border-radius: 5%;">
      <p class="login-box-msg">Sign in to start your session</p>

	<p style="color:red; font-size:80%; align=left;">*Required Field</p>
      <form action="" method="post" id="login">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Aadhar no as User Name" maxlength="16" minlength="16" pattern="[0-9]+" required="true" name="username" value="<?php if(isset($_COOKIE["user_login"])) { echo $_COOKIE["user_login"]; } ?>" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
	<p style="color:red; font-size:80%; align=left;">*Required Field</p>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" required="true" value="<?php if(isset($_COOKIE["userpassword"])) { echo $_COOKIE["userpassword"]; } ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember" <?php if(isset($_COOKIE["user_login"])) { ?> checked <?php } ?> />
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="submit" name="login" class="btn btn-primary">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        <a href="forgot-passworduser.php">I forgot my password</a>
        </p>
        <p class= "mb-2"><a href="../index.php">Back Home!!</a></p>
        <p class="login-box-msg">---------------------- OR ----------------------</p>
        <div class="topnav">
            <a class="active" href="registeruser.php"> CREATE A NEW ACCOUNT </a>
            </div>
    </div>
    <!-- /.login-card-body -->
  </div>
  <div class="container" style="padding: 70px 0 0;"></div>
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
