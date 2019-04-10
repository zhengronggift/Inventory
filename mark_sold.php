<?php
//echo "Hello " . $_GET['vin']; 

include('connect.php');
class sale_car{
	var $message = array();
	function __construct(){
		$this->loadcar();
		$this->receivem();
  	}

	function receivem(){
		if(isset($_POST['carsold']))
		{
$vin = $_GET['vin'];	
			$vin = $_POST['a_v'];
			$sold_d = $_POST['sold_d'];
			$sold_p = $_POST['sold_p'];
			$sold_e = $_POST['sold_e'];
			$did = $_POST['did'];
			if ($sold_d != '' && $sold_p != '' && $sold_e != '' && $did != ''){
			//make sure employee id is correct
			$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
			$sql = "SELECT e.e_id FROM employee e, dealer d WHERE e.e_id = '$sold_e' AND e.d_id = '$did'";
			$result = mysqli_query($db, $sql);
			$row = mysqli_fetch_assoc($result);
			if ($row != 0){
				$this->in_sold($vin, $sold_d, $sold_p, $sold_e, $did);}
			elseif ($row == 0) {
				echo "This employee does not work in this dealer, please try again";
			}
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
		echo "Selling Vehicle: " . $vin . "<br>";
		echo "<form action='mark_sold.php?vin=$vin' method='POST' >";
		echo "<input type='hidden' name='a_v' value = '$vin'>";
		echo "<input type='hidden' name='did' value = '$did'>";
		echo "<br>Sold Date: ";
		echo "<input type='date' name='sold_d' value = ''><br>";
		echo "Sold Price: ";
		echo "<input type='text' name='sold_p' value = ''><br>";
		echo "Employee ID: ";
		echo "<input type='text' name='sold_e' value = ''><br>";
		echo "<input type='submit' class='button button1' name='carsold' value= 'Mark As Sold'>";
		echo "</form>";
		echo "<br>";
	}	
	
	function in_sold($vin, $sold_d, $sold_p, $sold_e, $did){
		$conn = new mysqli(db_servername, db_username, db_pass, db_dbname);
		$sql = "INSERT INTO `sale`(`e_id`,`d_id`, `vin_num`, `sold_d`, `sold_p`) VALUES ('$sold_e', '$did', '$vin','$sold_d', '$sold_p')";
		if ($conn->query($sql) === TRUE) {
   			// echo "<br>******The car is sold******";
    			 header("location:index.php");
		}else {
    			echo "Error: The car has already been sold. <br>";
		}

	}
}

//include('get_emp.php');
//implement
$load = new sale_car();
?>
