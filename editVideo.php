<?php 

	require_once "./includes/header.php";
	require_once "./includes/classes/VideoPlayer.php";
	require_once "./includes/classes/VideoDetailsFormProvider.php";
	require_once "./includes/classes/VideoUploadData.php";
	require_once "./includes/classes/SelectThumbnail.php";

	/*Check if user is logged in or not*/
	if (!User::isLoggedIn()) {
		header("Location: signIn.php");
	}

	/*Check if video exists*/
	if (!isset($_GET["videoId"])) {
		echo "<div class='alert alert-danger'>
				<i class='fas fa-info'></i> ERROR: No video has been selected! 😢
			</div>";
			exit();
	}

	$video = new Video($con, $_GET["videoId"], $userLoggedInObj);

	/*Protect other users if user manuslly enters a video ID*/
	if ($video->getUploadedBy() != $userLoggedInObj->getUsername()) {
		echo "<div class='alert alert-danger'>
				<i class='fas fa-info'></i> ERROR: You cannot edit this video because this is not your video! 😢
			</div>";
			exit();
	}

	$detailsMessage = "";

	/*Check if form was submitted by user*/
	if (isset($_POST["saveButton"])) {
			$videoData = new VideoUploadData(
			null, 
			$_POST["titleInput"],
			$_POST["descriptionInput"],
			$_POST["privacyInput"],
			$_POST["categoryInput"],
			$userLoggedInObj->getUsername()
		);

		if ($videoData->updateDetails($con, $videoId->getId())) {
			$detailsMessage = "<div class='alert alert-success'>
									SUCCESS: <strong>Details updated succesfully</strong>
								</div>";

			$video = new Video($con, $_GET["videoId"], $userLoggedInObj);
		} else {

			$detailsMessage = "<div class='alert alert-danger'>
									<strong>Error:</strong> Something went wrong! 😢
								</div>";
		}	
	}

 ?>

 <script src="assets/js/editVideoActions.js"></script>

 <div class="editVideoContainer column">

 	<div class="message">
 		<?php 

 			echo $detailsMessage;

 		 ?>
 	</div>

 	<div class="topSection">
 		<?php 

 			/*Display the video being edited*/
 			$videoPlayer = new VideoPlayer($video);
 			echo $videoPlayer->create(false);

 			/*Show generated video thumnails*/
 			$selectThumbnail = new SelectThumbnail($con, $video);
 			echo $selectThumbnail->create();

 		 ?>
 	</div>

 	<div class="bottomSection">
 		<?php 

 			$formProvider = new VideoDetailsFormProvider($con);
 			echo $formProvider->createEditDetailsForm($video);

 		 ?>
 	</div>
 	
 </div>