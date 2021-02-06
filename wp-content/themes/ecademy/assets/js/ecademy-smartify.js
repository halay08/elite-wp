(function($){
	"use strict";
	jQuery(document).on('ready', function () {
        
        $('img').addClass('smartify');
        $('.smartify').smartify();

    });

    $( window ).on( 'elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/widget', function( $scope ) {
            
            $('img').addClass('smartify');
            $('.smartify').smartify();
        });
    });
}(jQuery));