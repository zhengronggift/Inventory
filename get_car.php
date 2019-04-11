<!DOCTYPE html>
<html lang="en">
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
       <title>Dealership Inventory</title>
       <link rel="stylesheet" href="main.css">
       <link rel="stylesheet" href="style.css">
</head>
 
<body>
       <ul>
           <li style="float:left"><a><img src="Rice&Beans_Logo.PNG" alt="circle" width="20" height="20"> Welcome to DMS</a></li>
            <li><a href="get_car.php?did=0">Vehicles</a></li>
           <li><a href= "get_dealer.php">Dealerships</a></li>
       </ul>
       <br>
       <p> </p> 
       <center>    
<?php 
include('connect.php');
$did = $_GET['did']; 
if ($did != 0){

		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		//echo $file;
		$did = $_GET['did'];
		$sql = "SELECT * FROM dealer WHERE d_id = '$did'";
		$sql2 = "SELECT * FROM manage m, employee e WHERE m.d_id = '$did' AND e.e_id = m.e_id";
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_assoc($result);
		$result2 = mysqli_query($db, $sql2);
		$row2 = mysqli_fetch_assoc($result2);
		$city = $row['city'];
		$state = $row['state'];
		$zip = $row['zip_code'];
		$name = $row['name'];
		$m_f = $row2['f_name'];
		$m_l = $row2['l_name'];
	
        	echo $name . " (Dealer ID:" . $did . ")<br>";
		echo $city . ", ";
        	echo $state . ", ";
        	echo $zip . "<br> ";
        	echo "Store Manager: " . $m_f . " " . $m_l . "<br>";

echo "<form action='get_emp.php?did=$did' method='post'>";
echo "<p style='text-align:center'><button type='submit' class='button button1' name='submit' value='Employees'>Employees</button></p>";
echo "</form>";

}





?>
<br>
<br>
<button class="button button1" type="button" onclick="window.location.href = 'upload_veh.php?did=<?php echo $did; ?>';">Add New Vehicle</button>
<script>
$(document).ready(function(){
$("#myInput").on("keyup", function() {
var value = $(this).val().toLowerCase();
$("#myTable tr").filter(function() {
$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
});
});
});
</script>

		<div class="container">
  		<h2>Vehicle Inventory</h2>
  		<input id="myInput" type="text" placeholder="Search..">         
  		<br><br><table class="table table-bordered">
    		<thead>
      		<tr>
        	<th>VIN #</th>
		<th>Year</th>
        	<th>Make</th>
        	<th>Model</th>
        	<th>Color</th>
		<th>Dealership</th>
		<th>MSRP</th>
		<th>Availability</th>
      		</tr>
    		</thead>
    		<tbody id="myTable">
<?php
//get table for vehicles

		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		//$did = $_GET['did']; 
		//echo $file;
		if ($did == 0){
		$sql = "SELECT * FROM vehicle ORDER BY make";}
		elseif ($did != 0){$sql = "SELECT * FROM inventory i, vehicle v WHERE i.d_id = '$did' AND v.vin_num = i.vin_num";}
		//echo $sql;
		$result = mysqli_query($db, $sql);
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
        	echo "<td><a href = 'car_info.php?vin=$vin'>" . $vin . "</a></td>";
		$vin_array[$i] = $vin;
		echo "<td>" . $year . "</td>";
		echo "<td>" . $make . "</td>";
        	echo "<td>" . $model . "</td>";
        	echo "<td>" . $color . "</td>";
		$sql3 = "SELECT d.name FROM dealer d, inventory i WHERE i.vin_num = '$vin' && i.d_id=d.d_id";
		$result3 = mysqli_query($db, $sql3);
		$row3 = mysqli_fetch_assoc($result3);
		$dealer = $row3['name'];
		echo "<td>" . $dealer . "</td>";

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
		}

?>

</tbody>
</table>
</div>
</div>
</body>
</html>
