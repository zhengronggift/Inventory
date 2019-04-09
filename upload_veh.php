<?php
//echo $_GET['did']; 
include ('connect.php');
class Upload{
	function __constructor(){
	$this->upload();
}
function upload(){
$did = $_GET['did'];
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
		echo "<br>Upload a vehicle <br><br>";
		echo "<form action='upload_veh.php?did=$did' method='POST' enctype='multipart/form-data'>";
		echo "Upload Image:<br>";
		echo "<input type='file' name='file' value = ''><br>";
		echo "Vehicle Vin Number: "."<input type='text' name='vin'><br>";
		if ($did == "0")
		{echo "Dealer ID: "."<input type='text' name='d_id'><br>";}
		elseif ($did != "0")
		{echo "Dealer ID: ". $did ."<br>";}
	
		echo "Make: "."<input type='text' name='make'><br>";
		echo "Model: "."<input type='text' name='model'><br>";
		echo "Year: "."<input type='text' name='year'><br>";
		echo "Color: "."<input type='text' name='color'><br>";
		echo "MSRP: "."<input type='text' name='msrp'><br>";
		//echo "Actual Price: "."<input type='text' name='acprice'><br>";
		echo "<input type='submit' name='submit' value='Upload'>";
		echo "</form>";
		
		if (isset($_POST['submit']))
		{
			$conn = new mysqli(db_servername, db_username, db_pass, db_dbname);
			$vin = $_POST['vin'];
			//verify upload file is picture
			//$_FILES['file']['name'] = $vin . '.jpg';
			$whitelist = ['jpg', 'jpeg', 'png', 'gif'];
			$name = $_FILES['file']['name'];
			$extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
			$make = $_POST['make'];
			$make = ucfirst($make);
			$model = $_POST['model'];
			$model = ucfirst($model);
			$year = $_POST['year'];
			$color = $_POST['color'];
			$color = ucfirst($color);
			$msrp = $_POST['msrp'];
			//$acp = $_POST['acprice'];
			if ($did == "0"){
			$did = $_POST['d_id'];}
			//check vin number does not exist
			$sql = "SELECT `vin_num`,`make`,`model` FROM vehicle WHERE `vin_num` = '$vin' AND `make` = '$make' AND `model` = '$model'";
			$result=mysqli_query($conn, $sql);
			$num=mysqli_num_rows($result);
			//check dealer exist
			$sql2 = "SELECT `d_id` FROM dealer WHERE `d_id` = '$did'";
			$result2=mysqli_query($conn, $sql2);
			$num2=mysqli_num_rows($result2);
if (isset($name)){
			if ($num == 0 && $num2 == 1 && in_array($extension,$whitelist)){
				$make = ucfirst($make);
				$color = ucfirst($color);
				$model = ucfirst($model);
				$vin = strtoupper($vin);
				//upload
				$location = 'picture/';
				move_uploaded_file($_FILES["file"]["tmp_name"], "picture/{$vin}.jpg");
				$sql1 = "INSERT INTO `vehicle`(`vin_num`,`make`, `model`, `year`, `color`,`msrp`) VALUES ('$vin','$make','$model','$year','$color','$msrp')";
				$sql2 = "INSERT INTO `inventory`(`vin_num`,`d_id`) VALUES ('$vin','$did')";
				if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
    echo "<br>******New vehicle added successfully.******"; header("location:index.php");
}else {echo "Error while uploading, please double check your values";}	
			} elseif ($num != 0){
	echo "This Vin Number exist in the database";
   // echo "Error: " . $sql . "<br>The test data added already<br>" . $conn->error;
}elseif ($num2 == 0){echo "Cannot find the dealer";}elseif (!in_array($extension,$whitelist)){echo "Select a picture";}
}
		}


		//get dealer table for id search
		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		//echo $file;
		$sql = "SELECT * FROM dealer ORDER BY name";
		//echo $sql;
		$result = mysqli_query($db, $sql);
		echo "<div class='container'>";
  		echo "<h2>Find Dealer</h2>";
		echo "<input id='myInput' type='text' placeholder='Dealer ID Search..'>";          
  		echo "<table class='table'>";
    		echo "<thead>";
      		echo "<tr>";
        	echo "<th>Dealer ID</th>";
        	echo "<th>Name</th>";
        	echo "<th>Manager</th>";
        	echo "<th>City</th>";
        	echo "<th>State</th>";
        	//echo "<th>Zip Code</th>";
		//echo "<th>Number of Employees</th>";
      		echo "</tr>";
    		echo "</thead>";
    		echo "<tbody id='myTable'>";
		while($row = mysqli_fetch_assoc($result))
    		{
		$d_id = $row['d_id'];
		$name = $row['name'];
		$sql2 = "SELECT e.f_name, e.l_name FROM dealer d, employee e, manage m WHERE d.d_id = '$d_id' AND m.d_id = '$d_id' AND e.e_id = m.e_id";
		$result2 = mysqli_query($db, $sql2);
		$row2 = mysqli_fetch_assoc($result2);
		$city = $row['city'];
		$state = $row['state'];
		//$zip_code = $row['zip_code'];
		//$emp = $row['employee'];
		//$num = $row['num'];
		echo "<tr>";
        	echo "<td>" . $d_id . "</td>";
		echo "<td>" . $name . "</td>";
        	echo "<td>" . $row2['f_name'] . " " . $row2['l_name'] . "</td>";
		echo "<td>" . $city . "</td>";
        	echo "<td>" . $state . "</td>";
        	//echo "<td>" . $zip_code . "</td>";
		//echo "<td>" . $row4['num_emp'] . "</td>";
		}

		echo "</tbody>";
  		echo "</table>";
		echo "</div>";

}
}
$up = new Upload();
?>
