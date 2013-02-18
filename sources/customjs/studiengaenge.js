$(document).ready(function(){
	$("input").focus(function() {
		$(this)
			.parent()
				.addClass("focused")
			.children("div")
				.toggle();
	});
	$("input").blur(function() {
		$(this)
			.parent()
				.removeClass("focused")
			.children("div")
				.toggle();
	});
	$("select").focus(function() {
		$(this)
			.parent()
				.addClass("focused")
			.children("div")
				.toggle();
	});
	$("select").blur(function() {
		$(this)
			.parent()
				.removeClass("focused")
			.children("div")
				.toggle();
	});
});