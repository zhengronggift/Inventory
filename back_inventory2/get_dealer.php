<?php
include('connect.php');
class load_dealer{
	var $message = array();
	function __construct(){
		$this->loadcar();
  	}

	function loadcar(){
		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		//echo $file;
		$sql = "SELECT * FROM dealer ORDER BY name";
		//echo $sql;
		$result = mysqli_query($db, $sql);
		echo "<div class='container'>";
  		echo "<h2>Dealer Table</h2>";
  		echo "<input id='myInput' type='text' placeholder='Search..'>";          
  		echo "<table class='table'>";
    		echo "<thead>";
      		echo "<tr>";
        	echo "<th>Dealer ID</th>";
        	echo "<th>Name</th>";
        	echo "<th>Manager</th>";
        	echo "<th>City</th>";
        	echo "<th>State</th>";
        	echo "<th>Zip Code</th>";
        	echo "<th>Number of Employees</th>";
        	echo "<th>Number of Vehicles</th>";
      		echo "</tr>";
    		echo "</thead>";
    		echo "<tbody id='myTable'>";
		$i = 0;
		while($row = mysqli_fetch_assoc($result))
    		{
		$d_id = $row['d_id'];
		$name = $row['name'];
		$sql2 = "SELECT e.f_name, e.l_name FROM dealer d, employee e, manage m WHERE d.d_id = '$d_id' AND m.d_id = '$d_id' AND e.e_id = m.e_id";
		$result2 = mysqli_query($db, $sql2);
		$row2 = mysqli_fetch_assoc($result2);
		$sql3= "SELECT d_id, count(d_id) as num_vehicles FROM inventory WHERE d_id = '$d_id'";
		$result3 = mysqli_query($db, $sql3);
		$row3 = mysqli_fetch_assoc($result3);
		$sql4= "SELECT e_id, count(e_id) as num_emp FROM employee WHERE d_id = '$d_id'";
		$result4 = mysqli_query($db, $sql4);
		$row4 = mysqli_fetch_assoc($result4);
		$city = $row['city'];
		$state = $row['state'];
		$zip_code = $row['zip_code'];
		//$emp = $row['employee'];
		//$num = $row['num'];
		echo "<tr>";
        	echo "<td>" . $d_id . "</td>";
		echo "<td><a href='#' id='vin$i'>" . $name . "</a></td>";
		$vin_array[$i] = $d_id;
		$i++;
        	echo "<td>" . $row2['f_name'] . " " . $row2['l_name'] . "</td>";
		echo "<td>" . $city . "</td>";
        	echo "<td>" . $state . "</td>";
        	echo "<td>" . $zip_code . "</td>";
		echo "<td>" . $row4['num_emp'] . "</td>";
		echo "<td>" . $row3['num_vehicles'] . "</td>";
		}
echo "<script>";
//search
echo "$(document).ready(function(){";
echo "$('#myInput').on('keyup', function() {";
echo "var value = $(this).val().toLowerCase();";
echo  "$('#myTable tr').filter(function() {";
echo  "$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)";
echo   "});";
echo  "});";
echo "});";
//get vin
for ($v = 0; $v < $i; $v++){
echo "$(document).ready(function(){";
echo "$('#vin$v').on('click', function() {";
echo "$('#content').load('dealer_info.php?did=$vin_array[$v]')";	
echo  "});";
echo "});";
}
echo "</script>";
		echo "</tbody>";
  		echo "</table>";
		echo "</div>";	
	}	

}

$load2 = new load_dealer();
//implement

?>

<button class="button button1" type="button" id="add_dealer">Add Dealership</button>