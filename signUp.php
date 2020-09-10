<?php 
	/*Database connection*/
	require_once "./config/db.php";
	require_once "./includes/classes/Account.php";
	require_once "./includes/classes/Constants.php";
	require_once "./includes/classes/FormSanitizer.php";

	$account = new Account($con);


	/*Check If form was submitted*/
	if (isset($_POST["submitButton"])) {
		/*Sanitize user data*/
	 	$firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
	 	$lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
	 	
	 	$username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
	 	
	 	$email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
	 	$email2 = FormSanitizer::sanitizeFormEmail($_POST["email2"]);
	 	
	 	$password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
	 	$password2 = FormSanitizer::sanitizeFormPassword($_POST["password2"]);

	 	/*Form Validation: Processing the data*/
	 	$wasSuccessful = $account->register($firstName, $lastName, $username, $email, $email2, $password, $password2);

	 	if ($wasSuccessful) {
	 		/*Storing the user session*/
	 		$_SESSION["userLoggedIn"] = $username;
	 		header("Location: index.php");
	 	} 
	 }

	 function getInputValue($name) {
	 	/*Stores user last entered data into text field*/
	 	if (isset($_POST["$name"])) {
	 		echo $_POST[$name];
	 	}
	 } 
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
		
		<title>Video Snap | Sign Up</title>
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

		<!--Jquery Script Links-->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>

	</head><!--End Main Head-->
	
	<body>

		<div class="signInContainer">
			
			<div class="column">
				
				<div class="header">
					<p align="center">
						<img src="media/img/favicon/android-chrome-192x192.png" alt="logo" title="Video Snap Logo">
					</p><hr>
					<h3>Sign Up</h3>
					<span>to continue to Video Snap</span>

				</div><!--End header-->

				<div class="loginForm">

					<form action="signUp.php" method="POST">
						<?php echo $account->getError(Constants::$firstNameCharacters); ?>
						<input type="text" name="firstName" value="<?php getInputValue('firstName'); ?>" placeholder="First name" autocomplete="OFF" required>

						<?php echo $account->getError(Constants::$lastNameCharacters); ?>
						<input type="text" name="lastName" value="<?php getInputValue('lastName'); ?>" placeholder="Last name" autocomplete="OFF" required>

						<?php echo $account->getError(Constants::$usernameCharacters); ?>
						<?php echo $account->getError(Constants::$usernameTaken); ?>
						<input type="text" name="username" value="<?php getInputValue('username'); ?>" placeholder="Username" autocomplete="OFF" required>

						<?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
						<?php echo $account->getError(Constants::$emailInvalid); ?>
						<?php echo $account->getError(Constants::$emailTaken); ?>
						<input type="email" name="email" value="<?php getInputValue('email'); ?>" placeholder="Email" autocomplete="OFF" required>

						<input type="email" name="email2" value="<?php getInputValue('email2'); ?>" placeholder="Confirm email" autocomplete="OFF" required>

						<?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
						<?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
						<?php echo $account->getError(Constants::$passwordLength); ?>
						<input type="password" name="password" placeholder="Password" autocomplete="OFF" required>

						<input type="password" name="password2" placeholder="Confirm password" autocomplete="OFF" required>

						<input type="submit" name="submitButton" value="Sign Up">
					</form>
					
				</div><!--End loginForm-->
				<p align="center">
					<a class="signInMessage" href="signIn.php">Already have an account? Sign in here.</a>
				</p>

			</div><!--End column-->

		</div><!--End signInContainer-->

	</body>

</html>