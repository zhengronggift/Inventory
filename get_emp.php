<button type="button" class="button button1" id="add_emp">Add New Employees</button>
<script>
$(document).ready( function() {
	$("#add_emp").on("click", function() {
		$("#content").load("reg_emp.php?did=<?php echo $_GET['did']; ?>");
		$("#content2").text("");	
		$("#content3").text("");	
	});
});
</script>

<?php
include('connect.php');
class load_emp{
	var $message = array();
	function __construct(){
		$this->loade();
  	}

	function loade(){
		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		//echo $file;
		$did = $_GET['did']; 
		$sql = "SELECT * FROM employee WHERE d_id = '$did' ORDER BY l_name";
		//echo $sql;
		$result = mysqli_query($db, $sql);
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

		echo "<div class='container'>";
  		echo "<h2>Employee Table</h2>";
  		echo "<input id='myInput' type='text' placeholder='Search..'>";           
  		echo "<br><br><table class='table table-bordered'>";
    		echo "<thead>";
      		echo "<tr>";
        	echo "<th>Employee ID</th>";
        	echo "<th>Last Name</th>";
		echo "<th>First Name</th>";
        	echo "<th>Job Location</th>";
        	echo "<th>Car Sold</th>";
      		echo "</tr>";
    		echo "</thead>";
    		echo "<tbody id='myTable'>";
		while($row = mysqli_fetch_assoc($result))
    		{
		$e_id = $row['e_id'];
		$f_name = $row['f_name'];
		$l_name = $row['l_name'];
		$sql2 = "SELECT d.name FROM dealer d, employee e WHERE e.e_id = '$e_id' AND d.d_id = e.d_id";
		//echo $sql;
		$result2 = mysqli_query($db, $sql2);
		$row2 = mysqli_fetch_assoc($result2);
		$sql3 = "SELECT e_id, count(e_id) as num_sold FROM sale WHERE e_id = '$e_id'";
		//echo $sql;
		$result3 = mysqli_query($db, $sql3);
		$row3 = mysqli_fetch_assoc($result3);
		//$location = $row['location'];
		//$sold = $row['sold'];
		echo "<tr>";
        	echo "<td>" . $e_id . "</td>";
		echo "<td>" . $l_name . "</td>";
		echo "<td>" . $f_name . "</td>";
        	echo "<td>" . $row2['name'] . "</td>";
        	echo "<td>" . $row3['num_sold'] . "</td>";
	        }
		echo "</tbody>";
  		echo "</table>";
		echo "</div>";	
	}	

}

$load = new load_emp();
//implement
?>
