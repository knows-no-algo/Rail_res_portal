<?php
    include('../functions.php');


if (!isAdmin()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: ../login.php');
}

?>

<html>
<head>
    <link rel="stylesheet" href="../style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand"><?php echo $_SESSION['user']['name'];?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="home.php"> Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="schedule.php">Schedule Train</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link " href="insert_new_train.php">Insert a Train</a>
	  </li>
	  <li class="nav-item active">
        <a class="nav-link " href="show_scheduled_trains.php">Scheduled Trains List</a>
	  </li>
	  <li class="nav-item active">
	  <a class="nav-link" href="home.php?logout='1'" style="color: red;">logout</a>
      </li>
    </ul>
  </div>
</nav>
<style type="text/css">
   body { background-image: url('https://images.unsplash.com/photo-1535535112387-56ffe8db21ff?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&w=1000&q=80') !important; } /* Adding !important forces the browser to overwrite the default style applied by Bootstrap */
</style>
<body>
<div class="header">
	<h2>Insert a new Train</h2>
</div>
<form method="post" action="insert_new_train.php">

	<?php echo display_error(); 
	?>
	<?php echo display_success();?>
    <div class="input-group">
		<label>Train Number</label>
		<input type="text" name="trainno" value="">
	</div>
    <div class="input-group">
		<label>Train Name</label>
		<input type="text" name="trainname" value="">
	</div>
	<div class="input-group">
		<button type="submit" class="btn" name="insert_train_btn">Insert</button>
    </div>
    <p>
	 <a href="home.php">Back to Admin Page</a>
	</p>
	<p>
	 <a href="schedule.php">Schedule a Train</a>
	</p>
</form>
</body>

</html>
