<?php 
	require_once "../../config/db.php";
	require_once "../../includes/classes/Video.php";
	require_once "../../includes/classes/User.php";

	$username = $_SESSION = $_SESSION["userLoggedIn"];
	$videoId = $_POST["videoId"];

	$userLoggedInObj = new User($con, $username);
	$video = new Video($con, $videoId, $userLoggedInObj);

	echo $video->dislike();

 ?>