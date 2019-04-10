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
	$dname=$_POST['d_name'];
	$dname=ucfirst($dname);
	$city=$_POST['city'];
	$city=ucfirst($city);
	$state=$_POST['state'];
	$state=ucfirst($state);
	$zip=$_POST['zip'];
	//$f_name=$_POST['f_name'];
	//$l_name=$_POST['l_name'];

	if($dname == "" || $city == "" || $state == "" || $zip == "") 
	{
	 echo "Dealer Name, City, State, Zip Code cannot be empty";
	}

	if(ctype_alnum($zip)){ 
	$query2="SELECT `name`, `zip_code` FROM dealer WHERE `name` = '$dname' AND `zip_code` = '$zip'";
	$result2=mysqli_query($conn, $query2);
	$num2=mysqli_num_rows($result2);	
	//if dealer name does not exist within same zip code
	if ($num2 == 0) //$num == 0 && 
	{
	
$sql = "INSERT INTO `dealer`(`name`, `city`, `state`,`zip_code`) 
VALUES ('$dname', '$city','$state','$zip')"; //`e_id`, '$eid', 

	if ($conn->query($sql) === TRUE) {
	    echo "<br>******New Dealer created successfully.******";
	    header("location:index.php");
	}else {
	    echo "Something goes wrong";
	}
	}elseif ($num2 != 0){ //$num == 0 && 
		echo "<br>A dealer with same name already exist in this zip code<br>";

	}

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

	echo "<br><br><p>Add A Dealer</p>";
	echo "<form action='add_dealer.php' method='POST'>";
	//echo "<p>Employee ID: <input type='text' name='e_id' size='15' maxlength='20' value = ''></p>";
	//echo "<p>Dealer ID: <input type='text' name='d_id' size='15' maxlength='20' value = ''></p>";
	echo "<p style="text-align:center">Dealer Name: <input style="margin-right: 86px" type='text' name='d_name' size='15' maxlength='20' value = ''></p>";
	//echo "<p>Manager First Name: <input type='text' name='f_name' size='15' maxlength='20' value = ''></p>";
	//echo "<p>Manager Last Name: <input type='text' name='l_name' size='15' maxlength='20' value = ''></p>";
	echo "<p style="text-align:center">City: <input style="margin-right: 30px" type='text' name='city' size='15' maxlength='20' value = ''></p>";
	echo "<p style="text-align:center">State: <input style="margin-right: 38px" type='text' name='state' size='15' maxlength='20' value = ''></p>";
	echo "<p style="text-align:center">Zip Code: <input style="margin-right: 65px" type='text' name='zip' size='15' maxlength='20' value = ''></p>";
	echo "<p style="text-align:center"><input type='submit' name='register' value='Register'></p>";
	echo "</form>";
	}
	
	function search(){	
		//get dealer table for id search
		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		//echo $file;
		$sql = "SELECT * FROM dealer ORDER BY name";
		//echo $sql;
		$result = mysqli_query($db, $sql);
		echo "<div class='container'>";
  		echo "<h2>Find Dealer Close By</h2>";
		echo "<input id='myInput' type='text' placeholder='Dealer Search..'>";          
  		echo "<table class='table'>";
    		echo "<thead>";
      		echo "<tr>";
        	//echo "<th>Dealer ID</th>";
        	echo "<th>Name</th>";
        	echo "<th>Manager</th>";
        	echo "<th>City</th>";
        	echo "<th>State</th>";
		echo "<th>Zip Code</th>";
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
        	//echo "<td>" . $d_id . "</td>";
		echo "<td>" . $name . "</td>";
        	echo "<td>" . $row2['f_name'] . " " . $row2['l_name'] . "</td>";
		echo "<td>" . $city . "</td>";
        	echo "<td>" . $state . "</td>";
		echo "<td>" . $row['zip_code'] . "</td>";
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
