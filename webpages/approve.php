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

</script>

  
  
  
</head>
<body>

	<?php $current = 7; include('inc/menu.php'); ?>
	<div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Approve Dataset</h1>
		<h2 style="color: red">For proof of concept purpose only.</h2>
		<br />
		<div class="row">
			<div class="span8">
				<?php
					if($role != 1)
					{
					?>
						<p>I'm sorry. You do not have approval rights. If you feel this is an error, please contact the administrator for further assistance</p>
					<?php
					}
					else
					{
					?>
					<p>Below is a list of datasets. Please select the dataset you would like to approve/disapprove. Only one dataset at a time and please include a comment.</p>
							<form class="well form-horizontal" onsubmit="return validate()" action="#">
								<fieldset>
									<table class="table">
										<thead>
											<th>Select</th>
											<th>Dataset Name</th>
											<th>Uploader</th>
											<th>Comments</th>
											<th>Download</th>
										</thead>
										<tr>
											<td><input id="selectData" type="checkbox" value="1"></td>
											<td>San Franciso Census</td>
											<td><a href="#">Thaddeus</a></td>
											<td>Multiple columns missing data</td>
											<td><button class="btn btn-inverse" href="#">Download</button></td>
										</tr>
										<tr>
											<td><input id="selectData" type="checkbox" value="2"></td>
											<td>Measles Data from China 1910</td>
											<td><a href="#">Rob F.</a></td>
											<td>None</td>
											<td><button class="btn btn-inverse" href="#">Download</button></td>
										</tr>
										<tr>
											<td><input id="selectData" type="checkbox" value="3"></td>
											<td>Temperature Georgia 1940's - 1950's</td>
											<td><a href="#">Evan M.</a></td>
											<td>Split over four different tables with excess of 100 columns per table</td>
											<td><button class="btn btn-inverse" href="#">Download</button></td>
										</tr>
									</table>
											
									<div class="control-group" id="comment-group">
										<label class="control-label" for="comment">Comments for selected dataset:</label>
										<div class="controls" id="for-comment">
											<textarea id="comment" class="input-xlarge" rows="3"></textarea>
										</div>
									</div>
									<div class="form-actions">
										<button class="btn btn-success" type="submit" style="width: 150px" id="submit">Approve</button> <button class="btn btn-danger" type="submit" style="width: 150px" id="submit">Disapprove</button>
									</div>
								</fieldset>
							</form>
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