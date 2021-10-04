<?php

include('functions.php');

if(!isUSer()){
    $_SESSION['msg'] ="You must log in first";
    header('location: login.php');
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Book ticket</title>
    <link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<style type="text/css">
   body { background-image: url('https://images.unsplash.com/photo-1535535112387-56ffe8db21ff?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&w=1000&q=80') !important; } /* Adding !important forces the browser to overwrite the default style applied by Bootstrap */
</style>
<body>
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
        <a class="nav-link" href="update-prof.php">Update Profile</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="check_availability.php">Book Tickets</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link " href="show_past_bookings.php">Show Past Bookings</a>
	  </li>
	  <li class="nav-item active">
	  <a class="nav-link" href="index.php?logout='1'" style="color: red;">logout</a>
      </li>
    </ul>
  </div>
</nav>
<div class="header">
	<h2>Book Ticket</h2>
</div>
<form method="post" action="check_availability.php">
	<?php echo display_error(); ?>
	<?php echo display_success(); ?>
    <div class="input-group">
		<label>Train Number</label>
		<input type="number" name="train_number" value="" required>
	</div>
    <div class="input-group">
		<label>Date of Journey</label>
		<input type="date" name="doj" value="" required>
	</div>
    <div class="input-group">
		<label>Number Of Passengers</label>
		<input type="number" name="no_of_pass" value="" required>
	</div>
	<div class="input-group">
		<label>Choose Class</label>
		<select name="class" id="user_type">
            <option value="Sleeper">Sleeper</option>
            <option value="AC">AC</option>

        </select>
	</div>
	<div class="input-group">
		<button type="submit" class="btn" name="check_availability_btn">Check Availability</button>
	</div>
	<p>
		<a href="welcome.php">Back to Home page</a>
	</p>
	<p>
		<a href="admin/show_scheduled_trains.php">Show All Released Trains</a>
	</p>
</form>
</body>
</html>