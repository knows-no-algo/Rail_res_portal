<?php
    include('functions.php')
?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration system PHP and MySQL</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<style type="text/css">
   body { background-image: url('https://images.unsplash.com/photo-1535535112387-56ffe8db21ff?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&w=1000&q=80') !important; } /* Adding !important forces the browser to overwrite the default style applied by Bootstrap */
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.php"> Main Page<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="register.php">Register</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link " href="login.php">Login</a>
	  </li>
	  <li class="nav-item active">
        <a class="nav-link " href="admin/show_scheduled_trains.php">Scheduled Trains List</a>
      </li>
    </ul>
  </div>
</nav>
<body>
<div class="header">
	<h2>Register</h2>
</div>
<form method="post" action="register.php">
    <?php echo display_error(); ?>
    <div class="input-group">
		<label>Name</label>
		<input type="text" name="name" required value="<?php echo $name;?>">
	</div>
    <div class="input-group">
		<label>CreditCard</label>
		<input type="number" name="creditcard" required value="<?php echo $creditcard; ?>">
	</div>
    <div class="input-group">
		<label>Address</label>
		<input type="text" name="address" required value="<?php echo $address; ?>">
	</div>
	<div class="input-group">
		<label>Username</label>
		<input type="text" name="username" required value="<?php echo $username; ?>">
	</div>
	<div class="input-group">
		<label>Email</label>
		<input type="email" name="email" required value="<?php echo $email; ?>">
	</div>
	<div class="input-group">
		<label>Password</label>
		<input type="password" required name="password_1">
	</div>
	<div class="input-group">
		<label>Confirm password</label>
		<input type="password" required name="password_2">
	</div>
	<div class="input-group">
		<button type="submit" class="btn" name="register_btn">Register</button>
	</div>
	<p>
		Already a member? <a href="login.php">Sign in</a>
	</p>
</form>
</body>
</html>