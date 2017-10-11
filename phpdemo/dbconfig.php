<?php
	$host ='127.0.0.1';
	$db = 'phpdemo';
	$user = 'root';
	$pass = '';
	$dsn = "mysql:host=$host;dbname=$db;";
	
	try{
		$connection = new PDO($dsn, $user, $pass); 
	}
	catch(PDOException $e){
		echo 'Connection Failed: ' . $e->getMessage();
	}

?>
