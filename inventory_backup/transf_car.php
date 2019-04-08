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
		echo "Transfer Vehicle: " . $vin . "<br>";
		echo "<form action='transf_car.php?vin=$vin' method='POST' >";
		echo "<input type='hidden' name='a_v' value = '$vin'>";
		echo "Transfer from: " . $did . "<br>";
		echo "<input type='hidden' name='did' value = '$did'>";
		//echo "<br>Sold Date: ";
		//echo "<input type='date' name='sold_d' value = ''><br>";
		//echo "Sold Price: ";
		//echo "<input type='text' name='sold_p' value = ''><br>";
		echo "Transfer to: ";
		echo "<input type='text' name='trans_dealer' value = ''><br>";
		echo "<input type='submit' name='transfer' value= 'Transfer'>";
		echo "</form>";
		echo "<br>";
	}	
	
	function in_sold($vin, $tran){
		$conn = new mysqli(db_servername, db_username, db_pass, db_dbname);
		$sql = "UPDATE `inventory` SET `d_id`='$tran' WHERE `vin_num`='$vin'";
		if ($conn->query($sql) === TRUE) {
   			// echo "<br>******The car is sold******";
    			 header("location:index.php");
		}else {
    			echo "Error: Not sure what happened, but check your values. <br>";
		}

	}
}

//include('get_emp.php');
//implement
$load = new tranf_car();
?>
