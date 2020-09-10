<?php  
	
	class VideoDetailsFormProvider {

		private $con;

		public function __construct($con) {
			/*Constructor: 
				1. used for SCOPE accessibility; variables outside file
				2. Called before the code is initialised
			*/
			$this->con = $con;
		}

	    public function createUploadForm() {
	    	$fileInput = $this->createFileInput();
	    	$titleInput = $this->createTitleInput(null);
	    	$descriptionInput = $this->createDescriptionInput(null);
	    	$privacyInput = $this->createPrivacyInput(null);
	    	$categoriesInput = $this->createCategoriesInput(null);
	    	$uploadButton = $this->createUploadButton();
	    	return "
	    		<p style='font-family:cursive;' align='center'>
	    			<img class='imgSize' src='media/img/favicon/android-chrome-192x192.png' alt='Video snap logo'><br><br> 
	    				Upload a new video for free and share it with your friends and family<hr>
	    		</p>
				<form action='processing.php' method='POST' enctype='multipart/form-data'>
					
					$fileInput
					$titleInput
					$descriptionInput
					$privacyInput
					$categoriesInput
					$uploadButton

				</form>
	    	";
	    }

	    public function createEditDetailsForm($video) {
	    	$titleInput = $this->createTitleInput($video->getTitle());
	    	$descriptionInput = $this->createDescriptionInput($video->getDescription());
	    	$privacyInput = $this->createPrivacyInput($video->getPrivacy());
	    	$categoriesInput = $this->createCategoriesInput($video->getCategory());
	    	$saveButton = $this->createSaveButton();
	    	return "
				<form method='POST'>
					
					$titleInput
					$descriptionInput
					$privacyInput
					$categoriesInput
					$saveButton

				</form>
	    	";
	    }

	    private function createFileInput() {
	    	/*Creates the default HTML form field for uploading files*/
	    	return "<div class='form-group'>
			    		<input type='file' class='form-control-file' name='fileInput' required>
			    	</div>";
	    }

	    private function createTitleInput($value) {
	    	
	    	if ($value == null) {
	    		$value = "";
	    	}

	    	return "<div class='form-group'>
	    				<input class='form-control' type='text' name='titleInput' placeholder='Enter a title' value='$value'>
	    			</div>	
	    	";
	    }

	    private function createDescriptionInput($value) {
	    	
	    	if ($value == null) {
	    		$value = "";
	    	}

	    	return "<div class='form-group'>	
	    				<textarea class='form-control' name='descriptionInput' placeholder='Enter a description' row='3' style='resize:none;'>$value</textarea>
	    			</div>	
	    	";
	    }

	    private function createPrivacyInput($value) {
	    	
	    	if ($value == null) {
	    		$value = "";
	    	}

	    	$privateSelected = ($value == 0) ? "selected='selected'" : "";
	    	$publicSelected = ($value == 1) ? "selected='selected'" : "";

	    	return "<div class='form-group'>
						<select class='form-control' name='privacyInput'>
							<option value='0' $privateSelected>Private</option>
							<option value='1' $publicSelected>Public</option>
						</select>
	    			</div>
	    	";
	    }

	    private function createCategoriesInput($value) {

	    	if ($value == null) {
	    		$value = "";
	    	}

	    	/*Retrieving the categories data*/
			$query = $this->con->prepare("SELECT * FROM categories");
			$query->execute();

			$html = "<div class='form-group'>
						<select class='form-control' name='categoryInput'>
					";

			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			    /*Loop through the records stored in the database*/
			    $id = $row ["id"];
			    $name = $row ["name"];

			    $selected = ($id == $value) ? "selected='selected'" : "";

			    $html .=  "<option $selected value='$id'>$name</option>";
			}
			$html .= "	</select>
	    			</div>";

	    	return $html;
	    }

	    private function createUploadButton() {
	    	return "<button type='submit' class='btn btn-primary' name='uploadButton'>
						<i class='fas fa-cloud-upload-alt'></i> Upload
	    			</button>";
	    }

	    private function createSaveButton() {
	    	return "<button type='submit' class='btn btn-primary' name='saveButton'>
						<i class='fas fa-cloud-upload-alt'></i> Save
	    			</button>";
	    }
	}
	

 ?>