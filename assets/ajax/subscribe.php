<?php 
	require_once "../../config/db.php";

	if (isset($_POST['userTo']) && isset($_POST['userFrom'])) {
		/*
			1. Check if user is subscribed
			2. If subscribed, delete
			3. If not subscribed, insert
			4. Return new number of subscribed users
		*/

		$userTo = $_POST['userTo'];
		$userFrom = $_POST['userFrom'];

		$query = $con->prepare("SELECT * FROM subscribers WHERE userTo = :userTo AND userFrom = :userFrom");
		$query->bindParam(":userTo", $userTo);
		$query->bindParam(":userFrom", $userFrom);
		$query->execute();

		if ($query->rowCount() == 0) {
			/*Insert Subscribe*/
			$query = $con->prepare("INSERT INTO subscribers(userTo, userFrom) VALUES(:userTo, :userFrom)");
			$query->bindParam(":userTo", $userTo);
			$query->bindParam(":userFrom", $userFrom);
			$query->execute();

		} else{
			/*Remove Subscribe*/
			$query = $con->prepare("DELETE FROM subscribers WHERE userTo = :userTo AND userFrom = :userFrom");
			$query->bindParam(":userTo", $userTo);
			$query->bindParam(":userFrom", $userFrom);
			$query->execute();
		}

		/*Show number of subscribes*/
		$query = $con->prepare("SELECT * FROM subscribers WHERE userTo = :userTo");
		$query->bindParam(":userTo", $userTo);
		$query->execute();
		echo $query->rowCount();

	} else {
		echo "ERROR: One or more parameters are not passed into the file  😢";
	}

 ?>