<?php
    include('functions.php');

     $pnr = $_SESSION['pnr'];

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
        <a class="nav-link" href="welcome.php"> Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="check_availability.php">Book Tickets</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link " href="show_past_bookings.php">Show Past Bookings</a>
      </li>
    </ul>
  </div>
</nav>
<body>
    <div align="CENTER">
	<h2>Ticket with PNR Number <?php echo $pnr;?> </h2>
</div>
<?php
$username = $_SESSION['user']['username'];
$query = "SELECT * from bookinghistory where pnr = '$pnr' and username='$username' ";
$result = mysqli_query($db,$query);

if(mysqli_num_rows($result) == 1){

    $row = mysqli_fetch_array($result);
    $train_number = $row[1];
    $train_name = $row[2];
    $doj = $row[3];
    $doj1 = str_replace('-','',$doj);

    $ticket_table_name = "ticket".$train_number.$doj1;
    echo "<div class='container'>
            <div class='row'>
            <div class='col border'>";

            echo "PNR: ".$pnr."<br> Train Number--".$train_number."<br> Train Name-- ".$train_name."<br> Date Of Journey:-".$doj."<br>" ;
            echo "<table class='table table-striped'>
            <thead class='thead-dark'>
            <tr>
            <th scope='col'>Name</th>
            <th scope='col'>Age</th>
            <th scope='col'>Gender</th>
            <th scope='col'>Berth No.</th>
            <th scope='col'>Berth Type</th>
            <th scope='col'>Coach No.</th>
            </tr>
            </thead>
            <tbody>";
        
            $query1 = "SELECT * from $ticket_table_name where pnr=$pnr";
            $result1 = mysqli_query($db,$query1);
            while($row1 = mysqli_fetch_array($result1)){
                echo "
                <tr>	
                <td>".$row1[3]."</td>
                <td>".$row1[7]."</td>
                <td>".$row1[8]."</td>
                <td>".$row1[4]."</td>
                <td>".$row1[5]."</td>
                <td>".$row1[6]."</td>
                </tr>
        
            ";
            }
            echo "</tbody>
            </table>";
            echo "</div>
            </div>
            </div>";
}

?>
</body>
</html>