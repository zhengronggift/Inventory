<?php
//include('connect.php'); 
//if(!isset($_SESSION)){
  //  session_start();
//}
//session_start();
//$error = " ";

class Login{
	function __construct()
	{
	$this->form();
	$this->login();
	}

	function login(){
	$conn = new mysqli(db_servername, db_username, db_pass, db_dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	if(isset($_POST['login'])){
	$test=$_POST['username'];
	$test1=$_POST['password'];

	if($test == "" || $test1 == "")
	{
	echo "Employee ID and Last Name cannot be empty";
	}

	if(ctype_alnum($test)){ 
	//echo "<br>username accept";
	//check to see if username in use
	$query="SELECT `e_id`, `l_name`, `d_id` FROM employee WHERE `e_id` = '$test'";
	//echo $query;
	$result=mysqli_query($conn, $query);
	$num=mysqli_num_rows($result);

	if ($num != 0)
	{
	$row = $result->fetch_assoc();

	if ($row["l_name"] == $test1)
	{
	//echo "You are connected";
	$_SESSION['login_user'] = $test1;
	$_SESSION['e_id'] = $row["e_id"];
	$_SESSION['d_id'] = $row["d_id"];
     	header("location:index.php");
	}
	else
	{
	echo "Sorry, Employee ID and Last Name does not match.";
	}

	}
	else
	{
	echo "No user found";
	}
	}
	}
	}

	function form(){
	echo "<br><br><p>Login</p>";
	echo "<form action'' method='POST'>";
	echo "<p>Employee ID: <input type='text' name='username' size='15' maxlength='20' value = ''></p>";
	echo "<p>Last Name: <input type='text' name='password' size='15' maxlength='20' value = ''></p>";

	echo "<p><input type='submit' name='login' value='Login'></p>";
	echo "</form>";
	echo "<p>New employee? <a href='https://lamp.cse.fau.edu/~rzheng/inventory/register.php' class='button'>Register</a></p>";
	}
}
?>












