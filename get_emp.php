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
		$sql = "SELECT * FROM employee GROUP BY e_id";
		//echo $sql;
		$result = mysqli_query($db, $sql);

		echo "<div class='container'>";
  		echo "<h2>Employee Table</h2>";
  		echo "<p>Following table contains all the employees work in a dealer:</p>";            
  		echo "<table class='table'>";
    		echo "<thead>";
      		echo "<tr>";
        	echo "<th>Employee ID</th>";
        	echo "<th>First Name</th>";
        	echo "<th>Last Name</th>";
        	echo "<th>Job Location</th>";
        	echo "<th>Car Sold</th>";
      		echo "</tr>";
    		echo "</thead>";
    		echo "<tbody>";
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
		echo "<td>" . $f_name . "</td>";
        	echo "<td>" . $l_name . "</td>";
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
