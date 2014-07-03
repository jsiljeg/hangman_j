<?php
		require_once('oop/class.game.php');
		require_once('oop/class.hangman.php');
		require_once('oop/db_class.php');
			
		echo '<link href="inc/style.css" rel="stylesheet" type="text/css">';
			
		session_start();
		
		if(isset($_POST['logout'])) {
			session_destroy();
			//unset($_SESSION['admin']);
			header('Location: index.php');
			exit();
		}
		
		if(isset($_SESSION['dummy'])) {
			$_SESSION['igrac'] = $_SESSION['dummy']->players[$_SESSION['dummy']->turn-1];
			unset($_SESSION['dummy']);
		}
		elseif (!isset($_SESSION['admin']))
			$_SESSION['igrac'] = $_SESSION['game']['hangman']->players[$_SESSION['game']['hangman']->turn-1];
		$db = new local_db;
		
		//treba podesiti
		for($i=0; $i<100; $i++) {
			if(isset($_POST["comm$i"])) {
				$prevComment = $_SESSION['currentRow'][1];
				if(isset($_SESSION['admin']))
					$prevComment .= "<br/>&nbsp" . "admin" . " : ";
				else $prevComment .= "<br/>&nbsp" . $_SESSION['igrac'] . " : ";
				$prevComment .= $_POST["comm$i"];
				$db->query("UPDATE comments SET comment='" . $prevComment . "' WHERE id = $i;");
			}
		}
		
		for($i=0; $i<100; $i++) {
			if(isset($_POST["delete$i"])) {
				$db->query("DELETE FROM comments WHERE id = $i;");
			}
		}
		
		if(isset($_POST["delete"])) {
				$db->query("DROP TABLE comments;");
				$db->query("CREATE TABLE IF NOT EXISTS comments (
						  id INT AUTO_INCREMENT PRIMARY KEY,
						  comment VARCHAR(500));");
		}
		
		if((isset($_POST['komentar'])  && isset($_SESSION['igrac'])) || (isset($_POST['komentar'])  && isset($_SESSION['admin']))) {
			if(isset($_SESSION['admin']))
				$igrac = 'admin';
			else $igrac = $_SESSION['igrac'];
			$db->query("INSERT INTO comments SET comment='" . $igrac . " : " . $_POST['komentar'] . "';");
		}
		echo "<div align = \"left\">";
		$db->query("SELECT * FROM hangmangames;")->output_query();
		echo "</div>";
		echo "<br/>";
		
		
		$db->query("SELECT * FROM comments;");
		while($row = $db->fetch_row()) {
				if(isset($_POST["$row[0]"])) {
					$_SESSION['currentRow'] = $row;
					echo "<form  method = \"POST\">
						
						<table border = \"0\" style = \"width:100%\">
						<tr>
							<td width=\"38%\">
								<table border = \"0\">
									<tr>
										<td>
										$row[1]
										<td/>
									</tr>
								</table>
							</td>
						</tr>
						</table>
						</form>";
					
					echo "<form method = \"POST\">
						  <table border = \"0\" style = \"width:100%\">
								<tr>
									<td width=\"38%\">
										<table border = \"0\">
											<tr>
												<td>
												<textarea id = \"com\" name=\"comm$row[0]\" rows = \"4\" cols = \"65\" onfocus=\"this.value=''\"> Enter comment here... </textarea><br/>
												</td>
											</tr>
										</table>
									</td>
								</tr>
						   </table>
						   <br/>
						   <table border = \"0\" style = \"width:10%\">
						   <tr>
						   <td width=\"1%\">
								<table border = \"0\">
									<tr>
										<td align=\"center\">
										<input align=\"center\" type=\"submit\" name=\"$row[0]\" value=\"Reply\">
										<td/>
									</tr>
								</table>
							</td>
							<td width=\"1%\">
								<table border = \"0\">
									<tr>
										<td>
										<input type=\"submit\" value=\"Comment\">
										</td>
									</tr>
								</table>
							</td>";
							
							
						if(isset($_SESSION['admin'])) {
						echo "<form method=\"POST\">
							<td width=\"1%\">
								<table border = \"0\">
									<tr>
										<td>
										<input type=\"submit\" name=\"delete$row[0]\" value=\"Delete\">
										<td/>
									</tr>
								</table>
							</td>
							</tr>
							</table>
							  </form>";
						}
				}
				else {
					echo "<form method = \"POST\">";
							if(isset($_SESSION['admin'])) {
							echo "<table border = \"0\" style = \"width:100%\"> ";  //<!--ode bilo 47 maloprije widtha-->
								}
							else echo "<table border = \"0\" style = \"width:46%\"> ";
							
							echo "
								<tr>
									<td width=\"38%\">
										<table border = \"0\">
											<tr>
												<td>
												$row[1]
												</td>
											</tr>
										</table>
									</td>
									
									<td width=\"1%\">
										<table border = \"0\">
											<tr>
												<td>
												<input type=\"submit\" name=\"$row[0]\" value=\"Reply\">
												</td>
											</tr>
										</table>
									</td>
						</form>";
						if(isset($_SESSION['admin'])) {
						echo "<form method=\"POST\">
									<td width=\"1%\">
										<table border = \"0\">
											<tr>
												<td>
												<input type=\"submit\" name=\"delete$row[0]\" value=\"Delete\">
												</td>
											</tr>
										</table>
									</td>
									<td width=\"60%\">
										<table border = \"0\">
										</table>
									</td>
							  </form>";
						}
					echo		"</tr>
							</table>
							<br/>";
							if(isset($_SESSION['admin'])) {
							echo	"<hr align=\"left\" width=\"44%\">";
							}
							else echo "<hr align=\"left\" width=\"44%\">";
					}
		}
		echo 	"<form method=\"POST\">
				<table border = \"0\" style = \"width:100%\">
					<tr>
						<td>
							<textarea id = \"com\" name=\"komentar\" rows = \"4\" cols = \"65\" onfocus=\"this.value=''\"> Enter comment here... </textarea> 
						</td>
					</tr>
				</table>
				<br/>
				<table border = \"0\" style = \"width:10%\">
					<tr>
						<td width=\"2%\">
							<input type=\"submit\" value=\"Comment\">
						</td>
				</form>";
		if(isset($_SESSION['admin'])) {
		echo "<form method=\"POST\"> 
						<td width=\"2%\">
							 <input type=\"submit\" name=\"delete\" value=\"Delete All\">
						</td>
							
							</form>";
		echo "<form method=\"POST\">
							 
						<td width=\"2%\">
							<input type=\"submit\" name=\"logout\" value=\"Logout\">
						</td>
					</tr>
				</table>
							 </form>";
				}
		if(!isset($_SESSION['admin']))
		{	
			echo "<form action=\"index.php\">
				<td>
				<input type=\"submit\" value=\"Back\">
				</td>
				</tr>
				</table>
				</form>";
			echo "<br/>";
		}
?>