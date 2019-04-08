<!DOCTYPE html>
<html lang="en">
<head>
  <title>Car Inventory</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body id="bootstrap-overrides">
    
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand">DMC</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="#" id="vehicle">Vehicles</a></li>
      <li><a href="#" id="dealer">Dealers</a></li>
      <li><a href="#" id="employee">Employees</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
	<li><a href="#" id="sign_up"><span class="glyphicon glyphicon-user"></span> Employee Register</a></li>
      	<li><a href="#" id="upload"><span class="glyphicon glyphicon-log-in"></span> Upload Vehicle</a></li>
    </ul>
  </div>
</nav>
    <p class="info">This is an online dealership database. Funtionalities available are add/delete from employees table, dealership table, and vehicle table. There is also viewing capabilities with indepth details pertaining to number of current employees and employee details. The current availability of vehicle's in inventory and their locations with prices and MSRP value. All of the current dealerships with employee and vehicle details.</p>
  
<div id = "content" class="container">
</div>
<div id = "content2" class="container">
</div>
<div id = "content3" class="container">
</div>

<script>
$(document).ready( function() {
	$("#vehicle").on("click", function() {
		$("#content").load("get_car.php");
		$("#content2").text("");
		$("#content3").text("");	
	});
});
$(document).ready( function() {
	$("#dealer").on("click", function() {
		$("#content").load("get_dealer.php");	
		$("#content2").text("");
		$("#content3").text("");	
	});
});
$(document).ready( function() {
	$("#employee").on("click", function() {
		$("#content").load("get_emp.php");
		$("#content2").text("");
		$("#content3").text("");		
	});
});
$(document).ready( function() {
	$("#sign_up").on("click", function() {
		$("#content").load("reg_emp.php");
		$("#content2").text("");
		$("#content3").text("");		
	});
});
$(document).ready( function() {
	$("#upload").on("click", function() {
		$("#content").load("upload_veh.php");	
		$("#content2").text("");
		$("#content3").text("");	
	});
});
</script>
</body>
</html>

