<?php 

	/*Including header page*/
	require_once "./includes/header.php";
	require_once "./includes/classes/VideoPlayer.php";
	require_once "./includes/classes/VideoInfoSection.php";
	require_once "./includes/classes/Comment.php";
	require_once "./includes/classes/commentSection.php";


	/*Get video ID - URL*/
	if (!isset($_GET["id"])) {
		echo "<div class='alert alert-danger'>
			<i class='fas fa-info iconColor'></i> 
				ERROR: The video you are looking for does not exist! Please contact our support for more details. <br><br>
				<p align='center'>
					<img src='./media/img/error/404.gif' alt='404'><br><br>
					<a href='./contact.php' class='btn btn-primary'>
						<i class='fas fa-envelope-open-text'></i> Contact support
					</a>
				</p>
			</div>";
			exit();
	}

	$video = new Video($con, $_GET["id"], $userLoggedInObj);
	$video->incrementViews();

 ?>

 <script src="assets/js/videoPlayerActions.js"></script>
 <script src="assets/js/commentActions.js"></script>

<!--Start Main page content-->

	<div class="watchLeftColumn">
		
		<?php 
			/*Autoplay from refresh does not play because there's a chrome bug*/
			$videoPlayer = new VideoPlayer($video);
			echo $videoPlayer->create(true);

			$videoPlayer = new VideoInfoSection($con, $video, $userLoggedInObj);
			echo $videoPlayer->create();

			if ($usernameLoggedIn === "") {
				$commentSection = new commentSection($con, $video, '');
			} else {
				$commentSection = new commentSection($con, $video, $userLoggedInObj);
			}

			echo $commentSection->create();

		 ?>

	</div>

	<div class="suggestions">
		 <?php 
		 	$videoGrid = new VideoGrid($con, $userLoggedInObj);
		 	echo $videoGrid->create(null, null, false);
		 ?>
	</div>

<!--End Main page content-->

 <?php 

	/*Including footer page*/
	require_once "./includes/footer.php";

 ?>			