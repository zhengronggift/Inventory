<?php
include('connect.php');
	function insert_manage($manager, $eid, $did){
	//echo $manager . $eid;	
		$conn = new mysqli(db_servername, db_username, db_pass, db_dbname);
		$query = "SELECT * FROM manage WHERE `d_id` = '$did'";
		$result = mysqli_query($conn, $query);
		$num=mysqli_num_rows($result);
		if ($manager == "manager" && $num == 0)
		{
			$sql = "INSERT INTO `manage`(`d_id`, `e_id`) VALUES ('$did', '$eid')";	
			$result3=mysqli_query($conn, $sql);
	   		echo "<br>Employee is inserted as a manager.";
			header("location:index.php");
		}elseif ($num != 0)
		{ echo "<br>Sorry, this dealer has a manager already, please check the dealer";}
	}
	$conn = new mysqli(db_servername, db_username, db_pass, db_dbname);
	if ($conn->connect_error) {
	    				die("Connection failed: " . $conn->connect_error);
				  }
		if(isset($_POST['register'])){
			$did = $_GET['did'];
			$fname=$_POST['f_name'];
			$lname=$_POST['l_name'];
			$manager=$_POST['emp_man'];
				if($fname == "" || $lname == "") //$eid == "" || 
					{
						 echo "First Name, or Last Name cannot be empty";
					}else{

					if(ctype_alnum($did)){ 
						$fname=ucfirst($fname);
						$lname=ucfirst($lname);
						$query2="SELECT `d_id` FROM dealer WHERE `d_id` = '$did'";

						$result2=mysqli_query($conn, $query2);
						//$num=mysqli_num_rows($result);
						$num2=mysqli_num_rows($result2);	

							if ($num2 > 0) //$num == 0 && 
								{
								//echo "<br>Search result: $num; Employee ID $eid is not in use";
								$sql = "INSERT INTO `employee`(`d_id`, `f_name`, `l_name`) 
										VALUES ('$did', '$fname','$lname')"; //`e_id`, '$eid', 

									if ($conn->query($sql) === TRUE) {
	  									  echo "<br>******New user created successfully.******";
	  									  $query3="SELECT `e_id` FROM employee WHERE `d_id` = '$did' AND `l_name` = '$lname' AND `f_name` = '$fname'";
	  									  $result3=mysqli_query($conn, $query3);
	  									  $num3=mysqli_fetch_assoc($result3);
	   									  $eid = $num3['e_id'];
	    									  insert_manage($manager, $eid, $did);
									}else {
	 									   echo "Error: " . $sql . "<br>The test data added already<br>" . $conn->error;
									}
							}elseif ($num2 == 0){ //$num == 0 && 
									echo "<br>Search result: Cannot find the Dealer ID, Please use one of following dealer ID <br>";
						}

	}}}
	
	

?>

