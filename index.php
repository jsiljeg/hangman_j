<?php
/***
* File: index.php
* Author: design1online.com, LLC
* Created: 5.11.2011
* License: Public GNU
***/

//include the required files
require_once('oop/class.game.php');
require_once('oop/class.hangman.php');

//this will keep the game data as they refresh the page
session_start();

//initialize players for session
if(!isset($_SESSION['players'])) {
	header("Location: players.php");
	exit();
}

//if they haven't started a game yet let's load one
if (!isset($_SESSION['game']['hangman']))
	$_SESSION['game']['hangman'] = new hangman(intval($_SESSION['nplayers']), $_SESSION['players']);
	
if(isset($_POST['showdb'])) {
	$_SESSION['game']['hangman']->show_db();
	exit();
	}

?>
<html>
	<head>
		<title>Hangman</title>
		<link rel="stylesheet" type="text/css" href="inc/style.css" />
	</head>
	<body>
		<div id="content">
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<h2>Hangman</h2>
		<?php
			$_SESSION['game']['hangman']->playGame($_POST);
		?>
		</form>
		<br/>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<div id="showdb"><input type="submit" name="showdb" value="Show previous results"></div>
		</form>
		</div>
	</body>
</html>