<?php
		require_once('oop/class.game.php');
		require_once('oop/class.hangman.php');
		require_once('oop/db_class.php');
		
		session_start();
		
		$db = new local_db;
		$db->query("SELECT * FROM hangmangames;")->output_query();
		echo "<br/>";
		echo "<form action=\"index.php\">
			  <input type=\"submit\" value=\"Back\">
			  </form>";
		echo "<br/>";
		
		$igrac = $_SESSION['igrac'];
		
		if ($_SESSION['tekst'] == '') 
		{ 
			if(isset($_POST['komentar']))
			{	
				echo $igrac . ' : ' . $_POST['komentar'];
			}
		}
		else
		{	
			echo $_SESSION['tekst'];
			if(isset($_POST['komentar']))
			{	
				echo $igrac . ' : ' . $_POST['komentar'];
			}
		}
		if(isset($_POST['komentar'])) {
		$nova = $igrac . ' : ' . $_POST['komentar'] . "<br/>";
		$_SESSION['tekst'] .= $nova;
		}
		echo "<div id=\"prethodni\"></div>";
		echo 	"<form method=\"POST\">
				<textarea id = \"com\" name=\"komentar\" rows = \"4\" cols = \"60\" onfocus=\"this.value=''\"> Enter comment here... </textarea> 
				<input type=\"submit\" value=\"Comment\">
				</form>";

?>