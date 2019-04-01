<?php
include('mainpage.php');
include('login.php');
include('upload.php');
function logout(){
	echo "<form action='' method='POST' >";
	echo "<button name='logout' value='1'>Logout</button>";
	echo "</form>";
	if (isset($_POST['logout']) == '1'){
		session_destroy();
		header("location:index.php");
	}
}


if (!isset($_SESSION['login_user'])){
			echo "Login to upload data";
			$lg= new Login();
}
else{
echo "Welcome ";
echo $_SESSION['login_user'];
$up = new Upload();
logout();
echo "<br>";
}

$mb = new MessageBoard();
?>
