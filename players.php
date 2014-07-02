<html>
<body>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

<?php
if(!isset($_POST['nplayers']) && !isset($_POST['players'][0])){
	echo  "Number of players: ";
	echo  "<input type=\"text\" name=\"nplayers\">
		  <input type=\"submit\" name=\"submit\" value=\"Submit\">
		  <br/>";
}
elseif(!isset($_POST['players'])){
	session_start();
	$_SESSION['nplayers'] = $_POST['nplayers'];
	echo "Enter players below:<br/>";
	for($i = 0; $i < intval($_POST['nplayers']); $i++) {
		echo "Player " . ($i+1) . ": ";
		echo "<input type=\"text\" name=\"players[]\"><br/>";
	}
	echo "<input type=\"submit\" name=\"submit\" value=\"Submit\"><br/>";
}

else {
	session_start();
	$_SESSION['players'] = array();
	for($i = 0; $i < intval($_SESSION['nplayers']); $i++) {
		$_SESSION['players'][$i] = $_POST['players'][$i];
	}
	header("Location: index.php");
	exit();
}

$_SESSION['tekst']='';
$_SESSION['ulaz']=1;

?>

</form>

</body>
</html>