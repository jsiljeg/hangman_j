<?php

define('host', 'localhost');
define('username', 'root');
define('password', '');
define('db', 'my_db');

echo '<link href="inc/style.css" rel="stylesheet" type="text/css">';

class local_db {
	public $con;
	public $result;
	
	function __construct() {
		$this->con=mysql_connect(host, username, password) or die(mysql_error());
		mysql_select_db(db) or die(mysql_error());
	}
	
	function get_result() {
		return $this->result;
	}
	
	function query($q) {
		$this->result = mysql_query($q);
		if(!$this->result)
			die(mysql_error());
		return $this;
	}

	function output_query() {
		echo "<table class=\"pretty-table\" border=1>";
		echo "<tr>";
		for($i = 0; $i < mysql_num_fields($this->result); $i++) {
			$field = mysql_fetch_field($this->result, $i);
			echo "<td>" . $field->name . "</td>";
		}
		echo "</tr>";
		while($row = mysql_fetch_array($this->result)) {
			echo "<tr>";
			for($i = 0; $i < mysql_num_fields($this->result); $i++)
			echo "<td> " . $row[$i] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
		return $this;
	}
	
	function new_field($table, $name, $type) {
		$this->query("ALTER TABLE " . $table . " ADD " . $name . " " . $type);
	}

	function __destruct() {
		mysql_close($this->con);
	}
	
}
?>
