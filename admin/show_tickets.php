
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
<body>
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
    </ul>
  </div>
</nav>

<?php 
$ticket_table_name = $_SESSION['ticket_table_name'];

$train_number = $_SESSION['train_number1'];
$doj = $_SESSION['doj1'];

?>

<div align='CENTER'>
    <h2>
        Tickets For Train No. <?php echo $train_number?> and DOJ <?php echo $doj?>
    </h2>
</div>

<?php

$query = "SELECT * from  $ticket_table_name order by pnr ";
$result = mysqli_query($db,$query);

echo "<table class='table table-striped'>
<thead class='thead-dark'>
<tr>
<th scope='col'>pnr</th>
<th scope='col'>Passenger Name</th>
<th scope='col'>Age</th>
<th scope='col'>Gender</th>
<th scope='col'>Berth No.</th>
<th scope='col'>Berth Type</th>
<th scope='col'>Coach No.</th>
</tr>
</thead>
<tbody>";

while($row = mysqli_fetch_array($result)){
    echo "
    <tr>	
	<td>".$row[0]."</td>
	<td>".$row[3]."</td>
    <td>".$row[7]."</td>
    <td>".$row[8]."</td>
    <td>".$row[4]."</td>
    <td>".$row[5]."</td>
    <td>".$row[6]."</td>
	</tr>";
}

echo "</tbody>
</table>";
echo "<br><a href='http://localhost/proj1/admin/home.php'>Back to Admin Page</a><br> ";

?>
</body>
</html>

