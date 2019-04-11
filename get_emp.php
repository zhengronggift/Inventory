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
$did = $_GET['did']; 
if ($did != 0){
echo "<div class='responsive'>";
echo "<div class='gallery'>";
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
	
        	echo "<br><font size='4'>" . $name . " (Dealer ID:" . $did . ")</font><br><br>";
		echo $city . ", ";
        	echo $state . ", ";
        	echo $zip . "<br> ";
        	echo "Store Manager: <b>" . $m_f . " " . $m_l . "</b><br><br>";
		echo "</div></div><br>";
echo "<form action='get_car.php?did=$did' method='post'>";
echo "<p style='text-align:center'><button type='submit' class='button button1' name='submit' value='Vehicle Inventory'>Vehicle Inventory</button></p>";
echo "</form>";

}

?>




<?php

		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		//echo $file;
		$did = $_GET['did']; 
		$sql = "SELECT * FROM employee WHERE d_id = '$did' ORDER BY l_name";
		//echo $sql;
		$result = mysqli_query($db, $sql);
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
?>

		<div class="container">
  		<h2>Employee Table</h2>
		<div id="center">
  		<input id="myInput" type="text" placeholder="Search..">    
		</div>
<br>
<div id="left">
<button class="button button1" type="button" onclick="window.location.href ='reg_emp.php?did=<?php echo $_GET['did']; ?>';">Add New Employees</button>
</div>
<?php        
  		echo "<br><br><table class='table table-bordered'>";
    		echo "<thead>";
      		echo "<tr>";
        	echo "<th>Employee ID</th>";
        	echo "<th>Last Name</th>";
		echo "<th>First Name</th>";
        	echo "<th>Job Location</th>";
        	echo "<th>Car Sold</th>";
      		echo "</tr>";
    		echo "</thead>";
    		echo "<tbody id='myTable'>";
		while($row = mysqli_fetch_assoc($result))
    		{
		$e_id = $row['e_id'];
		$f_name = $row['f_name'];
		$l_name = $row['l_name'];
		$sql2 = "SELECT d.name FROM dealer d, employee e WHERE e.e_id = '$e_id' AND d.d_id = e.d_id";
		//echo $sql;
		$result2 = mysqli_query($db, $sql2);
		$row2 = mysqli_fetch_assoc($result2);
		$sql3 = "SELECT e_id, count(e_id) as num_sold FROM sale WHERE e_id = '$e_id'";
		//echo $sql;
		$result3 = mysqli_query($db, $sql3);
		$row3 = mysqli_fetch_assoc($result3);
		//$location = $row['location'];
		//$sold = $row['sold'];
		echo "<tr>";
        	echo "<td>" . $e_id . "</td>";
		echo "<td>" . $l_name . "</td>";
		echo "<td>" . $f_name . "</td>";
        	echo "<td>" . $row2['name'] . "</td>";
        	echo "<td>" . $row3['num_sold'] . "</td>";
	        }
		echo "</tbody>";
  		echo "</table>";
		echo "</div>";	
	
?>

</div>
</body>
</html>
