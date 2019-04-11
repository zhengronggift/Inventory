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
//to get dealer info
include('connect.php');
//echo "Hello " . $_GET['did']; 
class load_car{
	var $message = array();
	function __construct(){
		$this->loadcar();
  	}
		function loadcar(){

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
		//echo " <button type='button' id='inventory'>Vehicle Inventory</button> ";
		//echo " <button type='button' id='employee'>Employees</button> ";
		//echo "<button type='button' id='sold'>Sold Vehicles</button><br>";

		}
}
$load = new load_car();	

?> 

<button class="button button1" type="button" id="veh">Vehicle Inventory</button>
<button class="button button1" type="button" id="emp">Employees</button>

<div id = "content" class="container">

</div>

<script>
$(document).ready( function() {
	$("#veh").on("click", function() {
		$("#content").load("get_car.php?did=<?php echo $did; ?>");
		$("#content2").text("");
		$("#content3").text("");	
	});
});
$(document).ready( function() {
	$("#emp").on("click", function() {
		$("#content").load("get_emp.php?did=<?php echo $did; ?>");	
		$("#content2").text("");
		$("#content3").text("");	
	});
});
</script>


</div>
</body>
</html>
