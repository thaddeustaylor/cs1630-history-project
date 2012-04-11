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
  
<script type="text/javascript">
//Include registration validation....//
</script>

  
  
  
</head>
<body>

	<?php include('inc/menu.php'); ?>
	<div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Register</h1>
		<p> Please enter your information in order to register for the site. You will receive a confirmation email
		with further instructions on how to access the site. Thank you.</p>
		<p style="color: red">Currently, the registration process has not been implemented. This is just to show
		its intention of being added to the site. We are sorry about the inconvienence."</p>
		<p>Additional fields will be added in order to handle the registration process.</p>
		<br />
		
		<div class="row">
			<div class="span8">
				<form class="well form-horizontal" onsubmit="return validate()" action="#">
					<fieldset>
						<div class="control-group" id="name-group">
							<label class="control-label" for="name">Name:</label>
							<div class="controls" id="for-name">
								<input type="text" class="input-xlarge" id="name">
							</div>
						</div>
						<div class="control-group" id="email-group">
							<label class="control-label" for="email">Email:</label>
							<div class="controls" id="for-email">
								<input type="text" class="input-xlarge" id="email">
								
							</div>
						</div>
						<div class="control-group" id="password-group">
							<label class="control-label" for="password">Password:</label>
							<div class="controls" id="for-password">
								<input type="password" class="input-xlarge" id="password">
							</div>
						</div>
						<div class="control-group" id="repassword-group">
							<label class="control-label" for="repassword">Re-Type Password:</label>
							<div class="controls" id="for-repassword">
								<input type="repassword" class="input-xlarge" id="repassword">
							</div>
						</div>
						<div class="control-group" id="university-group">
							<label class="control-label" for="university">University:</label>
							<div class="controls" id="for-university">
								<input type="university" class="input-xlarge" id="university">
							</div>
						</div>
						<div class="form-actions">
							<button class="btn btn-primary" type="submit" style="width: 150px" id="submit">Submit</button>
						</div>
					</fieldset>
				</form>
			
			</div>
		</div>
      </div>

 
 
 

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>

  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>
  <?php include('inc/footer.php'); ?>

</body>
</html>