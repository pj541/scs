<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['lssemsaid']==0)) {
    header('location:logout.php');
  }
else if(strlen($_SESSION['lssemsaid']!=0) && $_SESSION['login']=='admin'){
      header('location:dashboard.php');
    }
  else{
    if(isset($_POST['submit']))
  { 
      $uid= $_SESSION['lssemsaid'];
      $cpass= md5($_POST['currentpassword']);
      $sql ="SELECT ID FROM tblperson WHERE ID='$uid' and Password='$cpass'";
      $query= $dbh -> prepare($sql);
      $query->execute();
      $results = $query -> fetchAll(PDO::FETCH_OBJ);
      if($query -> rowCount() > 0){
        $val=1;
        $con="update tblperson set DEACTIVES='$val' where ID='$uid'";
        $deac= $dbh->prepare($con);
        $deac->execute();
        echo '<script>alert("adiós, amigo mío ! \nYour have successfully deactivated your account !")</script>';
        echo "<script>window.location.href ='logout.php'</script>";
    }else{
        echo '<script>alert("Your current password is wrong")</script>';
    }
  }
  ?>

<!DOCTYPE html>
<html>
<head>
  
  <title>Local Services Search Engine Mgmt System | User Profile</title>
    
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <?php include_once('includes/headeruser.php');?>

 
<?php include_once('includes/sidebaruser.php');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Account Settings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="user-profile.php">Home</a></li>
              <li class="breadcrumb-item active">Account Settings</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header" style="background: #8750bf;">
                <h3 class="card-title">Deactivate Account</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group"><label for="company" class=" form-control-label">Current Password</label><input type="password" name="currentpassword" id="currentpassword" class="form-control" required=""></div>
                  <label for="exampleInputEmail1" style="font-weight: 400; font-style: italic;"> <strong>Note</strong>: Deactivating your account will disable your profile and remove your name and photo from most things you've shared on Smart City Services. You can reactivate your account by logging in back with the same user-id.</label>
                </div>
                <div class="card-footer" style="text-align:center;">
                  <button type="submit" class="btn btn-primary" name="submit" style="background: slateblue;" onclick="return confirm('Are you sure you want to deactivate your account ?')">Deactivate</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

          </div>
          <!--/.col (left) -->
          <!-- right column -->
         
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
<?php include_once('includes/footer.php');?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
</body>
</html>
<?php }  ?>