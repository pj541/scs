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
if(strlen($_SESSION['lssemsaid']!=0) && $_SESSION['login']!='admin')
{
    header('location:user-profile.php');
}
else if(strlen($_SESSION['lssemsaid']!=0) && $_SESSION['login']=='admin')
{
    header('location:dashboard.php');
}else{
    if(isset($_POST['submit']))
  {

$name=$_POST['name'];
$email=$_POST['email'];
$mobnum=$_POST['mobilenumber'];
$long=$_POST['long'];
$lat=$_POST['lat'];
$aadnum=$_POST['aadharnumber'];
$address=$_POST['address'];
$city=$_POST['city'];
$category=$_POST['category'];
$propic=$_FILES["propic"]["name"];
$aadpic=$_FILES["aadpicture"]["name"];
$newpass=md5($_POST['newpassword']);
$charg=$_POST['charges'];
$extension = substr($propic,strlen($propic)-4,strlen($propic));
$extension1 = substr($aadpic,strlen($aadpic)-4,strlen($aadpic));
$allowed_extensions = array(".jpg","jpeg",".png",".gif");

if(!in_array($extension,$allowed_extensions))
{
echo "<script>alert('Profile Pics has Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
}
else if(!in_array($extension1,$allowed_extensions)){
  echo "<script>alert('Aadhar Photo has Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
}
else
{
$propic=md5($propic).time().$extension;
 move_uploaded_file($_FILES["propic"]["tmp_name"],"images/".$propic);
 $aadpic = md5($aadpic).time().$extension1;
 move_uploaded_file($_FILES["aadpicture"]["tmp_name"],"images/".$aadpic);

$sql="insert into tblperson(Category,Name,Picture,MobileNumber,Address,City,AdCard,AdPhoto,Password,Email,LONGIT,LATIT,Salary)values(:cat,:name,:pics,:mobilenumber,:address,:city,:aadharnumber,:aadpicture,:newpassword,:email,:long,:lat,:charges)";
$query=$dbh->prepare($sql);
$query->bindParam(':name',$name,PDO::PARAM_STR);
$query->bindParam(':pics',$propic,PDO::PARAM_STR);
$query->bindParam(':cat',$category,PDO::PARAM_STR);
$query->bindParam(':mobilenumber',$mobnum,PDO::PARAM_STR);
$query->bindParam(':long',$long,PDO::PARAM_STR);
$query->bindParam(':lat',$lat,PDO::PARAM_STR);
$query->bindParam(':address',$address,PDO::PARAM_STR);
$query->bindParam(':city',$city,PDO::PARAM_STR);
$query->bindParam(':aadharnumber',$aadnum,PDO::PARAM_STR);
$query->bindParam(':aadpicture',$aadpic,PDO::PARAM_STR);
$query->bindParam(':newpassword',$newpass,PDO::PARAM_STR);
$query->bindParam(':charges',$charg,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
try{
  $query->execute();
}
catch (Exception $e){
    echo '<script>alert("User Already Exists with this Aadhar / Email / Mobile Number.")</script>';
    echo "<script>window.location.href ='loginuser.php'</script>";
}
   $LastInsertId=$dbh->lastInsertId();
   if ($LastInsertId>0) {
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
         //Content
         $mail->isHTML(true);                            //Set email format to HTML
         $mail->Subject = 'Welcome to Smart City Services';
         $mail->Body    = "Dear $name, <br>
                            Welcome to Smart City Services. We hope you will have a great journey ahead on this platform.<br>
                            While you are here, we urge you to not use this platform for any illegal activities. Any suspicious account will be permanently banned from this platform.<br>
                            <br>NOTE: Your account is temporarily under verification stage for upto 14 days and will be only valid after verification is done from our side.<br>
                            <br>Best Regards
                            <br><br>
                            Smart City Services";
     
         $mail->send();
     } catch (Exception $e) {
      echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
         //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
     }
    echo '<script>alert("Thanks for Signing Up to SCS")</script>';
    echo "<script>window.location.href ='loginuser.php'</script>";
  }
  else
    {
         echo '<script>alert("Uh-oh ! Something Went Wrong. Please try again")</script>';
    }
}
}
?>
<!DOCTYPE html>
<html>
<head>
  
  <title>Local Services Search Engine Mgmt System | Add Person</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <meta charset="utf-8" />
	<link rel="shortcut icon" href="/favicon.ico"/>
    <meta http-equiv="x-ua-compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="This sample shows how to make an HTML marker draggable." />
    <meta name="keywords" content="Microsoft maps, map, gis, API, SDK, markers, pins, pushpins, symbols, drag, draggable, mouse, GIS, custom, control, custom control, geolocation, user, location, position, tracking, gps, gps tracking" />
    <meta name="author" content="Microsoft Azure Maps" />

    <!-- Add references to the Azure Maps Map control JavaScript and CSS files. -->
    <link rel="stylesheet" href="https://atlas.microsoft.com/sdk/javascript/mapcontrol/2/atlas.min.css" type="text/css" />
    <script src="https://atlas.microsoft.com/sdk/javascript/mapcontrol/2/atlas.min.js"></script>
    <script src="https://azuremapscodesamples.azurewebsites.net/Common/scripts/azure-maps-geolocation-control.min.js"></script>

  <style>

/* Button used to open the contact form - fixed at the bottom of the page */
.open-button {
  background-color: #55a5a3;
  color: white;
  padding: 6px 2px;
  border: none;
  cursor: pointer;
  opacity: 1.0;
  position: fixed;
  bottom: 741px;
  right: 28.5px;
  width: 276px;
  border-radius: 5px;
}
/* The popup form - hidden by default */
.form-popup {
  display: none;
  position: fixed;
  bottom: 741px;
  width: 400px;
  min-width: 290px;
  height:300px;
  right: 15px;
  border: 3px solid #f1f1f1;
  z-index: 9;
}
/* Add styles to the form container */
.form-container {
  max-width: 300px;
  padding: 10px;
  background-color: white;
}
/* Set a style for the submit/login button */
.form-container .btn {
  background-color: #04AA6D;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}
/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}
</style>

<script type="text/javascript">
function checkpass()
{
if(document.addpassword.newpassword.value!=document.addpassword.confirmpassword.value)
{
alert('New Password and Confirm Password field does not match');
document.addpassword.confirmpassword.focus();
return false;
}
return true;
}   

function openForm() {
  document.getElementById("mapForm").style.display = "block";
}

function closeForm() {
  document.getElementById("mapForm").style.display = "none";
}

var map, geolocationControl;

function GetMap() {
    //Initialize a map instance.
    map = new atlas.Map('myMap', {
        center: [20.049159, 64.4018361],
        zoom: 0,
        view: 'Auto',

        //Add authentication details for connecting to Azure Maps.
        authOptions: {
            //Use Azure Active Directory authentication.
            //authType: 'anonymous',
            //clientId: '04ec075f-3827-4aed-9975-d56301a2d663', //Your Azure Active Directory client id for accessing your Azure Maps account.
            //getToken: function (resolve, reject, map) {
            //    //URL to your authentication service that retrieves an Azure Active Directory Token.
            //    var tokenServiceUrl = "https://azuremapscodesamples.azurewebsites.net/Common/TokenService.ashx";
//
            //    fetch(tokenServiceUrl).then(r => r.text()).then(token => resolve(token));
            //}

            //Alternatively, use an Azure Maps key. Get an Azure Maps key at https://azure.com/maps. NOTE: The primary key should be used as the key.
            authType: 'subscriptionKey',
            subscriptionKey: 'gaEVY4Ooa2FpTR3MKnq31JdsuPcunWwx6nlgMAF5wog'
        }
    });

        
    //Wait until the map resources are ready.
    map.events.add('ready', function () {
        //Create a draggable HTML marker.
        var marker = new atlas.HtmlMarker({
            draggable: true,

            //Tip: add "pointer-events:none" as a style on the html content to disable the default drag behavior in MS Edge which will display an unwanted icon.
            htmlContent: '<img src="images/ylw-pushpin.png" style="pointer-events: none;" />',

            position: [64.4018361, 20.049159],
            pixelOffset: [5, -15]
        });

        var output = document.getElementById('output');
        var check1;
        var check2;
        //Add a drag event to get the position of the marker. Markers support drag, dragstart and dragend events.
        map.events.add('drag', marker, function () {
            var pos = marker.getOptions().position;

            //Round longitude,latitude values to 5 decimal places.
            
            output.innerText = Math.round(pos[0] * 100000) / 100000 + ', ' + Math.round(pos[1] * 100000) / 100000;
            document.getElementById("getlocation").value= output.innerText;
            check1 = Math.round(pos[0] * 100000) / 100000;
            document.getElementById("long").value= check1;
            check2 = Math.round(pos[1] * 100000) / 100000;
            document.getElementById("lat").value= check2;
                 
        });

        //var markerone = new atlas.HtmlMarker({
        //    draggable: false,
//
        //    //Tip: add "pointer-events:none" as a style on the html content to disable the default drag behavior in MS Edge which will display an unwanted icon.
        //    htmlContent: '<img src="images/ylw-pushpin.png" style="pointer-events: none;" />',
//
        //    position: [78.9324213, 21.1613484],
        //    pixelOffset: [5, -15]
        //});
        //Add the marker to the map.
        map.markers.add(marker);
        //map.markers.add(markerone);
        map.controls.add([
            //Optional. Add the map style control so we can see how the custom control reacts.
            new atlas.control.StyleControl(),

            //Add the geolocation control to the map.
            new atlas.control.GeolocationControl({
                style: 'auto'
            })
        ], {
            position: 'top-right'
        });
    });

    
    }

</script>
</head>

    <body onload='GetMap()' class="hold-transition login-page"style="background-image:url(https://assets.website-files.com/5f204aba8e0f187e7fb85a87/5f210a533185e7434d9efcab_hero%20img.jpg);
    background-repeat: no-repeat; background-attachment: fixed; background-size: cover;">

  <!-- Content Wrapper. Contains page content -->
  <div class="wrapper">
  <div class="login-box" style="width: 1000px;">
  <div class="login-logo" style="margin-top: 10rem;">
    <a href="registeruser.php"><b> SIGN-UP </b> | Service Provider </a>
  </div>
  <div class="card" style=" background: transparent; border-radius:5%; box-shadow: none;">
    <!-- Main content -->
    <section class="content" style=" background: inherit; backdrop-filter: blur(15px); box-shadow: 0 0 10px; border-radius:5%; padding: 10px 0 0;">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary" style="border-radius:5%;">
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" name="addpassword" method="post" onsubmit="return checkpass();" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required="true">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Service Category</label>
                    <select type="text" name="category" id="category" value="" class="form-control" required="true">
<option value="">Choose Category</option>
                                                        <?php 

$sql2 = "SELECT * from   tblcategory ";
$query2 = $dbh -> prepare($sql2);
$query2->execute();
$result2=$query2->fetchAll(PDO::FETCH_OBJ);

    foreach($result2 as $row)
    {          
    ?>  
    <option value="<?php echo htmlentities($row->Category);?>"><?php echo htmlentities($row->Category);?></option>
 <?php } ?> 
            
                                                        
                                                    </select>
                  </div>
                     
                  <div class="form-group">
                    <label for="exampleInputEmail1">Profile Pics</label>
                    <input type="file" class="form-control" id="propic" name="propic" required="true">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email Address</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Email Address" required="true">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Mobile Number</label>
                    <input type="text" class="form-control" id="mobilenumber" name="mobilenumber" placeholder="Mobile Number" maxlength="10" minlength="10" pattern="[0-9]+" required="true">
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputEmail1">Get Location</label>
                    <input type="text" class="form-control" id="getlocation" placeholder="Use Pin to mark your Location" name="getlocation"  required="true" readonly="true">
                  </div> 
                  <div class="form-group">
                    <input type="hidden" class="form-control" id="lat"  name="lat"  required="true">
                  </div> 
                  <div class="form-group">
                    <input type="hidden" class="form-control" id="long"  name="long"  required="true">
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputEmail1">Address</label>
                    <textarea type="text" class="form-control" id="address" name="address" placeholder="Address" required="true"></textarea>
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputEmail1">City</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="City" required="true">
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputEmail1">Aadhar Number</label>
                    <input type="text" class="form-control" id="aadharnumber" name="aadharnumber" placeholder="Aadhar Number" maxlength="16" minlength="16" pattern="[0-9]+" required="true">
                  </div>  
                  <div class="form-group">
                    <label for="exampleInputEmail1">Upload your Aadhar</label>
                    <input type="file" class="form-control" id="aadpicture" name="aadpicture" required="true">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Password</label>
                    <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="Use [$,a-z,A-Z,0-9]" required="true">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" required="true">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Charges</label>
                    <input type="text" class="form-control" id="charges" name="charges" placeholder="Charges / Salary per month in ₹" maxlength="7" minlength="2" pattern="[0-9]+" required="true">
                  </div>
                </div>
                
                <div class="card-footer" style="text-align: center;">
                  <button type="submit" class="btn btn-primary" name="submit" style="background:slateblue;"> Submit </button>
                </div>
              </form>
              <button class="open-button" onclick="openForm()">Mark Your Exact Location on Map</button>
                      <div class="form-popup" id="mapForm">
                      <div id="myMap" style="position:relative;width: 400px; min-width:290px;height:300px;"></div>
                        <form class="form-container">
                        <div id="output" style="position:absolute;top:305px;left:calc(50% - 218px);height:20px;width:200px;background-color:white;text-align:center;"></div>
                          <br>
                          <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
                        </form>
                      </div>
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
    <div class="container" style="padding: 100px 0 0;"></div>
  </div>
  
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
    </div>

  <!-- /.content-wrapper -->
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