<?php>
        session_start();
        error_reporting(0);
        include('includes/dbconnection.php');

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
<body>
    <?php
        $eid=$_GET['reset'];
        echo "$eid";
    ?>
</body>
</html>