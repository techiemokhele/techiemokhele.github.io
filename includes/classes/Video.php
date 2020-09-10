<?php 

	class Video {

		private $con;
		private $sqlData;
		private $userLoggedInObj;

		public function __construct($con, $input, $userLoggedInObj) {
			$this->con = $con;
			$this->userLoggedInObj = $userLoggedInObj;


			/*Check if is video ID exist & is sqlData*/
			if (is_array($input)) {
				$this->sqlData = $input;
			} else {
				/*this is ID: create video*/
				$query = $this->con->prepare("SELECT * FROM videos WHERE id = :id");
				$query->bindParam(":id", $input);
				$query->execute();

				$this->sqlData = $query->fetch(PDO::FETCH_ASSOC);

			}
		}

		public function getId() {
			return $this->sqlData["id"];
		}

		public function getUploadedBy() {
			return $this->sqlData["uploadedBy"];
		}

		public function getTitle() {
			return $this->sqlData["title"];
		}

		public function getDescription() {
			return $this->sqlData["description"];
		}

		public function getPrivacy() {
			return $this->sqlData["privacy"];
		}

		public function getFilePath() {
			return $this->sqlData["filePath"];
		}

		public function getCategory() {
			return $this->sqlData["category"];
		}

		public function getUploadDate() {
			$date = $this->sqlData["uploadDate"];
			return date("M j, Y", strtotime($date));
		}

		public function getTimeStamp() {
			$date = $this->sqlData["uploadDate"];
			return date("M jS, Y", strtotime($date));
		}

		public function getViews() {
			return $this->sqlData["views"];
		}

		public function getDuration() {
			return $this->sqlData["duration"];
		}

		public function incrementViews() {
			/*Increase number of views per-stream*/
			$query = $this->con->prepare("UPDATE videos SET views=views+1 WHERE id=:id");
			$query->bindParam(":id", $videoId);

			$videoId = $this->getId();
			$query->execute();

			/*Update the views value in DB*/
			$this->sqlData["views"] = $this->sqlData["views"] + 1;
		}

		public function getLikes() {
			$query = $this->con->prepare("SELECT count(*) as 'count' FROM likes WHERE videoId = :videoId");
			$query->bindParam(":videoId", $videoId);
			$videoId = $this->getId();
			$query->execute();

			$data = $query->fetch(PDO::FETCH_ASSOC);
			return $data["count"];
		}

		public function getDislikes() {
			$query = $this->con->prepare("SELECT count(*) as 'count' FROM dislikes WHERE videoId = :videoId");
			$query->bindParam(":videoId", $videoId);
			$videoId = $this->getId();
			$query->execute();

			$data = $query->fetch(PDO::FETCH_ASSOC);
			return $data["count"];
		}

		public function like() {
			/*Find out if user liked the video*/
			$id = $this->getId();

			$username = $this->userLoggedInObj->getUsername();

			if ($this->wasLikedBy()) {
				/*User already liked video: Unlike*/
				$query = $this->con->prepare("DELETE FROM likes WHERE username = :username AND videoId = :videoId");
				$query->bindParam(":username", $username);
				$query->bindParam(":videoId", $id);
				$query->execute();

				$result = array(
					"likes" => -1,
					"dislikes" => 0
				);
				return json_encode($result);

			} else {
				/*Removes dislikes if video is liked*/
				$query = $this->con->prepare("DELETE FROM dislikes WHERE username = :username AND videoId = :videoId");
				$query->bindParam(":username", $username);
				$query->bindParam(":videoId", $id);
				$query->execute();
				$count = $query->rowCount();

				/*User has not liked video: LIKE*/
				$query = $this->con->prepare("INSERT INTO likes(username, videoId) VALUES(:username, :videoId)");
				$query->bindParam(":username", $username);
				$query->bindParam(":videoId", $id);
				$query->execute();

				$result = array(
					"likes" => 1,
					"dislikes" => 0 - $count
				);
				return json_encode($result);
			}
		}

		public function dislike() {
			/*Find out if user disliked the video*/
			$id = $this->getId();

			$username = $this->userLoggedInObj->getUsername();

			if ($this->wasDislikedBy()) {
				/*User already disliked video: LIKE*/
				$query = $this->con->prepare("DELETE FROM dislikes WHERE username = :username AND videoId = :videoId");
				$query->bindParam(":username", $username);
				$query->bindParam(":videoId", $id);
				$query->execute();

				$result = array(
					"likes" => 0,
					"dislikes" => -1
				);
				return json_encode($result);

			} else {
				/*Removes likes if video is liked*/
				$query = $this->con->prepare("DELETE FROM likes WHERE username = :username AND videoId = :videoId");
				$query->bindParam(":username", $username);
				$query->bindParam(":videoId", $id);
				$query->execute();
				$count = $query->rowCount();

				/*User has not liked video: DISLIKES*/
				$query = $this->con->prepare("INSERT INTO dislikes(username, videoId) VALUES(:username, :videoId)");
				$query->bindParam(":username", $username);
				$query->bindParam(":videoId", $id);
				$query->execute();

				$result = array(
					"likes" => 0 - $count,
					"dislikes" => 1
				);
				return json_encode($result);
			}
		}

		public function wasLikedBy() {
			$query = $this->con->prepare("SELECT * FROM likes WHERE username = :username AND videoId = :videoId");
			$query->bindParam(":username", $username);
			$query->bindParam(":videoId", $id);

			$id = $this->getId();

			$username = $this->userLoggedInObj->getUsername();
			$query->execute();

			return $query->rowCount() > 0;
		}

		public function wasDislikedBy() {
			$query = $this->con->prepare("SELECT * FROM dislikes WHERE username = :username AND videoId = :videoId");
			$query->bindParam(":username", $username);
			$query->bindParam(":videoId", $id);

			$id = $this->getId();

			$username = $this->userLoggedInObj->getUsername();
			$query->execute();

			return $query->rowCount() > 0;
		}

		public function getNumberOfComments() {
			$query = $this->con->prepare("SELECT * FROM comments WHERE videoId = :videoId");
			$query->bindParam(":videoId", $id);
			$id = $this->getId();
			$query->execute();

			return $query->rowCount();
		}

		public function getComments() {
			$query = $this->con->prepare("SELECT * FROM comments WHERE videoId = :videoId AND responseTo = 0 ORDER BY datePosted DESC");
			$query->bindParam(":videoId", $id);
			$id = $this->getId();
			$query->execute();

			$comments = array();

			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			    $comment = new Comment($this->con, $row, $this->userLoggedInObj, $id);
			    array_push($comments, $comment);
			}

			return $comments;
		}

		public function getThumbnail() {
			$query = $this->con->prepare("SELECT filePath FROM thumbnails WHERE videoId=:videoId AND selected = 1");
			$query->bindParam(":videoId", $videoId);
			$videoId = $this->getId();
			$query->execute();

			return $query->fetchColumn();
		}		

	}

 ?>