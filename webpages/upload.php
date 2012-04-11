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
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
  <script src="js/libs/modernizr-2.5.3.min.js"></script>
  <style type="text/css">@import "datepick/smoothness.datepick.css";</style> 
<script src="datepick/jquery.datepick.js"></script>
<script>

	$(function() {
	$('#popupDatepicker').datepick({showOnFocus: false, showTrigger: '#calImg'});
});
	$(function() {
	$('#endDate').datepick({showOnFocus: false, showTrigger: '#calImg'});
});

</script>
</head>
<body>

	<?php $current = 6; include('inc/menu.php'); ?>
	<div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Upload Dataset</h1>
		<p>Unfortunately, this functionality has not been implemented yet. This is just a template </p>
		<br />
		<div class="row">
			<div class="span8">
				<form class="well form-horizontal" action="#">
					<fieldset>
						<div class="control-group" id="name-group">
							<label class="control-label" for="name">Name of Dataset:</label>
							<div class="controls" id="for-name">
								<input type="text" class="input-xlarge" id="name">
							</div>
						</div>
						<div class="control-group" id="file-group">
							<label class="control-label" for="file">Please Select File:</label>
							<div class="controls" id="for-file">
								<input id="file" class="input-file" type="file">
							</div>
						</div>
						<div class="control-group" id="type-group">
							<label class="control-label" for="type">Type:</label>
							<div class="controls" id="for-type">
								<select id="type">
									<option>Census</option>
									<option>Climate</option>
									<option>Disease</option>
								</select>
							</div>
						</div>
						<div class="control-group" id="beginDate-group">
							<label class="control-label" for="beginDate">Begin Date:</label>
							<div class="controls" id="for-beginDate">
								<input type="text" id="popupDatepicker"><div style="display: none;"> 
									<img id="calImg" src="datepick/calendar.gif" alt="Popup" class="trigger"> 
								</div>
							</div>
						</div>
						<div class="control-group" id="endDate-group">
							<label class="control-label" for="endDate">End Date:</label>
							<div class="controls" id="for-endDate">
								<input type="text" id="endDate"><div style="display: none;"> 
									<img id="calImg" src="datepick/calendar.gif" alt="Popup" class="trigger"> 
								</div>
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
				<p style="color: red" align="center" id="success">Note: Once submitted, your dataset will be sent to a group of moderators who will approve/deny the dataset into the collection.</p>
			</div>
		</div>
			
      </div>



  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>
  <?php include('inc/footer.php'); ?>

</body>
</html>