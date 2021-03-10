jQuery(document).ready(function($){
    'use strict';

	$.fn.countdown = function () {
		const self = this;
		const { timer = "" } = self.data();
		const [ hour, minute, second ] = self.find('.countdown-amount');

		const reload = function () {
			const distance = new Date(`${timer} GMT+0000`).getTime() - new Date().getTime();
			if(distance <= 0) {
				clearInterval(clock)
				return;
			}

			const hours = Math.floor(distance / (1000 * 60 * 60));
			const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			const seconds = Math.floor((distance % (1000 * 60)) / 1000);

			$(hour).html(hours)
			$(minute).html(minutes)
			$(second).html(seconds)
		};

		const clock = setInterval(reload, 1000);
	};

	$(document).ready(function() {
		const countdownClassSelectors = [ '.tutor-zoom-lesson-countdown', '.tutor-zoom-meeting-countdown' ];

		countdownClassSelectors.forEach(function(classSelector) {
			const zoomLessons = $(classSelector)
			zoomLessons.each(function (index) {
				$(this).countdown();
			})
		})
	})
});

