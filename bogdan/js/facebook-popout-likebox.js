/* Static Facebook Pop Out Like Box */
jQuery(document).ready(function () {
	var dur = "medium"; // Duration of Animation
	var offset = jQuery("#fbplikebox").attr("data-offset"); // Offset 
	if (jQuery("#fbplikebox").hasClass("fbpl_right")) {
		var margin = "-" + jQuery("#fbplikebox").attr("data-width"); // Width of Likebox
		jQuery("#fbplikebox").css({
			marginRight: margin,
			top: offset
		});
		jQuery("#fbplikebox").hover(function () {
			jQuery(this).stop().animate({
				marginRight: 0
			}, dur);
		}, function () {
			jQuery(this).stop().animate({
				marginRight: margin
			}, dur);
		});
	}
	if (jQuery("#fbplikebox").hasClass("fbpl_bottom")) {
		var margin = "-" + jQuery("#fbplikebox").attr("data-height"); // Width of Likebox
		jQuery("#fbplikebox").css({
			marginBottom: margin,
			left: offset
		});
		jQuery("#fbplikebox").hover(function () {
			jQuery(this).stop().animate({
				marginBottom: 0
			}, dur);
		}, function () {
			jQuery(this).stop().animate({
				marginBottom: margin
			}, dur);
		});
	}
	if (jQuery("#fbplikebox").hasClass("fbpl_left")) {
		var margin = "-" + jQuery("#fbplikebox").attr("data-width"); // Width of Likebox
		jQuery("#fbplikebox").css({
			marginLeft: margin,
			top: offset
		});
		jQuery("#fbplikebox").hover(function () {
			jQuery(this).stop().animate({
				marginLeft: 0
			}, dur);
		}, function () {
			jQuery(this).stop().animate({
				marginLeft: margin
			}, dur);
		});
	}
	if (jQuery("#fbplikebox").hasClass("fbpl_top")) {
		var margin = "-" + jQuery("#fbplikebox").attr("data-height"); // Width of Likebox
		jQuery("#fbplikebox").css({
			marginTop: margin,
			left: offset
		});
		jQuery("#fbplikebox").hover(function () {
			jQuery(this).stop().animate({
				marginTop: 0
			}, dur);
		}, function () {
			jQuery(this).stop().animate({
				marginTop: margin
			}, dur);
		});
	}
	// Show the Likebox
	jQuery("#fbplikebox").show();
});