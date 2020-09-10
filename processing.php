<?php 

	/*Including header page*/
	require_once "./includes/header.php";
	require_once "./includes/classes/VideoUploadData.php";
	require_once "./includes/classes/VideoProcessor.php";

	/*Check if user submit form correctly*/
	if (!isset($_POST["uploadButton"])) {
		echo "<div class='alert alert-danger'>
				<i class='fas fa-info iconColor'></i> 
					ERROR: Unfortunately, no file has been submitted! Please try again later. 😢
				</div>";
		exit();
	} 
		//1. Create file upload data
		$videoUploadData = new VideoUploadData(
			$_FILES["fileInput"], 
			$_POST["titleInput"],
			$_POST["descriptionInput"],
			$_POST["privacyInput"],
			$_POST["categoryInput"],
			$userLoggedInObj->getUsername()
		);

		//2. Process video data; uploaded
		$videoProcessor = new VideoProcessor($con);
		$wasSuccessful = $videoProcessor->upload($videoUploadData);

		//3. Check if upload was successful
		if ($wasSuccessful) {
			echo "<div class='alert alert-success'>
				<i class='fas fa-info iconColorSuccess'></i> 
					SUCCESS: Your video was successfully uploaded.
				</div>";
		}

 ?>