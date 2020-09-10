<?php 

	class VideoGridItem {
		/*Show all random videos on the side of the page*/
		private $video;
		private $largeMode;

		public function __construct($video, $largeMode) {
			$this->video = $video;
			$this->largeMode = $largeMode;
		} 

		public function create() {
			$thumbnail = $this->createthumbnail();
			$details = $this->createDetails();
			$url = "watch.php?id=" . $this->video->getId();

			return "<a href='$url'>
						<div class='videoGridItem'>
							$thumbnail
							$details
						</div>
					</a>";
		}

		private function createThumbnail() {
			
			$thumbnail = $this->video->getThumbnail();
			$duration  = $this->video->getDuration();

			return "<div class='thumbnail'>
						<img src='$thumbnail'>

							<div class='duration'>
								<span>$duration</span>
							</div>

					</div>";

		}

		private function createDetails() {
			$title = $this->video->getTitle();
			$username = $this->video->getUploadedBy();
			$views = $this->video->getViews();
			$description = $this->createDescription();
			$timestamp = $this->video->getTimeStamp();

			return "<div class='details'>
						<h3 class='title'>$title</h3>
						<span class='username'>
							<i class='fas fa-user-astronaut'></i> $username
						</span>
						
						<div class='stats'>
							<span class='viewCount'>
								<i class='fas fa-users'></i> $views views
							</span><br>
							<span class='timestamp'>
								<i class='fas fa-calendar-day'></i> $timestamp
							</span>		
						</div>
						
						$description
					</div>";

		}

		private function createDescription() {
			if (!$this->largeMode) {
				return "";
			} else {
				$description = $this->video->getDescription();
				$description = (strlen($description) > 350) ? substr($description, 0, 347) . "..." : $description;

				return "<span class='description'>$description</span>";
			}
		}
	}

 ?>