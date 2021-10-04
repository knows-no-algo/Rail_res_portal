<?php
session_start();

// connect to database
$db = mysqli_connect('localhost', 'root', 'deepak', 'railwayproj');
//$db = mysqli_connect('localhost', 'T', '7376748947', 'reservation');

// variable declaration
$username = "";
$email    = "";
$name     = "";
$address  = "";
$creditcard = "";
$errors   = array();
$errors1  = array();
$success = array();
$errors2 = array();

if(isset($_POST['register_btn'])){
    register();
}

function register(){
    global $db,$errors,$username,$email;
    $name = e($_POST['name']);
    $creditCard = e($_POST['creditcard']);
    $address = e($_POST['address']);
    $username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	$password_1  =  e($_POST['password_1']);
    $password_2  =  e($_POST['password_2']);


    if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	if (empty($password_1)) {
		array_push($errors, "Password is required");
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
    }

    if(count($errors) == 0){
        $password = $password_1;

        if(isset($_POST['user_type'])){
            $user_type = e($_POST['user_type']);
            $query = "INSERT INTO bookingagents(name,creditCard,address,username,emailID,password,user_type)
                     values('$name','$creditCard','$address','$username','$email','$password','$user_type'  )";
            mysqli_query($db,$query);
            $SESSION['success'] = "New user Successfully Created!!";
            header('location: admin/home.php');
        }
        else{
			$username_check = mysqli_query($db,"SELECT * from bookingagents where username='$username' or emailID='$email'");
			if(mysqli_num_rows($username_check)>=1){
				array_push($errors,"Username or Email Already Exists.");
			}
			else{
				$query = "INSERT INTO bookingagents(name,creditCard,address,username,emailID,password,user_type)
						values('$name','$creditCard','$address','$username','$email','$password','user'  )";
				mysqli_query($db,$query);
				//$logged_in_user_id = mysqli_insert_id($db);
				//$_SESSION['user'] = getUserById($logged_in_user_id);
				$SESSION['success'] = "You are now logged in";
				header('location: welcome.php');
			}
        }
    }

}

function getUserById($id){
	global $db;
	$query = "SELECT * FROM bokingagents WHERE id=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}


function e($val){
    global $db;
    return mysqli_real_escape_string($db,trim($val));
}

function display_error(){
    global $errors;
    if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}

function display_success(){
    global $success;
    if (count($success) > 0){
		echo '<div class="success">';
			foreach ($success as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}

function display_error1(){
    global $errors1;
    if (count($errors1) > 0){
		echo '<div class="error">';
			foreach ($errors1 as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}

function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}

if(isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['user']);
    header('location: index.php');
}

if(isset($_POST['login_btn'])){
    login();
}



function login(){
    global $db,$username,$errors;
    $username = e($_POST['username']);
	$password = e($_POST['password']);

	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
    }
    if (count($errors) == 0) {
		$query = "SELECT * FROM bookingagents WHERE username='$username' and password='$password' LIMIT 1";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) { // user found
			// check if user is admin or user
			$logged_in_user = mysqli_fetch_assoc($results);
			if ($logged_in_user['user_type'] == 'admin') {

				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";
				header('location: admin/home.php');
			}else{
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";

				header('location: welcome.php');
			}
		}else {
			array_push($errors, "Wrong username/password combination");
		}
    }
}

function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
		return true;
	}else{
		return false;
	}
}

function isUser(){
	if(isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'user'){
		return true;
	}
	else{
		return false;
	}
}

if(isset($_POST['insert_train_btn'])){
	insert_train();
}

function insert_train(){
	global $db,$errors,$success;
	$trainno = e($_POST['trainno']);
	$trainname = e($_POST['trainname']);
	$call = mysqli_prepare($db,'CALL insert_new_train(?,?,@result)');
	mysqli_stmt_bind_param($call,'is',$trainno,$trainname);
	mysqli_stmt_execute($call);

	$res = mysqli_query($db,'Select @result');
	$output = mysqli_fetch_assoc($res);

	$ans = $output['@result'];
	if($ans!=0){
		array_push($success,"Train Successfully Inserted");
	}
	else{
		array_push($errors,"Train with Given Number Already Exists");
	}
}

if(isset($_POST['schedule_train_btn'])){
	schedule_train();
}

function schedule_train(){
	global $db,$errors,$success;
	$trainno = e($_POST['trainno']);
	$trainname="";
	$sql = "SELECT name from trains where trainno='$trainno'";
	$result = mysqli_query($db,$sql);
	if(mysqli_num_rows($result)==1){
		$row = mysqli_fetch_assoc($result);
		$trainname = $row["name"];
	}
	else{
		$trainname = "dummy";
	}
	$doj = date('Y-m-d',strtotime($_POST['date']));
	$doj1= date('Ymd',strtotime($_POST['date']));
	/*$trainname = e($_POST['trainname']);*/
	$ac_coaches = e($_POST['acCoaches']);
	$sl_coaches = e($_POST['sleeperCoaches']);
	$ac_seats_left = $ac_coaches*18;
	$sl_seats_left = $sl_coaches*24;
	$call = mysqli_prepare($db,'CALL schedule_train(?,?,?,?,?,@result,?,?)');
	mysqli_stmt_bind_param($call,'issiiii',$trainno,$doj,$trainname,$ac_seats_left,$sl_seats_left,$ac_coaches,$sl_coaches);
	mysqli_stmt_execute($call);

	$res = mysqli_query($db,'Select @result');
	$output = mysqli_fetch_assoc($res);

	$ans = $output['@result'];
	if($ans==1){
		$ticket = "ticket";
		$table_name = $ticket.$trainno.$doj1;
		$sql = "CREATE Table $table_name (
				`pnr` varchar(30) NOT NULL,
				`trainNo` int(11) NOT NULL,
				`doj` date NOT NULL,
				`name` varchar(20) NOT NULL,
				`berth no` int(11) NOT NULL,
				`berth type` varchar(2) NOT NULL,
				`coach no` varchar(4) NOT NULL,
				`age` int(11) NOT NULL,
				`gender` varchar(7) NOT NULL,
				PRIMARY KEY( `berth no`, `coach no`)
			)";
		mysqli_query($db,$sql);
		array_push($success,"Train Scheduled Successfully");
	}
	elseif($ans==0){
		array_push($errors,"Train with Given Number Does Not Exists");
	}
	elseif($ans==2){
		array_push($errors,"Please Schedule in the Limit of 2 to 4 months");
	}

}

if(isset($_POST['show_tickets_btn'])){
	show_tickets();
}

function show_tickets(){
	global $db,$errors;
	$train_number = e($_POST['train_number']);
	$doj = ($_POST['doj']);

	$doj1= date('Ymd',strtotime($_POST['doj']));
	$sql = "SELECT * from bookinghistory where trainno='$train_number' and doj='$doj'";
	$result = mysqli_query($db,$sql);
	if(mysqli_num_rows($result) != 0){

		$ticket_table_name = "ticket".$train_number.$doj1;
		$_SESSION['ticket_table_name'] = $ticket_table_name;
		$_SESSION['train_number1'] = $train_number;
		$_SESSION['doj1'] = $doj;
		header('location: show_tickets.php');
	}
	else{
        $sql = "SELECT * from trainsavailable where trainno='$train_number' and doj='$doj'";
	   $result = mysqli_query($db,$sql);
        if(mysqli_num_rows($result) != 0){
            array_push($errors,"No tickets to show");
        }
        else{
		  array_push($errors,"No such train scheduled on the given date");
        }
	}
}

if(isset($_POST['check_availability_btn'])){
	check_availibility();
}
if(isset($_POST['update_btn'])){
    update();
//    $query="UPDATE Bookingagents SET name=$name,address=$address,email=$email where username=$username";
}
function update(){
    global $db,$errors,$username,$email,$success;
    $name = e($_POST['name']);
    $address = e($_POST['address']);
    $username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
    if(count($errors) == 0){
        $query = "UPDATE bookingagents SET name='$name',address='$address',emailID='$email' where username='$username'";
        mysqli_query($db,$query);
        array_push($success,"Profile successfully updated");
        $logged_in_user_id = mysqli_insert_id($db);
        array_push($success,"Profile updated successfully");
//        array_push($success,"Train Scheduled Successfully");
//        $_SESSION['user'] = getUserById($logged_in_user_id);
        $SESSION['success'] = "You are now logged in";
        header('location: welcome.php');
    }

}


function check_availibility(){
	global $db,$errors;
	$no_of_pass = e($_POST['no_of_pass']);
	$username = $_SESSION['user']['username'];
	$train_number = e($_POST['train_number']);
	$doj = date('Y-m-d',strtotime($_POST['doj']));
	$class = e($_POST['class']);
	$call = mysqli_prepare($db,'CALL check_availability(?,?,?,?,@result,@value)');
	mysqli_stmt_bind_param($call,'issi',$train_number,$doj,$class,$no_of_pass);
	mysqli_stmt_execute($call);

	$res = mysqli_query($db,'Select @result,@value');
	$output = mysqli_fetch_assoc($res);

	$ans1 = $output['@result'];
	$ans2 = $output['@value'];
	if($ans1 == 1){
		$_SESSION['train_number'] = $train_number;
		$_SESSION['doj'] = $doj;
		$_SESSION['no_of_pass'] = $no_of_pass;
		$_SESSION['class'] = $class;
		header('location: book_ticket.php');
	}
	elseif($ans1 == 0){
		if($ans2==0){
            $sql = "SELECT * from trains where trainno='$train_number'";
	         $result = mysqli_query($db,$sql);
            if(mysqli_num_rows($result) == 0){
                array_push($errors,"No train with the given train no exists");
            }
            else{
                    array_push($errors,"train is not available for the given journey date");
                }
            }
		elseif($ans2 == 1){
			array_push($errors,"Required AC seats not left");
		}
		elseif($ans2 == 2){
			array_push($errors,"Required Sleeper Seats not left");
		}
	}

}

if(isset($_POST['book_ticket_btn'])){
	book_ticket();
}

function book_ticket(){
	global $db,$errors,$success;
	$pnr = "";
	$pnr = date("Ymdhis");
	$berth_no = array();
	$berth_type = array();
	$coach = array();
	$passenger_name = array();
	$passenger_age = array();
	$passenger_gender = array();
	$train_number = $_SESSION['train_number'];
	$username = $_SESSION['user']['username'];
	$doj = $_SESSION['doj'];
	$doj1 = str_replace('-','',$doj);
	$no_of_pass = $_SESSION['no_of_pass'];
	$class = $_SESSION['class'];
	$seats_left = "";
	$coach_no="";
	$eq_birth_no="";
	for($i=0;$i<$no_of_pass;$i++){
		$passenger_name[$i] = e($_POST['passenger_name'][$i]);
		$passenger_age[$i] =  e($_POST['passenger_age'][$i]);
		$passenger_gender[$i] =  e($_POST['passenger_gender'][$i]);
	}
	$sql = "SELECT * from trainsavailable where trainno='$train_number' and doj='$doj'";
	$ticket = "ticket";
	$train_name = "";
	$ticket_table_name = $ticket.$train_number.$doj1;
	$result = mysqli_query($db,$sql);
	if(mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_assoc($result);
		$train_name = $row["trainName"];
		if($class == 'AC'){
			$seats_left = $row["AcSeatsLeft"];
			for($i=0;$i<$no_of_pass;$i++){
				if($seats_left%18 == 0){
					$coach_no = $seats_left/18;
					$coach_no = "AC".$coach_no;
					$eq_birth_no = 18;
					array_push($berth_no,$eq_birth_no);

				}
				else{
					$eq_birth_no = $seats_left%18;
					$coach_no = floor($seats_left/18) + 1;
					$coach_no = "AC".$coach_no;
					array_push($berth_no,$eq_birth_no);

				}
				array_push($coach,$coach_no);
				$sql1 = "SELECT * from berth where classType='$class' and birthNo='$eq_birth_no'";
				$result1 = mysqli_query($db,$sql1);
				$row1 = mysqli_fetch_assoc($result1);
				$type_of_birth = $row1["birthType"];
				array_push($berth_type,$type_of_birth);
				$seats_left = $seats_left-1;

			}
			$sql2 = "UPDATE trainsavailable set AcSeatsLeft = AcSeatsLeft - '$no_of_pass' where trainno='$train_number' and doj='$doj' ";
			mysqli_query($db,$sql2);
		}
		else{
			$seats_left = $row["SlSeatsLeft"];
			for($i=0;$i<$no_of_pass;$i++){
				if($seats_left%24 == 0){
					$coach_no = $seats_left/24;
					$eq_birth_no = 24;
					array_push($berth_no,$eq_birth_no);
					$coach_no = "SL".$coach_no;
				}
				else{
					$eq_birth_no = $seats_left%24;
					array_push($berth_no,$eq_birth_no);
					$coach_no = floor($seats_left/24) + 1;
					$coach_no = "SL".$coach_no;
				}
				array_push($coach,$coach_no);
				$sql2 = "SELECT * from berth where classType='SL' and birthNo='$eq_birth_no'";
				$result2 = mysqli_query($db,$sql2);
				$row2 = mysqli_fetch_assoc($result2);
				$type_of_birth = $row2["birthType"];
				array_push($berth_type,$type_of_birth);
				$seats_left = $seats_left-1;

			}
			$sql2 = "UPDATE trainsavailable set SlSeatsLeft = SlSeatsLeft - '$no_of_pass' where trainno='$train_number' and doj='$doj' ";
			mysqli_query($db,$sql2);
		}
		$sql = "INSERT into bookinghistory values('$username','$train_number','$train_name','$doj','$pnr')";
		mysqli_query($db,$sql);
		for($i=0;$i<$no_of_pass;$i++){
			$sql = "INSERT into $ticket_table_name Values('$pnr','$train_number','$doj','$passenger_name[$i]','$berth_no[$i]','$berth_type[$i]',
					'$coach[$i]','$passenger_age[$i]','$passenger_gender[$i]')";
			mysqli_query($db,$sql);

		}
		unset($_SESSION['train_number']);
		array_push($success,"Ticket Booked Successfully");
	}
}

function display_error2(){
    global $errors2;
    if (count($errors2) > 0){
		echo '<div class="error">';
			foreach ($errors2 as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}

if(isset($_POST['see_train_btn'])){
	see_train();
}

function see_train(){
	global $db,$errors;
	$train_no = e($_POST['train_number']);
	$sql = "SELECT * from trainsavailable where trainno = '$train_no' ";
	$result = mysqli_query($db,$sql);

	if(mysqli_num_rows($result) != 0){
		$_SESSION['train_number'] = $train_no;
		header('location: see_train.php');
	}
	else{
        $sql = "SELECT * from trains where trainno = '$train_no' ";
	   $result = mysqli_query($db,$sql);
        if(mysqli_num_rows($result) != 0){
           array_push($errors,"This train is not released for any future dates till now"); 
        }
        else{
		  array_push($errors,"Train Not Available");
        }
	}
}

if(isset($_POST['see_train_by_date_btn'])){
	see_train_by_date();
}

function see_train_by_date(){
	global $db,$errors2;
	$doj = date('Y-m-d',strtotime($_POST['date']));
	$sql = "SELECT * from trainsavailable where doj = '$doj' ";
	$result = mysqli_query($db,$sql);

	if(mysqli_num_rows($result) != 0){
		$_SESSION['doj'] = $doj;
		header('location: see_train_by_date.php');
	}
	else{
		array_push($errors2,"No Train Available on this date");
	}
}

if(isset($_POST['see_pnr_btn'])){
	see_pnr();
}

function see_pnr(){
	global $db,$errors1;
	$pnr = e($_POST['pnr']);
	$sql = "SELECT * from bookinghistory where pnr = '$pnr' ";
	$result = mysqli_query($db,$sql);

	if(mysqli_num_rows($result) == 1){
		$_SESSION['pnr'] = $pnr;
		header('location: see_pnr.php');
	}
	else{
		array_push($errors1,"PNR Not Available");
	}
}

?>
