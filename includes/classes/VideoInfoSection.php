<?php 

	require_once "./includes/classes/VideoInfoControls.php";

	class VideoInfoSection {

		private $con;
		private $video;
		private $userLoggedInObj;

		public function __construct($con, $video, $userLoggedInObj) {
			$this->con = $con;
			$this->video = $video;
			$this->userLoggedInObj = $userLoggedInObj;
		}

		public function create() {

			return $this->createPrimaryInfo() . $this->createSecondaryInfo();

		}

		private function createPrimaryInfo() {
			/*Shows main part of the video: who uploaded the video*/
			$title = $this->video->getTitle();
			$views = $this->video->getViews();

			$VideoInfoControls = new VideoInfoControls($this->video, $this->userLoggedInObj);
			$controls = $VideoInfoControls->create();

			return "
				<div class='videoInfo'>
					<h1><i class='fas fa-video'></i> $title</h1>

					<div class='bottomSection'>
						<span class='viewCount'>
							<i class='fas fa-users'></i> $views Views</span>
						$controls	
					</div>
				</div>
			";
		}

		private function createSecondaryInfo() {
			/*Show user information and descriptions*/
			$description = $this->video->getDescription();
			$uploadDate = $this->video->getUploadDate();
			$uploadedBy = $this->video->getUploadedBy();
			$profileButton = ButtonProvider::createUserProfileButton($this->con, $uploadedBy);


			/*Subscribe button*/
			if ($uploadedBy == $this->userLoggedInObj->getUsername()) {
				/*Show edit button: if user logged in*/
				$actionButton = ButtonProvider::createEditVideoButton($this->video->getId());
			} else {
				/*Show subcribe button: if user not logged in*/
				$userToObject = new User($this->con, $uploadedBy);
				$actionButton = ButtonProvider::createSubscriberButton($this->con, $userToObject, $this->userLoggedInObj);
			}

			return "<div class='secondaryInfo'>
				
					<div class='topRow'>
						$profileButton

						<div class='uploadInfo'>
							<span class='owner'>
								<a href='profile.php?username=$uploadedBy'>
									$uploadedBy
								</a>
							</span>	

							<span class='date'>
								Published on $uploadDate
							</span>
						</div>

						$actionButton

					</div>

					<div class='descriptionContainer'>
						$description
					</div>

				</div>";
		}
	}

 ?>