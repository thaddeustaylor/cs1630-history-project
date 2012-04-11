<?php 
	include('inc/header.php');
	$needMYSQLI = true;
	include('inc/creds.php');
	//if(isSet($_GET['email']))
	//{
		//$email = $_GET['email'];
		$email = "acl37@pitt.edu";
		$mysqli = mysqli_connect($dbserver, $dbusername, $dbpassword, $dbname);
		$query = "SELECT question FROM user_login WHERE email LIKE ?";
		$result = $mysqli->prepare($query);
		$result->bind_param('s', $email);
		$result->execute();
		$result->bind_result($question);
		$result->fetch();
	//}

?>
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
function validate()
{
		
        var answer=$("#answer").val();
		var newPassword=$("#newPassword").val();
		var email=$("#email").val();
		
		var valid = true;
		
		if(answer == "" || answer == null) 
		{
			$("#answer-group").addClass("error");
			$("#for-answer").append("<span class=\"help-inline\">Cannot be blank.</span>");
			valid = false;
		}
		else
		{
			$("#answer-group").removeClass("error");
			$("#for-answer span").remove();
		}
		if(newPassword == "" || newPassword == null) 
		{
			$("#newPassword-group").addClass("error");
			$("#for-newPassword").append("<span class=\"help-inline\">Cannot be blank.</span>");
			valid = false;
		}
		else
		{
			$("#newPassword-group").removeClass("error");
			$("#for-newPassword span").remove();
		}
		
		if(valid == true)
		{
			$.ajax({
				type: "POST",
				url: "/webtest/cs1630History/webpages/scripts/sendEmailForgot.php",
				data: "function=reset?email="+email+"?password="+newPassword,
				success: function(html){
					if(html=='true')
					{
						$("#answer-group").removeClass("error");
						$("#newPassword-group").removeClass("error");
						$(".form-actions").removeClass("error");
						$("#success").css('color', 'green');
						$("#success").text("An email has been sent to your address with instructions on how to reset your password. Thank you.");
						$("#submit").attr("disabled", "disabled");
						return true;
					}
					else
					{
						$("#answer-group").addClass("error");
						$("#newPassword-group").addClass("error");
						$(".form-actions").addClass("error");
						$("#success").css('color', 'red');
						$("#success").text("I'm sorry there was an error with retrieving your information. Please contact the administrator for further help.");
						return false;
					}
				}
			});
			return false;
		}
}
</script>

  
  
  
</head>
<body>

	<?php //include('inc/menu.php'); ?>
	<div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Reset Password</h1>
		<p>Please answer your security question below.</p>
		<br />
		<div class="row">
			<div class="span8">
				<?php if($question != null)
				{
				?>
					<form class="well form-horizontal" onsubmit="return validate()" action="forgotPassword.php">
						<fieldset>
							<p><?php echo $question; ?></p>
							<div class="control-group" id="answer-group">
								<label class="control-label" for="answer">Answer:</label>
								<div class="controls" id="for-answer">
									<input type="text" class="input-xlarge" id="answer">
								</div>
							</div>
							<div class="control-group" id="newPassword-group">
								<label class="control-label" for="newPassword">New Password:</label>
								<div class="controls" id="for-newPassword">
									<input type="password" class="input-xlarge" id="newPassword">
								</div>
							</div>
							<div class="form-actions">
								<button class="btn btn-primary" type="submit" style="width: 150px" id="submit">Submit</button>
							</div>
						</fieldset>
					</form>
					<input type="hidden" id="email" value="<?php echo $email ?>" />
				<?php 
				}
				else
				{
				?>
					<p>I'm sorry there was an error with retrieving your information. Please contact the administrator for further help.</p>
				<?php
				}
				?>
			</div>
		</div>
		<div class="row">
			<div class="span8">
				<p style="color: green" align="center" id="success"></p>
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