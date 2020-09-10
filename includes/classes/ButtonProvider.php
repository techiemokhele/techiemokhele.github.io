<?php 

	class ButtonProvider {

		public static $signInFunction = "notSignedIn()";

		public static function createLink($link) {
			return User::isLoggedIn() ? $link : ButtonProvider::$signInFunction;
		}

		public static function createButton($text, $imageSrc, $action, $class) {

			$image = ($imageSrc == null) ? "" : "<img src='$imageSrc'>";

			$action = ButtonProvider::createLink($action);

			return 
				"<button class='$class' onclick='$action'>
					$image
					<span class='text'>$text</span>
				</button>";
		}

		public static function createHyperlinkButton($text, $imageSrc, $href, $class) {

			$image = ($imageSrc == null) ? "" : "<img src='$imageSrc'>";

			return 
				"<a href='$href'>
					<button class='$class'>
						$image
						<span class='text'>$text</span>
					</button>
				</a>";
		}

		public static function createUserProfileButton($con, $username) {
		      if($username !== ""){
			   $userObj = new User($con, $username);
			   $profilePic = $userObj->getProfilePic();
		      }
				
		      else {
			   $profilePic = "media/img/profilePictures/default.png";
		      }
		 
		      $link = "profile.php?username=$username";
		 
		    return "<a href='$link'>
						<img src='$profilePic' class='profilePicture'>
				    </a>";
		}


		public static function createEditVideoButton($videoId) {
			$href = "editVideo.php?videoId=$videoId";

			$button = ButtonProvider::createHyperlinkButton("EDIT VIDEO", null, $href, "edit button");

			return "<div class='editVideoButtonContainer'>
				$button
			</div>";
		}

		public static function createSubscriberButton($con, $userToObj, $userLoggedInObj) {
			/*Check if user is subscribed to this admin(poster/blogger)*/
			$userTo = $userToObj->getUsername();
			$userLoggedIn = $userLoggedInObj->getUsername();

			$isSubscribedTo = $userLoggedInObj->isSubscribedTo($userTo);

			$buttonText = $isSubscribedTo ? "SUBSCRIBED" : "SUBSCRIBE";
			$buttonText .= " " . $userToObj->getSubscriberCount();

			$buttonClass = $isSubscribedTo ? "unsubscribe button" : "subscribe button";
			$action = "subscribe(\"$userTo\", \"$userLoggedIn\", this)";

			$button = ButtonProvider::createButton($buttonText, null, $action, $buttonClass);

			return "<div class='subscribeButtonContainer'>
				$button
			</div>";
		}

		public static function createUserProfileNavigationButton($con, $username) {
			if (User::isLoggedIn()) {
				return ButtonProvider::createUserProfileButton($con, $username);
			} else {
				return "<a href='signIn.php'>
							<span class='signInLink'>SIGN IN</span>
						</a>";
			}
		}

	} 

 ?>