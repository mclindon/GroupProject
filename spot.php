<!DOCTYPE html> 
<html>

<head>
	<title>Where the Wild Things Are | Login</title> 
	<meta charset="utf-8">
	<meta name="apple-mobile-web-app-capable" content="yes">
 	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 

	<link rel="stylesheet" href="jquery.mobile-1.2.0.css" />
	<link rel="stylesheet" href="style.css" />
	<link rel="apple-touch-icon" href="icon2.png" />
	<link rel="apple-touch-startup-image" href="startup.png"/>
	
	<script src="jquery-1.8.2.min.js"></script>
	<script src="jquery.mobile-1.2.0.js"></script>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

</head>  
<body> 
<?php
 include("config.php"); 

 $spotID = $_GET['url']; 
 $query = "select * from Spots where url = '$spotID'";
 $result = mysql_query($query);
 
 while($row = mysql_fetch_array($result, MYSQL_BOTH)) {
	$spotDescription = $row['description']; 
	$spotName = $row['name'];  
	$spotCreator = $row['username']; 
	$spotPhoto = $row['url']; 
 }
 ?>

<!-- /Home Screen/NewsFeed -->
<div data-role="page" id="home" data-add-back-btn="true">

	<div data-role="header">
		<h1><?=$spotName?></h1>
	</div><!-- /header -->
	<p></p>	
		<h2>
		<?=$spotDescription?>
		</h2>
		<h2>
		<img src = "<?=$spotPhoto?>" alt = "test" vspace="20" hspace="50" align="middle"/>
		</h2>

		<div id="mapcanvas" style="height:315px;width:320px" vspace ="20" hspace ="20"></div>

		<script type="text/javascript">
		var map;
		var wayA;
		var wayB;
		var debug;
				
		// This is the display window
		var infowindow = new google.maps.InfoWindow({
		    size: new google.maps.Size(150, 50)
		});
		
		
		// Create the marker
		function createMarker(latlng, name, html) {
		    var contentString = html;
		    var marker = new google.maps.Marker({
		        position: latlng,
		        map: map
		    });
		
		    google.maps.event.addListener(marker, 'click', function () {
		        infowindow.setContent(contentString);
		        infowindow.open(map, marker);
		    });
		    google.maps.event.trigger(marker, 'click');
		    return marker;
		}
		
		function success(position) {
			console.log("The user's position is at");
			debug = position;
		    console.log(debug);
		    
		    var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		    var myOptions = {
		        zoom: 15,
		        center: latlng,
		        mapTypeControl: false,
		        navigationControlOptions: {
		            style: google.maps.NavigationControlStyle.SMALL
		        },
		        mapTypeId: google.maps.MapTypeId.ROADMAP
		    };
		
		    map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);
		
		    var marker = new google.maps.Marker({
		        position: latlng,
		        map: map,
		        title: "You are here!",
		        icon: 'beachflag.png'
		    });
		    
		    var renderer;
		    google.maps.event.addListener(map, 'click', function (event) {
		        if (!wayA) {
		        	// If a direction has been set, 
		        	// remove it.
		        	if (renderer) {
		        		renderer.setMap(null);
		        	}
		            wayA = new google.maps.Marker({
		
		                position: event.latLng,
		                map: map
		
		            });
		        } else {
		            wayB = new google.maps.Marker({
		
		                position: event.latLng,
		                map: map
		
		            });
					 
		            // Directions
		            renderer = new google.maps.DirectionsRenderer({
		                'draggable': true
		            });
		            renderer.setMap(map);
		
					// Uncomment the following to add a directions pane
		            //ren.setPanel(document.getElementById("directionsPanel"));
		            service = new google.maps.DirectionsService();
		
		            service.route({
		                'origin': wayA.getPosition(),
		                'destination': wayB.getPosition(),
		                'travelMode': google.maps.DirectionsTravelMode.DRIVING
		            }, function (result, status) {
		            	
		            	console.log("The route between the two points is");
		            	debug = result;
		    			console.log(debug);
		    			
		                if (status == 'OK') renderer.setDirections(result);
		                	wayA.setMap(null);
				            wayA = null;
				            wayB.setMap(null);
				            wayB = null;
		            })
		        }
		    });
		}
		
		function error(msg) {
		    var s = document.querySelector('#status');
		    s.innerHTML = typeof msg == 'string' ? msg : "failed";
		    s.className = 'fail';
		}
		
		if (navigator.geolocation) {
		    navigator.geolocation.getCurrentPosition(success, error);
		} else {
		    error('not supported');
		}		
		</script> 
		
		
			
		<div data-role="content">
   		<ul class = "LV" data-role="listview" data-divider-theme="d">
		<?php
			$query = "select * from Users where username = '$spotCreator'";
		 	 $result = mysql_query($query);
 
 			 while($row = mysql_fetch_array($result, MYSQL_BOTH)) {
 			 ?>
 			<li>
 				<a href="profile.php?username=<?=$row['username']?>" data-transition="slideup" method="get">
 				<img src = "<?=$row['picture']?>" alt = "test"/>
 				<h3>Spotted by <?=$row["username"]?></h3>
   		 		</a>
 			</li>
   				<span class="ui-icon ui-icon-arrow-r ui-icon-shadow"></span>
   			<?php
 	 			}
 	 		?>
		</ul>
		</div>
	
	<div data-role="footer" data-id="samebar" class="nav-glyphish-example" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" class="nav-glyphish-example" data-grid="a">
		<ul>
			<li><a href="home.php" id="homepage" data-icon="custom">Home</a></li>
			<li><a href="share.php" id="share" data-icon="custom">Share</a></li>
		
		</ul>
		</div>
	</div>
</div>

<!-- Start of third page: #popup -->
<div data-role="page" id="comments">

	<div data-role="header" data-theme="e">
		<h1>Dialog</h1>
	</div><!-- /header -->

	<div data-role="content" data-theme="d">	
		<h2>Popup</h2>
		<p>I have an id of "popup" on my page container and only look like a dialog because the link to me had a <code>data-	rel="dialog"</code> attribute which gives me this inset look and a <code>data-transition="pop"</code> attribute to change the transition to pop. Without this, I'd be styled as a normal page.</p>		
		<p><a href="#one" data-rel="back" data-role="button" data-inline="true" data-icon="back">Back to page "one"</a></p>	
	</div><!-- /content -->
	
	<div data-role="footer" data-id="samebar" class="nav-glyphish-example" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" class="nav-glyphish-example" data-grid="a">
		<ul>
			<li><a href="home.php" id="homepage" data-icon="custom">Home</a></li>
			<li><a href="share.php" id="share" data-icon="custom">Share</a></li>
		</ul>
		</div>
	</div>
</div>
</div><!-- /page popup -->

<script type="text/javascript">
	$("#logout").hide();
	$("#info").hide();
	var retrievedObject = localStorage.getItem('username');
	if (retrievedObject == "test") {
		$("#form").hide();	
		$("#logout").show();
		$("#info").show();
	}
	$("#logout").click(function() {
		localStorage.removeItem('username');
		$("#form").show();
		$("#logout").hide();
		$("#info").hide();
	});
	</script>
</div>
<!--Home Screen/News Feed End-->
</body>
</html>