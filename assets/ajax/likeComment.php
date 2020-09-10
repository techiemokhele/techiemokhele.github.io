<?php 
	require_once "../../config/db.php";
	require_once "../../includes/classes/Comment.php";
	require_once "../../includes/classes/User.php";

	$username = $_SESSION = $_SESSION["userLoggedIn"];
	$videoId = $_POST["videoId"];
	$commentId = $_POST["commentId"];

	$userLoggedInObj = new User($con, $username);
	$comment = new Comment($con, $commentId, $userLoggedInObj, $videoId);

	echo $comment->like();

 ?>