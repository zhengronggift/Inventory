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

<?php
include('connect.php');?>

<?php
$vin = $_GET['vin'];
if (!isset($_POST["yes"])){
echo "<div class='responsive'>";
echo "<p>You sure you want to DELETE? This will delete all the exist information about this vehicle. <br><br>Please select following options:</p><br>";
echo "<div id='left'>";
echo "<form action='delete_car.php?vin=$vin' method='POST' >";
echo "<button type='submit' class='button button1' name='yes' value='Yes'>Yes</button>";
echo "</form>";
echo "</div>";

echo "<div id='right'>";
echo "<form action='car_info.php?vin=$vin' method='POST' >";
echo "<button type='submit' class='button button1' name='submit' value='No'>No</button>";
echo "</form>";
echo "</div>";
echo "</div>";}
?>

<?php
$conn = new mysqli(db_servername, db_username, db_pass, db_dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

if (isset($_POST["yes"])){
$vin = $_GET['vin'];
$sql = "DELETE FROM vehicle WHERE vin_num = '$vin'";
$sql2 = "DELETE FROM inventory WHERE vin_num = '$vin'";
$result = mysqli_query($conn, $sql2);
$result2 = mysqli_query($conn, $sql);
//$row2 = mysqli_fetch_assoc($result2);
echo "The vehicle is deleted";
echo "<p>Go back to the <a href='get_car.php?did=0'>Inventory</a></p>";
}
?>
</div>
</body>
</html>
