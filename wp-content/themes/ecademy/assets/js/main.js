(function($){
	"use strict";
	jQuery(document).on('ready', function () {

        // Header Sticky
		$(window).on('scroll',function() {
            if ($(this).scrollTop() > 120){  
                $('.navbar-area').addClass("is-sticky");
            }
            else{
                $('.navbar-area').removeClass("is-sticky");
            }
        });

        // Newsletter Modal JS
        if (jQuery(".newsletter-modal")[0]) {
            var popDisplayed = $.cookie('popDisplayed');
            if(popDisplayed == '1'){
                console.log('');
            }else{
                setTimeout(function(){
                    $("body").addClass('modal-open');
                    $("#newsletter-modal").fadeIn(500);
                }, 3000);
                $.cookie('popDisplayed', '1', { expires: 1 });

                $(".btn-yes").on('click', function () {
                    $("#newsletter-modal").fadeOut(500);
                    $("body").removeClass('modal-open');
                });
            }
        }

        // Odometer JS
        $('.odometer').appears(function(e) {
			var odo = $(".odometer");
			odo.each(function() {
				var countNumber = $(this).attr("data-count");
				$(this).html(countNumber);
			});
        });

        
        $(".search-submit, .blog_widget #bbp_search_submit").val('');

        // Bbpress Breadcrumbs
        if ($('.bbp-breadcrumb').length > 0) {
            $( '.bbp-breadcrumb' ).appendTo( $(".bbpress-breadcrumbs"));
        }

        // Others Option Responsive JS
        $(".others-option-for-responsive .dot-menu").on("click", function(){
            $(".others-option-for-responsive .container .container").toggleClass("active");
        });
        
        // Button Hover JS
        $(function() {
            $('.default-btn')
            .on('mouseenter', function(e) {
                var parentOffset = $(this).offset(),
                relX = e.pageX - parentOffset.left,
                relY = e.pageY - parentOffset.top;
                $(this).find('span').css({top:relY, left:relX})
            })
            .on('mouseout', function(e) {
                var parentOffset = $(this).offset(),
                relX = e.pageX - parentOffset.left,
                relY = e.pageY - parentOffset.top;
                $(this).find('span').css({top:relY, left:relX})
            });
        });

        // FAQ Accordion
        $(function() {
            $('.accordion').find('.accordion-title').on('click', function(){
                // Adds Active Class
                $(this).toggleClass('active');
                // Expand or Collapse This Panel
                $(this).next().slideToggle('fast');
                // Hide The Other Panels
                $('.accordion-content').not($(this).next()).slideUp('fast');
                // Removes Active Class From Other Titles
                $('.accordion-title').not($(this)).removeClass('active');		
            });
        });

        // Mean Menu
		$('.mean-menu').meanmenu({
			meanScreenWidth: "1199"
        });

        $(".learnpress .become-teacher-form .form-fields .form-field label").first().append("<span>*</span>");
        $(".learnpress .become-teacher-form .form-fields .form-field:nth-child(2) label").append("<span>*</span>");

        // Banner Animation
        window.onload = function() {
            var timeline = new TimelineMax();
            timeline.from(".main-banner-content, .main-banner-courses-list, .banner-wrapper-content, .banner-wrapper-image, .banner-content, .banner-image", 1, {y:60},0)
        }

        // Isotop Js
        var $grid = $('.blog-items, .courses-items').isotope({
            itemSelector: '.grid-item',
            percentPosition: true,
            masonry: {
                // Use outer width of grid-sizer for columnWidth
                columnWidth: '.grid-item'
            }
        });

        // Popup Image
		$('.popup-btn').magnificPopup({
            type: 'image',
            gallery: {
                enabled:true
            }
        });

        // Tabs
        (function ($) {
            $('.tab ul.tabs').addClass('active').find('> li:eq(0)').addClass('current');
            $('.tab ul.tabs li a').on('click', function (g) {
                var tab = $(this).closest('.tab'), 
                index = $(this).closest('li').index();
                tab.find('ul.tabs > li').removeClass('current');
                $(this).closest('li').addClass('current');
                tab.find('.tab-content').find('div.tabs-item').not('div.tabs-item:eq(' + index + ')').slideUp();
                tab.find('.tab-content').find('div.tabs-item:eq(' + index + ')').slideDown();
                g.preventDefault();
            });
        })(jQuery);

        // Price Range Slider JS
        $(".js-range-of-price").ionRangeSlider({
            type: "double",
            drag_interval: true,
            min_interval: null,
            max_interval: null,
        });

        // Input Plus & Minus Number JS
        $('.input-counter').each(function() {
            var spinner = jQuery(this),
            input = spinner.find('input[type="text"]'),
            btnUp = spinner.find('.plus-btn'),
            btnDown = spinner.find('.minus-btn'),
            min = input.attr('min'),
            max = input.attr('max');
            
            btnUp.on('click', function() {
                var oldValue = parseFloat(input.val());
                if (oldValue >= max) {
                    var newVal = oldValue;
                } else {
                    var newVal = oldValue + 1;
                }
                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
            });
            btnDown.on('click', function() {
                var oldValue = parseFloat(input.val());
                if (oldValue <= min) {
                    var newVal = oldValue;
                } else {
                    var newVal = oldValue - 1;
                }
                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
            });
        });
        
        // Load More
        $(function () {
            $(".courses-section .col-lg-4").slice(0, 6).show();
            $("body").on('click touchstart', '.load-more-btn .load-more', function (e) {
                e.preventDefault();
                $(".courses-section .col-lg-4:hidden").slice(0, 3).slideDown();
                if ($(".courses-section .col-lg-4:hidden").length == 0) {
                    $(".load-more-btn").css('display', 'none');
                }
                $('html,body').animate({
                    scrollTop: $(this).offset().top
                }, 1000);
            });
        });

        // Nice Select JS
        $('select').niceSelect();

        // Popup Video
		$('.popup-youtube').magnificPopup({
			disableOn: 320,
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false
        });

        // Go to Top
        $(function(){
            // Scroll Event
            $(window).on('scroll', function(){
                var scrolled = $(window).scrollTop();
                if (scrolled > 300) $('.go-top').addClass('active');
                if (scrolled < 300) $('.go-top').removeClass('active');
            });  
            // Click Event
            $('.go-top').on('click', function() {
                $("html, body").animate({ scrollTop: "0" },  500);
            });
        });        
    });
	
	// WoW JS
	$(window).on ('load', function (){
        if ($(".wow").length) { 
            var wow = new WOW ({
                boxClass:     'wow',      // Animated element css class (default is wow)
                animateClass: 'animated', // Animation css class (default is animated)
                offset:       20,         // Distance to the element when triggering the animation (default is 0)
                mobile:       true,       // Trigger animations on mobile devices (default is true)
                live:         true,       // Act on asynchronously loaded content (default is true)
            });
            wow.init();
        }
    });

    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/widget', function( $scope ) {
            // Blog Slides
            $('.blog-slides').owlCarousel({
                loop: true,
                nav: true,
                dots: true,
                autoplayHoverPause: true,
                autoplay: true,
                margin: 30,
                navText: [
                    "<i class='bx bx-chevron-left'></i>",
                    "<i class='bx bx-chevron-right'></i>"
                ],
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 1,
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    }
                }
            });

            // Feedback Slides
            $('.feedback-slides').owlCarousel({
                loop: true,
                nav: false,
                dots: true,
                autoplayHoverPause: true,
                autoplay: true,
                animateOut: 'fadeOut',
                autoHeight: true,
                items: 1,
                navText: [
                    "<i class='bx bx-chevron-left'></i>",
                    "<i class='bx bx-chevron-right'></i>"
                ],
            });
            // Sidebar Sticky
            $('.courses-sidebar-sticky').stickySidebar({
                topSpacing: 90,
                bottomSpacing: 90
            });

            // Testimonials Slides
            $('.testimonials-slides').owlCarousel({
                loop: true,
                nav: false,
                dots: true,
                autoplayHoverPause: true,
                autoplay: true,
                animateOut: 'fadeOut',
                autoHeight: true,
                items: 1,
                navText: [
                    "<i class='bx bx-chevron-left'></i>",
                    "<i class='bx bx-chevron-right'></i>"
                ],
            });

            // Feedback Slides Two
            $('.feedback-slides-two').owlCarousel({
                loop: true,
                nav: false,
                dots: true,
                autoplayHoverPause: true,
                autoplay: true,
                margin: 30,
                navText: [
                    "<i class='bx bx-chevron-left'></i>",
                    "<i class='bx bx-chevron-right'></i>"
                ],
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 1,
                    },
                    768: {
                        items: 2,
                    },
                    1200: {
                        items: 2,
                    }
                }
            });
            
            // Article Image Slides
            $('.article-image-slides').owlCarousel({
                loop: true,
                nav: true,
                dots: false,
                autoplayHoverPause: true,
                autoplay: true,
                animateOut: 'fadeOut',
                items: 1,
                navText: [
                    "<i class='flaticon-chevron'></i>",
                    "<i class='flaticon-right-arrow'></i>"
                ],
            });

            // Courses Slides
            $('.courses-slides').owlCarousel({
                loop: true,
                nav: true,
                dots: true,
                autoplayHoverPause: true,
                autoplay: true,
                margin: 30,
                navText: [
                    "<i class='bx bx-chevron-left'></i>",
                    "<i class='bx bx-chevron-right'></i>"
                ],
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 1,
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    }
                }
            });

            // Advisor Slides Two
            $('.advisor-slides-two').owlCarousel({
                loop: true,
                nav: false,
                dots: true,
                autoplayHoverPause: true,
                autoplay: true,
                margin: 30,
                navText: [
                    "<i class='bx bx-chevron-left'></i>",
                    "<i class='bx bx-chevron-right'></i>"
                ],
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 2,
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    }
                }
            });

            // Advisor Slides
            $('.advisor-slides').owlCarousel({
                loop: true,
                nav: false,
                dots: true,
                autoplayHoverPause: true,
                autoplay: true,
                margin: 30,
                navText: [
                    "<i class='bx bx-chevron-left'></i>",
                    "<i class='bx bx-chevron-right'></i>"
                ],
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 2,
                    },
                    768: {
                        items: 1,
                    },
                    992: {
                        items: 2,
                    }
                }
            });
            
            // MixItUp Shorting
            $(function(){
                $('.shorting').mixItUp();
            });

            // TweenMax JS
            $('.main-banner, .banner-section, .banner-wrapper-area, .banner-wrapper').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.banner-shape1, .banner-shape2, .banner-shape3, .banner-shape4, .banner-shape5, .banner-shape6, .banner-shape7, .banner-shape8, .banner-shape9, .banner-shape10, .banner-shape11, .banner-shape12, .banner-shape13').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });
            $('.about-area, .about-area-two, .about-area-three').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.shape1, .shape2, .shape3, .shape4, .shape6, .shape7, .shape8, .shape9, .shape10, .shape11, .shape12, .shape13, .shape14, .shape15, .shape16, .shape17, .shape18, .shape19, .shape20, .shape21, .shape22, .shape23').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });
            $('.funfacts-and-feedback-area').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.shape1, .shape2, .shape3, .shape4, .shape6, .shape7, .shape8, .shape9, .shape10, .shape11, .shape12, .shape13, .shape14, .shape15, .shape16, .shape17, .shape18, .shape19, .shape20, .shape21, .shape22, .shape23').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });
            $('.get-instant-courses-area').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.shape1, .shape2, .shape3, .shape4, .shape6, .shape7, .shape8, .shape9, .shape10, .shape11, .shape12, .shape13, .shape14, .shape15, .shape16, .shape17, .shape18, .shape19, .shape20, .shape21, .shape22, .shape23').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });
            $('.view-all-courses-area, .view-all-courses-area-two').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.shape1, .shape2, .shape3, .shape4, .shape6, .shape7, .shape8, .shape9, .shape10, .shape11, .shape12, .shape13, .shape14, .shape15, .shape16, .shape17, .shape18, .shape19, .shape20, .shape21, .shape22, .shape23').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });
            $('.premium-access-area').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.shape1, .shape2, .shape3, .shape4, .shape6, .shape7, .shape8, .shape9, .shape10, .shape11, .shape12, .shape13, .shape14, .shape15, .shape16, .shape17, .shape18, .shape19, .shape20, .shape21, .shape22, .shape23').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });
            $('.slogan-area').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.shape1, .shape2, .shape3, .shape4, .shape6, .shape7, .shape8, .shape9, .shape10, .shape11, .shape12, .shape13, .shape14, .shape15, .shape16, .shape17, .shape18, .shape19, .shape20, .shape21, .shape22, .shape23').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });
            $('.subscribe-area').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.shape1, .shape2, .shape3, .shape4, .shape6, .shape7, .shape8, .shape9, .shape10, .shape11, .shape12, .shape13, .shape14, .shape15, .shape16, .shape17, .shape18, .shape19, .shape20, .shape21, .shape22, .shape23').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });
            $('.feedback-area').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.shape1, .shape2, .shape3, .shape4, .shape6, .shape7, .shape8, .shape9, .shape10, .shape11, .shape12, .shape13, .shape14, .shape15, .shape16, .shape17, .shape18, .shape19, .shape20, .shape21, .shape22, .shape23').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });
            $('.success-story-area').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.shape1, .shape2, .shape3, .shape4, .shape6, .shape7, .shape8, .shape9, .shape10, .shape11, .shape12, .shape13, .shape14, .shape15, .shape16, .shape17, .shape18, .shape19, .shape20, .shape21, .shape22, .shape23').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });

            $('.health-coaching-banner-area').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.health-coaching-shape2, .health-coaching-shape4, .health-coaching-shape5, .health-coaching-shape6, .health-coaching-shape7').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });
            $('.experience-area').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.experience-shape1, .experience-shape2').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });

            // TweenMax JS
            $('.kindergarten-main-banner').mousemove(function(e){
                var wx = $(window).width();
                var wy = $(window).height();
                var x = e.pageX - this.offsetLeft;
                var y = e.pageY - this.offsetTop;
                var newx = x - wx/2;
                var newy = y - wy/2;
                $('.kindergarten-banner-image .image img').each(function(){
                    var speed = $(this).attr('data-speed');
                    if($(this).attr('data-revert')) speed *= -1;
                    TweenMax.to($(this), 1, {x: (1 - newx*speed), y: (1 - newy*speed)});
                });
            });

            // Feedback Slides Three
            $('.feedback-slides-three').owlCarousel({
                loop: true,
                nav: true,
                dots: false,
                autoplayHoverPause: true,
                autoplay: true,
                margin: 0,
                navText: [
                    "<i class='flaticon-chevron'></i>",
                    "<i class='flaticon-right-arrow'></i>"
                ],
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 2,
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    },
                    1200: {
                        items: 4,
                    },
                    1550: {
                        items: 5,
                    }
                }
            });

            // Services Slides
            $('.services-slides').owlCarousel({
                loop: true,
                nav: true,
                dots: false,
                autoplayHoverPause: true,
                autoplay: true,
                margin: 30,
                navText: [
                    "<i class='flaticon-chevron'></i>",
                    "<i class='flaticon-right-arrow'></i>"
                ],
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 2,
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    }
                }
            });

            // Courses Slides Two
            $('.courses-slides-two').owlCarousel({
                loop: false,
                nav: true,
                dots: false,
                autoplayHoverPause: true,
                autoplay: true,
                margin: 30,
                navText: [
                    "<i class='flaticon-chevron'></i>",
                    "<i class='flaticon-right-arrow'></i>"
                ],
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 1,
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    }
                }
            });
            
        });
    });
    
    // Preloader
    $(window).on('load', function () {
        $('.preloader').fadeOut();
    });
    

}(jQuery));

