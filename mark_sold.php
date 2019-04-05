<?php
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
			$vin = $_POST['a_v'];
			$sold_d = $_POST['sold_d'];
			$sold_p = $_POST['sold_p'];
			$sold_e = $_POST['sold_e'];
			$did = $_POST['did'];
			if ($sold_d != '' && $sold_p != '' && $sold_e != '' && $did != ''){
			$this->in_sold($vin, $sold_d, $sold_p, $sold_e, $did);}
			else {
				echo "Please fill out the form";
			}
		}
	}

	
	function loadcar(){
		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		//echo $file;
		$sql = "SELECT * FROM vehicle v WHERE v.vin_num NOT IN (SELECT s.vin_num FROM sale s)";
		//echo $sql;
		$result = mysqli_query($db, $sql);
		while($row = mysqli_fetch_assoc($result))
    		{
		$vin = $row['vin_num'];
		$model = $row['model'];
		$year = $row['year'];
		$color = $row['color'];
		$msrp = $row['msrp'];
		$sql2 = "SELECT d_id FROM inventory i WHERE i.vin_num = '$vin'";
		//echo $sql;
		$result2 = mysqli_query($db, $sql2);
		$row2 = mysqli_fetch_assoc($result2);
		$did = $row2['d_id'];
		
		echo "Vin:" . $vin . " Model:" . $model . " Year:" . $year . " Color:" . $color . " MSRP:" . $msrp . " ";
		echo "<form action='mark_sold.php' method='POST' >";
		echo "<input type='hidden' name='a_v' value = '$vin'>";
		echo "<input type='hidden' name='did' value = '$did'>";
		echo "<br>Sold Date: ";
		echo "<input type='date' name='sold_d' value = ''>";
		echo "Sold Price: ";
		echo "<input type='text' name='sold_p' value = ''>";
		echo "Employee ID: ";
		echo "<input type='text' name='sold_e' value = ''>";
		echo "<input type='submit' name='carsold' value= 'Mark As Sold'>";
		echo "</form>";
		echo "<br>";
	        }	
	}	
	
	function in_sold($vin, $sold_d, $sold_p, $sold_e, $did){
		$conn = new mysqli(db_servername, db_username, db_pass, db_dbname);
		$sql = "INSERT INTO `sale`(`e_id`,`d_id`, `vin_num`, `sold_d`, `sold_p`) VALUES ('$sold_e', '$did', '$vin','$sold_d', '$sold_p')";
		if ($conn->query($sql) === TRUE) {
   			 echo "<br>******The car is sold******";
    			 header("location:index.php");
		}else {
    			echo "Error: The car has already been sold. <br>";
		}
	}
}


//implement
$load = new sale_car();
?>
