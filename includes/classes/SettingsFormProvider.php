<?php  
	
	class SettingsFormProvider {

	    public function createUserDetailsForm($firstName, $lastName, $email) {
	    	$firstNameInput = $this->createFirstNameInput($firstName);
	    	$lastNameInput = $this->createLastNameInput($lastName);
	    	$emailInput = $this->createEmailInput($email);
	    	$saveButton = $this->createSaveUserDetailsButton();
	    	return "
	    		<p style='font-family:cursive;' align='center'>
	    			<img class='imgSize' src='media/img/favicon/android-chrome-192x192.png' alt='Video snap logo'><br><br> 
	    				Edit your information so that people can know you better<hr>
	    		</p>
				<form action='settings.php' method='POST' enctype='multipart/form-data'>
					<span class='title'>
						<i class='fas fa-user-astronaut'></i> User Details
					</span> <br><br>
					$firstNameInput
					$lastNameInput
					$emailInput
					$saveButton

					<a href='index.php' class='btn btn-danger'>
						<i class='fas fa-chevron-circle-left'></i> Cancel
	    			</a>

				</form>
	    	";
	    }

	    public function createPasswordForm() {
	    	$oldPasswordInput = $this->createPasswordInput("oldPassword", "Enter your old password");
	    	$newPassword1Input = $this->createPasswordInput("newPassword", "Enter your new Password");
	    	$newPassword2Input = $this->createPasswordInput("newPassword2", "Confirm your new Password");
	    	$saveButton = $this->createSavePasswordButton();

	    	return "<form action='settings.php' method='POST' enctype='multipart/form-data'>
					<span class='title'>
						<i class='fas fa-user-astronaut'></i> User Login Details
					</span> <br><br>
					$oldPasswordInput
					$newPassword1Input
					$newPassword2Input
					$saveButton

					<a href='index.php' class='btn btn-danger'>
						<i class='fas fa-chevron-circle-left'></i> Cancel
	    			</a>

				</form>
	    	";
	    }

	    /*Personal user change functions*/

	    private function createFirstNameInput($value) {
	    	if ($value == null) {
	    		$value = "";
	    	}
	    	return "<div class='form-group'>
	    				<input class='form-control' type='text' name='firstName' value='$value' placeholder='Edit your first name' required>
	    			</div>	
	    	";
	    }

	    private function createLastNameInput($value) {
	    	if ($value == null) {
	    		$value = "";
	    	}
	    	return "<div class='form-group'>
	    				<input class='form-control' type='text' name='lastName' value='$value' placeholder='Edit your last name' required>
	    			</div>	
	    	";
	    }

	    private function createEmailInput($value) {
	    	if ($value == null) {
	    		$value = "";
	    	}
	    	return "<div class='form-group'>
	    				<input class='form-control' type='email' name='email' value='$value' placeholder='Edit your email' required>
	    			</div>	
	    	";
	    }

	    private function createSaveUserDetailsButton() {
	    	return "<button type='submit' class='btn btn-primary' name='saveDetailsButton'>
						<i class='fas fa-cloud-upload-alt'></i> Save
	    			</button>";
	    }

	    /*Password change's functions*/
	    private function createPasswordInput($name, $placeholder) {
	    	return "<div class='form-group'>
	    				<input class='form-control' type='password' name='$name' placeholder='$placeholder' required>
	    			</div>	
	    	";
	    }

	    private function createSavePasswordButton() {
	    	return "<button type='submit' class='btn btn-primary' name='savePasswordButton'>
						<i class='fas fa-cloud-upload-alt'></i> Save
	    			</button>";
	    }

	}
	

 ?>