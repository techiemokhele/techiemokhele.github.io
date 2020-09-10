<?php 

	/*Including all required pages*/
	require_once "./includes/header.php";
	require_once "./includes/classes/SearchResultsProvider.php";

	/*Checks if user entered a keyword on search-bar*/
	if (!isset($_GET["term"]) || $_GET["term"] == "") {
		echo "<div class='alert alert-danger'>
				<i class='fas fa-info iconColor'></i> 
					ERROR: You must enter a keyword to view some videos. 😢
				</div>";
		exit();
	}

	/*Executes the search function*/
	$term = $_GET["term"];

	if (!isset($_GET["orderBy"]) || $_GET["orderBy"] == "views") {
		$orderBy = "views";
	} else {
		$orderBy = "uploadDate";
	}


	$searchResultsProvider = new SearchResultsProvider($con, $userLoggedInObj);
	$videos = $searchResultsProvider->getVideos($term, $orderBy);

	$videoGrid = new VideoGrid($con, $userLoggedInObj);

 ?>


<div class="largeVideoGridContainer">
	
	<?php 

		if (sizeof($videos) > 0) {
			echo $videoGrid->createLarge($videos, "<i class='fas fa-video'></i> Total number of videos found: " . sizeof($videos), true);
		} else {
			echo "<div class='alert alert-danger'>
					<i class='fas fa-info iconColor'></i> 
						ERROR: No results found! Please try again. 😢
					</div>";
		}

	 ?>

</div>


 <?php 

	/*Including footer page*/
	require_once "./includes/footer.php";

 ?>