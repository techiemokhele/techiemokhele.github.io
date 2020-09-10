<?php 

	/*Including all required pages*/
	require_once "./includes/header.php";
	require_once "./includes/classes/TrendingProvider.php";

	$trendingProvider = new TrendingProvider($con, $userLoggedInObj);
	$videos = $trendingProvider->getVideos();

	$videoGrid = new VideoGrid($con, $userLoggedInObj);
 ?>

<div class="largeVideoGridContainer">
	
	<?php 

		if (sizeof($videos)) {
			echo $videoGrid->createLarge($videos, "<i class='fas fa-blog'></i> Trending videos uploaded last week", false);
		} else {
			echo "<div class='alert alert-danger'>
				<i class='fas fa-info iconColor'></i> 
					ERROR: No trending videos to show! Please try again later. 😢
				</div>";
		}

	 ?>

</div>