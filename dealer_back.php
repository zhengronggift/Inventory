<?php
include('connect.php');
	$conn = new mysqli(db_servername, db_username, db_pass, db_dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	if(isset($_POST['register'])){
	$dname=$_POST['d_name'];
	$dname=ucfirst($dname);
	$city=$_POST['city'];
	$city=ucfirst($city);
	$state=$_POST['state'];
	$state=ucfirst($state);
	$zip=$_POST['zip'];
	//$f_name=$_POST['f_name'];
	//$l_name=$_POST['l_name'];

	if($dname == "" || $city == "" || $state == "" || $zip == "") 
	{
	 echo "Dealer Name, City, State, Zip Code cannot be empty";
	}

	if(ctype_alnum($zip)){ 
	$query2="SELECT `name`, `zip_code` FROM dealer WHERE `name` = '$dname' AND `zip_code` = '$zip'";
	$result2=mysqli_query($conn, $query2);
	$num2=mysqli_num_rows($result2);	
	//if dealer name does not exist within same zip code
	if ($num2 == 0) //$num == 0 && 
	{
	
$sql = "INSERT INTO `dealer`(`name`, `city`, `state`,`zip_code`) 
VALUES ('$dname', '$city','$state','$zip')"; //`e_id`, '$eid', 

	if ($conn->query($sql) === TRUE) {
	    $message = "New Dealer created successfully."; 
	    header("location:index.php");
	    //echo "$('#content').load('get_car.php?did=0');";
	    //echo "<script type='text/javascript'>alert('$message');</script>";
	    //echo "<br>******New Dealer created successfully.******";
	    

	}else {
	    echo "Something goes wrong";
	}
	}elseif ($num2 != 0){ //$num == 0 && 
		echo "<br>A dealer with same name already exist in this zip code<br>";

	}

	}
	}

?>
