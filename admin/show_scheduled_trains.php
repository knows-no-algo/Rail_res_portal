<?php
    include('../functions.php');



?>

<html>
<head>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="../back.php"> Back <span class="sr-only">(current)</span></a>
      </li>
    </ul>
  </div>
</nav>
<body>
    <div align="CENTER">
	<h2>List of all Scheduled Trains</h2>
</div>
<?php
$query = "SELECT * from trainsavailable";
$result = mysqli_query($db,$query);

echo "<table class='table table-striped'>
<thead class='thead-dark'>
<tr>
<th scope='col'>Train_Number</th>
<th scope='col'>Train_Name</th>
<th scope='col'>Date Of Journey</th>
<th scope='col'>AC Coaches</th>
<th scope='col'>SL Coaches</th>
<th scope='col'>AC Seats Left</th>
<th scope='col'>Sleeper Seats Left</th>
</tr>
</thead>
<tbody>";

while($row = mysqli_fetch_array($result)){
    echo "
    <tr>	
	<td>".$row[0]."</td>
	<td>".$row[2]."</td>
    <td>".$row[1]."</td>
    <td>".$row[3]."</td>
    <td>".$row[4]."</td>
    <td>".$row[5]."</td>
    <td>".$row[6]."</td>
	</tr>";
}

echo "</tbody>
</table>";


?>
</body>
</html>