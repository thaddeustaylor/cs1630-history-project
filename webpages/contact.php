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
		var name =$("#name").val();
        var email=$("#email").val();
        var comment=$("#comment").val();
		if(name == "" || name == null) 
		{
			$("#name-group").addClass("error");
			$("#for-name").append("<span class=\"help-inline\">Cannot be blank.</span>");
			return false;
		}
		else
		{
			$("#name-group").removeClass("error");
			$("#for-name span").remove();
		}
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
		if(comment == "" || comment == null)
		{
			$("#comment-group").addClass("error");
			$("#for-comment").append("<span class=\"help-inline\">Cannot be blank.</span>");
			return false;
		}
		else
		{
			$("#comment-group").removeClass("error");
			$("#for-comment span").remove();
			
		}
        $.ajax({
            type: "POST",
            url: "/webtest/cs1630History/webpages/scripts/sendcontact.php",
            data: "name="+name+"?email="+email+"&comment="+comment,
            success: function(html){
                if(html=='true')
                {
					$("#name-group").removeClass("error");
					$("#email-group").removeClass("error");
					$("#comment-group").removeClass("error");
					$("#success").text("An email has been sent to support. Thank you.");
                    return true;
                }
                else
                {

                    $("#success").css('color', 'red');
					$("#success").text("I'm sorry. There seems to be a problem with our submission process. Please use the email address listed above for any support related questions/comments. Sorry for the inconvience.");
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
        <h1>Contact Us</h1>
		<br />
		<p>You can email support at <a href="mailto:support@historyproject.org">support@historyproject.org</a>, or you can fill out the form below. We will contact you as soon as we are able to. Thank you.</p>
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
						<div class="control-group" id="comment-group">
							<label class="control-label" for="comment">Questions/Comments</label>
							<div class="controls" id="for-comment">
								<textarea id="comment" class="input-xlarge" rows="3"></textarea>
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