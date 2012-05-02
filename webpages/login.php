<?php 
	include('inc/header.php');
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
		
        var email=$("#email").val();
        var password=$("#password").val();
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
		if(password == "" || password == null)
		{
			$("#password-group").addClass("error");
			$("#for-password").append("<span class=\"help-inline\">Cannot be blank.</span>");
			return false;
		}
		else
		{
			$("#password-group").removeClass("error");
			$("#for-password span").remove();
			
		}
        $.ajax({
            type: "POST",
            /*url: "/webtest/cs1630History/webpages/scripts/validate.php",*/
			url: "scripts/validate.php",
            data: "email="+email+"&pwd="+password,
            success: function(html){
                if(html=='true')
                {
                    window.location = "index.php";
                }
                else
                {
			alert(html);
					$("#email-group").addClass("error");
					$("#password-group").addClass("error");
					if( $(".help-inline").length == 0 )
					{
						$(".form-actions").addClass("error");
						$(".form-actions").append("<span class=\"help-inline\"> Incorrect email/password.</span>");
					}
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
        <h1>Log In</h1>
		<br />
		<div class="row">
			<div class="span8">
				<form class="well form-horizontal" onsubmit="return validate()" action="index.php">
					<fieldset>
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