<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
?>
<!DOCTYPE html>
<html>
<head>
    
	<title>Smart City Services || Home Page</title>
	

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

	<script type='text/javascript'>
         var map, geolocationControl;

        function GetMap() {
            //Initialize a map instance.
            map = new atlas.Map('myMap', {
                view: 'Auto',

                //Add authentication details for connecting to Azure Maps.
                authOptions: {
                    //Use Azure Active Directory authentication.
                    //authType: 'anonymous',
                    //clientId: '04ec075f-3827-4aed-9975-d56301a2d663', //Your Azure Active Directory client id for accessing your Azure Maps account.
                    //getToken: function (resolve, reject, map) {
                    //    //URL to your authentication service that retrieves an Azure Active Directory Token.
                    //    var tokenServiceUrl = "https://azuremapscodesamples.azurewebsites.net/Common/TokenService.ashx";
                    //    fetch(tokenServiceUrl).then(r => r.text()).then(token => resolve(token));
                    //
                    //Alternatively, use an Azure Maps key. Get an Azure Maps key at https://azure.com/maps. NOTE: The primary key should be used as the key.
                    authType: 'subscriptionKey',
                    subscriptionKey: 'gaEVY4Ooa2FpTR3MKnq31JdsuPcunWwx6nlgMAF5wog'
                }
            });

                <?php
					$deactivates=0;
                    $sql="SELECT COUNT(*) FROM tblperson where DEACTIVES='$deactivates'";
                    $qr= $dbh->prepare($sql);
                    $qr->execute();
                    $result= $qr->fetch(PDO::FETCH_NUM);
                    $count= $result[0];
                    //longitude array
                    $geteachloc="SELECT LONGIT FROM tblperson where DEACTIVES='$deactivates' ORDER BY ID ASC";
                    $geteachqr= $dbh->prepare($geteachloc);
                    $geteachqr->execute();
                    $getres= $geteachqr->fetchAll(PDO::FETCH_COLUMN);
                    
                    //latitude array
                    $geteachlat= "SELECT LATIT FROM tblperson where DEACTIVES='$deactivates' ORDER BY ID ASC";
                    $geteachlatqr = $dbh->prepare($geteachlat);
                    $geteachlatqr->execute();
                    $getreslat= $geteachlatqr->fetchAll(PDO::FETCH_COLUMN);

                    //category array
                    $getcat="SELECT Category FROM tblperson where DEACTIVES='$deactivates' ORDER BY ID ASC";
                    $getcatqr= $dbh->prepare($getcat);
                    $getcatqr->execute();
                    $getcatres= $getcatqr->fetchAll(PDO::FETCH_COLUMN);
                    
                    //name
                    $getname="SELECT Name FROM tblperson where DEACTIVES='$deactivates' ORDER BY ID ASC";
                    $getnameqr= $dbh->prepare($getname);
                    $getnameqr->execute();
                    $getnameres= $getnameqr->fetchAll(PDO::FETCH_COLUMN);
                ?>
            
            //Wait until the map resources are ready.
            
            map.events.add('ready', function () {
                //Create a draggable HTML marker.
                    var lala=1;
                    var marker;
                    var c="<?php echo $count?>";
                    var longit= <?php echo json_encode($getres);?>;
                    var latit= <?php echo json_encode($getreslat);?>;
                    var cat= <?php echo json_encode($getcatres);?>;
                    var name1= <?php echo json_encode($getnameres);?>;
                    datasource= new atlas.source.DataSource();
                    map.sources.add(datasource);
                    //alert(c);
                    while(lala<=c){
                    datasource.add([
                        new atlas.data.Feature(new atlas.data.Point([longit[lala-1], latit[lala-1]]),{
                            name: name1[lala-1],
                            description: cat[lala-1]
                        })
                    ]);

                    symbolLayer = new atlas.layer.SymbolLayer(datasource, null, { iconOptions: {allowOverlap: true}});
                    map.layers.add(symbolLayer);

                    popup = new atlas.Popup({
                    position: [longit[lala-1], latit[lala-1]],
                    pixelOffset: [5, -15]
                });
                    lala=lala+1;
                    }

                    map.events.add('mousemove', closePopup);

                    map.events.add('mousemove', symbolLayer, symbolHovered);
                    map.events.add('touchstart', symbolLayer, symbolHovered);
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

            function closePopup() {
                popup.close();
            }

        function symbolHovered(e) {
            //Make sure the event occurred on a shape feature.
            if (e.shapes && e.shapes.length > 0) {
                var properties = e.shapes[0].getProperties();

                //Update the content and position of the popup.
                popup.setOptions({
                    //Create the content of the popup.
                    content: `<div style="padding:10px;"><b>${properties.name}</b><br/>${properties.description}</div>`,
                    position: e.shapes[0].getCoordinates(),
                    pixelOffset: [5, -15]
                });

                //Open the popup.
                popup.open(map);
            }
        }
    </script>
    <!--================================BOOTSTRAP STYLE SHEETS================================-->
        
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	
    <!--================================ Main STYLE SHEETs====================================-->
	
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/menu.css">
	<link rel="stylesheet" type="text/css" href="css/color/color.css">
	<link rel="stylesheet" type="text/css" href="assets/testimonial/css/style.css" />
	<link rel="stylesheet" type="text/css" href="assets/testimonial/css/elastislide.css" />
	<link rel="stylesheet" type="text/css" href="css/responsive.css">

	<!--================================FONTAWESOME==========================================-->
		
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
        
	<!--================================GOOGLE FONTS=========================================-->
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Montserrat:400,700|Lato:300,400,700,900'>  
		
	<!--================================SLIDER REVOLUTION =========================================-->
	
	<link rel="stylesheet" type="text/css" href="assets/revolution_slider/css/revslider.css" media="screen" />
		
</head>
<body onload='GetMap()'>
	<div class="preloader"><span class="preloader-gif"></span></div>
	<div class="theme-wrap clearfix">
		<!--================================responsive log and menu==========================================-->
		<div class="wsmenucontent overlapblackbg"></div>
		<div class="wsmenuexpandermain slideRight">
			<a id="navToggle" class="animated-arrow slideLeft"><span></span></a>
			<a href="#" class="smallogo"><img src="images/logo.png" width="120" alt="" /></a>
		</div>
		<?php include_once('includes/header.php');?>
		
		<!--================================Revolution SLIDER SECTION==========================================-->
		
		<section id="slider-revolution">
			<div class="fullwidthbanner-container">
				<div class="revolution-slider tx-center">
					<ul><!-- SLIDE  -->
								
						<!-- Slide1 -->
						<li data-transition="slideright" data-slotamount="5" data-masterspeed="1000">
						<!-- MAIN IMAGE -->
							<img src="images/baseimage.jpg" alt="item slide">
						<!-- LAYERS -->	
						</li>
					</ul>
				</div>
			</div>
		</section>
		
		<section id="search-form">
			<div class="container">
		
				<div class="search-form-wrap" style="margin-top: 80px;">
					<form class="clearfix" name="search" action="serviceman-search.php" method="post">
						
						<div class="select-field-wrap pull-left">
		
							<input class="input-field" type="text" placeholder="Location" name="location" style="height:55px;" required="required">	
							</select>
						</div>
						<div class="select-field-wrap pull-left">
							<select class="search-form-select" name="categories" >
								<option class="options" value="all-categories">all categories</option>
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
						<div class="submit-field-wrap pull-right">
							<input class="search-form-submit bgyallow-1 black" name="search" type="submit"/>
						</div>
					</form>
				</div>
			</div>
		</section>
		
		<section class="categories-section padding-top-20 padding-bottom-40">
			<div class="container"><!-- section container -->
				<div class="section-title-wrap margin-bottom-50"><!-- section title -->
					<h4>Category</h4>
					<div class="title-divider">
						<div class="line" style="background: radial-gradient(red, blue);"></div>
						<i class="fa fa-star-o"></i>
						<div class="line" style="background: radial-gradient(red, blue);"></div>
					</div>
				</div><!-- section title end -->
				<div class="row category-section-wrap cat-style-2">
					<div class="col-md-12 col-sm-6 col-xs-12"><!-- category column -->
						<div class="cat-wrap shadow-1">
							
							<h5><i class="fa fa-heart bgpurpal-1 white"></i>Local Service Category </h5>
							<div class="cat-list-wrap">
								<ul class="cat-list">
									<?php $deactivates=0;
$sql="SELECT Category, count(ID) as total from tblperson where DEACTIVES='$deactivates' group by Category";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
									<li><a href="view-category-detail.php?viewid=<?php echo htmlentities ($row->Category);?>"><?php  echo htmlentities($row->Category);?> <span>(<?php  echo htmlentities($row->total);?>)</span></a></li>
									<?php $cnt=$cnt+1;}} ?>
									
								</ul>
							</div>
						</div>
						
						<div class="listing-border-bottom bgpurpal-1"></div>
					</div><!-- category column end -->
					</div>
			</div><!-- section container end -->
			<div class="row category-section-wrap cat-style-2">
				<div class="col-md-12 col-sm-6 col-xs-12">
					<div class="cat-wrap shadow-1" style="background:transparent;">
					<div id="myMap" style="position:relative;width:100%;min-width:290px;height:400px;border-radius:20px;"></div>
					</div>
				</div>
			</div>
		</section>
		
	<?php include_once('includes/footer.php');?>
	</div>
	
	
	<!--================================JQuery===========================================-->
        
	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
	<script src="js/jquery.js"></script><!-- jquery 1.11.2 -->
	<script src="js/jquery.easing.min.js"></script>
	<script src="js/modernizr.custom.js"></script>
	
	<!--================================BOOTSTRAP===========================================-->
        
	<script src="bootstrap/js/bootstrap.min.js"></script>	
	
	<!--================================NAVIGATION===========================================-->
	
	<script type="text/javascript" src="js/menu.js"></script>
	
	<!--================================SLIDER REVOLUTION===========================================-->
		
	<script type="text/javascript" src="assets/revolution_slider/js/revolution-slider-tool.js"></script>
	<script type="text/javascript" src="assets/revolution_slider/js/revolution-slider.js"></script>
	
	<!--================================OWL CARESOUL=============================================-->
		
	<script src="js/owl.carousel.js"></script>
    <script src="js/triger.js" type="text/javascript"></script>
		
	<!--================================FunFacts Counter===========================================-->
		
	<script src="js/jquery.countTo.js"></script>
	
	<!--================================jquery cycle2=============================================-->
	
	<script src="js/jquery.cycle2.min.js" type="text/javascript"></script>	
	
	<!--================================waypoint===========================================-->
		
	<script type="text/javascript" src="js/jquery.waypoints.min.js"></script><!-- Countdown JS FILE -->
	
	<!--================================RATINGS===========================================-->	
	
	<script src="js/jquery.raty-fa.js"></script>
	<script src="js/rate.js"></script>
	
	<!--================================ testimonial ===========================================-->
	<script id="img-wrapper-tmpl" type="text/x-jquery-tmpl">	
			
			<div class="rg-image-wrapper">
				<div class="rg-image"></div>
				<div class="rg-caption-wrapper">
					<div class="rg-caption" style="display:none;">
						<p></p>
						<h5></h5>
						<div class="caption-metas">
							<p class="position"></p>
							<p class="orgnization"></p>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</script>	
	<script type="text/javascript" src="assets/testimonial/js/jquery.tmpl.min.js"></script>
	<script type="text/javascript" src="assets/testimonial/js/jquery.elastislide.js"></script>
	<script type="text/javascript" src="assets/testimonial/js/gallery.js"></script>
	
	<!--================================custom script===========================================-->
		
	<script type="text/javascript" src="js/custom.js"></script>
    
</body>
</html>