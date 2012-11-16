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

<!-- /Spot Info Page -->
<div data-role="page" id="home">
	<div data-role="header" data-position="inline">
		<h1><?=$spotName?></h1>
		<?php
		 $username = $_GET["username"];
		 $queryCheck = "select * from Favorites where url = '$spotID' and username = '$username'";
 		 $resultCheck = mysql_query($queryCheck);
 		 if (mysql_num_rows($resultCheck) == 0) {
		?>
			<a href="#" data-icon="star" data-theme="b" class="ui-btn-right" id="favoriteButton">Add this spot to Favorites!</a>
		<?php
 		 } else {
 		 ?>
 		 	<a href="#" data-icon="star" data-theme="b" class="ui-btn-right" id="favoriteButtonRemove">Click to remove from Favorites</a>
 		 <?php	
 		 }
		?>
	</div><!-- /header -->

		<h2>
		<?=$spotDescription?>
		</h2>
		<h2>
		<img src = "<?=$spotPhoto?>" alt = "test" vspace="20" hspace="50" align="middle"/>
		</h2>

		<div data-role="collapsible" data-collapsed-icon="arrow-r" and data-expanded-icon="arrow-d" data-mini="true">
   		 <h3>Comments</h3>
   		 <?php
			$query = "select * from Comments where spot = '$spotID'";
 			$result = mysql_query($query);

 			 while($row = mysql_fetch_array($result, MYSQL_BOTH)) {
 			 ?>
 				 <h4><?=$row["comment"]?> -- <?=$row["user"]?></h4>
   		 	<?php
 		 	}
			?>
			<form action = "newComment.php" method = "post">
				<h5>
				Comment:  <input type="text" name ="comment" class="ui-input-text ui-body-c ui-corner-all ui-shadow-inset ui-focus">
				</h5> 
				<input name="username" type="text" value="<?=$_GET['username']?>"/>
				<input name="url" type="text" value="<?=$_GET['url']?>"/>
				<input type = "submit" data-direction = "reverse" data-role = "button" data-theme = "c" value = "Comment">
				</div>
			</form>
		
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
 				<a href="profile.php?profileUsername=<?=$row['username']?>&username=<?=$_GET['username']?>" method="get">
 				<img src = "<?=$row['picture']?>" alt = "test"/>
 				<h3>Spotted by <?=$row["username"]?></h3>
   		 		</a>
 			</li>
   				<span class="ui-icon ui-icon-arrow-r ui-icon-shadow"></span>
   			<?php
 	 			}
 	 		?>
		</ul>
		
		<script>
		$('#favoriteButton').click(function() {
			$.post('addToFavs.php', { url: "<?=$_GET['url']?>", username: "<?=$_GET['username']?>" }, function(data) {
 				$('#favoriteButton .ui-btn-text').html("Added to Favorites!");
			});
		});
		
		$('#favoriteButtonRemove').click(function() {
			$.post('removeFromFavs.php', { url: "<?=$_GET['url']?>", username: "<?=$_GET['username']?>" }, function(data) {
 				$('#favoriteButtonRemove .ui-btn-text').html("Removed from Favorites!");
			});
		});
		
		</script>
		
		</div>
	
	<div data-role="footer" data-id="samebar" class="nav-glyphish-example" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" class="nav-glyphish-example" data-grid="a">
		<ul>
			<li><a href="home.php?username=<?=$_GET['username']?>" id="homepage" data-icon="custom" method = "get">Home</a></li>
			<li><a href="share.php?username=<?=$_GET['username']?>" id="share" data-icon="custom" method = "get" data-ajax="false">Share</a></li>
		
		</ul>
		</div>
	</div>
</div>


</div>
<!--Home Screen/News Feed End-->
</body>
</html>