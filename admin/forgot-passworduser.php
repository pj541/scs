<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

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
if(isset($_POST['reset']))
{
$email=$_POST['email'];
$aadno=$_POST['aadharnumber'];
$mobile=$_POST['mobile'];
$sql="SELECT ID FROM tblperson WHERE Email=:email and AdCard=:aadharnumber and MobileNumber=:mobile";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> bindParam(':aadharnumber', $aadno, PDO::PARAM_STR);
$query-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
   $token= md5(rand());
   $samay=time()+300;
   $otp= rand(pow(10, 4), pow(10, 5)-1);
   $sr="update tblperson set Token='$token', Timeo='$samay', OTP='$otp' where Email=:email and AdCard=:aadharnumber and MobileNumber=:mobile";
   $chgtoken= $dbh->prepare($sr);
   $chgtoken->bindParam(':email', $email, PDO::PARAM_STR);
   $chgtoken->bindParam(':aadharnumber', $aadno, PDO::PARAM_STR);
   $chgtoken->bindParam(':mobile', $mobile, PDO::PARAM_STR);
   $chgtoken->execute();
   foreach($results as $row)
   {
     $id=$row->ID;
     //Import PHPMailer classes into the global namespace
     //These must be at the top of your script, not inside a function
     //Create an instance; passing `true` enables exceptions
     $mail = new PHPMailer(true);
     
     try {
         //Server settings

         $mail->isSMTP();                                            //Send using SMTP
         $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
         $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
         $mail->Username   = 'cmreclocalsearch@gmail.com';                     //SMTP username
         $mail->Password   = 'CmrecLocalSearch@1102';                               //SMTP password
         $mail->SMTPSecure = 'ssl';           //Enable implicit TLS encryption
         $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
     
         //Recipients
         $mail->setFrom('cmreclocalsearch@gmail.com', 'SMART CITY SERVICES');
         $mail->addAddress($email);     //Add a recipient
         $mail->addReplyTo('no-reply@gmail.com', 'No Reply');

          $url="http://".$_SERVER["HTTP_HOST"].dirname($_SERVER["PHP_SELF"])."/fcngu.php?reset=$token&id=$id";
         //Content
         $mail->isHTML(true);                                  //Set email format to HTML
         $mail->Subject = 'OTP Verification for Smart City services';
         $mail->Body    = "<h1>You requester for a password Reset</h1>
                            Your OTP is : $otp <br>
                            <a href='$url'>Click me </a> to verify the OTP <br>
                            <br>Best Regards
                            <br><br>
                            Smart City Services";
         $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
     
         $mail->send();
         echo "<script>alert('Reset Password link has been sent to your email with OTP valid only for 5 mins.');</script>";
     } catch (Exception $e) {
      echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
         //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
     }

     

   }
   
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
  
</head>
<body class="hold-transition login-page" style="background-image: url(https://assets.website-files.com/5f204aba8e0f187e7fb85a87/5f210a533185e7434d9efcab_hero%20img.jpg); background-repeat: no-repeat; background-attachment: fixed; background-size: cover;">
<div class="login-box">
  <div class="login-logo" style="margin-top: 35px;">
    <a href="forgot-passworduser.php"><b></b> Forgot Password? </a>
  </div>
  <!-- /.login-logo -->
  <div class="card" style="background: inherit; backdrop-fliter:blur(15px); box-shadow: 0 0 10px; border-radius: 5%;">
    <div class="card-body login-card-body" style="background: linear-gradient(45deg, #edb0f5f2, #8efdffed); border-radius: 5%;">
      <p class="login-box-msg">Get your new Password</p>

      <form action="" method="post" id="reset">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="aadharnumber" placeholder="Aadhar No"  minlength="16" maxlength="16" pattern="[0-9]+" required="true">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-address-card" ></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control"  name="mobile" placeholder="Mobile Number" minlength="10" maxlength="10" pattern="[0-9]+" required="true">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-mobile" style="font-size:20px;color:red"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="email" placeholder="Email Address" required="true">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope" ></span>
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
            <button type="submit" name="reset" class="btn btn-primary btn-block">Reset</button>
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
