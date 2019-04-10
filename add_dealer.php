<!DOCTYPE html>
<html lang="en">
   <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
       <title>Dealership Inventory</title>
       <link rel="stylesheet" href="main.css">
       <link rel="stylesheet" href="style.css">
   </head>
 
<body>
       <ul>
           <li style="float:left"><a><img src="Rice&Beans_Logo.PNG" alt="rice&beans" width="20" height="20"> Welcome to DMS</a></li>
            <li><a href="get_car.php?did=0">Vehicles</a></li>
           <li><a href= "get_dealer.php">Dealerships</a></li>
       </ul>

<p style="text-align:center">Add A Dealer</p>
<form action="dealer_back.php" method="POST">
<p style="text-align:center">Dealer Name: <input style="margin-right: 86px" type="text" name="d_name" size="15" maxlength="20" value = ""></p>
<p style="text-align:center">City: <input style="margin-right: 30px" type="text" name="city" size="15" maxlength="20" value = ""></p>
<p style="text-align:center">State: <input style="margin-right: 38px" type="text" name="state" size="15" maxlength="20" value = ""></p>
<p style="text-align:center">Zip Code: <input style="margin-right: 65px" type="text" name="zip" size="15" maxlength="20" value = ""></p>
<p style="text-align:center"><input class="button button1" type="submit" name="register" value="Register"></p>
</form>


<?php
include('connect.php');
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

		//get dealer table for id search
		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		//echo $file;
		$sql = "SELECT * FROM dealer ORDER BY name";
		//echo $sql;
		$result = mysqli_query($db, $sql);
		echo "<div class='container'>";
  		echo "<h2>Find Dealerships Nearby</h2>";
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

?>
    </body>
</html>
