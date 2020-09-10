<?php 

	require_once "../../config/db.php";

	if (isset($_POST['videoId']) && isset($_POST['thumbnailId'])) {

		$videoId = $_POST['videoId'];
		$thumbnailId = $_POST['thumbnailId'];

		/*Defaults query to false: 0 [unselect]*/
		$query = $con->prepare("UPDATE thumbnails SET selected = 0 WHERE videoId = :videoId");
		$query->bindParam(":videoId", $videoId);
		$query->execute();

		/*Defaults query to true: 1 [selected]*/
		$query = $con->prepare("UPDATE thumbnails SET selected = 1 WHERE id = :thumbnailId");
		$query->bindParam(":thumbnailId", $thumbnailId);
		$query->execute();

	} else {
		echo "ERROR: One or more parameters are not passed into the file: updateThumbnail.php 😢";
	}

 ?>