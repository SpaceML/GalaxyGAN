<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <meta name="description" content="Project page for the deredshift project">
    <meta name="author" content="gokul">
    <link rel="icon" href="favicon.ico">

    <!-- CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/dropzone.css" type="text/css" rel="stylesheet"/>
    <link href="css/sticky-footer-navbar.css" rel="stylesheet">
    <link href="css/html5demos.css" rel="stylesheet">
    <style>
    	.navbar .navbar-left {
   			margin-left: 30px;
		}

    	.navbar .navbar-right {
   			margin-right: 30px;
		}
		.dropzone .dz-preview .dz-image {
      		width: 250px;
      		height: 250px;
    	}
    	#myDropzone {
    		height: 300px; 
    		width: 700px; 
    		max-height: 80%;
    		max-width: 80%;
    		border: 10px dashed #ccc; 
    		margin: 0px auto; 
    		object-fit: contain; 
    		text-align: center;
    		overflow: hidden;
    	}

    </style>

	<!-- JavaScript -->
	<script src="js/dropzone.js"></script>
	<script src="js/jquery.min.js"></script>
	<title>GalaxyNet</title>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  	<div class="navbar-header">
    	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
      		<span class="icon-bar"></span>
      		<span class="icon-bar"></span>
      		<span class="icon-bar"></span>
    	</button>

  	</div>
	<div class="navbar-collapse collapse">
    <ul class="nav navbar-nav navbar-left">
        <li><a href="#">GalaxyNet</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
    	<li><a href="gallery.html">Gallery</a></li>
    </ul>
	</div>
</nav>

	<div class="page-header">
		<h1 text-align="center"><br/>Drag and Drop Images below to deredshift them!</h1>
	</div>
	<div id="preview-template" style="display: none; text-align: center; padding: 10px;">
		<div class="dz-preview dz-file-preview">
		<div class="dz-details">
		<img data-dz-thumbnail style="height: 256px; width: 256px; padding: 20px" />
		</div>
		<div class="dz-progress"></div>
		<div class="dz-success-mark"></div>
		<div class="dz-error-mark"></div>
		<div class="dz-error-message"><span data-dz-errormessage></span></div>
		</div>
	</div>
	<script type="text/javascript">
		Dropzone.autoDiscover = false;
		$(document).ready(function(){
		    var myDropzone = new Dropzone("#myDropzone",{
		    url: "upload.php",
		    autoProcessQueue: false,
		    maxFiles: 1,
		    maxFilesize: 20,
		    thumbnailWidth: 256,
    		previewTemplate: document.getElementById('preview-template').innerHTML,
		    init: function() {
				this.on("success", function(file, responseText) {
      			alert('Deredshift complete!');
      			window.open ('results.php?img='+responseText,'_self',false);
            // alert(responseText);
    			});
				
				this.on("maxfilesexceeded", function(file){
					this.removeAllFiles();
					this.addFile(file);
       			});
  				
  				this.on("drop", function(event){
  					console.log(typeof event);
  				});
  				}
	  		});
	  		$('#btn').on('click',function(e){
	    		e.preventDefault();
	    		myDropzone.processQueue();  
	  		});
	 	}); 	
	</script>
<div id = "myDropzone"></div>
<br/>
<button type="button" class="btn btn-primary center-block" id="btn">Deredshift</button>
    <footer class="footer">
      <div class="container">
        <p class="text-muted"><a href = "about.html">About </a> | <a href = "mailto: sgokula@ethz.ch"> Contact </a></p>
      </div>
    </footer>

</body>
</html>
