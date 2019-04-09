<?php
include('connect.php');
$conn = new mysqli(db_servername, db_username, db_pass, db_dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

$vin = $_GET['vin'];
$sql = "DELETE FROM vehicle WHERE vin_num = '$vin'";
$sql2 = "DELETE FROM inventory WHERE vin_num = '$vin'";
$result = mysqli_query($conn, $sql2);
$result2 = mysqli_query($conn, $sql);
//$row2 = mysqli_fetch_assoc($result2);
echo "The vehicle is deleted";
?>
