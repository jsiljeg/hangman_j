<?php

include "session_class.php";

echo '<link href="inc/style.css" rel="stylesheet" type="text/css">';

/*function login_check() {
	session_start();
	if(!isset($_SESSION['user']))
		header('Location:login.html');*/

$s = new login_session;	

if(isset($_POST['logout'])){
	unset($_POST['logout']);
	$s->logout();
	header('Location: home.php');
	}

if($s->login_check() == false) {
	if(isset($_POST['username']) && isset($_POST['password']))
		$success = $s->login_process($_POST['username'], $_POST['password']);
	else {$s->create_form(); exit;}
	if(!$success) {$s->create_form(); exit;}
	}
	
	$_SESSION['admin'] = 1;
	header('Location: ../comment.php');
?>

<html>
<body>
Welcome! <br>
<form action="home.php" method="post">
<input type="submit" name="logout" value="Logout"/>
</form>
</body>
</html>