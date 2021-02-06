<?php
/**
 * Register custom style.
 */

if ( ! function_exists( 'ecademy_custom_style' ) ) {
    function ecademy_custom_style(){
        
        $custom_style ='';
            global $ecademy_opt;

            if( isset( $ecademy_opt['primary_color'] ) ):
                $primary_color              = $ecademy_opt['primary_color'];
                $footer_bg                  = $ecademy_opt['footer_bg'];
                $header_bg_color            = $ecademy_opt['header_background_color'];
            else:   
                $primary_color              = '#fe4a55';
                $footer_bg                  = '#100f1f';
                $header_bg_color            = '#ffffff';
            endif;

            if( isset( $ecademy_opt['footer_item_color'] ) ):
                $footer_item_color          = $ecademy_opt['footer_item_color'];
            else:
                $footer_item_color          = '#e4e4e4';
            endif;

            $custom_style .='
                .default-btn, .ecademy-nav .navbar .navbar-nav .nav-item.megamenu .dropdown-menu .single-category-widget:hover .icon, .ecademy-nav .navbar .others-option .cart-btn a span, .others-option-for-responsive .dot-menu:hover .inner .circle, .others-option-for-responsive .option-inner .others-option .cart-btn a span, .ecademy-responsive-nav .ecademy-responsive-menu.mean-container .navbar-nav .nav-item.megamenu .dropdown-menu .single-category-widget:hover .icon, .ecademy-responsive-nav .ecademy-responsive-menu.mean-container .others-option .cart-btn a span, .banner-wrapper-content form button, .home-banner-area, .about-video-box .video-btn, .single-courses-box .courses-image .price, .single-courses-item-box .courses-image .price, .courses-slides.owl-theme .owl-dots .owl-dot:hover span::before, .courses-slides.owl-theme .owl-dots .owl-dot.active span::before, .courses-slides.owl-theme .owl-nav [class*=owl-]:hover , .shorting-menu.shorting-menu-style-two .filter::before, .load-more-btn .load-more:hover, .courses-details-desc .nav .nav-item .nav-link::before, .courses-details-info .image .content i, .courses-details-info .courses-share .share-info .social-link li a:hover, .courses-details-desc-style-two .courses-author .author-profile-header, .courses-sidebar-information .courses-share .share-info .social-link li a:hover, .single-advisor-box .advisor-content .social-link li a:hover, .advisor-slides.owl-theme .owl-dots .owl-dot:hover span::before, .advisor-slides.owl-theme .owl-dots .owl-dot.active span::before, .single-advisor-item .advisor-image .social-link li a:hover, .advisor-slides-two.owl-theme .owl-dots .owl-dot:hover span::before, .advisor-slides-two.owl-theme .owl-dots .owl-dot.active span::before, .start-with-success-box .content .link-btn:hover, .single-feedback-item::after, .feedback-slides.owl-theme .owl-dots .owl-dot:hover span::before, .feedback-slides.owl-theme .owl-dots .owl-dot.active span::before, .testimonials-slides.owl-theme .owl-dots .owl-dot:hover span::before, .testimonials-slides.owl-theme .owl-dots .owl-dot.active span::before, .feedback-slides-two.owl-theme .owl-dots .owl-dot:hover span::before, .feedback-slides-two.owl-theme .owl-dots .owl-dot.active span::before, .profile-box .content .social-link li a:hover, .profile-courses-quizzes .nav .nav-item .nav-link::before, .profile-courses-quizzes .tab-content .nav .nav-item .nav-link:hover, .profile-courses-quizzes .tab-content .nav .nav-item .nav-link.active, .video-box .video-btn, .events-details-image #timer .countdown-section::before, .events-details-info .events-share .share-info .social-link li a:hover, .blog-slides.owl-theme .owl-dots .owl-dot:hover span::before, .blog-slides.owl-theme .owl-dots .owl-dot.active span::before, .blog-slides.owl-theme .owl-nav [class*=owl-]:hover, .blog-details .article-image-slides.owl-theme .owl-nav [class*=owl-]:hover, .blog-details .article-footer .article-share .social li a, .blog-details .article-author .author-profile-header, blockquote::after, .blockquote::after, .prev-link-wrapper .image-prev::after, .next-link-wrapper .image-next::after, .become-instructor-partner-content.bg-color, .teacher-register-box, .apply-instructor-content .nav .nav-item .nav-link::before, .single-products-box .products-image .products-button ul li a .tooltip-label, .single-products-box .products-image .products-button ul li a .tooltip-label::before, .single-products-box .products-image .products-button ul li a:hover, .membership-levels-table .table thead th, .membership-levels-table .table tbody tr td .select-btn:hover, .pagination-area .page-numbers:hover, .pagination-area .page-numbers.current, .faq-accordion-tab .tabs li a:hover, .faq-accordion-tab .tabs li.current a, .login-form form .lost-your-password-wrap a::after, .login-form form button, .register-form form button, .contact-info ul li:hover .icon, .contact-form, .single-footer-widget .social-link li a:hover, .go-top:hover, .wp-block-search .wp-block-search__button, .wp-block-tag-cloud a:hover, .wp-block-tag-cloud a:focus, .page-links .post-page-numbers:hover, .post-password-form input[type="submit"], .comment-navigation .nav-links .nav-previous a:hover, .comment-navigation .nav-links .nav-next a:hover, .footer-area .single-footer-widget ul li::before, .footer-area .tagcloud a:hover, .sidebar .widget .widget-title::before, .sidebar .widget_search form button:hover, .sidebar .widget_search form button:focus, .sidebar .tagcloud a:hover, .comments-area .comment-body .reply a:hover, #comments .comment-list .comment-body .reply a:hover, lp-profile-content button, #course-item-content-header .form-button.lp-button-back button, .login-content .login-form form button, .sidebar .tagcloud a:hover, .footer-area .widget_search form button, body.single-lp_course.course-item-popup .course-item-nav a:hover, .learnpress .become-teacher-form button, .learnpress #learn-press-checkout-login button, .learnpress #learn-press-user-profile button, .no-results form button, .single-course-sidebar .widget ul li::before, .single-course-sidebar .widget_lp-widget-popular-courses .widget-footer a:hover::before, .single-course-sidebar .widget_lp-widget-featured-courses .widget-footer a:hover::before, .single-course-sidebar .widget_lp-widget-recent-courses .widget-footer a:hover::before, .sidebar .widget_lp-widget-popular-courses .widget-footer a:hover::before, .sidebar .widget_lp-widget-featured-courses .widget-footer a:hover::before, .sidebar .widget_lp-widget-recent-courses .widget-footer a:hover::before, .wp-block-button__link, .single-language-courses-box:hover .default-btn, .single-language-courses-box .default-btn span, .feedback-slides-style-two.feedback-slides.owl-theme::before, .information-content .apply-details li .icon, .products_details div.product .woocommerce-tabs ul#tabs .nav-item .nav-link::before, .newsletter-modal .newsletter-modal-content .modal-inner-content form button, .free-trial-form form button, button#bbp_reply_submit, .bg-fe4a55, .experience-content .features-list li:hover i, .single-pricing-box .default-btn span, .experience-image .title, .experience-image .video-btn:hover, .experience-image::before, #fep-menu .fep-button, .fep-button, .fep-button-active, #event-lightbox .event_auth_button, .event-auth-form  input#wp-submit, .about-content .about-list li span:hover i, .feedback-slides-three.owl-theme .owl-nav [class*=owl-]:hover::before, .courses-slides-two.owl-theme .owl-nav [class*=owl-]:hover::before, .owl-item:nth-child(2) .single-kindergarten-courses-box, .services-slides.owl-theme .owl-nav [class*=owl-]:hover::before, .about-content .about-list li span:hover i, .default-btn-style-two::before, .experience-img::before, .single-pricing-box .default-btn span, .tutor-form-group.tutor-reg-form-btn-wrap .tutor-button, .tutor-login-form-wrap input[type="submit"], .pmpro_login_wrap #content-item-quiz button, input[type=submit], #popup_ok { background-color: '.esc_attr($primary_color).'; }

                .ecademy-grid-sorting .ordering .nice-select .list .option:hover, .ecademy-grid-sorting .ordering .nice-select .list .option.selected:hover, .page-links .current, .wp-block-file .wp-block-file__button, .learnpress-page .lp-button, #learn-press-course-curriculum.courses-curriculum ul li.current a, .elementor-1114 .elementor-element.elementor-element-59893a7:not(.elementor-motion-effects-element-type-background), .download-syllabus-form form .form-group .nice-select .list .option.selected:hover, .download-syllabus-form form .form-group .nice-select .list .option:hover, .fep-button:hover, .learn-press-pmpro-buy-membership .purchase-button { background-color: '.esc_attr($primary_color).' !important; }

                .comments-area .form-submit input, .coming-soon-content form .form-group .label-title::before, .login-form form .remember-me-wrap [type="checkbox"]:checked + label:after, .login-form form .remember-me-wrap [type="checkbox"]:not(:checked) + label:after, .footer-area .widget_search form button, .sidebar .widget .widget-title::after, .sidebar .widget ul li::before, .sidebar .widget_search form button, learn-press-pagination .page-numbers > li a:hover, .learn-press-pagination .page-numbers > li a.current, .learn-press-pagination .page-numbers > li a:hover, .learn-press [type=button], .learn-press [type=reset], .learn-press [type=submit], .learn-press button, body.single-lp_course.course-item-popup .curriculum-sections .section .section-content .course-item.current, .learnpress .become-teacher-form .learn-press-message:before, .learnpress #learn-press-checkout-login .learn-press-message:before, #user-submit, #bbp_search_submit, .owl-item:nth-child(2) .single-kindergarten-courses-box .price, .tutor-button.tutor-success, .pmpro-has-access a.pmpro_btn, .pmpro-has-access input.pmpro_btn { background: '.esc_attr($primary_color).';}

                .learn-press-message:before, .guest-and-class a { background: '.esc_attr($primary_color).' !important;}

                a:hover, .section-title .sub-title, .ecademy-nav .navbar .search-box button, .ecademy-nav .navbar .navbar-nav .nav-item a:hover, .ecademy-nav .navbar .navbar-nav .nav-item a:focus, .ecademy-nav .navbar .navbar-nav .nav-item a.active, .ecademy-nav .navbar .navbar-nav .nav-item:hover a, .ecademy-nav .navbar .navbar-nav .nav-item.active a, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li a:hover, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li a:focus, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li a.active, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li a:hover, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li a:focus, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li a.active, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li a:hover, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li a:focus, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li a.active, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a:hover, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a:focus, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a.active, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a:hover, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a:focus, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a.active, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a:hover, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a:focus, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a.active, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a:hover, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a:focus, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li a.active, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li.active a, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li.active a, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li .dropdown-menu li.active a, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li .dropdown-menu li.active a, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li.active a, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li.active a, .ecademy-nav .navbar .navbar-nav .nav-item.megamenu .dropdown-menu .megamenu-submenu li a:hover, .ecademy-nav .navbar .navbar-nav .nav-item.megamenu .dropdown-menu .megamenu-submenu li a.active, .ecademy-nav .navbar .navbar-nav .nav-item.megamenu .dropdown-menu .single-category-widget .sub-title, .ecademy-nav .navbar .others-option .cart-btn a:hover, .others-option-for-responsive .option-inner .search-box button, .others-option-for-responsive .option-inner .others-option .cart-btn a:hover, .ecademy-responsive-nav .ecademy-responsive-menu.mean-container .mean-nav ul li a.active, .ecademy-responsive-nav .ecademy-responsive-menu.mean-container .navbar-nav .nav-item.megamenu .dropdown-menu .megamenu-submenu li a:hover, .ecademy-responsive-nav .ecademy-responsive-menu.mean-container .navbar-nav .nav-item.megamenu .dropdown-menu .megamenu-submenu li a.active, .ecademy-responsive-nav .ecademy-responsive-menu.mean-container .navbar-nav .nav-item.megamenu .dropdown-menu .single-category-widget .sub-title, .ecademy-responsive-nav .ecademy-responsive-menu.mean-container .search-box button, .ecademy-responsive-nav .ecademy-responsive-menu.mean-container .others-option .cart-btn a:hover, .banner-wrapper-content form label, .banner-wrapper-content .popular-search-list li a:hover, .single-banner-box:hover .icon, .single-box-item .link-btn, .single-features-box .link-btn, .about-content .sub-title, .about-content .features-list li span i, .about-content-box .sub-title, .about-content-box .link-btn, .single-courses-box .courses-image .fav:hover, .single-courses-box .courses-content .course-author span a, .single-courses-box .courses-content .courses-box-footer li i, .single-courses-item .courses-content .fav:hover, .single-courses-item .courses-content .price, .single-courses-item .courses-content .courses-content-footer li i, .single-courses-item-box .courses-image .fav:hover, .single-courses-item-box .courses-content .course-author span, .courses-info p a, .shorting-menu .filter.active, .shorting-menu .filter:hover, .ecademy-grid-sorting .ordering .nice-select .list .option::before, .load-more-btn .load-more, .courses-details-desc .tab-content .courses-curriculum ul li a::before, .courses-details-desc .tab-content .courses-curriculum ul li a .courses-meta .duration, .courses-details-desc .tab-content .courses-curriculum ul li a:hover, .courses-details-info .info li span i, .courses-details-info .info li.price, .courses-details-info .courses-share .share-info span, .courses-details-header .courses-meta ul li span, .courses-details-header .courses-meta ul li a:hover, .courses-details-header .courses-meta ul li a:focus, .courses-details-desc-style-two .why-you-learn ul li span i, .courses-details-desc-style-two .courses-curriculum ul li a::before, .courses-details-desc-style-two .courses-curriculum ul li a .courses-meta .duration, .courses-details-desc-style-two .courses-curriculum ul li a:hover, .courses-sidebar-information .info li span i, .courses-sidebar-information .info li.price, .courses-sidebar-information .courses-share .share-info span, .slogan-content span, .single-advisor-box .advisor-content .sub-title, .single-advisor-item .advisor-content span, .start-with-success-box .content .link-btn, .start-with-success-box .content span, .single-funfacts-box h3, .single-funfacts-item h3, .single-funfacts h3, .feedback-content .sub-title, .feedback-content .feedback-info p a, .single-feedback-item .client-info .title h3, .single-testimonials-item h3, .single-feedback-box .client-info .title h3, .single-testimonials-box h3, .profile-box .content .sub-title, .profile-courses-quizzes .tab-content .table tbody tr td a:hover, .get-instant-courses-content .sub-title, .single-events-box .image .date, .single-events-box .content .location i, .events-details-header ul li i, .events-details-info .info li.price, .events-details-info .btn-box p a, .events-details-info .events-share .share-info span, .single-blog-post .post-content .category:hover, .single-blog-post .post-content .post-content-footer li i, .single-blog-post-item .post-content .category:hover, .single-blog-post-item .post-content .post-content-footer li .post-author span, .single-blog-post-item .post-content .post-content-footer li i, .blog-post-info p a, .single-blog-post-box .post-content .category:hover, .single-blog-post-box .post-content .post-content-footer li .post-author span, .single-blog-post-box .post-content .post-content-footer li i, .blog-details .article-content .entry-meta ul li span, .blog-details .article-content .features-list li i, .blog-details .article-footer .article-share .social li a:hover, .blog-details .article-footer .article-share .social li a:focus, .prev-link-wrapper a:hover .prev-link-info-wrapper, .next-link-wrapper a:hover .next-link-info-wrapper, .view-all-courses-content .sub-title, .teacher-register-box form .default-btn:hover, .premium-access-content .sub-title, .page-title-content ul li a:hover, .subscribe-content .sub-title, .single-products-box .products-content .add-to-cart:hover, .products-details-desc .price, .contact-info .sub-title, .contact-info ul li .icon, .contact-form form .default-btn:hover, .single-footer-widget .footer-links-list li a:hover, .single-footer-widget .footer-contact-info li a:hover, .footer-bottom-area p a, .footer-bottom-area ul li a:hover, .footer-area .calendar_wrap .wp-calendar-nav-prev a:hover, .footer-area .single-footer-widget ul li a:hover, body.single-lp_course.course-item-popup .curriculum-sections .section .section-content .course-item .section-item-link::before, body.single-lp_course.course-item-popup .curriculum-sections .section .section-content .course-item .course-item-meta .item-meta.course-item-status, .learnpress .become-teacher-form .message-info::before, .learnpress #learn-press-checkout-login #checkout-form-login .row a:hover, .learnpress #learn-press-user-profile .learn-press-form-login .row a:hover, .learnpress #learn-press-user-profile .learn-press-form-register .row a:hover, .learnpress .become-teacher-form .form-fields .form-field label span, .single-course-sidebar .widget_lp-widget-popular-courses .course-entry .course-detail a:hover, .single-course-sidebar .widget_lp-widget-popular-courses .course-entry .course-detail h3:hover, .single-course-sidebar .widget_lp-widget-featured-courses .course-entry .course-detail a:hover, .single-course-sidebar .widget_lp-widget-featured-courses .course-entry .course-detail h3:hover, .single-course-sidebar .widget_lp-widget-recent-courses .course-entry .course-detail a:hover, .single-course-sidebar .widget_lp-widget-recent-courses .course-entry .course-detail h3:hover, .sidebar .widget_lp-widget-popular-courses .course-entry .course-detail a:hover, .sidebar .widget_lp-widget-popular-courses .course-entry .course-detail h3:hover, .sidebar .widget_lp-widget-featured-courses .course-entry .course-detail a:hover, .sidebar .widget_lp-widget-featured-courses .course-entry .course-detail h3:hover, .sidebar .widget_lp-widget-recent-courses .course-entry .course-detail a:hover, .sidebar .widget_lp-widget-recent-courses .course-entry .course-detail h3:hover, .lp-user-profile #learn-press-profile-content .learn-press-subtab-content .lp-sub-menu li span, #learn-press-course-curriculum.courses-curriculum ul li a::before, .sidebar .calendar_wrap table #today a, .footer-area .calendar_wrap table #today, .footer-area .single-footer-widget .wp-calendar-nav .wp-calendar-nav-next a:hover, .sidebar .widget_rss ul li .rsswidget:hover, .sidebar .calendar_wrap table th a, .sidebar .calendar_wrap table #today, .wp-block-calendar a, .wp-block-image figcaption a, blockquote a, table td a, dd a, p a, .page-main-content .wp-caption .wp-caption-text a, .blog-details .wp-caption .wp-caption-text a, .blog-details table a, .blog-details .blog-details-content ul li a, .sticky .single-blog-post .post-content .post-content-footer li a:hover, .sticky .single-blog-post .post-content h3 a:hover, .blog-details .blog-details-content .entry-meta li a:hover, .blog-details .blog-details-content ol li a, .wp-block-file a, .blog-details .blog-details-content ol li a, #comments .comment-metadata a:hover, .page-main-content table a, .products_details div.product .woocommerce-product-rating a.woocommerce-review-link:hover, .products_details div.product .product_meta span.sku_wrapper span, .single-language-courses-box .default-btn, .information-content .sub-title, .bbpress-wrapper a, #bbpress-forums div.bbp-topic-author a.bbp-author-name, #bbpress-forums div.bbp-reply-author a.bbp-author-name, #bbpress-forums #bbp-single-user-details #bbp-user-navigation a:hover, a.bbp-register-link, a.bbp-lostpass-link, .right-sidebar ul li a:hover, .bbp-author-name:hover, .download-syllabus-form form span.wpcf7-list-item-label a:hover, .preloader .loader .sbl-half-circle-spin, .boxes-info p a, .overview-box .overview-content .sub-title, .single-training-box .link-btn, .experience-content .sub-title, .download-syllabus-form form .form-group .nice-select .list .option::before, #fep-content a, .fep-error a, .about-content .about-list li span:hover i, .single-kindergarten-services-box .content .icon, .single-kindergarten-courses-box .courses-image .fav:hover, .single-blog-item .post-content .category:hover, .events-box .content .location i, .col-lg-3:nth-child(2) .single-selected-ages-box h3, .col-lg-3:nth-child(2) .single-selected-ages-box .ages-number, .tutor-container .tutor-course-loop-title h2 a:hover, .lp-pmpro-membership-list .item-td.item-desc, .lp-pmpro-membership-list .item-td.item-check, .lp-pmpro-membership-list .item-td a:hover, #pmpro_account-profile a, a.ld-enroll-btn { color: '.esc_attr($primary_color).'; }

                .single-footer-widget .footer-contact-info li a:hover, .footer-area .single-footer-widget ul li a:hover, span.bbp-admin-links a { color: '.esc_attr($primary_color).' !important; }

                .form-control:focus, .ecademy-nav .navbar .search-box .input-search:focus, .others-option-for-responsive .option-inner .search-box .input-search:focus, .ecademy-responsive-nav .ecademy-responsive-menu.mean-container .search-box .input-search:focus, .banner-wrapper-content form .input-search:focus, .courses-slides.owl-theme .owl-dots .owl-dot:hover span, .courses-slides.owl-theme .owl-dots .owl-dot.active span, .ecademy-grid-sorting .ordering .nice-select:hover, .advisor-slides.owl-theme .owl-dots .owl-dot:hover span, .advisor-slides.owl-theme .owl-dots .owl-dot.active span, .advisor-slides-two.owl-theme .owl-dots .owl-dot:hover span, .advisor-slides-two.owl-theme .owl-dots .owl-dot.active span, .funfacts-list .row .col-lg-6:nth-child(2) .single-funfacts-box, .single-funfacts-box:hover, .feedback-slides.owl-theme .owl-dots .owl-dot:hover span, .feedback-slides.owl-theme .owl-dots .owl-dot.active span, .testimonials-slides.owl-theme .owl-dots .owl-dot:hover span, .testimonials-slides.owl-theme .owl-dots .owl-dot.active span, .feedback-slides-two.owl-theme .owl-dots .owl-dot:hover span, .feedback-slides-two.owl-theme .owl-dots .owl-dot.active span, .blog-slides.owl-theme .owl-dots .owl-dot:hover span, .blog-slides.owl-theme .owl-dots .owl-dot.active span, .blog-details .article-image-slides.owl-theme .owl-nav [class*=owl-]:hover, .login-form form .remember-me-wrap [type="checkbox"]:hover + label:before, .login-form form .remember-me-wrap [type="checkbox"]:checked + label:before, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu, .about-video-box .video-btn::after, .about-video-box .video-btn::before, .video-box .video-btn::after, .video-box .video-btn::before, .blog-details .article-footer .article-share .social li a, .products-details-desc .products-share .social li a, .user-actions, .is-style-outline .wp-block-button__link, #comments .comment-list .comment-body .reply a:hover, .products_details div.product .woocommerce-product-rating a.woocommerce-review-link:hover, .single-language-courses-box .default-btn, .services-slides.owl-theme .owl-nav [class*=owl-], .courses-slides-two.owl-theme .owl-nav [class*=owl-], .default-btn-style-two, .tutor-form-group.tutor-reg-form-btn-wrap .tutor-button, .tutor-login-form-wrap input[type="submit"] { border-color: '.esc_attr($primary_color).'; }                

                .navbar-area { background-color: '.esc_attr( $header_bg_color ).' !important; }              
                .footer-area .single-footer-widget p, .footer-area .single-footer-widget ul li, .single-footer-widget .footer-contact-info li a, .footer-area .single-footer-widget ul li a { color: '.esc_attr( $footer_item_color  ).' !important; }              
                .footer-area { background-color: '.esc_attr( $footer_bg ).'; }       
                .single-footer-widget .social-link li .d-block:hover { color: #ffffff !important;}

                .single-products .sale-btn, .single-products .products-image ul li a:hover, .productsQuickView .modal-dialog .modal-content .products-content form button, .productsQuickView .modal-dialog .modal-content button.close:hover, .productsQuickView .modal-dialog .modal-content button.close:hover, .woocommerce ul.products li.product:hover .add-to-cart-btn, .shop-sidebar .widget_product_search form button, .shop-sidebar a.button, .shop-sidebar .woocommerce-widget-layered-nav-dropdown__submit, .shop-sidebar .woocommerce button.button, .woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .products_details div.product .woocommerce-tabs .panel #respond input#submit, .products_details div.product .product_title::before, .woocommerce #respond input#submit.alt.disabled, .woocommerce #respond input#submit.alt.disabled:hover, .woocommerce #respond input#submit.alt:disabled, .woocommerce #respond input#submit.alt:disabled:hover, .woocommerce #respond input#submit.alt:disabled[disabled], .woocommerce #respond input#submit.alt:disabled[disabled]:hover, .woocommerce a.button.alt.disabled, .woocommerce a.button.alt.disabled:hover, .woocommerce a.button.alt:disabled, .woocommerce a.button.alt:disabled:hover, .woocommerce a.button.alt:disabled[disabled], .woocommerce a.button.alt:disabled[disabled]:hover, .woocommerce button.button.alt.disabled, .woocommerce button.button.alt.disabled:hover, .woocommerce button.button.alt:disabled, .woocommerce button.button.alt:disabled:hover, .woocommerce button.button.alt:disabled[disabled], .woocommerce button.button.alt:disabled[disabled]:hover, .woocommerce input.button.alt.disabled, .woocommerce input.button.alt.disabled:hover, .woocommerce input.button.alt:disabled, .woocommerce input.button.alt:disabled:hover, .woocommerce input.button.alt:disabled[disabled], .woocommerce input.button.alt:disabled[disabled]:hover, .btn-primary:hover, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce .woocommerce-MyAccount-navigation ul .is-active a, .woocommerce .woocommerce-MyAccount-navigation ul li a:hover, .products_details div.product span.sale-btn, .shop-sidebar .tagcloud a:focus, .shop-sidebar .widget_search form button, .shop-sidebar .widget .widget-title::before, .shop-sidebar .widget ul li::before, .shop-sidebar .tagcloud a:hover, .shop-sidebar .tagcloud a:focus { background-color: '.esc_attr($primary_color).'; }
                .btn-primary, .btn-primary.disabled, .btn-primary:disabled { background-color: '.esc_attr($primary_color).'; }

                .productsQuickView .modal-dialog .modal-content .products-content .product-meta span a:hover, .woocommerce ul.products li.product h3 a:hover, .woocommerce ul.products li.product .add-to-cart-btn, .woocommerce div.product .woocommerce-tabs ul.tabs li.active a, .products_details div.product .woocommerce-tabs ul.tabs li a:hover, .products_details div.product .woocommerce-tabs ul.tabs li.active, .products_details div.product .woocommerce-tabs ul.tabs li.active a:hover, .products_details div.product .product_meta span.posted_in a:hover, .products_details div.product .product_meta span.tagged_as a:hover, .products_details div.product span.price, .cart-table table tbody tr td.product-name a, .woocommerce-message::before, .woocommerce-info::before, .shop-sidebar .widget ul li a:hover, .shop-sidebar .widget_rss .widget-title .rsswidget { color: '.esc_attr ($primary_color).'; }

                .woocommerce-info, .woocommerce-message { border-top-color: '.esc_attr ($primary_color).'; }
                .shop-sidebar .widget_shopping_cart .cart_list li a:hover, .shop-sidebar ul li a:hover { color: '.esc_attr ($primary_color).' !important; }
                .woocommerce ul.products li.product:hover .add-to-cart-btn, .form-control:focus, .woocommerce .form-control:focus, .shop-sidebar .tagcloud a:hover, .shop-sidebar .tagcloud a:focus, .tutor-button.tutor-success { border-color: '.esc_attr ($primary_color).'; }

                .navbar-area.no-sticky.is-sticky {display:none !important;}
                .courses-curriculum .scroll-wrapper > .scroll-content { overflow: inherit !important; }
                .courses-curriculum .scroll-wrapper { overflow: initial !important; }
                ';
        
            // Hide Sticky Header
            if(isset($ecademy_opt['enable_sticky_header']) && $ecademy_opt['enable_sticky_header'] == false){ $custom_style .='
                .navbar-area.is-sticky{
                    display:none !important;
                }';
            }
            // is 404 page
            if( is_404() ):
                $custom_style .='
                .navbar-area, .footer-area {
                    display:none !important;
                }';
            endif;

            // Custom Css
            if( isset($ecademy_opt['css_code'] ) && !empty($ecademy_opt['css_code']) ):
                $custom_style .= $ecademy_opt['css_code'];
            endif;

            if( is_user_logged_in() ){ 
                $custom_style .=' .comments-area .comment-respond .form-submit {
                    margin-top: 20px;
                }';
            }

            // Lesson Icon
            if( isset($ecademy_opt['lesson_icon'] ) && !empty($ecademy_opt['lesson_icon']) ):
                $custom_style .=' #learn-press-course-curriculum.courses-curriculum ul li a::before { content: "'.$ecademy_opt['lesson_icon'].'"; } ';
            endif;

            /**
             * Options from Theme Settings
             */
            $custom_style .= "";

            if ( function_exists('get_field') ) {
                /**
                 * Banner Styling
                 */
                $banner_text_color = get_field('banner_text_color');
                if( is_home() ) {
                    $post_page_id = get_option( 'page_for_posts' );
                    $banner_text_color = get_field('banner_text_color', $post_page_id);
                }
                
                if ( !empty( $banner_text_color ) ) {
                    $custom_style .= ".page-title-content h2, .page-title-content ul li, .page-title-content ul li a { color: $banner_text_color !important;; }";
                    $custom_style .= ".page-title-content ul li::before { background-color: $banner_text_color !important;; }";
                }
        
                // Banner Background Gradient Colors
                $banner_bg_color_right = function_exists( 'get_field' ) ? get_field( 'background_color_right' ) : '';
                if( is_home() ) {
                    $post_page_id = get_option( 'page_for_posts' );
                    $banner_bg_color_right = function_exists( 'get_field' ) ? get_field( 'background_color_right', $post_page_id ) : '';
                }
                if ( !empty($banner_bg_color_right) ) {
                    $background_color_right =  get_field( 'background_color_right' );
                    $background_color_left =  get_field( 'background_color_left' );
                    $banner_background_image =  get_field( 'banner_background_image' );
                    if( is_home() ) {
                        $post_page_id = get_option( 'page_for_posts' );
                        $background_color_left = get_field( 'background_color_left', $post_page_id );
                        $background_color_right =  get_field( 'background_color_right', $post_page_id );
                    }

                    if($banner_background_image ==''):
                        $custom_style .= "
                        .page-title-area {
                            background-image: -moz-linear-gradient(180deg, " . esc_attr( $background_color_right ) . " 0%, " . $background_color_left . " 100% ) !important;
                            background-image: -webkit-linear-gradient(180deg, " . esc_attr( $background_color_right ) . " 0%, " . $background_color_left . " 100% ) !important;
                            background-image: -ms-linear-gradient(180deg, " . esc_attr( $background_color_right ) . " 0%, " . $background_color_left . " 100% ) !important;
                        }";
                    endif;
                }

                /**
                 * Menu Item Color
                 */
                $menu_item_color = get_field( 'menu_item_color' );
                if( is_home() ) {
                    $post_page_id = get_option( 'page_for_posts' );
                    $menu_item_color = get_field( 'menu_item_color', $post_page_id );
                }
                if ( $menu_item_color ) {
                    $custom_style .= ".ecademy-nav .navbar .navbar-nav .nav-item a {color: $menu_item_color !important;}";
                }

                $sticky_menu_color = get_field( 'sticky_menu_color' );
                if( is_home() ) {
                    $post_page_id = get_option( 'page_for_posts' );
                    $sticky_menu_color = get_field( 'sticky_menu_color', $post_page_id );
                }
                if ( $sticky_menu_color ) {
                    $custom_style .= ".navbar-area.is-sticky .ecademy-nav .navbar .navbar-nav .nav-item a { color: $sticky_menu_color !important; }";
                }

                /**
                 * Menu Item Active Color
                 */
                $menu_item_active_color = function_exists( 'get_field' ) ? get_field( 'menu_item_active_color' ) : '';
                if( is_home() ) {
                    $post_page_id = get_option( 'page_for_posts' );
                    $menu_item_active_color = function_exists( 'get_field' ) ? get_field( 'menu_item_active_color', $post_page_id ) : '';
                }
                if ( !empty($menu_item_active_color) ) {
                    $custom_style .= "
                    .ecademy-nav .navbar .navbar-nav .nav-item:hover a, .ecademy-nav .navbar .navbar-nav .nav-item.active a, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li.active a, .ecademy-nav .navbar .navbar-nav .nav-item .dropdown-menu li .dropdown-menu li.active a, .navbar-area.is-sticky .ecademy-nav .navbar .navbar-nav .nav-item a:hover, .navbar-area.is-sticky .ecademy-nav .navbar .navbar-nav .nav-item.active a { color: $menu_item_active_color !important; }
                    ";
                }

                /**
                 * Page Padding controls
                 */
                $page_padding = function_exists( 'get_field' ) ? get_field( 'page_content_padding' ) : '';
                if( is_home() ) {
                    $post_page_id = get_option( 'page_for_posts' );
                    $page_padding = function_exists( 'get_field' ) ? get_field( 'page_content_padding', $post_page_id ) : '';
                }
                // Padding top
                if ( isset($page_padding['padding_top']) && !$page_padding['padding_bottom'] == '' ) {
                    $custom_style .= "
                    .page-area, .blog-details-area.ptb-100, .events-details-area, .products-area.products_details.ptb-100, .elementor-template-full-width .elementor.elementor-" . get_the_ID() . " { padding-top: {$page_padding['padding_top']}px; }";
                }

                // Padding bottom
                if ( isset($page_padding['padding_bottom']) && !$page_padding['padding_bottom'] == '' ) {
                    $custom_style .= "
                        .page-area, .blog-details-area.ptb-100, .products-area.products_details.ptb-100, .events-details-area, .elementor-template-full-width .elementor.elementor-" . get_the_ID() . " { padding-bottom: {$page_padding['padding_bottom']}px; } 
                    ";
                }
            }

            // Pre-loader image
            $is_preloader       = !empty($ecademy_opt['enable_preloader']) ? $ecademy_opt['enable_preloader'] : '';
            $preloader_image    = isset( $ecademy_opt['preloader_image']['url'] ) ? $ecademy_opt['preloader_image']['url'] : '';
            $preloader_style = !empty( $ecademy_opt['preloader_style'] ) ? $ecademy_opt['preloader_style'] : 'text';
            if ( $preloader_style == 'image' && $is_preloader == '1' ) {
                $custom_style .= "
                .preloader {
                    background-image: url(" . esc_url( $preloader_image ) . ");
                    background-repeat: no-repeat;
                    background-position: center;
                }";
            }
            
            wp_add_inline_style('ecademy-main-style', $custom_style);

            // Custom Js
            $custom_script ='';
            if( isset($ecademy_opt['js_code'] )){
                $custom_script .= $ecademy_opt['js_code'];
            }         
            
            wp_add_inline_script( 'ecademy-main', $custom_script );
    }
}
add_action( 'wp_enqueue_scripts', 'ecademy_custom_style' );