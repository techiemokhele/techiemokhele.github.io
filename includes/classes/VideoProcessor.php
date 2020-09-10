<?php 

	class VideoProcessor {

		private $con;
		private $sizeLimit = 50000000; //5million BYTES [half Gigabyte]
		private $allowedTypes = array(
			"mp4",
			"flv",
			"webm",
			"mkv",
			"vob",
			"ogg",
			"avi",
			"wmv",
			"mov",
			"mpeg",
			"mpg",
			"qt",
			"drc",
			"gif",
			"gifv",
			"mng",
			"mts",
			"m2ts",
			"ts",
			"yuv",
			"rm",
			"rmvb",
			"viv",
			"asf",
			"amv",
			"mp2",
			"mpe",
			"mpv",
			"m4v",
			"svi",
			"3gp",
			"3g2",
			"mxf",
			"roq",
			"nsv",
			"f4v",
			"f4p",
			"f4a",
			"f4b"
		);
		private $ffmpegPath;
		private $ffprobePath;


		public function __construct($con) {
			/*Constructor: 
				1. used for SCOPE accessibility; variables outside file
				2. Called before the code is initialised
			*/
			$this->con = $con;
			$this->ffmpegPath = realpath("ffmpeg/bin/ffmpeg.exe");
			$this->ffprobePath = realpath("ffmpeg/bin/ffprobe.exe");
		}

		public function upload($videoUploadData) {
			$targetDir = "uploads/videos/";
			$videoData = $videoUploadData->videoDataArray;

			$tempFilePath = $targetDir . uniqid() . basename($videoData["name"]);
			$tempFilePath = str_replace(" ", "_", $tempFilePath); 

			$isValidData = $this->processData($videoData, $tempFilePath);

			if (!$isValidData) {
				return false;
			}

			/*
				tmp_name: stores data on servers hard disc temporarily - unsupported file paths.
			*/
			if (move_uploaded_file($videoData["tmp_name"], $tempFilePath)) {
				/*Final converted uploaded file: mp4*/
				$finalFilePath = $targetDir . uniqid() . ".mp4";

				if (!$this->insertVideoData($videoUploadData, $finalFilePath)) {
					echo "insert error failed";
					return false;
				}

				if (!$this->convertVideoToMp4($tempFilePath, $finalFilePath)) {
					echo "<div class='alert alert-danger'>
						<i class='fas fa-info iconColor'></i> 
							ERROR: The upload process failed! Please try again. 😢
						</div>";
						return false;
				}


				if (!$this->deleteFile($tempFilePath)) {
					echo "<div class='alert alert-danger'>
						<i class='fas fa-info iconColor'></i> 
							ERROR: The upload process failed! Please try again. 😢
						</div>";
						return false;
				}

				if (!$this->generateThumbnails($finalFilePath)) {
					echo "<div class='alert alert-danger'>
						<i class='fas fa-info iconColor'></i> 
							ERROR: The upload process failed! Could not generate thumbnail. Please try again. 😢
						</div>";
						return false;
				}

				return true;	
			}
		}

		private function processData($videoData, $filePath) {
			$videoType = pathInfo($filePath, PATHINFO_EXTENSION);

			/*Validate submitted: SIZE,TYPE, ERRORS*/
			if (!$this->isValidSize($videoData)) {
				echo "<div class='alert alert-danger'>
						<i class='fas fa-info iconColor'></i> 
							ERROR: File is too large! File cannot be more than ". $this->sizeLimit ." bytes. Please try again. 😢
						</div>";
				return false;
			}
			else if(!$this->isValidType($videoType)) {
				echo "<div class='alert alert-danger'>
						<i class='fas fa-info iconColor'></i> 
							ERROR: You have uploaded an unsupported file type! Please try again. 😢
						</div>";
				return false;
			} 

			else if ($this->hasError($videoData)) {
				echo "<div class='alert alert-danger'>
						<i class='fas fa-info iconColor'></i> 
							ERROR: Unexpected processing! Error code: ".$videoData["error"].". Please try again. 😢
						</div>";
				return false;		
			}

			/*If no error: save uploaded video*/
			return true; 
		}

		private function isValidSize($data) {
			return $data["size"] <= $this->sizeLimit;
		}

		private function isValidType($type) {
			$lowerCased = strtolower($type);
			return in_array($lowerCased, $this->allowedTypes);
		}

		private function hasError($data) {
			return $data["error"] != 0;
		}

		private function insertVideoData($uploadData, $filePath) {
			$query = $this->con->prepare(
				"INSERT INTO videos(title, uploadedBy, description, privacy, category, filePath)
				VALUES(:title, :uploadedBy, :description, :privacy, :category, :filePath)
				");

			$query->bindParam(":title", $uploadData->title);
			$query->bindParam(":uploadedBy", $uploadData->uploadedBy);
			$query->bindParam(":description", $uploadData->description);
			$query->bindParam(":privacy", $uploadData->privacy);
			$query->bindParam(":category", $uploadData->category);
			$query->bindParam(":filePath", $filePath);

			return $query->execute();
		}

		public function convertVideoToMp4($tempFilePath, $finalFilePath) {
			$cmd = "$this->ffmpegPath -i $tempFilePath $finalFilePath 2>&1";

			/*Check if the conversion was successful or not*/
			$outputLog = array();
			exec($cmd, $outputLog, $returnCode);

			if ($returnCode != 0) {
				//Command failed
				foreach ($outputLog as $line) {
					echo $line . "<br>";
				}
				//if it didn't work
				return false;
			} 
			return true;
		}

		private function deleteFile($filePath) {
			/*Delete the temporarily stored video in the project*/
			if (!unlink($filePath)) {
				echo "<div class='alert alert-danger'>
						<i class='fas fa-info iconColor'></i> 
							ERROR: Could not delete file! Please try again. 😢\n
						</div>";
						return false;
			}
			return true;
		}

		public function generateThumbnails($filePath) {
			$thumbnailSize = "210x118";
			$numThumbnails = 3;
			$pathToThumbnail = "uploads/videos/thumbnails";

			$duration = $this->getVideoDuration($filePath);

			$videoId = $this->con->lastInsertId();
			
			$this->updateDuration($duration, $videoId);

			for ($num = 1; $num <= $numThumbnails; $num++) {
				$imageName = uniqid() . ".jpg";
				$interval = ($duration * 0.8) / $numThumbnails * $num;
				$fullThumbnailPath = "$pathToThumbnail/$videoId-$imageName";

				/*Create Thumbnails
				-i = filepath
				-ss = intervals to generate thumbnails from video
				-s = file size
				-vframe =  number of video frames to generate
				*/
				$cmd = "$this->ffmpegPath -i $filePath -ss $interval -s $thumbnailSize -vframes 1 $fullThumbnailPath 2>&1";

				/*Check if the conversion was successful or not*/
				$outputLog = array();
				exec($cmd, $outputLog, $returnCode);

				if ($returnCode != 0) {
					//Command failed
					foreach ($outputLog as $line) {
						echo $line . "<br>";
					}
				}

				/*Insert thumbnail into table*/
				$query = $this->con->prepare("INSERT into thumbnails(videoId, filePath, selected)
						VALUES(:videoId, :filePath, :selected)");
				$query->bindParam(":videoId", $videoId);
				$query->bindParam(":filePath", $fullThumbnailPath);
				$query->bindParam(":selected", $selected); 

				$selected = $num == 1 ? : 0;

				$success = $query->execute();

				if (!$success) {
					echo "<div class='alert alert-danger'>
						<i class='fas fa-info iconColor'></i> 
							ERROR: Could not insert a new thumbnail! Please try again.\n
						</div>";
						return false;
				}
			}

			return true;

		}

		private function getVideoDuration($filePath) {
			/*Allows us to execute a script: returns output given*/
			return (int)shell_exec("$this->ffprobePath -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 $filePath");
		}

		private function updateDuration($duration, $videoId) {
			
			$hours = floor($duration / 3600); //round down the hours [1.4 = 1]
			$mins = floor(($duration - ($hours * 3600)) / 60); //remain mins
			$secs = floor($duration % 60); //reminder [120 % 60 = 0]

			/*Format video duration: Hours*/
			if ($hours < 1) {
				//if shorter than 1 hour, show nothing e.g. [00:10].
				$hours = "";
			} else {
				//if longer than 1 hour, show colon e.g. [1:00:10]
				$hours = $hours . ":";
			}

			/*Format video duration: Minutes (ternary)*/
			$mins = ($mins < 10) ? "0" . $mins . ":" : $mins . ":";

			/*Format video duration: Seconds (ternary)*/
			$secs = ($secs < 10) ? "0" . $secs : $secs;

			/*Time output formatting*/
			$duration = $hours.$mins.$secs;

			$query = $this->con->prepare("UPDATE videos SET duration=:duration WHERE id=:videoId");
			$query->bindParam(":duration", $duration);
			$query->bindParam(":videoId", $videoId);
			$query->execute();
		}
	}

 ?>

