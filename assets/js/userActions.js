function subscribe(userTo, userFrom , button) {
	if (userTo ==userFrom) {
		alert("😢 You can't subscribe to yourself");
		return;
	}

	$.post("assets/ajax/subscribe.php", {
		userTo: userTo,
		userFrom: userFrom
	})
	.done(function(count) {
		if (count != null) {
			$(button).toggleClass("subscribe unsubscribe");

			var buttonText = $(button).hasClass("subscribe") ? "SUBSCRIBE" : "SUBSCRIBED";
			$(button).text(buttonText + " " + count);

		} else {
			alert("Oops! Something went wrong");
		}

	});
}