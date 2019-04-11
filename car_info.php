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
//to modify vehicle status (move it to sold, transfer, etc)
include('connect.php');
//echo "Hello " . $_GET['vin']; 
class load_car{
	var $message = array();
	function __construct(){
		$this->loadcar();
  	}
		function loadcar(){
		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		//echo $file;
		$vin = $_GET['vin'];
		$sql = "SELECT * FROM vehicle WHERE vin_num = '$vin'";
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_assoc($result);
		$vin = $row['vin_num'];
		$make = $row['make'];
		$model = $row['model'];
		$year = $row['year'];
		$color = $row['color'];
		$msrp = $row['msrp'];
		$picture = $vin . ".jpg";
		//echo $picture;
		echo "<img src='picture/". $picture . "'  width='300'>" . "<br>";
        	echo "Vin Number: " . $vin . "<br>";
		echo "Make: " . $make . "<br>";
        	echo "Model: " . $model . "<br>";
        	echo "Year: " . $year . "<br>";
        	echo "Color: " . $color . "<br>";
        	echo "MSRP: " . $msrp . "<br>";
		//echo "Vin:" . $vin . " Model:" . $model . " Year:" . $year . " Color:" . $color . " MSRP:" . $msrp . " ";

		//check if the car is sold
		$sql1 = "SELECT * FROM sale s, dealer d, employee e WHERE s.vin_num = '$vin' AND d.d_id = s.d_id AND e.e_id = s.e_id";
		$result2 = mysqli_query($db, $sql1);
		$row = mysqli_fetch_assoc($result2);
		$sql3 = "SELECT d.name FROM dealer d, inventory i WHERE i.vin_num = '$vin' && i.d_id=d.d_id";
		$result3 = mysqli_query($db, $sql3);
		$row3 = mysqli_fetch_assoc($result3);
		$dealer = $row3['name'];
		echo "Availability: ";
		if ($row == 0){
		echo "AVAILABLE ";
		echo "Location: " . $dealer . "<br>";
		echo "<button class='button button1' type='button' id='sold'> Mark As Sold</button>";
		echo "        ";
		echo "<button class='button button1' type='button' id='trans'> Transfer</button>";	
		echo "        ";
		echo "<button class='button button1' type='button' id='delete'> Delete</button><br><br>";	
		}
		else
		{echo "SOLD<br>";
		echo "Sold by: " . $row['f_name'] . " " . $row['l_name'] . "<br>";
		echo "Sold date: " . $row['sold_d'] . "<br>";
		echo "Sold price: $" . $row['sold_p'] . "<br>";
		echo "Location: " . $dealer . "<br><br>";
		}


echo "<script>";
//action for mark sold
echo "$(document).ready(function(){";
echo "$('#sold').on('click', function() {";
echo "$('#content2').load('mark_sold.php?vin=$vin')";	
echo  "});";
echo "});";
//action for transfer
echo "$(document).ready(function(){";
echo "$('#trans').on('click', function() {";
echo "$('#content2').load('transf_car.php?vin=$vin')";	
echo  "});";
echo "});";
echo "$(document).ready(function(){";
echo "$('#delete').on('click', function() {";
echo "$('#content').load('delete_car.php?vin=$vin')";	
echo  "});";
echo "});";
echo "</script>";


		}
}
$load = new load_car();	
?> 


</div>
</body>
</html>
