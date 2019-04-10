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
	//$eid=$_POST['e_id'];
	$did = $_GET['did'];
	//$did=$_POST['d_id'];
	$fname=$_POST['f_name'];
	$lname=$_POST['l_name'];
	$manager=$_POST['emp_man'];

	if($fname == "" || $lname == "") //$eid == "" || 
	{
	 echo "First Name, or Last Name cannot be empty";
	}else{

	if(ctype_alnum($did)){ 
	$fname=ucfirst($fname);
	$lname=ucfirst($lname);
	//echo "<br>username accept";
	//check to see if username in use
	//$query="SELECT `e_id` FROM employee WHERE `e_id` = '$eid'";
	$query2="SELECT `d_id` FROM dealer WHERE `d_id` = '$did'";
	//echo $query;
	//$result=mysqli_query($conn, $query);
	$result2=mysqli_query($conn, $query2);
	//$num=mysqli_num_rows($result);
	$num2=mysqli_num_rows($result2);	

	if ($num2 > 0) //$num == 0 && 
	{
	//echo "<br>Search result: $num; Employee ID $eid is not in use";
$sql = "INSERT INTO `employee`(`d_id`, `f_name`, `l_name`) 
VALUES ('$did', '$fname','$lname')"; //`e_id`, '$eid', 

	if ($conn->query($sql) === TRUE) {
	    echo "<br>******New user created successfully.******";
	    $query3="SELECT `e_id` FROM employee WHERE `d_id` = '$did' AND `l_name` = '$lname' AND `f_name` = '$fname'";
	    $result3=mysqli_query($conn, $query3);
	    $num3=mysqli_fetch_assoc($result3);
	    $eid = $num3['e_id'];
	    $this->insert_manage($manager, $eid, $did);
	}else {
	    echo "Error: " . $sql . "<br>The test data added already<br>" . $conn->error;
	}
	}elseif ($num2 == 0){ //$num == 0 && 
		echo "<br>Search result: Cannot find the Dealer ID, Please use one of following dealer ID <br>";
		//$qls = "SELECT `d_id`, `name` FROM dealer";
		//$rst=mysqli_query($conn, $qls);
		//while($row2 = mysqli_fetch_assoc($rst))
		//{
		//	$dealerID = $row2['d_id'];
		//	$dname = $row2['name'];
		//	echo "Dealer ID: " . $dealerID . " " . $dname . "<br>";
			
		//}
		//echo "<br>";
	}//elseif ($num != 0){
	//	echo "<br>The Employee ID is in use, please use another Employee ID. <br>";
	//}

	}}
	}
	}
	function insert_manage($manager, $eid, $did){
	//echo $manager . $eid;	
		$conn = new mysqli(db_servername, db_username, db_pass, db_dbname);
		$query = "SELECT * FROM manage WHERE `d_id` = '$did'";
		$result = mysqli_query($conn, $query);
		$num=mysqli_num_rows($result);
		if ($manager == "manager" && $num == 0)
		{
			$sql = "INSERT INTO `manage`(`d_id`, `e_id`) VALUES ('$did', '$eid')";	
			$result3=mysqli_query($conn, $sql);
	   		echo "<br>Employee is inserted as a manager.";
			header("location:index.php");
		}elseif ($num != 0)
		{ echo "<br>Sorry, this dealer has a manager already, please check the dealer";}
	}
	function form(){

	echo "<br><br><p>Register</p>";
	echo "<form action='reg_emp.php?did=" . $_GET['did'] . "' method='POST'>"; //
	echo "<p>Dealer ID: " . $_GET['did'] . "</p>";
	echo "<p>First Name: <input type='text' name='f_name' size='15' maxlength='20' value = ''></p>";
	echo "<p>Last Name: <input type='text' name='l_name' size='15' maxlength='20' value = ''></p>";
	echo "<p>Role: <input type='radio' name='emp_man' value='employee' checked> Employee   ";
	echo "<input type='radio' name='emp_man' value='manager'> Manager</p>";
	echo "<p><input type='submit' name='register' value='Register'></p>";
	echo "</form>";
	}
	
}

$reg = new Register();
?>

