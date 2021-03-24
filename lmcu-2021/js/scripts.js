/*! lmcu-divi-child-theme v0.0.1 | (c) 2021 Ben West | GPL License | https://github.com/lmculondon/lmcu-divi-child-theme */
jQuery(document).ready((function ($) {
	// Hide Header on on scroll down
	var didScroll;
	var lastScrollTop = 0;
	var delta = 5;
	var navbarHeight = $('#global-header-section').outerHeight();
	$(window).on("load resize", (function (event) {

		$(document.body).css('padding-top', navbarHeight);

	}));
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
			$('#global-header-section').removeClass('nav-down').addClass('nav-up');
		} else {
			// Scroll Up
			if (st + $(window).height() < $(document).height()) {
				$('#global-header-section').removeClass('nav-up').addClass('nav-down');
			}
		}

		lastScrollTop = st;
	}
}));
