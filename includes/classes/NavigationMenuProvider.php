<?php 

	class NavigationMenuProvider {

		private $con;
		private $userLoggedInObj;

		public function __construct($con, $userLoggedInObj) {
			$this->con = $con;
			$this->userLoggedInObj = $userLoggedInObj;
		}

		public function create() {
			/*Create HTML content for navigation bar*/
			$menuHtml = $this->createNavItem("Home", "media/img/icons/home.png", "index.php");
			$menuHtml .= $this->createNavItem("Trending", "media/img/icons/trending.png", "trending.php");
			$menuHtml .= $this->createNavItem("Subscriptions", "media/img/icons/subscriptions.png", "subscriptions.php");
			$menuHtml .= $this->createNavItem("Liked videos", "media/img/icons/thumb-up.png", "likedVideos.php");
			$menuHtml .= $this->createNavItem("Contact Support", "media/img/icons/phone.png", "contact.php");

			if (User::isLoggedIn()) {
				/*Show these content if user is logged in*/
				$menuHtml .= $this->createNavItem("Settings", "media/img/icons/settings.png", "settings.php");
				$menuHtml .= $this->createNavItem("Logout", "media/img/icons/logout.png", "logout.php");

				/*Show subscriptions sections on side navigation*/
				$menuHtml .= $this->createSubscriptionsSection();
			}

			return "<div class='navigationItems'>
						$menuHtml
					</div>";
		}

		private function createNavItem($text, $icon, $link) {
			/*create navigation items*/
			return "<div class='navigationItem'>
						<a href='$link'>
							<img src='$icon'>
							<span>$text</span>
						</a>
					</div>";
		}

		private function createSubscriptionsSection() {
			/*Subscription section for navigation bar*/
			$subscriptions = $this->userLoggedInObj->getSubscriptions();

			$html = "<span class='heading'>Subscriptions</span>";

			foreach ($subscriptions as $sub) {
				/*Loop through all the user subscriptions*/
				$subUsername = $sub->getUsername();
				$subUserProfilePic = $sub->getProfilePic();
				$html .= $this->createNavItem($subUsername, $subUserProfilePic, "profile.php?username=$subUsername");
			}

			return $html;
		}

	}

 ?>