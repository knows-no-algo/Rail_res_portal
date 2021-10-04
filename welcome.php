<?php 
   include('functions.php');
   if(!isLoggedIn()){
      $_SESSION['msg'] = "You must log in first";
      header('location: login.php');
      
   }
   if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<style type="text/css">
   body { background-image: url('https://images.unsplash.com/photo-1535535112387-56ffe8db21ff?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&w=1000&q=80') !important; } /* Adding !important forces the browser to overwrite the default style applied by Bootstrap */
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand"><?php echo $_SESSION['user']['name'];?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="welcome.php"> Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="check_availability.php">Book Tickets</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link " href="show_past_bookings.php">Show Past Bookings</a>
	  </li>
	  <li class="nav-item active">
	  <a class="nav-link" href="welcome.php?logout='1'" style="color: red;">logout</a>
      </li>
    </ul>
  </div>
</nav>
<body>	
	<div class="header">
		<h2>Home Page</h2>
	</div>
	<div class="content">
		<!-- notification message -->
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php 
						echo $_SESSION['success']; 
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>
		<!-- logged in user information -->
		<div class="profile_info">

			<div>
				<?php  if (isset($_SESSION['user'])) : ?>
					<strong><?php echo $_SESSION['user']['username']; ?></strong>

					<small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
						<br>
						<a href="welcome.php?logout='1'" style="color: red;">logout</a>
					</small>

				<?php endif ?>
			</div>
		</div>
		<div align="CENTER" >
			<div>
			<h2 style="font-style: italic;"><br><a href="check_availability.php">Book a New Ticket</a><br>
			<br><a href="show_past_bookings.php">Show all Past Bookings</a><br>
			<br><a href="./update-prof.php">Update My Profile</a><br>
			</h2>
			</div>
		</div>	
	</div>
<div class="header">
	<h2>See Running Trains on a Particular Date</h2>
</div>
<form method="post" action="welcome.php">
    <?php echo display_error2(); ?>
    <div class="input-group">
		<label>Date of Journey</label>
		<input type="date" name="date" value="" required>
	</div>
	<div class="input-group">
		<button type="submit" class="btn" name="see_train_by_date_btn">Check</button>
	</div>
</form>
			
<div class="header">
	<h2>Enter PNR</h2>
</div>
<form method="post" action="welcome.php">
    <?php echo display_error1(); ?>
    <div class="input-group">
		<label>PNR</label>
		<input type="text" name="pnr" value="" required>
	</div>
	<div class="input-group">
		<button type="submit" class="btn" name="see_pnr_btn">See</button>
	</div>
</form>
<div class="header">
	<h2>See Details for a Train</h2>
</div>
<form method="post" action="welcome.php">
    <?php echo display_error(); ?>
    <div class="input-group">
		<label>Train Number</label>
		<input type="text" name="train_number" value="" required>
	</div>
	<div class="input-group">
		<button type="submit" class="btn" name="see_train_btn">Check</button>
	</div>
</form>
					
</body>
</html>