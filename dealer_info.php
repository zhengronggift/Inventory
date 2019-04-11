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
<br>
<button class="button button1" type="button" onclick="window.location.href = 'get_car.php?did=<?php echo $did; ?>';">Vehicle Inventory</button>
<button class="button button1" type="button" onclick="window.location.href = 'get_emp.php?did=<?php echo $did; ?>';">Employees</button>


</body>
</html>
