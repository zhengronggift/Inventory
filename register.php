<?php
include('connect.php');
class Register{
	function __construct()
	{
	$this->form();
	$this->register();
	}

	function register(){
	$conn = new mysqli(db_servername, db_username, db_pass, db_dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	if(isset($_POST['register'])){
	$eid=$_POST['e_id'];
	$did=$_POST['d_id'];
	$fname=$_POST['f_name'];
	$lname=$_POST['l_name'];

	if($eid == "" || $did == "" || $fname == "" || $lname == "")
	{
	echo "Employee ID, Dealer ID, First Name, or Last Name cannot be empty";
	}

	if(ctype_alnum($eid)){ 
	//echo "<br>username accept";
	//check to see if username in use
	$query="SELECT `e_id` FROM employee WHERE `e_id` = '$eid'";
	$query2="SELECT `d_id` FROM dealer WHERE `d_id` = '$did'";
	//echo $query;
	$result=mysqli_query($conn, $query);
	$result2=mysqli_query($conn, $query2);
	$num=mysqli_num_rows($result);
	$num2=mysqli_num_rows($result2);	

	if ($num == 0 && $num2 > 0)
	{
	echo "<br>Search result: $num; Employee ID $eid is not in use";
$sql = "INSERT INTO `employee`(`e_id`,`d_id`, `f_name`, `l_name`)
VALUES ('$eid', '$did', '$fname','$lname')";

if ($conn->query($sql) === TRUE) {
    echo "<br>******New user created successfully.******";
    header("location:index.php");
}else {
    echo "Error: " . $sql . "<br>The test data added already<br>" . $conn->error;
}
	}elseif ($num == 0 && $num2 == 0){
		echo "<br>Search result: Cannot find the Dealer ID, Please use one of following dealer ID: <br>";
		$qls = "SELECT `d_id`, `name` FROM dealer";
		$rst=mysqli_query($conn, $qls);
		while($row2 = mysqli_fetch_assoc($rst))
		{
			$dealerID = $row2['d_id'];
			$dname = $row2['name'];
			echo "Dealer ID: " . $dealerID . " " . $dname . "<br>";
			
		}
		echo "<br>";
	}elseif ($num != 0){
		echo "<br>The Employee ID is in use, please use another Employee ID. <br>";
	}

	}
	}
	}

	function form(){
	echo "<br><br><p>Register</p>";
	echo "<form action'' method='POST'>";
	echo "<p>Employee ID: <input type='text' name='e_id' size='15' maxlength='20' value = ''></p>";
	echo "<p>Dealer ID: <input type='text' name='d_id' size='15' maxlength='20' value = ''></p>";
	echo "<p>First Name: <input type='text' name='f_name' size='15' maxlength='20' value = ''></p>";
	echo "<p>Last Name: <input type='text' name='l_name' size='15' maxlength='20' value = ''></p>";

	echo "<p><input type='submit' name='register' value='Register'></p>";
	echo "</form>";
	}
}

$reg = new Register();
?>

