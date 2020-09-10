<?php 

	require "ProfileData.php";

	class ProfileGenerator {
		private $con;
		private $userLoggedInObj;
		private $profileData;

		public function __construct($con, $userLoggedInObj, $profileUsername) {
			$this->con = $con;
			$this->userLoggedInObj = $userLoggedInObj;
			$this->profileData = new ProfileData($con, $profileUsername);
		}

		public function create() {
			$profileUsername = $this->profileData->getProfileUsername();

			if (!$this->profileData->userExists()) {
				return "<div class='alert alert-danger'>
							<i class='fas fa-info iconColor'></i> 
								ERROR: Unfortunately, this user does not exist! 😢
							<br><br><p align='center'>
								<img src='media/img/error/404.gif' alt='user not found'>
							</p>	
						</div>";
			}

			/*Profile.php actual content: HTML format*/
			$coverPhotoSection = $this->createCoverPhotoSection();
			$headerSection = $this->createHeaderSection();
			$tabSection = $this->createTabSection();
			$contentSection = $this->createContentSection();
			
			return "<div class='profileContainer'>
						$coverPhotoSection
						$headerSection
						$tabSection
						$contentSection
					</div>";
		}

		public function createCoverPhotoSection() {
			$coverPhotoSrc = $this->profileData->getCoverPhoto();
			$name = $this->profileData->getProfileUserFullName();

			return "<div class='coverPhotoContainer'>
						<span class='channelName'>
							<i class='fas fa-user-astronaut'></i> $name
						</span>
						<img src='$coverPhotoSrc' class='coverPhoto'>
					</div>";
		}

		public function createHeaderSection() {
			/*Retrieve user information*/
			$profileImage = $this->profileData->getProfilePic();
			$name = $this->profileData->getProfileUserFullName();
			$subCount = $this->profileData->getSubscriberCount();

			$button = $this->createHeaderButton();

			return "<div class='profileHeader'>
						<div class='userInfoContainer'>
							<img src='$profileImage' class='profileImage'>
							<div class='userInfo'>
								<span class='title'>$name</span>
								<span class='subscriberCount'>$subCount subscribers</span>
							</div>
						</div>

						<div class='buttonContainer'>
							<div class='buttonItem'>
								$button
							</div>
						</div>
					</div>";
		}

		public function createTabSection() {
			return "<ul class='nav nav-tabs' role='tablist'>
					  <li class='nav-item'>
					    <a class='nav-link active' id='videos-tab' data-toggle='tab' href='#videos' role='tab' aria-controls='videos' aria-selected='true'>VIDEOS</a>
					  </li>
					  <li class='nav-item'>
					    <a class='nav-link' id='about-tab' data-toggle='tab' href='#about' role='tab' aria-controls='about' aria-selected='false'>ABOUT</a>
					  </li>
					</ul>
					";
		}

		public function createContentSection() {

			$videos = $this->profileData->getUsersVideos();

			if (sizeof($videos) > 0) {
				$videoGrid = new VideoGrid($this->con, $this->userLoggedInObj);
				$videoGridHtml = $videoGrid->create($videos, null, false);
			} else {
				$videoGridHtml = "<span>
									<b class='errorMessage'>This user has no video! 😢</b>
								</span>";
			}

			$aboutSection = $this->createAboutSection();

			return "<div class='tab-content channelContent'>
					  <div class='tab-pane fade show active' id='videos' role='tabpanel' aria-labelledby='videos-tab'>
					  	$videoGridHtml
					  </div>
					  <div class='tab-pane fade' id='about' role='tabpanel' aria-labelledby='about-tab'>
					  	$aboutSection
					  </div>
					</div>";
		}

		private function createHeaderButton() {
			if ($this->userLoggedInObj->getUsername() == $this->profileData->getProfileUsername()) {
				return "";
			} else {
				return ButtonProvider::createSubscriberButton($this->con, $this->profileData->getProfileUserObj(), $this->userLoggedInObj);
			}
		}

		private function createAboutSection() {

			$html = "<div class='section'>
					<div class='title'>
						<span>
							<i class='fas fa-info-circle'></i> 
								PROFILE DETAILS <hr>
						</span>
					</div>
					<div class='values'>";

			/*Add user details*/
			$details = $this->profileData->getAllUserDetails();
			foreach ($details as $key => $value) {
				$html .= "<span>$key $value</span>";			
			}		
						
			$html .= "</div>
				</div>";

			return $html;	

		}

	}

 ?>