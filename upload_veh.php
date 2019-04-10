<?php
include('connect.php');
$did = $_GET['did']; ?>
<script>
$(document).ready(function(){
$("#myInput").on("keyup", function() {
var value = $(this).val().toLowerCase();
$("#myTable tr").filter(function() {
$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
});
});
});
</script>
		<p style="text-align:center">Add New Vehicle </p>
		<form action="veh_back.php?did=<?php echo $did; ?>" method="POST" enctype="multipart/form-data">
		<?php if ($did == "0")
		{echo "<p style='text-align:center'>Dealer ID: "."<input type='text' name='d_id' size='15' maxlength='20' value = ''></p>";}
		elseif ($did != "0")
		{echo "<p style='text-align:center'>Dealer ID: ". $did ."</p>";} ?>
		<p style="text-align:center">VIN #: <input type="text" name="vin" size="15" maxlength="20" value = ""></p>
		<p style="text-align:center">Year: <input type="text" name="year" size="15" maxlength="20" value = ""></p>
		<p style="text-align:center">Make: <input type="text" name="make" size="15" maxlength="20" value = ""></p>
		<p style="text-align:center">Model: <input type="text" name="model" size="15" maxlength="20" value = ""></p>
		<p style="text-align:center">Color: <input type="text" name="color" size="15" maxlength="20" value = ""></p>
		<p style="text-align:center">MSRP: <input type="text" name="msrp" size="15" maxlength="20" value = ""></p>
		<p style="text-align:center">Upload Image: </p>
		<center><input type="file" class="button button1" name="file" value = ""></center>
		<p style="text-align:center"><input type="submit" class="button button1" name="submit" value="Save"></p>
		</form>"


<div class="container">
<h2>Find Dealer</h2>
<input id="myInput" type="text" placeholder="Dealer ID Search..">
<table class="table">
<thead>
<tr>
<th>Dealer ID</th>
<th>Name</th>
<th>Manager</th>
<th>City</th>
<th>State</th>
</tr>
</thead>
<tbody id="myTable">

<?php
if ($did == "0"){
		//get dealer table for id search
		$db = mysqli_connect(db_servername, db_username, db_pass, db_dbname);
		$sql = "SELECT * FROM dealer ORDER BY name";
		$result = mysqli_query($db, $sql);
		while($row = mysqli_fetch_assoc($result))
    		{
		$d_id = $row['d_id'];
		$name = $row['name'];
		$sql2 = "SELECT e.f_name, e.l_name FROM dealer d, employee e, manage m WHERE d.d_id = '$d_id' AND m.d_id = '$d_id' AND e.e_id = m.e_id";
		$result2 = mysqli_query($db, $sql2);
		$row2 = mysqli_fetch_assoc($result2);
		$city = $row['city'];
		$state = $row['state'];
		echo "<tr>";
        	echo "<td>" . $d_id . "</td>";
		echo "<td>" . $name . "</td>";
        	echo "<td>" . $row2['f_name'] . " " . $row2['l_name'] . "</td>";
		echo "<td>" . $city . "</td>";
        	echo "<td>" . $state . "</td>";
        	//echo "<td>" . $zip_code . "</td>";
		//echo "<td>" . $row4['num_emp'] . "</td>";
		}
}
?>
</tbody>
</table>
</div>
