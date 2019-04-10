<?php
//to get dealer info
include('connect.php');
//echo "Hello " . $_GET['did']; 
class load_car{
	var $message = array();
	function __construct(){
		$this->loadcar();
  	}
		function loadcar(){

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
	
        	echo $name . " (Dealer ID:" . $did . ")<br>";
		echo $city . ", ";
        	echo $state . ", ";
        	echo $zip . "<br> ";
        	echo "Store Manager: " . $m_f . " " . $m_l . "<br>";
		//echo " <button type='button' id='inventory'>Vehicle Inventory</button> ";
		//echo " <button type='button' id='employee'>Employees</button> ";
		//echo "<button type='button' id='sold'>Sold Vehicles</button><br>";

		}
}
$load = new load_car();	
?> 

<button class="button button1" type="button" id="inventory">Vehicle Inventory</button>
<button class="button button1" type="button" id="employee">Employees</button><br>
<script>
$(document).ready( function() {
	$("#inventory").on("click", function() {
		$("#content").load("dealer_info.php?did=<?php echo $_GET['did']; ?>");
		$("#content2").load("get_car.php?did=<?php echo $_GET['did']; ?>");
		$("#content3").text("");		
	});
});
$(document).ready( function() {
	$("#employee").on("click", function() {
		$("#content").load("dealer_info.php?did=<?php echo $_GET['did']; ?>");
		$("#content2").load("get_emp.php?did=<?php echo $_GET['did']; ?>");	
		$("#content3").text("");	
	});
});
</script>
