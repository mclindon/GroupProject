<!DOCTYPE html> 
<html>

<head>
	<title>Where the Wild Things Are | Home</title> 
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
	<script src="js/script.js"></script>
	
</head>  
<body> 

  <?php
 include("config.php"); 

 $username = $_POST["username"];
 
 if($username == "") {
 	$username = $_GET["username"];
 	$query = "select * from Users where username = '$username'";
 	$result = mysql_query($query);
 	$row = mysql_fetch_array($result, MYSQL_BOTH);
 	$password =  $row['password'];
 } else {
 	
 $password = $_POST["password"];
 $passwordCheck = $_POST["passwordCheck"];
 $email = $_POST["email"];
 }
 
 if ($passwordCheck != "") {
 	if ($password == $passwordCheck) {
 		$queryInsert = "select * from NewPhotos";
        $resultInsert = mysql_query($queryInsert);
 
        $rowInsert = mysql_fetch_array($resultInsert, MYSQL_BOTH);
        $url = $rowInsert["url"];
        if($url == "") {
 			$url = "http://www.fabricworkshopandmuseum.org/images/noMediaUploaded.png";	
 		}

 		mysql_query("insert into Users (username, password, email, picture) VALUES ('$username', '$password', '$email', '$url')");
 		
 		 mysql_query("delete from NewPhotos");
 	} else {
 		?>
 		<p> Your passwords did not match. </p>
 	
 		<p> Would you like to try again? </p>
 		<p><a href="index.php" data-direction="reverse" data-role="button" data-theme="b">Try Again</a></p>		
 		<?php
 	}	
 }

 $query = "select * from Users where username = '$username' and password='$password'";
 $result = mysql_query($query);

 $num_rows = mysql_num_rows($result);

 if ($num_rows == 0) {
 ?>
 	<h1><?=$_GET['username']?>:)</h1>
 
 	<p> Username or password is incorrect. </p>
 	
 	<p> Would you like to try again? </p>
 	<p><a href="index.php" data-direction="reverse" data-role="button" data-theme="b">Try Again</a></p>		
 	
 	<!--The code below redirects you immediately to the below link. This was used during testing
 	and might be helpful later.
	<script type="text/javascript">
		window.location="http://www.stanford.edu/~ckortel/cgi-bin/GroupProject/index.php";
	</script>	-->
 <?php
 } else {
 	
 ?>

	<!-- /Home Screen/NewsFeed -->
	<div data-role="page" id="home">

		<div data-role="header">
			<h1><?=$username?>'s Home Page</h1>
		</div><!-- /header -->

		<div data-role="content">	

			<h2>News Feed</h2>	

			<div data-role="content">
   				<ul class = "LV" data-role="listview" data-divider-theme="d" data-filter="true">
			<!-- Let's include the header file that we created above -->
			<?php
			$query = "select * from Spots";
 			$result = mysql_query($query);

 			while($row = mysql_fetch_array($result, MYSQL_BOTH)) {
 			?>
 					<li>
 						<a href="spot.php?url=<?=$row['url']?>&username=<?=$username?>" data-transition="slide" method="get">
 						<img src = "<?=$row['url']?>" alt = "test"/>
 						<h2><?=$row["name"]?></h2>
   						<p><?=$row["description"]?></p>
   						</a>
   					</li>
   					<span class="ui-icon ui-icon-arrow-r ui-icon-shadow"></span>
 			<?php
 			}
			?>
				</ul>
			</div>
			
			
			<div data-role="content">
   			<ul class = "LV" data-role="listview" data-divider-theme="d">
			<?php
			$query = "select * from Users where username = '$username'";
		 	 $result = mysql_query($query);
 
 			 while($row = mysql_fetch_array($result, MYSQL_BOTH)) {
 			 ?>
 			 
 			 <div>
 			 <p>
 			 </p>
 			 <h2>
 			 </h2>
 			 </div>
 			<li>
 				<a href="profile.php?profileUsername=<?=$username?>&username=<?=$username?>" data-transition="slide" method="get" data-ajax="false">
 				<img src = "<?=$row['picture']?>" alt = "test"/>
 				<h3>My Profile</h3>
   		 		</a>
 			</li>
   				<span class="ui-icon ui-icon-arrow-r ui-icon-shadow"></span>
   			<?php
 	 			}
 	 		?>
		</ul>
		</div>
		
		</div><!-- /content -->
	
		<div data-role="footer" data-id="samebar" class="nav-glyphish-example" data-position="fixed" data-tap-toggle="false">
			<div data-role="navbar" class="nav-glyphish-example" data-grid="a">
				<ul>
					<li><a href="home.php?username=<?=$username?>" id="homepage" data-icon="custom" method="get" >Home</a></li>
					<li><a href="share.php?username=<?=$username?>" id="share" data-icon="custom" method="get" data-ajax="false">Share</a></li>	
				</ul>
			</div>
		</div>
	</div>

<!-- Start of third page: #popup -->
<div data-role="page" id="favorites">

	<div data-role="header" data-theme="e">
		<h1>Dialog</h1>
	</div><!-- /header -->

	<div data-role="content" data-theme="d">	
		<h2>Favorites</h2>
		<p>I have an id of "popup" on my page container and only look like a dialog because the link to me had a 
		<code>data-rel="dialog"</code> attribute which gives me this inset look and a <code>data-transition="pop"</code> 
		attribute to change the transition to pop. Without this, I'd be styled as a normal page.</p>		
		<p><a href="#one" data-rel="back" data-role="button" data-inline="true" data-icon="back">Back to page "one"</a></p>	
	</div><!-- /content -->
	
	<div data-role="footer" data-id="samebar" class="nav-glyphish-example" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" class="nav-glyphish-example" data-grid="c">
		<ul>
			<li><a href="home.php?username=<?=$username?>" id="home" data-icon="custom" method = "get">Home</a></li>
			<li><a href="login.php" id="key" data-icon="custom">Login</a></li>
			<li><a href="filter.php" id="beer" data-icon="custom" class="ui-btn-active">Filter</a></li>
			<li><a href="#" id="skull" data-icon="custom">Settings</a></li>
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
 <?php
 } 
 ?>
<!--Home Screen/News Feed End-->
</body>
</html>