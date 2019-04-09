<?php
//get table for vehicles
include('connect.php');
class load_car{
	var $message = array();
	function __construct(){
		$this->loadcar();
  	}

	function loadcar(){
		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		$did = $_GET['did']; 
		//echo $file;
		if ($did == 0){
		$sql = "SELECT * FROM vehicle ORDER BY make";}
		elseif ($did != 0){$sql = "SELECT * FROM vehicle WHERE d_id = '$did' ORDER BY make";}
		//echo $sql;
		$result = mysqli_query($db, $sql);
		echo "<div class='container'>";
  		echo "<h2>Vehicle Table</h2>";
  		echo "<input id='myInput' type='text' placeholder='Search..'>";            
  		echo "<table class='table'>";
    		echo "<thead>";
      		echo "<tr>";
        	echo "<th>Vin Number</th>";
        	echo "<th>Make</th>";
        	echo "<th>Model</th>";
        	echo "<th>Year</th>";
        	echo "<th>Color</th>";
        	echo "<th>MSRP</th>";
        	echo "<th>Availability</th>";
		echo "<th>Location</th>";
      		echo "</tr>";
    		echo "</thead>";
    		echo "<tbody id='myTable'>";
		$i = 0;
		while($row = mysqli_fetch_assoc($result))
    		{
		
		$vin = $row['vin_num'];
		$make = $row['make'];
		$model = $row['model'];
		$year = $row['year'];
		$color = $row['color'];
		$msrp = $row['msrp'];
		echo "<tr>";
        	echo "<td><a href='#' id='vin$i'>" . $vin . "</a></td>";
		$vin_array[$i] = $vin;
		echo "<td>" . $make . "</td>";
        	echo "<td>" . $model . "</td>";
        	echo "<td>" . $year . "</td>";
        	echo "<td>" . $color . "</td>";
        	echo "<td>" . $msrp . "</td>";
		$i++;
		//echo "Vin:" . $vin . " Model:" . $model . " Year:" . $year . " Color:" . $color . " MSRP:" . $msrp . " ";

		//check if the car is sold
		$sql1 = "SELECT vin_num FROM sale WHERE vin_num = '$vin'";
		$result2 = mysqli_query($db, $sql1);
		$row = mysqli_fetch_assoc($result2);
		if ($row == 0){
		echo "<td>AVAILABLE</td>";}
		else
		{echo "<td>SOLD</td>";}
	       // }
		$sql3 = "SELECT d.name FROM dealer d, inventory i WHERE i.vin_num = '$vin' && i.d_id=d.d_id";
		$result3 = mysqli_query($db, $sql3);
		$row3 = mysqli_fetch_assoc($result3);
		$dealer = $row3['name'];
		echo "<td>" . $dealer . "</td>";}
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
echo "$('#content').load('car_info.php?vin=$vin_array[$v]')";	
echo  "});";
echo "});";
}
echo "</script>";
		echo "</tbody>";
  		echo "</table>";
		echo "</div>";	
		}
	}	



$load = new load_car();
//implement

?>
<button href="button button1">Add Vehicle</button>