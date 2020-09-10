<?php 

	/*Including header page*/
	require_once "./includes/header.php";

 ?>

<!--Start Main page content-->

<div class="videoSection">
	<?php 

		$subscriptionsProvider = new SubscriptionsProvider($con, $userLoggedInObj);
		$subscriptionsVideos = $subscriptionsProvider->getVideos();

		$videoGrid = new VideoGrid($con, $userLoggedInObj->getUsername());

		if (User::isLoggedIn() && sizeof($subscriptionsVideos) > 0) {
			echo $videoGrid->create($subscriptionsVideos, "<i class='fas fa-user-plus'></i> Subscriptions", false);
		}

		echo $videoGrid->create(null, "<i class='fas fa-video'></i> Today's recommended videos", false);

	 ?>
</div>

<!--End Main page content-->

 <?php 

	/*Including footer page*/
	require_once "./includes/footer.php";

 ?>			