<?php 

	/*Including all required pages*/
	require_once "./includes/header.php";
	require_once "./includes/classes/LikedVideosProvider.php";

	if (!User::isLoggedIn()) {
		header("Location: signIn.php");
	}

	$likedVideosProvider = new LikedVideosProvider($con, $userLoggedInObj);
	$videos = $likedVideosProvider->getVideos();

	$videoGrid = new VideoGrid($con, $userLoggedInObj);
 ?>

<div class="largeVideoGridContainer">
	
	<?php 

		if (sizeof($videos)) {
			echo $videoGrid->createLarge($videos, "<i class='fas fa-blog'></i> Showing all the videos you have liked", false);
		} else {
			echo "<div class='alert alert-danger'>
				<i class='fas fa-info iconColor'></i> 
					ERROR: No videos to display! Please try again later. 😢
				</div>";
		}

	 ?>

</div>