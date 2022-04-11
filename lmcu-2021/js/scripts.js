/*! lmcu-divi-child-theme v0.0.1 | (c) 2022 Ben West | GPL License | https://github.com/lmculondon/lmcu-divi-child-theme */
jQuery(document).ready((function ($) {

	/* SCROLLUP HEADINGS*/
	// Hide Header on on scroll down
	var didScroll;
	var lastScrollTop = 0;
	var delta = 5;
	var headerElement = $('.et-l--header');
	var navbarHeight = headerElement.outerHeight();
	$(window).scroll((function (event) {
		didScroll = true;
	}));

	setInterval((function () {
		if (didScroll) {
			hasScrolled();
			didScroll = false;
		}
	}), 350);

	function hasScrolled() {
		var st = $(this).scrollTop();

		// Make sure they scroll more than delta
		if (Math.abs(lastScrollTop - st) <= delta)
			return;

		// If they scrolled down and are past the navbar, add class .nav-up.
		// This is necessary so you never see what is "behind" the navbar.
		if (st > lastScrollTop && st > navbarHeight) {
			// Scroll Down
			headerElement.removeClass("nav-down").addClass("nav-up");
		} else {
			// Scroll Up
			if (st + $(window).height() < $(document).height()) {
				headerElement.removeClass("nav-up").addClass("nav-down");
			}
		}

		lastScrollTop = st;
	}
	/* Tabs */
	$(".et_pb_toggle_trigger").click((function(e){
		e.preventDefault();
		var anchor = $(this).attr("href");
		$(anchor).addClass("et_pb_toggle_tab_active");
		$(".et_pb_toggle_tabs").not(anchor).removeClass("et_pb_toggle_tab_active");

		var matchanchor = $(".et_pb_toggle_items a[href^='"+ anchor + "'");
		$(matchanchor).addClass("et_pb_link_active");
		$("a").not(matchanchor).removeClass("et_pb_link_active");

	}));
	$(".et_pb_application_steps_buttons").on("click", ".et_pb_blurb", (function (e) {
		e.preventDefault();
		$(this).addClass("et_pb_step_active");
		$(".et_pb_application_steps_buttons .et_pb_blurb").not(this).removeClass("et_pb_step_active");
		var stepid = $(this).attr("id");
		var stepname = stepid.split("_").pop();
		$(".et_pb_step").not("#" + stepname).removeClass("et_pb_steps_active");
		$("#" + stepname).addClass("et_pb_steps_active");

	}));

	/* Backlink */
	$("js--backlink").click((function(event) {
		event.preventDefault();
		history.back(1);
	}));

}));
