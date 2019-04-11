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
$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
$vin = $_GET['vin'];
		$sql5 = "SELECT d_id FROM inventory WHERE vin_num = '$vin'";
		$result5 = mysqli_query($db, $sql5);
		$row5 = mysqli_fetch_assoc($result5);
		$did = $row5['d_id'];
?>

<p><font size='4'>Selling Vehicle: <?php echo $vin; ?></font></p>
<form action="mark_sold.php?vin=<?php echo $vin; ?>" method="POST">
<input type="hidden" name="a_v" value = "<?php echo $vin; ?>">
<input type="hidden" name="did" value = "<?php echo $did; ?>">
<p>Sold Date: <input type="date" name="sold_d" value = ""></p>
<p>Sold Price: <input type="text" name="sold_p" value = ""></p>
<p>Employee ID: <input type="text" name="sold_e" value = ""></p>
<button type="submit" class="button button1" name="carsold" value= "Mark As Sold">Mark As Sold</button>
</form>

<?php
//echo "Hello " . $_GET['vin']; 

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
				echo "This employee does not work in this dealer, please try again or ";
				echo "<form action='mark_sold.php?vin=$vin' method='POST' >";
				echo "<button type='submit' class='button button1' name='search' value='Search'>Search Employees</button>";
				echo "</form>";
			}
			}
			else {
				echo "Please fill out the form.";
			}
		}
		

	function in_sold($vin, $sold_d, $sold_p, $sold_e, $did){
		$conn = new mysqli(db_servername, db_username, db_pass, db_dbname);
		$sql = "INSERT INTO `sale`(`e_id`,`d_id`, `vin_num`, `sold_d`, `sold_p`) VALUES ('$sold_e', '$did', '$vin','$sold_d', '$sold_p')";
		if ($conn->query($sql) === TRUE) {
   			 echo "<br>******The car is sold******";
    			 echo "<p>Go back to the <a href = 'car_info.php?vin=$vin'>Vehicle</a></p>";
		}else {
    			echo "Error: The car has already been sold. <br>";
		}
	}
		if(isset($_POST['search'])){
		$vin = $_GET['vin'];
		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		//echo $file;
		$sql = "SELECT * FROM employee e, dealer d, inventory i WHERE i.vin_num = '$vin' AND i.d_id = d.d_id AND e.d_id = d.d_id ORDER BY e.l_name";
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

		echo "<div class='container'>";
  		echo "<h2>Employee Table</h2>";
  		echo "<input id='myInput' type='text' placeholder='Search..'>";           
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
		}
	

?>

</div>
</body>
</html>
