<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <meta name="description" content="Results page">
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
      body {
        text-align: center;
      }
      figure {
        display: inline-block;  
      }
      .result {
      display: inline-block;
      /*display: block;*/ /*if you want to have one beneath the other*/
      padding: 5px;
      overflow: hidden;
      margin-left:auto;
      margin-right:auto;
      max-height:400px;
      }
    </style>

	<!-- JavaScript -->
	<script src="js/jquery.min.js"></script>
	<title>Results</title>

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
        <li><a href="index.php">GalaxyNet</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
    	<li><a href="gallery.html">Gallery</a></li>
    </ul>
	</div>
</nav>

	<div class="page-header">
		<h1 text-align="center"><br/>Results</h1>
	</div>
<?php
  echo "<figure><img class='result' src='uploads/" .$_GET["img"]."'/><figcaption>Original Image</figcaption></figure>";
  echo "<figure><img class='result' src='uploads/drshift_" .$_GET["img"]."'/><figcaption>DRS Image</figcaption></figure>";
?>
  <button type="button" class="btn btn-primary center-block" id="btn" onclick="window.open('index.php','_self',false);">Try another Image</button>
    <footer class="footer">
      <div class="container">
        <p class="text-muted"><a href = "about.html">About </a> | <a href = "mailto: sgokula@ethz.ch"> Contact </a></p> 
      </div>
    </footer>

</body>
</html>
