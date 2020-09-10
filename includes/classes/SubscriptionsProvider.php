<?php 

	class SubscriptionsProvider {

		private $con;
		private $userLoggedInObj;

		public function __construct($con, $userLoggedInObj) {
			$this->con = $con;
			$this->userLoggedInObj = $userLoggedInObj;
		}

		public function getVideos() {
			/*Get all videos a user subscribed to*/
			$videos = array();
			$subscriptions = $this->userLoggedInObj->getSubscriptions();

			if (sizeof($subscriptions) > 0) {
				$condition = "";
				$initialize = 0;

				while ($initialize < sizeof($subscriptions)) {
					if ($initialize == 0) {
						$condition .= "WHERE uploadedBy = ?";
					} else {
						$condition .= " OR uploadedBy = ?";
					}

					$initialize++;
				}

				$videoSql = "SELECT * FROM videos $condition ORDER BY uploadDate DESC";
				$videoQuery = $this->con->prepare($videoSql);

				$initialize = 1;

				foreach ($subscriptions as $sub) {
					$subUsername = $sub->getUsername();
					$videoQuery->bindValue($initialize, $subUsername);
					$initialize++;
				}

				$videoQuery->execute();
				while ($row = $videoQuery->fetch(PDO::FETCH_ASSOC)) {
				    $video = new Video($this->con, $row, $this->userLoggedInObj);
				    array_push($videos, $video);
				}
			}

			return $videos;
		}
	}

 ?>