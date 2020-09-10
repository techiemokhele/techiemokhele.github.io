<?php 

	class VideoGrid {
		/*Shows suggestions videos on the side of the page*/
		private $con;
		private $userLoggedInObj;
		private $largeMode = false;
		private $gridClass = "videoGrid";


		public function __construct($con, $userLoggedInObj) {
			$this->con = $con;
			$this->userLoggedInObj = $userLoggedInObj;
		}

		public function create($videos, $title, $showFilter) {

			if ($videos == null) {
				/*If theres no videos*/
				$gridItems = $this->generateItems();
			} else {
				/*If theres are videos; show them*/
				$gridItems = $this->generateItemsFromVideos($videos);
			}

			/*Header to show results: "filter controls - Recommended"*/
			$header = "";
			if ($title != null) {
				$header = $this->createGridHeader($title, $showFilter);
			}

			return "$header
					<div class='$this->gridClass'>
						$gridItems
					</div>";
		}

		public function generateItems() {
			$query = $this->con->prepare("SELECT * FROM videos ORDER BY RAND() LIMIT 20");
			$query->execute();

			$elementsHtml = "";
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			    $video = new Video($this->con, $row, $this->userLoggedInObj);
			    $item = new VideoGridItem($video, $this->largeMode);
			    $elementsHtml .= $item->create();
			}

			return $elementsHtml;
		}

		public function generateItemsFromVideos($videos) {
			$elementsHtml = "";

			foreach ($videos as $video) {
				$item = new VideoGridItem($video, $this->largeMode);
				$elementsHtml .= $item->create();
			}

			return $elementsHtml;
		}

		public function createGridHeader($title, $showFilter) {
			$filter = "";

			if ($showFilter) {
				/*Show filter of search query via URL*/
				$link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				
				$urlArray = parse_url($link);
				$query = $urlArray["query"];

				parse_str($query, $params);

				unset($params["orderBy"]);

				$newQuery = http_build_query($params);

				$newUrl = basename($_SERVER["PHP_SELF"]) . "?" . $newQuery;

				$filter = "<div class='right'>
								<span>
									<i class='fas fa-cloud-upload-alt fa-xs'></i> Order by: 
								</span><br>
								<a href='$newUrl&orderBy=uploadDate' class='btn btn-primary btn-sm'>
									 <i class='fas fa-upload fa-xs'></i> Upload date 
								</a>
								<a href='$newUrl&orderBy=views' class='btn btn-primary btn-sm'>
									<i class='fas fa-binoculars fa-xs'></i> Most viewed
								</a>
							</div>";
			}

			/*Creating filter for suggested videos on INDEX.php*/
			return "<div class='videoGridHeader'>
							<div class='left'>
								$title
							</div>
							$filter
						</div>";
		} 

		public function createLarge($videos, $title, $showFilter) {
			/*Create large video presentations for the search query*/
			$this->gridClass .= " large";
			$this->largeMode = true;
			return $this->create($videos, $title, $showFilter);
		}

	}

 ?>