<?php 

	class VideoPlayer {

		private $video;

		public function __construct($video) {
			$this->video = $video;
		}

		public function create($autoPlay) {

			if ($autoPlay) {
				$autoPlay = "autoplay";
			} else {
				$autoPlay = "";
			}

			$filePath = $this->video->getFilePath();
			return "<video class='videoPlayer' controls $autoPlay>
				<source src='$filePath' type='video/mp4'>
				<div class='alert alert-danger'>
					<i class='fas fa-info iconColor'></i> 
						ERROR: Unfortunately, your browser does not support this video format/tag. Please use another browser to view this video. 😢
					</div>
			</video>";

		}

	}

 ?>