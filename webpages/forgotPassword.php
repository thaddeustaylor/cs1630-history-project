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
function validate()
{
		
        var email=$("#email").val();
		if(email == "" || email == null) 
		{
			$("#email-group").addClass("error");
			$("#for-email").append("<span class=\"help-inline\">Cannot be blank.</span>");
			return false;
		}
		else
		{
			$("#email-group").removeClass("error");
			$("#for-email span").remove();
		}
        $.ajax({
            type: "POST",
            url: "/scripts/sendEmailForgot.php",
            data: "function=email?email="+email,
            success: function(html){
                if(html=='true')
                {
					$("#email-group").removeClass("error");
					$(".form-actions").removeClass("error");
					$("#success").css('color', 'green');
                    $("#success").text("An email has been sent to your address with instructions on how to reset your password. Thank you.");
					$("#submit").attr("disabled", "disabled");
                    return true;
                }
                else
                {
					$("#email-group").addClass("error");
					$(".form-actions").addClass("error");
					$("#success").css('color', 'red');
					$("#success").text("I'm sorry. We do not have records of your email in our databases. Please re-type your email or <a href=\"mailto:admin@history.org\">contact</a> our administrator if you feel as though this is as error. We are sorry for the incovienence.");
					return false;
                }
            }
        });
        return false;
}
</script>

  
  
  
</head>
<body>

	<?php include('inc/menu.php'); ?>
	<div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Forgot Password</h1>
		<p>Please enter your email address. Instructions on how to reset your password will be sent to you via email Thank you.</p>
		<br />
		<div class="row">
			<div class="span8">
				<form class="well form-horizontal" onsubmit="return validate()" action="forgotPassword.php">
					<fieldset>
						<div class="control-group" id="email-group">
							<label class="control-label" for="email">Email:</label>
							<div class="controls" id="for-email">
								<input type="text" class="input-xlarge" id="email">
								
							</div>
						</div>
						<div class="form-actions">
							<button class="btn btn-primary" type="submit" style="width: 150px" id="submit">Submit</button>
						</div>
					</fieldset>
				</form>
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