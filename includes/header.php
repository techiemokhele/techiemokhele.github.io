<?php 
	/*Database connection*/
	require_once "./config/db.php";
	require_once "./includes/classes/ButtonProvider.php";	
	require_once "./includes/classes/User.php";	
	require_once "./includes/classes/Video.php";
	require_once "./includes/classes/VideoGrid.php";
	require_once "./includes/classes/VideoGridItem.php";
	require_once "./includes/classes/SubscriptionsProvider.php";
	require_once "./includes/classes/NavigationMenuProvider.php";

	/*Check if user is logged in or not*/
	$usernameLoggedIn = User::isLoggedIn() ? $_SESSION["userLoggedIn"] : "";
	$userLoggedInObj = new User($con, $usernameLoggedIn);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!--Meta Data-->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Video streaming app">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="author" content="Neo Tsietsi Mokhele - Founder & CEO">
	    <meta name="title" content="Video Snap">
    	<meta name="description" content="Video Snap is a site that our users can use to stream videos uploaded by different people from around the world. You can stream, like, share, comment and do lots of other functions on the application. We promise to bring the hottest and latest content from around the globe. Subscribe today and stay abreast with the trendy videos.">
    	<meta name="keywords" content="Video, Stream, Share, Like, Subscribe, Comment, Dislike, Upload, Watch, Binge">
    	<meta http-equiv="refresh" content="">
		
		<title>Video Snap | Home</title>
		<!--Favicon-->
		<link rel="icon" type="image/png" href="media/img/favicon/favicon.ico">
		<link rel="icon" type="image/png" sizes="16x16" href="media/img/favicon/favicon-16x16.png">
		<link rel="icon" type="image/png" sizes="32x32" href="media/img/favicon/favicon-32x32.png">
		<link rel="apple-touch-icon" sizes="180x180" href="media/img/favicon/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="192x192" href="media/img/favicon/android-chrome-192x192.png">
		<link rel="icon" type="image/png" sizes="512x512" href="media/img/favicon/android-chrome-512x512.png">
		<link rel="manifest" href="media/img/favicon/site.webmanifest">
		
		<!--Fontawesome CDN-->
	    <link href="assets/fontawesome/css/fontawesome.css" rel="stylesheet">
	    <link href="assets/fontawesome/css/brands.css" rel="stylesheet">
	    <link href="assets/fontawesome/css/solid.css" rel="stylesheet">
	
		<!--Page Style Link-->
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
		<link rel="stylesheet" type="text/css" href="assets/css/contact.css">

		<!--Jquery Script Links-->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/commonActions.js"></script>
		<script src="assets/js/userActions.js"></script>

	</head><!--End Main Head-->
	
	<body>
		
		<!--Start pageContainer-->
		<div id="pageContainer">


			<div id="mastHeadContainer">
				<button class="navShowHide">
					<img src="media/img/icons/menu.png" alt="menu">
				</button>

				<a href="index.php" class="logoContainer">
					<img src="media/img/favicon/android-chrome-192x192.png" alt="logo" title="Video Snap Logo">
				</a>

				<div class="searchBarContainer">
					<form action="search.php" method="GET">
						<input type="text" class="searchBar" name="term" placeholder="Search">
						<button class="searchButton">
							<img src="media/img/icons/search.png" alt="Search button">
						</button>
					</form><!--End Form searchBarContainer-->
				</div><!--End searchBarContainer-->
				
				<div class="rightIcons">
					<a href="upload.php">
						<img class="upload" src="media/img/icons/upload.png" alt="upload button">
					</a>
					<?php 

						echo ButtonProvider::createUserProfileNavigationButton($con, $userLoggedInObj->getUsername());

					 ?>
				</div><!--End rightIcons-->

			</div><!--End mastHeadContainer-->

			<div id="sideNavContainer" style="display:none;">
				<?php 

					$navigationProvider = new NavigationMenuProvider($con, $userLoggedInObj);

					echo $navigationProvider->create();

				 ?>
			</div><!--End sideNavContainer-->

			<div id="mainSectionContainer" class="leftPadding">
				
				<div id="mainContentContainer">