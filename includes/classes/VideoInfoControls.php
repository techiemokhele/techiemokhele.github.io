<?php 

	require_once "./includes/classes/ButtonProvider.php";

	class VideoInfoControls {

		private $video;
		private $userLoggedInObj;

		public function __construct($video, $userLoggedInObj) {
			$this->video = $video;
			$this->userLoggedInObj = $userLoggedInObj;
		}

		public function create() {

			$likeButton = $this->createLikeButton();
			$dislikeButton = $this->createDislikeButton();

			return 
				"<div class='controls'>
					$likeButton
					$dislikeButton
				</div>
			";
		}

		private function createLikeButton() {
			$text = $this->video->getLikes();
			$videoId = $this->video->getId();
			$action = "likeVideo(this, $videoId)";
			$class = "likeButton";
			$imageSrc = "./media/img/icons/thumb-up.png";

			/*Change button image if video has been liked already*/
			if ($this->video->wasLikedBy()) {
				$imageSrc = "./media/img/icons/thumb-up-active.png";
			}

			return ButtonProvider::createButton($text, $imageSrc, $action, $class);
		}

		private function createDislikeButton() {
			$text = $this->video->getDislikes();
			$videoId = $this->video->getId();
			$action = "dislikeVideo(this, $videoId)";
			$class = "dislikeButton";
			$imageSrc = "./media/img/icons/thumb-down.png";

			/*Change button image if video has been disliked already*/
			if ($this->video->wasDislikedBy()) {
				$imageSrc = "./media/img/icons/thumb-down-active.png";
			}
			

			return ButtonProvider::createButton($text, $imageSrc, $action, $class);
		}
	}

 ?>