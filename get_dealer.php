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

<style>
div.gallery {
  border: 3px solid #0f8eeaf7;

}

div.gallery:hover {
  border: 3px solid #0f8eeaf7;
}

div.gallery img {
  width: 100%;
  height: auto;
}

div.desc {
  padding: 15px;
  text-align: center;
}

* {
  box-sizing: border-box;
}

.responsive {
  padding: 0 6px;
  float: center;
  width: 24.99999%;
}

@media only screen and (max-width: 700px) {
  .responsive {
    width: 49.99999%;
    margin: 6px 0;
  }
}

@media only screen and (max-width: 500px) {
  .responsive {
    width: 100%;
  }
}

.clearfix:after {
  content: "";
  display: table;
  clear: both;
}

#left
{
  float: left;
}

#center
{
  float: center;
}

#right
{
  float: right;
}

</style>


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
		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		//echo $file;
		$sql = "SELECT * FROM dealer ORDER BY name";
		//echo $sql;
		$result = mysqli_query($db, $sql);
		echo "<div class='container'>";
  		echo "<h2>Dealerships</h2>";
  		echo "<div id='center'><input id='myInput' type='text' placeholder='Search..'></div>";
?>

<div id="left">
<button class="button button1" type="button" onclick="window.location.href = 'add_dealer.php';">Add Dealership</button>
</div>
<script>
$(document).ready( function() {
	$("#add_dealer").on("click", function() {
		$("#content").load("add_dealer.php");	
		$("#content2").text("");
		$("#content3").text("");	
	});
});
</script>

<?php
  		echo "<br><br><table class='table table-bordered'>";
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
		echo "<td><a href = 'dealer_info.php?did=$d_id'>" . $name . "</a></td>";
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
echo "</script>";
		echo "</tbody>";
  		echo "</table>";
		echo "</div>";	
	

?>

</div>
</body>
</html>
