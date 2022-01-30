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
    $eid=$_SESSION['lssemsaid'];
    $email=$_POST['email'];
$mobnum=$_POST['mobilenumber'];
$address=$_POST['address'];
$category=$_POST['category'];
$city=$_POST['city'];
$charg= $_POST['charges'];

$sql="update tblperson set Category=:cat,Email=:email,MobileNumber=:mobilenumber,Address=:address,City=:city,Salary=:charges where ID=:eid";
$query=$dbh->prepare($sql);
$query->bindParam(':cat',$category,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':mobilenumber',$mobnum,PDO::PARAM_STR);
$query->bindParam(':address',$address,PDO::PARAM_STR);
$query->bindParam(':city',$city,PDO::PARAM_STR);
$query->bindParam(':charges',$charg,PDO::PARAM_STR);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
$query->execute();
echo '<script>alert("Your profile has been updated")</script>';
 
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
            <h1>User Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="user-profile.php">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
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
                <h3 class="card-title">Update Person Detail</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" enctype="multipart/form-data">
                <?php
                   $eid=$_SESSION['lssemsaid'];
$sql="SELECT * from tblperson where ID=$eid";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlentities($row->Name);?>" required="true" readonly="true">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Service Category</label>
                    <select type="text" name="category" id="category" value="" class="form-control" required="true">
<option value="<?php echo htmlentities($row->Category);?>"><?php echo htmlentities($row->Category);?></option>
                                                        <?php 

$sql2 = "SELECT * from   tblcategory ";
$query2 = $dbh -> prepare($sql2);
$query2->execute();
$result2=$query2->fetchAll(PDO::FETCH_OBJ);

foreach($result2 as $row1)
{          
    ?>  
<option value="<?php echo htmlentities($row1->Category);?>"><?php echo htmlentities($row1->Category);?></option>
 <?php } ?> 
            
                                                        
                                                    </select>
                  </div>
                     
                  <div class="form-group">
                    <label for="exampleInputEmail1">Profile Pics </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <img src="images/<?php echo $row->Picture;?>" width="100" height="100" value="<?php  echo $row->Picture;?>">
                    <a href="changeimageuser.php?editid=<?php echo $row->ID;?>"> &nbsp; Edit Image</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label for="exampleInputEmail1">Aadhar Picture </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <img src="images/<?php echo $row->AdPhoto;?>" width="100" height="100" value="<?php  echo $row->AdPhoto;?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Aadhar Number / User-Name</label>
                    <input type="text" class="form-control" id="aadharnumber" name="aadharnumber" value="<?php echo htmlentities($row->AdCard);?>" readonly='true'>
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email Address</label>
                    <input type="text" class="form-control" id="email" name="email" value="<?php echo htmlentities($row->Email);?>" required="true">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Mobile Number</label>
                    <input type="text" class="form-control" id="mobilenumber" name="mobilenumber" value="<?php echo htmlentities($row->MobileNumber);?>" maxlength="10" pattern="[0-9]+" required="true">
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputEmail1">Address</label>
                    <textarea type="text" class="form-control" id="address" name="address" placeholder="Address" required="true"><?php echo htmlentities($row->Address);?></textarea>
                  </div>  
                  <div class="form-group">
                    <label for="exampleInputEmail1">City</label>
                    <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlentities($row->City);?>" required="true">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Charges</label>
                    <input type="text" class="form-control" id="charges" name="charges" value="<?php echo htmlentities($row->Salary);?>" placeholder="Charges / Salary per month in ₹" maxlength="7" minlength="2" pattern="[0-9]+" required="true">
                  </div> 
                </div>
              <?php $cnt=$cnt+1;}} ?> 
                <div class="card-footer" style="text-align:center;">
                  <button type="submit" class="btn btn-primary" name="submit" style="background: slateblue;">Update</button>
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