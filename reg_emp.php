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

<style>
div.gallery {
  border: 3px solid #0f8eeaf7;

}

div.gallery:hover {
  border: 3px solid #0f8eeaf7;
}

div.gallery img {
  width: 100%;
  height: auto;
}

div.desc {
  padding: 15px;
  text-align: center;
}

* {
  box-sizing: border-box;
}

.responsive {
  padding: 0 6px;
  float: center;
  width: 24.99999%;
}

@media only screen and (max-width: 700px) {
  .responsive {
    width: 49.99999%;
    margin: 6px 0;
  }
}

@media only screen and (max-width: 500px) {
  .responsive {
    width: 100%;
  }
}

.clearfix:after {
  content: "";
  display: table;
  clear: both;
}

#left
{
  float: left;
}

#center
{
  float: center;
}

#right
{
  float: right;
}

</style>


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

<div class="responsive">
  <div class="gallery">

<?php
//to get dealer info
include('connect.php');
		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		//echo $file;
		$did = $_GET['did'];
		$sql = "SELECT * FROM dealer WHERE d_id = '$did'";
		$sql2 = "SELECT * FROM manage m, employee e WHERE m.d_id = '$did' AND e.e_id = m.e_id";
		$result = mysqli_query($db, $sql);
		$row = mysqli_fetch_assoc($result);
		$result2 = mysqli_query($db, $sql2);
		$row2 = mysqli_fetch_assoc($result2);
		$city = $row['city'];
		$state = $row['state'];
		$zip = $row['zip_code'];
		$name = $row['name'];
		$m_f = $row2['f_name'];
		$m_l = $row2['l_name'];
	
        	echo "<br><font size='4'>" . $name . " (Dealer ID:" . $did . ")</font><br><br>";
		echo $city . ", ";
        	echo $state . ", ";
        	echo $zip . "<br> ";
        	echo "Store Manager: <b>" . $m_f . " " . $m_l . "</b><br><br>";
?>

</div>
</div>

<p>Register</p>
<form action="reg_emp.php?did=<?php echo $_GET['did']; ?>" method="POST">
<p>Dealer ID: <?echo $_GET['did']; ?></p>
<p>First Name: <input type="text" name="f_name" size="15" maxlength="20" value = ""></p>
<p>Last Name: <input type="text" name="l_name" size="15" maxlength="20" value = ""></p>
<p>Role: <input type="radio" name="emp_man" value="employee" checked> Employee   
<input type="radio" name="emp_man" value="manager"> Manager</p>
<p><button class="button button1" type="submit" name="register" value="Register">Register</button>
</form>

<?php
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
										  echo "<p>Go back to the <a href='dealer_info.php?did=$did'>Dealer</a></p>";
									}else {
	 									   echo "Error: " . $sql . "<br>The test data added already<br>" . $conn->error;
									}
							}elseif ($num2 == 0){ //$num == 0 && 
									echo "<br>Search result: Cannot find the Dealer ID, Please use one of following dealer ID <br>";
						}

	}}}
	
	

?>



</div>
</body>
</html>

