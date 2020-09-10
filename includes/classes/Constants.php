<?php 

	class Constants {
		/*Show error message Array: Registration*/
		public static $firstNameCharacters = "
		<div class='alert alert-danger'>
			<i class='fas fa-info'></i> First name must be between 2 and 25 characters long 😢
		</div>";

		public static $lastNameCharacters = "
		<div class='alert alert-danger'>
			<i class='fas fa-info'></i> Last name must be between 2 and 25 characters long 😢
		</div>";

		public static $usernameCharacters = "
		<div class='alert alert-danger'>
			<i class='fas fa-info'></i> Username must be between 5 and 25 characters long 😢
		</div>";

		public static $usernameTaken = "
		<div class='alert alert-danger'>
			<i class='fas fa-info'></i> Unfortunately, this username is already in use 😢
		</div>";

		public static $emailsDoNotMatch = "
		<div class='alert alert-danger'>
			<i class='fas fa-info'></i> Your emails do not match 😢
		</div>";

		public static $emailInvalid = "
		<div class='alert alert-danger'>
			<i class='fas fa-info'></i> Please enter a valid email address 😢
		</div>";

		public static $emailTaken = "
		<div class='alert alert-danger'>
			<i class='fas fa-info'></i> Unfortunately, this email is already in use 😢
		</div>";

		public static $passwordsDoNotMatch = "
		<div class='alert alert-danger'>
			<i class='fas fa-info'></i> Your passwords do not match 😢
		</div>";

		public static $passwordNotAlphanumeric = "
		<div class='alert alert-danger'>
			<i class='fas fa-info'></i> Your passwords should only contain letters and numbers 😢
		</div>";

		public static $passwordLength = "
		<div class='alert alert-danger'>
			<i class='fas fa-info'></i> Password must be between 5 and 30 characters long 😢
		</div>";

		public static $loginFailed = "
		<div class='alert alert-danger'>
			<i class='fas fa-info'></i> Your username or password was incorrect 😢
		</div>";

		public static $passwordIncorrect = "
		<div class='alert alert-danger'>
			<i class='fas fa-info'></i> Could not update your profile because your password is incorrect 😢
		</div>";
	}

 ?>