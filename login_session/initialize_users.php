<?php
include "db_class.php";
$b = new local_db;

$b->query("CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(100), password VARCHAR(100));");
$b->query("INSERT INTO users SET username='djelusic', password='p62Hkkx2';");
$b->query("INSERT INTO users SET username='jsiljeg', password='0989387517';");

$b->query("CREATE TABLE IF NOT EXISTS comments (id INT AUTO_INCREMENT PRIMARY KEY,comment VARCHAR(500));");

?>