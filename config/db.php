<?php 
	/*Debugging option turned ON*/
	declare(strict_types=1);
	error_reporting(-1); 
	ini_set('display_errors', 'true');

	/*Output Buffering: PHP code waits until everything is outputted*/
	ob_start();

	/*Session variable*/
	session_start();

	/*Store the correct timezone*/
	date_default_timezone_set('Africa/Johannesburg');

	/*Database connection: PDO*/
	try {
		/*Establish database: */
		$con = new PDO("mysql:dbname=videosnap;host:localhost", "root", "");
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

	} catch (PDOException $e) {
		/*Show error*/
		echo "<i class='fas fa-info' style='color:red;'></i> MySQL connection failed because: <b style='color:red;'>". $e->getMessage() ."</b>";
	}

 ?>