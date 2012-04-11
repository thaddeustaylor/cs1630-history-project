<?php
$active[$current] = "class=\"active\"";
?>

	<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">


        
          <div class="nav-collapse">
            <ul class="nav">
				<li <?php echo $active[0]; ?>><a href="index.php">Home</a></li>
			<?php
			if(isSet($logged_in) && $logged_in != false)
			{
				?>
				<li <?php echo $active[6]; ?>><a href="upload.php">Upload Dataset</a></li>
				<li <?php echo $active[7]; ?>><a href="approve.php">Approve Dataset</a></li>
				<li <?php echo $active[8]; ?>><a href="viewDataset.php">View/Download Dataset</a></li>
				<li <?php echo $active[9]; ?>><a href="search.php">Search/Visualize Datasets</a></li>
				<li <?php echo $active[10]; ?>><a href="logout.php">Logout</a></li>
				<?php
			}
			else 
			{
				?> 	
				<li <?php echo $active[1]; ?>><a href="login.php">Log In</a></li>
				<li <?php echo $active[2]; ?>><a href="register.php">Register</a></li>
				<li <?php echo $active[3]; ?>><a href="forgotPassword.php">Forgot Password?</a></li>
				<li <?php echo $active[4]; ?>><a href="about.php">About</a></li>
				<li <?php echo $active[5]; ?>><a href="contact.php">Contact Us</a></li>
				<?php
			}
			  ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
