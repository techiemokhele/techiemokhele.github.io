<?php 

	/*Including all required pages*/
	require_once "./includes/header.php";

	if (!User::isLoggedIn()) {
		header("Location: signIn.php");
	}

	$subscriptionsProvider = new SubscriptionsProvider($con, $userLoggedInObj);
	$videos = $subscriptionsProvider->getVideos();

	$videoGrid = new VideoGrid($con, $userLoggedInObj);
 ?>

<div class="largeVideoGridContainer">
	
	<?php 

		if (sizeof($videos)) {
			echo $videoGrid->createLarge($videos, "<i class='fas fa-blog'></i> New from your subscription", false);
		} else {
			echo "<div class='alert alert-danger'>
				<i class='fas fa-info iconColor'></i> 
					ERROR: No videos to display! Please try again later. 😢
				</div>";
		}

	 ?>

</div>