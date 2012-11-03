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

 $username = $_GET['username']; 
  
 $query = "select * from Users where username = '$username'";
 $result = mysql_query($query);
 
 while($row = mysql_fetch_array($result, MYSQL_BOTH)) {
	$userPhoto = $row['picture']; 
 }

 ?> 

<!-- /Home Screen/NewsFeed -->
<div data-role="page" id="home" data-add-back-btn="true">

	<div data-role="header">
		<h1><?=$username?></h1>
	</div><!-- /header -->
		<img src = "<?=$userPhoto?>" alt = "test" vspace="20" hspace="20" align="middle"/>
		
	<div data-role="content">	

			<h2><?=$username?>'s Spots</h2>	
			
			<div data-role="content">
   			<ul class = "LV" data-role="listview" data-divider-theme="d" data-filter="true">
			<?php
			$query = "select * from Spots where username = '$username'";
 			$result = mysql_query($query);

 			while($row = mysql_fetch_array($result, MYSQL_BOTH)) {
 			?>
 					<li>
 						<a href="spot.php?url=<?=$row['url']?>" data-transition="pop" method="get">
 						<img src = "<?=$row['url']?>" alt = "test"/>
   						<h3><?=$row["description"]?></h3>
   						</a>
   					</li>
   					<span class="ui-icon ui-icon-arrow-r ui-icon-shadow"></span>
 			<?php
 			}
			?>
				</ul>
			</div>
			
			<!--follow button needed -->
		
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