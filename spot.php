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

</head>  
<body> 
<?php
 include("config.php"); 

 
 $spotID = $_GET['id']; 
  
 $query = "select * from Spots where id = '$spotID'";
 $result = mysql_query($query);
 
 while($row = mysql_fetch_array($result, MYSQL_BOTH)) {
	$spotDescription = $row['description']; 
	$spotName = $row['name']; 
	$spotCoordX = $row['coordX']; 
	$spotCoordY = $row['coordY']; 
	$spotCreator = $row['username']; 
 }

 ?>

<!-- /Home Screen/NewsFeed -->
<div data-role="page" id="home" data-add-back-btn="true">

	<div data-role="header">
		<h1><?=$spotName?></h1>
	</div><!-- /header -->
	<p></p>	
		<h2>
		<?=$spotName?> 
		</h2>
		<h2>
		<?=$spotDescription?>
		</h2>
		<div data-role="content">
   		<ul class = "LV" data-role="listview" data-divider-theme="d">
		<h2> 
		<?php
		 	$query = "select * from Users where name = '$spotCreator'";
 			$result = mysql_query($query);
 			
 			while($row = mysql_fetch_array($result, MYSQL_BOTH)) {
 			?>
 			<li>
 			 	<a href="profile.php?id=<?=$row['name']?>" data-transition="slideup" method="get">
 				<img src = "<?=$row['picture']?>" alt = "test"/>
   				<h3>Created by <?=$row["name"]?></h3>
   				</a>
   			</li>
   				<span class="ui-icon ui-icon-arrow-r ui-icon-shadow"></span>
   			<?php
 				}
 			?>
		</h2>
		</ul>
		</div>

		
		<h2>
		Latitude: <?=$spotCoordX?> , Longitude: <?=$spotCoordY?>
		</h2>
		<p>
		<a href="map.php" data-direction="reverse" data-role="button" data-theme="b">Go To Map</a>
		</p>	
		</h2>
		<h2>
		<p>
		<a href="spot.php" data-direction="reverse" data-role="button" data-theme="b">Favorite (will animate when you press)</a>
		</p>	
		
	<div data-role="content">	
		<p></p>			
	</div><!-- /content -->
	
	<div data-role="footer" data-id="samebar" class="nav-glyphish-example" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" class="nav-glyphish-example" data-grid="c">
		<ul>
			<li><a href="search.php" id="search" data-icon="custom">Search</a></li>
			<li><a href="home.php" id="homepage" data-icon="custom">Home</a></li>
			<li><a href="share.php" id="share" data-icon="custom">Share</a></li>
			<li><a href="" id="explore" data-icon="custom">Explore</a></li>
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
		<div data-role="navbar" class="nav-glyphish-example" data-grid="c">
		<ul>
			<li><a href="search.php" id="search" data-icon="custom">Search</a></li>
					<li><a href="home.php" id="homepage" data-icon="custom">Home</a></li>
					<li><a href="share.php" id="share" data-icon="custom">Share</a></li>
					<li><a href="" id="explore" data-icon="custom">Explore</a></li>
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