<?php 
	require_once "../../config/db.php";
	require_once "../../includes/classes/Comment.php";
	require_once "../../includes/classes/User.php";

	if (isset($_SESSION["userLoggedIn"])) {
		$username = $_SESSION["userLoggedIn"];
	} else {
		$username = "";
	}
	$videoId = $_POST["videoId"];
	$commentId = $_POST["commentId"];

	$userLoggedInObj = new User($con, $username);
	$comment = new Comment($con, $commentId, $userLoggedInObj, $videoId);

	echo $comment->getReplies();

 ?>