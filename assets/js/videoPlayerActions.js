function likeVideo(button, videoId) {
	$.post("assets/ajax/likeVideo.php", {
		videoId: videoId
	})
	.done(function(data) {
		/*When Ajax call is done, this will run: Update button(like/dislike)*/
		var likeButton = $(button);
		var dislikeButton = $(button).siblings(".dislikeButton");

		likeButton.addClass("active");
		dislikeButton.removeClass("active");

		var result = JSON.parse(data);
		updateLikesValue(likeButton.find(".text"), result.likes);
		updateLikesValue(dislikeButton.find(".text"), result.dislikes);

		if (result.likes < 0) {
			likeButton.removeClass("active");
			likeButton.find("img:first").attr("src", "./media/img/icons/thumb-up.png")
		} else {
			likeButton.find("img:first").attr("src", "./media/img/icons/thumb-up-active.png")
		}

		dislikeButton.find("img:first").attr("src", "./media/img/icons/thumb-down.png")

	});
}

function dislikeVideo(button, videoId) {
	$.post("assets/ajax/dislikeVideo.php", {
		videoId: videoId
	})
	.done(function(data) {
		/*When Ajax call is done, this will run: Update button(like/dislike)*/
		var dislikeButton = $(button);
		var likeButton = $(button).siblings(".likeButton");

		dislikeButton.addClass("active");
		likeButton.removeClass("active");

		var result = JSON.parse(data);
		updateLikesValue(likeButton.find(".text"), result.likes);
		updateLikesValue(dislikeButton.find(".text"), result.dislikes);

		if (result.dislikes < 0) {
			dislikeButton.removeClass("active");
			dislikeButton.find("img:first").attr("src", "./media/img/icons/thumb-down.png")
		} else {
			dislikeButton.find("img:first").attr("src", "./media/img/icons/thumb-down-active.png")
		}

		likeButton.find("img:first").attr("src", "./media/img/icons/thumb-up.png")

	});
}

function updateLikesValue(element, num) {
	var likesCountVal = element.text() || 0;
	element.text(parseInt(likesCountVal) + parseInt(num));
}