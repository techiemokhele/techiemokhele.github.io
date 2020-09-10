$(document).ready(function($) {
	
	$(".navShowHide").on("click", function() {
		//Hide and shows the navigation button
		var main = $("#mainSectionContainer");
		var nav = $("#sideNavContainer");

		if (main.hasClass("leftPadding")) {
			nav.hide();
		} else {
			nav.show();
		}
		//Checks if main leftpadding show or hide
		main.toggleClass("leftPadding");
	});

});

function notSignedIn() {
	alert("You have to be signed in to perform this action"); 
}