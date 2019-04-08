<?php
include('connect.php');
class Register{
	function __construct()
	{
	$this->form();
	$this->register();
	$this->search();
	}

	function register(){
	$conn = new mysqli(db_servername, db_username, db_pass, db_dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	if(isset($_POST['register'])){
	//$eid=$_POST['e_id'];
	$did=$_POST['d_id'];
	$fname=$_POST['f_name'];
	$lname=$_POST['l_name'];
	$manager=$_POST['emp_man'];

	if($did == "" || $fname == "" || $lname == "") //$eid == "" || 
	{
	 echo "Dealer ID, First Name, or Last Name cannot be empty";
	}

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

	}
	}
	}

	function form(){
echo "<script>";
echo "$(document).ready(function(){";
echo "$('#myInput').on('keyup', function() {";
echo "var value = $(this).val().toLowerCase();";
echo  "$('#myTable tr').filter(function() {";
echo  "$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)";
echo   "});";
echo  "});";
echo "});";

echo "</script>";

	echo "<br><br><p>Register</p>";
	echo "<form action='reg_emp.php' method='POST'>";
	//echo "<p>Employee ID: <input type='text' name='e_id' size='15' maxlength='20' value = ''></p>";
	echo "<p>Dealer ID: <input type='text' name='d_id' size='15' maxlength='20' value = ''></p>";
	echo "<p>First Name: <input type='text' name='f_name' size='15' maxlength='20' value = ''></p>";
	echo "<p>Last Name: <input type='text' name='l_name' size='15' maxlength='20' value = ''></p>";
	
	echo "<p>Role: <input type='radio' name='emp_man' value='employee' checked> Employee   ";
	echo "<input type='radio' name='emp_man' value='manager'> Manager</p>";

	echo "<p><input type='submit' id='reg' name='register' value='Register'></p>";
	echo "</form>";

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
		}elseif ($num != 0)
		{ echo "<br>Sorry, this dealer has a manager already, please check the dealer";}
	}

	function search(){	
		//get dealer table for id search
		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		//echo $file;
		$sql = "SELECT * FROM dealer ORDER BY name";
		//echo $sql;
		$result = mysqli_query($db, $sql);
		echo "<div class='container'>";
  		echo "<h2>Find Dealer</h2>";
		echo "<input id='myInput' type='text' placeholder='Dealer ID Search..'>";          
  		echo "<table class='table'>";
    		echo "<thead>";
      		echo "<tr>";
        	echo "<th>Dealer ID</th>";
        	echo "<th>Name</th>";
        	echo "<th>Manager</th>";
        	echo "<th>City</th>";
        	echo "<th>State</th>";
        	//echo "<th>Zip Code</th>";
		//echo "<th>Number of Employees</th>";
      		echo "</tr>";
    		echo "</thead>";
    		echo "<tbody id='myTable'>";
		while($row = mysqli_fetch_assoc($result))
    		{
		$d_id = $row['d_id'];
		$name = $row['name'];
		$sql2 = "SELECT e.f_name, e.l_name FROM dealer d, employee e, manage m WHERE d.d_id = '$d_id' AND m.d_id = '$d_id' AND e.e_id = m.e_id";
		$result2 = mysqli_query($db, $sql2);
		$row2 = mysqli_fetch_assoc($result2);
		$city = $row['city'];
		$state = $row['state'];
		//$zip_code = $row['zip_code'];
		//$emp = $row['employee'];
		//$num = $row['num'];
		echo "<tr>";
        	echo "<td>" . $d_id . "</td>";
		echo "<td>" . $name . "</td>";
        	echo "<td>" . $row2['f_name'] . " " . $row2['l_name'] . "</td>";
		echo "<td>" . $city . "</td>";
        	echo "<td>" . $state . "</td>";
        	//echo "<td>" . $zip_code . "</td>";
		//echo "<td>" . $row4['num_emp'] . "</td>";
		}

		echo "</tbody>";
  		echo "</table>";
		echo "</div>";
}



}

$reg = new Register();
?>

