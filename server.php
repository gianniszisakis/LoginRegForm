<?php 
session_start();
$_SESSION['message'] = '';
$username = "";
$name = "";
$surname = "";
$email = "";
$password= "";

//Db connection
$mysqli = new mysqli('localhost', 'root', '', 'registration');


if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$username = mysqli_real_escape_string($mysqli, $_POST['username']);
		$password = mysqli_real_escape_string($mysqli, $_POST['password']);

		//Check username and email
		$mysqli_u = "SELECT * FROM users WHERE username='$username'";
		$mysqli_e = "SELECT * FROM users WHERE email='$email'";
		$res_u = mysqli_query($mysqli, $mysqli_u);
		$res_e = mysqli_query($mysqli, $mysqli_e);
		if(mysqli_num_rows($res_u) > 0){
			$_SESSION['message'] = "Please fill another username. $username exists!";
		}
		else if(mysqli_num_rows($res_e) > 0){
			$_SESSION['message'] = "Please fill another email. $email exists!";
		}
		else{

		//Insert values into db	
		$sql = "INSERT INTO users (name, surname, email, username, password) VALUES ('$name', '$surname', '$email', '$username', '$password')";
		if($mysqli->query($sql) === TRUE){
		$_SESSION['message'] = "Success registration";
	}
}
}

//Login user
if(isset($_POST['login'])){
	$username = mysqli_real_escape_string($mysqli, $_POST['username']);
  	$password = mysqli_real_escape_string($mysqli, $_POST['password']);
  	$name = "";
  	$surname = "";
  	$email = "";
  	

if(empty($username)){
	$_SESSION['message'] = "Username required";
}

if(empty($password)){
	$_SESSION['message'] = "Password required";
}
else{
	
	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
	$results = mysqli_query($mysqli,$query);
}
	if(mysqli_num_rows($results) == 1){
		header('location: index.php');
	}
	else{
		$_SESSION['message'] = "Username: $username or Password: $password doesn't exist!";

	}
}

/* Show the table results */
$query = "SELECT * FROM mobile";
$results = $mysqli ->query($query);

echo "<div class='container'><h2>Daily Report</h2><table class='table table-hover'><thead><tr><th>date</th><th>p2p</th><th>portin</th><th>data</th><th>business</th><th>total</th></tr></thead>";
while($row = $results->fetch_assoc()){
echo "<tr><td>".$row["date"]."</td><td>".$row["p2p"]."</td><td>".$row["portin"]."</td><td>".$row["data"]."</td><td>".$row["business"]."</td><td>".$row["total"]."</td>";
}
echo "</table>";
/*end of table results code */

?>

