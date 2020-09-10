<?php 

	/*Including header page*/
	require_once "./includes/header.php";
	require_once "./includes/classes/ProfileGenerator.php";

	if (isset($_GET["username"])) {
		$profileUsername = $_GET["username"];
	} else {
		echo "<div class='alert alert-danger'>
				<i class='fas fa-info iconColor'></i> 
					ERROR: User could not be found! 😢<br><br>";
			echo "<p align='center'>
						<img src='media/img/error/404.gif' alt='user not found'>
					</p>
				</div>";
		exit();
	}

	$profileGenerator = new ProfileGenerator($con, $userLoggedInObj, $profileUsername);

	echo $profileGenerator->create();

 ?>