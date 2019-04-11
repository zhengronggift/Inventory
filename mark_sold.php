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
include('connect.php');
		$vin = $_GET['vin'];
		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		$sql = "SELECT d_id FROM inventory WHERE vin_num = '$vin'";
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_assoc($result);
		$did = $row['d_id'];
?>

<p>Selling Vehicle: <?php echo $vin; ?> </p>
<form action="mark_sold.php?vin=<?php echo $vin; ?>" method="POST">
<input type="hidden" name="a_v" value = "$vin">
<input type="hidden" name="did" value = "$did">
<p>Sold Date: </p>
<input type="date" name="sold_d" value = ""><br>
<p>Sold Price: </p>
<input type="text" name="sold_p" value = ""><br>
<p>Employee ID: </p>
<input type="text" name="sold_e" value = ""><br>
<input type="submit" class="button button1" name="carsold" value= "Mark As Sold">
</form>
<br>


<?php
//echo "Hello " . $_GET['vin']; 
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

</div>
</body>
</html>
