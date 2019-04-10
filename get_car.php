<!DOCTYPE html>
<html lang="en">
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
       <title>DMS - Welcome </title>
       <link rel="stylesheet" href="main.css">
   </head>
 
<body>
       <ul>
           <li style="float:left"><a><img src="img/CircleLogo.png" alt="circle" width="20" height="20"> Welcome to DMS</a></li>
            <li><a href="get_car.php?did=0">Vehicles</a></li>
           <li><a href= "get_dealer.php">Dealerships</a></li>
       </ul>
       <br>
       <p> </p>
       <center>    

<button class="button button1" type="button" id="add_car">Add New Vehicle</button>
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
<script>
$(document).ready( function() {
	$("#add_car").on("click", function() {
		$("#content").load("upload_veh.php?did=<?php echo $_GET['did']; ?>");
		$("#content2").text("");	
		$("#content3").text("");	
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
//echo $_GET['did'];
include('connect.php');

		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		$did = $_GET['did']; 
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
        	echo "<td><a href='#' id='vin$i'>" . $vin . "</a></td>";
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
echo "<script>";
//get vin
for ($v = 0; $v < $i; $v++){
echo "$(document).ready(function(){";
echo "$('#vin$v').on('click', function() {";
echo "$('#content').load('car_info.php?vin=$vin_array[$v]')";	
echo  "});";
echo "});";
}
echo "</script>";
		

?>

</tbody>
  		</table>
		</div>
</div>
</body>
</html>
