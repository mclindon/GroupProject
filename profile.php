<!DOCTYPE html> 
<html>

<head>
	<title>Where the Wild Things Are | Login</title> 
	<meta charset="utf-8">
	<meta name="apple-mobile-web-app-capable" content="yes">
 	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<link rel="stylesheet" href="delete.css" />
	<link rel="stylesheet" href="style.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
	<script src="photoswipe2.js"></script>
		
	<script type="text/javascript">
		$(document).ready(function() {

			// attach the plugin to an element
			$('#swipeMe li').swipeDelete({
				btnTheme: 'e',
				btnLabel: 'Delete',
				btnClass: 'aSwipeButton',
				click: function(e){
					e.preventDefault();
					var url = $(e.target).attr('href');
					$(this).parents('li').slideUp();
					$.get(url, function(data) {
						
					});
				}
			});

			$('#triggerMe').on('click', function(){
				$('#swipeMe li:nth-child(1)').trigger('swiperight')
			});

		});
	</script>

</head>  
<body>

<?php
 include("config.php"); 

 $username = $_GET['username']; 
 $profileUsername = $_GET['profileUsername'];
  
 $query = "select * from Users where username = '$profileUsername'";
 $result = mysql_query($query);
 
 while($row = mysql_fetch_array($result, MYSQL_BOTH)) {
	$userPhoto = $row['picture']; 
 }

 ?> 

<!-- /Home Screen/NewsFeed -->
<div data-role="page" id="home">

	<div data-role="header">
		<h1><?=$profileUsername?></h1>
	</div><!-- /header -->
		<img src = "<?=$userPhoto?>" alt = "test" vspace="20" hspace="20" align="middle"/>
		<?php
		if ($profileUsername == $_GET['username']) {
			?>
			<a href="changePicture.php?username=<?=$profileUsername?>" data-theme="b" data-role="button" data-ajax="false">Click here to change your profile picture</a>	
			<?php	
		}
		?>
		
	<div data-role="content">	

			<h2><?=$profileUsername?>'s Spots</h2>	
			
			<div data-role="content">
			<?php
			if ($_GET['username'] != $profileUsername) {
			?>
   				<ul class = "LV" data-role="listview" data-divider-theme="d" data-filter="true">
			<?php
			} else {
			?>
				<ul id="swipeMe" data-role="listview">
			<?php	
			}
			$query = "select * from Spots where username = '$profileUsername'";
 			$result = mysql_query($query);
			if (mysql_num_rows($result) != 0) {
	 			while($row = mysql_fetch_array($result, MYSQL_BOTH)) {
	 				if ($_GET['username'] != $profileUsername) {
	 			?>
	 					<li>
	 						<a href="spot.php?url=<?=$row['url']?>&username=<?=$username?>" data-transition="slide" method="get">
	 						<img src = "<?=$row['url']?>" alt = "test"/>
	   						<h3><?=$row["description"]?></h3>
	   						</a>
	   					</li>
	   					<span class="ui-icon ui-icon-arrow-r ui-icon-shadow"></span>
	 			<?php
	 				} else {
	 				?>
						<li data-swipeurl="swiped.php?url=<?=$row['url']?>&username=<?=$username?>" method="get">
							<a href="spot.php?url=<?=$row['url']?>&username=<?=$username?>" data-transition="slide" method="get">
							<img src = "<?=$row['url']?>" alt = "test"/>
	   						<h3><?=$row["description"]?></h3>
							</a>
						</li>
	 				<?php	
	 				}
	 			}
			} else {
				?>
				<li><h3>No spots have been posted.</h3></li>
				<?php	
			}
			?>
			
			<li data-role="list-divider" ><h2><?=$profileUsername?>'s Favorite Spots</h2></li>	
			
			<?php
			$query = "select * from Favorites where username = '$profileUsername'";
 			$result = mysql_query($query);
			if (mysql_num_rows($result) != 0) {
 				while($row = mysql_fetch_array($result, MYSQL_BOTH)) {
 					$picture = $row['url'];
 					$query2 = "select * from Spots where url = '$picture'";
 					$result2 = mysql_query($query2);
 					while($row2 = mysql_fetch_array($result2, MYSQL_BOTH)) {
 						if ($_GET['username'] != $profileUsername) {
	 			?>
		 					<li>
		 						<a href="spot.php?url=<?=$row2['url']?>&username=<?=$username?>" data-transition="slide" method="get">
		 						<img src = "<?=$row2['url']?>" alt = "test"/>
		   						<h3><?=$row2["description"]?></h3>
		   						</a>
		   					</li>
		   					<span class="ui-icon ui-icon-arrow-r ui-icon-shadow"></span>
		 			<?php
 						} else {
 						?>
	 						<li data-swipeurl="swipedFavs.php?url=<?=$row['url']?>&username=<?=$username?>" method="get">
								<a href="spot.php?url=<?=$row['url']?>&username=<?=$username?>" data-transition="slide" method="get">
								<img src = "<?=$row['url']?>" alt = "test"/>
		   						<h3><?=$row2["description"]?></h3>
								</a>
							</li>
 						<?php	
 						}	
 					}
 				}
			} else {
				?>
				<li><h3>No spots have been added to Favorites.</h3></li>
				<?php	
			}
			?>
			<a href="#" data-role="button" id="triggerMe">trigger swipe right</a>
				</ul>
			</div>
		
		</div><!-- /content -->

	<div data-role="footer" data-id="samebar" class="nav-glyphish-example" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" class="nav-glyphish-example" data-grid="a">
		<ul>
			<li><a href="home.php?username=<?=$username?>" id="homepage" data-icon="custom" method="get">Home</a></li>
			<li><a href="share.php?username=<?=$username?>" id="share" data-icon="custom" method="get" data-ajax="false">Share</a></li>
		</ul>
		</div>
	</div>

</div>

</div>
<!--Home Screen/News Feed End-->
</body>
</html>