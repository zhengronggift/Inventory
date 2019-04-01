<?php
class Upload{
	function __constructor(){
	$this->upload();
}

function upload(){
		echo "<br>Upload a vehicle <br><br>";
		echo "<form action='' method='POST' >";
		echo "Vehicle Vin Number: "."<input type='text' name='vin'><br>";
		echo "Make: "."<input type='text' name='make'><br>";
		echo "Model: "."<input type='text' name='model'><br>";
		echo "Year: "."<input type='text' name='year'><br>";
		echo "Color: "."<input type='text' name='color'><br>";
		echo "MSRP: "."<input type='text' name='msrp'><br>";
		echo "Actual Price: "."<input type='text' name='acprice'><br>";
		echo "<input type='submit' name='submit' value='Upload'>";
		echo "</form>";
		
		if (isset($_POST['submit']))
		{
			$conn = new mysqli(db_servername, db_username, db_pass, db_dbname);
			$vin = $_POST['vin'];
			$make = $_POST['make'];
			$model = $_POST['model'];
			$year = $_POST['year'];
			$color = $_POST['color'];
			$msrp = $_POST['msrp'];
			$acp = $_POST['acprice'];
			$did = $_SESSION['d_id'];
			$sql = "SELECT `vin_num`,`make`,`model` FROM vehicle WHERE `vin_num` = '$vin' AND `make` = '$make' AND `model` = '$model'";
			$result=mysqli_query($conn, $sql);
			$num=mysqli_num_rows($result);
			if ($num == 0){
				$make = ucfirst($make);
				$color = ucfirst($color);
				$model = ucfirst($model);
				$sql1 = "INSERT INTO `vehicle`(`vin_num`,`make`, `model`, `year`, `color`,`msrp`) VALUES ('$vin','$make','$model','$year','$color','$msrp')";
				$sql2 = "INSERT INTO `inventory`(`vin_num`,`actual_p`, `d_id`) VALUES ('$vin','$acp','$did')";
				if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
    echo "<br>******New vehicle added successfully.******";
}else {
	echo "This Vin Number exist in the database";
   // echo "Error: " . $sql . "<br>The test data added already<br>" . $conn->error;
}

			} else{
				echo "This vehicle exist in the database";
							
			}

		}
}

}

?>


