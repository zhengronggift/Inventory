<p>Register</p>
<form action="emp_back.php?did=<?php echo $_GET['did']; ?>" method="POST">
<p>Dealer ID: <?echo $_GET['did']; ?></p>
<p>First Name: <input type="text" name="f_name" size="15" maxlength="20" value = ""></p>
<p>Last Name: <input type="text" name="l_name" size="15" maxlength="20" value = ""></p>
<p>Role: <input type="radio" name="emp_man" value="employee" checked> Employee   
<input type="radio" name="emp_man" value="manager"> Manager</p>
<p><input type="submit" class="button button1" name="register" value="Register"></p>
</form>

	

