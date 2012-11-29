<!DOCTYPE html> 
<html>

<head>
	<title>Where the Wild Things Are | Login</title> 
	<meta charset="utf-8">
	<meta name="apple-mobile-web-app-capable" content="yes">
 	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 

	<link rel="stylesheet" href="jquery.mobile-1.2.0.css" />
	<link rel="stylesheet" href="css/main.css" />
	<link rel="stylesheet" href="style.css" />
	<link rel="apple-touch-icon" href="icon2.png" />
	<link rel="apple-touch-startup-image" href="startup.png"/>
	
	<script src="jquery-1.8.2.min.js"></script>
	<script src="jquery.mobile-1.2.0.js"></script>
	<script src="js/script.js"></script>
	
	<script type="text/javascript"src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en">
	<script type="text/javascript" src="/admin/gmap3.min.js"></script>
	 <script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
    <script type="text/javascript" src="gmap3.js"></script> 



</head>  
<style>

	#ctrl{
        width: 500px;
        margin:0 auto;
      }
      .gmap3{
        margin: 20px auto;
        border: 1px dashed #C0C0C0;
        width: 250px;
        height: 250px;
      }
    
</style>

 <script type="text/javascript">
      $(function(){
      
        $('#test1').gmap3({
          getgeoloc:{
            callback : function(latLng){
              if (latLng){
                $('#test1-result').html('localised !');
                $(this).gmap3({
                  marker:{ 
                    latLng:latLng
                  }, 
                  map:{
            		options:{
             		 zoom: 18
            	}
          		}
                });
              } else {
                $('#test1-result').html('not localised !');
              }
            }
          }
        });
        
        $('#test-ok').click(function(){
          var addr = $('#test-address').val();
          if ( !addr || !addr.length ) return;
          $("#test").gmap3({
            getlatlng:{
              address:  addr,
              callback: function(results){
                if ( !results ) return;
                $(this).gmap3({
                  marker:{
                    latLng:results[0].geometry.location,
                    map:{
                      center: true
                    }
                  }
                });
              }
            }
          });
        });
        
        $('#test-address').keypress(function(e){
          if (e.keyCode == 13){
            $('#test-ok').click();
          }
        });
      });

    </script>

<body> 


<!-- /Home Screen/NewsFeed -->
<div data-role="page" id="home">

	<div data-role="header">
		<h1>Share A Spot</h1>
	</div><!-- /header -->
		
	 <div class="container">
		<div class="upload_form_cont">
                <form id="upload_form" enctype="multipart/form-data" method="post" action="upload.php">
                    <div>
                        <div><label for="image_file">Please select image file</label></div>
                        <div><input type="file" name="image_file" id="image_file" onchange="fileSelected();"/></div>
                        
                    </div>
                    <div>
                        <input type="button" value="Upload" onclick="startUploading()"/>
                    </div>
                    <div id="fileinfo">
                        <div id="filename"></div>
                        <div id="filesize"></div>
                        <div id="filetype"></div>
                        <div id="filedim"></div>
                    </div>
                    <div id="error">You should select valid image files only!</div>
                    <div id="error2">An error occurred while uploading the file</div>
                    <div id="abort">The upload has been canceled by the user or the browser dropped the connection</div>
                    <div id="warnsize">Your file is very big. We can't accept it. Please select more small file</div>

                    <div id="progress_info">
                        <div id="progress"></div>
                        <div id="progress_percent"></div>
                        <div class="clear_both"></div>
                        <div>
                            <div id="speed"></div>
                            <div id="remaining"></div>
                            <div id="b_transfered"></div>
                            <div class="clear_both"></div>
                        </div>
                        <div id="upload_response"></div>
                    </div>
                </form>
                <img id="preview"/>
            </div>
		</div>

	<form action = "temp.php" method = "post">
		<div style="padding-left:10px;padding-right:10px;">
		<h2>
		Name the Spot  <input type="text" name ="newName" class="ui-input-text ui-body-c ui-corner-all ui-shadow-inset ui-focus">
		</h2>
		<h2>
		What's the Spot? <input type="text" name ="newDescription" class="ui-input-text ui-body-c ui-corner-all ui-shadow-inset ui-focus">
		</h2>
		<input type="hidden" name="username" value="<?=$_GET['username']?>"/>
		</div>
		<h2>
		Where's the Spot? 
		</h2>
		<div style="padding-left:10px;padding-right:10px;">
		<p>Enter your location below or tap it on the map.</p>
		
		
		 <div>
		 <input type="text" id="test-address" size="60"> 
		 <button type="button" id="test-ok">Locate</button></div>  


		</div>
		
	<!-- This is where the map gets inserted -->
		<div id="test1" class="gmap3"></div>
		
		<input type = "submit" data-direction = "reverse" data-role = "button" data-theme = "c" value = "Share">
	</form>

	<div data-role="footer" data-id="samebar" class="nav-glyphish-example" data-position="fixed" data-tap-toggle="false">
		<div data-role="navbar" class="nav-glyphish-example" data-grid="a">
			<ul>
				<li><a href="home.php?username=<?=$_GET['username']?>" id="homepage" data-icon="custom" method = "get">Home</a></li>
				<li><a href="share.php?username=<?=$username?>" id="share" data-icon="custom" method="get" data-ajax="false">Share</a></li>	

			</ul>
		</div>
	</div>
	
</div>	

</body>
</html>
