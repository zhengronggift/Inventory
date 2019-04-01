<?php
include('connect.php');
class MessageBoard{
	var $message = array();
	function __construct(){
		$this->showform();
		$this->receivem();
  	}

	function showform(){
		echo "<form action='' method='POST' >";
		echo "<input type='submit' name='categ' value='Category'>";
		echo "<input type='submit' name='location' value='Location'>";
		echo "</form>";
	}

	function receivem(){
		if(isset($_POST['categ']))
		{
			$this->loadm();
		}
		
		if(isset($_POST['location']))
		{	
			$this->location();
		}
		
		if(isset($_POST['make']))
		{	
			$make = $_POST['make'];
			$this->loadcar($make);
		}
		
		if(isset($_POST['dealer']))
		{	
			$dealer = $_POST['dealer'];
			$this->getinven($dealer);
		}
		
		if(isset($_POST['sold']))
		{	
			$vin = $_POST['a_v'];
			$this->carsold($vin);
		}
		
		if(isset($_POST['mk']))
		{	
			$vin = $_POST['ad_v'];
			$this->carsold($vin);
		}

		if(isset($_POST['carsold']))
		{	
			$vin = $_POST['vin_num'];
			$sold_p = $_POST['sold_p'];
			if ($sold_p != ''){
			$this->in_sold($vin, $sold_p);}
			else {
				$this->carsold($vin);
				echo "Please select a date.";
			}
		}
	}

	function loadm(){
		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		//echo $file;
		$sql = "SELECT DISTINCT `make` FROM `vehicle`";
		//echo $sql;
		$result = mysqli_query($db, $sql);
		while($row = mysqli_fetch_assoc($result))
    		{
        	$make = $row['make'];
	        echo "<br>";
		echo "<form action='' method='POST' >";
		echo "<input type='submit' name='make' value= $make>";
		echo "</form>";
	        }

	}

	function location(){
		//echo "<form action='' method='POST' >";
		//echo "Zip Code: <input type='text' name = 'zipc' value = ''>";
		//echo "<input type='submit' name='zip' value= 'Go'>";
		//echo "</form>";
		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		//echo $file;
		$sql = "SELECT * FROM `dealer`";
		//echo $sql;
		$result = mysqli_query($db, $sql);
		while($row = mysqli_fetch_assoc($result))
    		{
		$d_id = $row['d_id'];
		$city = $row['city'];
		$state = $row['state'];
		$zip_code = $row['zip_code'];
		$name = $row['name'];
		echo "<br>";
		echo "<form action='' method='POST' >";
		echo "<input type='submit' name='dealer' value= $name>";
		echo "</form>";
		echo "Dealer ID:" . $d_id . " Location:" . ucfirst($city) . ", " . ucfirst($state) . ", " . $zip_code;
		echo "<br>";
	        }	
	}
	
	function loadcar($make){
		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		//echo $file;
		$sql = "SELECT * FROM `vehicle` WHERE `make` = '$make'";
		//echo $sql;
		$result = mysqli_query($db, $sql);
		echo $make . "<br>";
		while($row = mysqli_fetch_assoc($result))
    		{
		$vin = $row['vin_num'];
		$model = $row['model'];
		$year = $row['year'];
		$color = $row['color'];
		$msrp = $row['msrp'];
		
		echo "Vin:" . $vin . " Model:" . $model . " Year:" . $year . " Color:" . $color . " MSRP:" . $msrp . " ";

		//check if the car is sold
		$sql1 = "SELECT vin_num FROM sale WHERE vin_num = '$vin'";
		$result2 = mysqli_query($db, $sql1);
		$row = mysqli_fetch_assoc($result2);
		if ($row == 0){
		echo "<form action='' method='POST' >";
		echo "<input type='hidden' name='a_v' value = '$vin'>";
		echo "<input type='submit' name='sold' value= 'Mark As Sold'>";
		echo "</form>";
		echo "<br>";}
		else
		{echo "<br>SOLD <br><br>";}
	        }	
	}	

	function getinven($dealer){

		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		//echo $file;
		$sql = "SELECT * FROM vehicle v, dealer d, inventory i WHERE d.name = '$dealer' AND i.d_id = d.d_id AND v.vin_num = i.vin_num";
		//echo $sql;
		$result = mysqli_query($db, $sql);


		echo "Dealer: " .$dealer . "<br><br>";
		while($row = mysqli_fetch_assoc($result))
    		{
		$vin = $row['vin_num'];
		$model = $row['model'];
		$year = $row['year'];
		$color = $row['color'];
		$msrp = $row['msrp'];
		echo "Vin:" . $vin . " Model:" . $model . " Year:" . $year . " Color:" . $color . " MSRP:" . $msrp . " ";

		//check if the car is sold
		$sql1 = "SELECT vin_num FROM sale WHERE vin_num = '$vin'";
		$result2 = mysqli_query($db, $sql1);
		$row = mysqli_fetch_assoc($result2);
		if ($row == 0){
		echo "<form action='' method='POST' >";
		echo "<input type='hidden' name='ad_v' value = '$vin'>";
		echo "<input type='submit' name='mk' value= 'Mark As Sold'>";
		echo "</form>";
		echo "<br>";}
		else
		{echo "<br>SOLD <br><br>";}
	        }		
	}
	
	function carsold($vin){
		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		$sql = "SELECT * FROM vehicle WHERE vin_num = '$vin'";
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_assoc($result);
		$make = $row['make'];
		$model = $row['model'];
		$year = $row['year'];
		$color = $row['color'];
		$msrp = $row['msrp'];
		echo "<form action='' method='POST' >";
		echo "Car Vin Number: " . $vin . "<br>";
		echo "Make: " . $make . "      Model: " . $model . "<br>";
		echo "Year: " . $year . "      Color: " . $color . "<br>";
		echo "MSRP: " . $msrp . "<br>";
		echo "Sold Date: ";
		echo "<input type='date' name='sold_p' value = ''>";
		echo "<input type='hidden' name='vin_num' value = '$vin'>";
		echo "<input type='submit' name='carsold' value= 'Sold'>";
		echo "</form>";
		echo "<br>";		
		
	}
	
	function in_sold($vin, $sold_p){
		$eid = $_SESSION['e_id'];
		$did = $_SESSION['d_id'];
		$conn = new mysqli(db_servername, db_username, db_pass, db_dbname);
		$sql = "INSERT INTO `sale`(`e_id`,`d_id`, `vin_num`, `sold_d`) VALUES ('$eid', '$did', '$vin','$sold_p')";
		if ($conn->query($sql) === TRUE) {
   			 echo "<br>******The car is sold******";
    			// header("location:index.php");
		}else {
    			echo "Error: The car has already been sold. <br>";
		}
	}
}


//implement

?>
