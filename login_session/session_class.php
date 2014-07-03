<?php

include "db_class.php";
session_start();

echo '<link href="inc/style.css" rel="stylesheet" type="text/css">';

class login_session {

	function login_check() {
		if(!isset($_SESSION['user']))
			return false;
		else return true;
	}
	
	function login_process($username, $password) {
		$b = new local_db;

		$b->query("SELECT * FROM users WHERE username='".$username."' AND password='".$password."';");
		$result = $b->get_result();
		if(mysql_num_rows($result) == 0)
			return false;
		else {
			$_SESSION['user'] = $_POST['username'];
			return true;
		}
	}
	
	function create_form() {
		echo "
			<form action=\"home.php\" method=\"post\">
			<div id=\"pretty-table\">
			<table  border=\"0\">
			<tr>
				<td>
					Username: 
				</td>
				<td>
					<input type=\"text\" name=\"username\"><br>
				</td>
			</tr>
			<tr>
				<td>
					Password: 
				</td>
				<td>
					<input type=\"text\" name=\"password\"><br>
				</td>
			</tr>
			</table>
			</div>
			<input type=\"submit\" name=\"submit\">
			</form>";
	}
	
	function logout() {
		session_destroy();
	}
}