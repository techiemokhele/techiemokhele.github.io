<?php 

	class SearchResultsProvider {

		private $con;
		private $userLoggedInObj;

		public function __construct($con, $userLoggedInObj) {
			$this->con = $con;
			$this->userLoggedInObj = $userLoggedInObj;
		}

		public function getVideos($term, $orderBy) {
			/*Fetches all the videos similar to the text typed on the search-bar.*/
			$query = $this->con->prepare("SELECT * FROM videos WHERE title LIKE CONCAT('%', :term, '%') OR uploadedBy LIKE CONCAT('%', :term, '%') ORDER BY $orderBy DESC");
			$query->bindParam(":term", $term);
			$query->execute();

			$videos = array();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			    $video = new Video($this->con, $row, $this->userLoggedInObj);
			    array_push($videos, $video);
			}

			return $videos;
		}
	}

 ?>