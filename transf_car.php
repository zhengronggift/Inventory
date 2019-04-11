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
//echo "Hello " . $_GET['vin']; 
//transfer car
include('connect.php');
class tranf_car{
	function __construct(){
		$this->loadcar();
		$this->receivem();
  	}

	function receivem(){
		if(isset($_POST['transfer']))
		{
			$vin = $_GET['vin'];	
			$vin = $_POST['a_v'];
			$tran = $_POST['trans_dealer'];
			$did = $_POST['did'];
			if ($tran != ''){
			//make sure destination dealer id is correct and is not equal to original dealer
			$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
			$sql = "SELECT d_id FROM dealer WHERE d_id = '$tran'";
			$result = mysqli_query($db, $sql);
			$row = mysqli_fetch_assoc($result);
			if ($row != 0 && $did != $tran){
				$this->in_sold($vin, $tran);
			}
			elseif ($row == 0) {
				echo "This dealer does not exist";
			}elseif ($did == $tran){echo "The vehicle is with this dealer, please select another dealer";}
			else{echo "Error, please check your input";}
			}
			else {
				echo "Please fill out the form.";
			}
		}
	}

	
	function loadcar(){
		$vin = $_GET['vin'];
		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		$sql = "SELECT d_id FROM inventory WHERE vin_num = '$vin'";
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_assoc($result);
		$did = $row['d_id'];
		echo "<p><font size='4'>Transfer Vehicle: " . $vin . "</font></p>";
		echo "<form action='transf_car.php?vin=$vin' method='POST' >";
		echo "<input type='hidden' name='a_v' value = '$vin'>";
		echo "<p>Transfer from: " . $did . "<br>";
		echo "<input type='hidden' name='did' value = '$did'>";
		echo "<br><p>Transfer to: ";
		echo "<input type='text' name='trans_dealer' value = ''><br><br>";
		echo "<button type='submit' class='button button1' name='transfer' value= 'Transfer'>Transfer</button>";
		echo "</form>";
		echo "<br>";
	}	
	
	function in_sold($vin, $tran){
		$conn = new mysqli(db_servername, db_username, db_pass, db_dbname);
		$sql = "UPDATE `inventory` SET `d_id`='$tran' WHERE `vin_num`='$vin'";
		if ($conn->query($sql) === TRUE) {
   			 echo "<p>The car is transferred</p>";
    			 echo "<p>Go back to the <a href = 'car_info.php?vin=$vin'>Vehicle</a></p>";
		}else {
    			echo "Error: Not sure what happened, but check your values. <br>";
		}

	}
}

//include('get_emp.php');
//implement
$load = new tranf_car();
?>

</div>
</body>
</html>
