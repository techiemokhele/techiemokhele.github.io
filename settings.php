<?php 

	/*Including header page*/
	require_once "./includes/header.php";
	require_once "./includes/classes/Account.php";
	require_once "./includes/classes/FormSanitizer.php";
	require_once "./includes/classes/Constants.php";
	require_once "./includes/classes/SettingsFormProvider.php";

	if (!User::isLoggedIn()) {
		header("Location: signIn.php");
	}

	$detailsMessage = "";
	$passwordMessage = "";

	$formProvider = new SettingsFormProvider();

	/*Check if form was sent: Save Details*/
	if (isset($_POST["saveDetailsButton"])) {
		$account = new Account($con);

		$firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
		$lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
		$email = FormSanitizer::sanitizeFormString($_POST["email"]);

		if ($account->updateDetails($firstName, $lastName, $email, $userLoggedInObj->getUsername())) {
			$detailsMessage = "<div class='alert alert-success'>
									SUCCESS: <strong>Details updated succesfully</strong>
								</div>";
		} else {
			$errorMessage = $account->getFirstError();

			if ($errorMessage == "") {
				$errorMessage = "Something went wrong!";
			}

			$detailsMessage = "<div class='alert alert-danger'>
									<strong>Error:</strong> $errorMessage
								</div>";
		}
	}

	/*Check if form was sent: Save Password*/
	if (isset($_POST["savePasswordButton"])) {
		$account = new Account($con);

		$oldPassword = FormSanitizer::sanitizeFormPassword($_POST["oldPassword"]);
		$newPassword = FormSanitizer::sanitizeFormPassword($_POST["newPassword"]);
		$newPassword2 = FormSanitizer::sanitizeFormPassword($_POST["newPassword2"]);

		if ($account->updatePassword($oldPassword, $newPassword, $newPassword2,  $userLoggedInObj->getUsername())) {
			$passwordMessage = "<div class='alert alert-success'>
									<strong>SUCCESS:</strong> Password updated succesfully
								</div>";
		} else {
			$errorMessage = $account->getFirstError();

			if ($errorMessage == "") {
				$errorMessage = "Something went wrong!";
			}

			$passwordMessage = "<div class='alert alert-danger'>
									<strong>Error Note:</strong> $errorMessage
								</div>";
		}
	}

 ?>

 <div class="settingsContainer column">
 	
 	<div class="formSection">
 		
 		<div class="message">
 			<?php 

 				echo $detailsMessage;

 			 ?>
 		</div>

 		<?php 

 			echo $formProvider->createUserDetailsForm(
 				isset($_POST['firstName']) ? $_POST['firstName'] : $userLoggedInObj->getFirstName(),
 				isset($_POST['lastName']) ? $_POST['lastName'] : $userLoggedInObj->getLastName(),
 				isset($_POST['email']) ? $_POST['email'] : $userLoggedInObj->getEmail()
 			);

 		 ?>

 	</div><!--End create createUserDetailsForm-->

 	<hr>

 	<div class="formSection">

 		<div class="message">
 			<?php 

 				echo $passwordMessage;

 			 ?>
 		</div>
 		
 		<?php 

 			echo $formProvider->createPasswordForm();

 		 ?>

 	</div><!--End create createUserDetailsForm-->

 </div>