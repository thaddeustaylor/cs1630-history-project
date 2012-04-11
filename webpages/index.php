<?php include('inc/header.php'); ?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>History Project</title>
  <meta name="description" content="">

  <meta name="viewport" content="width=device-width">

  <link rel="stylesheet" href="css/bootstrap.css">
      <link rel="stylesheet" href="css/style.css">

  <script src="js/boostrap.js"></script>
  <script src="js/libs/modernizr-2.5.3.min.js"></script>
</head>
<body>

	<?php include('inc/menu.php'); ?>
	<div class="container">
	<?php 
	if(isSet($logged_in) && $logged_in != false)
	{
	?>
		<div class="hero-unit">
			<h1>Welcome <?php echo $_SESSION['email']; ?></h1>
			<br />
			<p>Above, you will find options to upload, search, and visualize datasets.</p>
		</div>
		<div class="row">
			<div class="span12">
				<p align="center"><img src="img/pittSeal.jpg" /></p>
			</div>
		</div>
		<br />
	<?php
		}
	else
	{
	?>
		
      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>History Project</h1>
        <p>The World-historical Data project addresses the need for comprehensive historical data on the human experience at the global level. </p>
        <p><a class="btn btn-primary btn-large" href="register.php">Register</a></p>

      </div>

      <!-- Example row of columns -->
      <div class="row">
	    <div class="span8">
			<p align="center"><img src="img/home-graph.jpg" /></p>
        </div>
        <div class="span4">
          <h2>Herodotus</h2>
           <p>The Herodotus Data Repository and Analysis System project aims to generate a simple, straightforward way for researchers to submit data, query data, and perform data analysis across multiple dimensions of information. </p>
          <p><a class="btn" href="about.php">View details &raquo;</a></p>

        </div>

      </div>
	<?php
	}
	?>


 
 
 

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>

  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>
  <?php include('inc/footer.php'); ?>

</body>
</html>