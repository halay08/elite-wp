<?php
/**
 *  Your Domain WooCommerce functions and definitions
 */
 	// Theme WooCommerce Support
	apply_filters( 'storefront_woocommerce_args', array(
		'single_image_width'    => 530,
		'thumbnail_image_width' => 350,
		add_theme_support( 'wc-product-gallery-zoom' ),
		add_theme_support( 'wc-product-gallery-lightbox' ),
		add_theme_support( 'wc-product-gallery-slider' ),
	) );

	if ( is_active_sidebar( 'shop' ) ) {
		// Change number or products per row to 3
		add_filter('loop_shop_columns', 'ecademy_loop_columns', 999);
		if (!function_exists('ecademy_loop_columns')) {
			function ecademy_loop_columns() {
				global $ecademy_opt;

				if ( isset( $_GET['shop-sidebar'] ) ):
					if( $_GET['shop-sidebar'] == 'right' || $_GET['shop-sidebar'] == 'left' ):
						return 2; // 2 products per row
					elseif( $_GET['shop-sidebar'] == 'none' ):
						return 3; // 3 products per row
					endif;
				else:
					if ( $ecademy_opt['ecademy_product_sidebar'] == 'ecademy_product_no_sidebar' ):
						return 3; // 3 products per row
					else:
						return 2; // 2 products per row
					endif;
				endif;	
			}
		}
	}else{
		// Change number or products per row to 3
		add_filter('loop_shop_columns', 'ecademy_loop_columns', 999);
		if (!function_exists('ecademy_loop_columns')) {
			function ecademy_loop_columns() {
				return 3; // 3 products per row
			}
		}
	}

	// Change number of related products output
	function ecademy_woo_related_products_limit() {
		global $product;
		$args['posts_per_page'] = 6;
		return $args;
	}
	add_filter( 'woocommerce_output_related_products_args', 'ecademy_related_products_args', 20 );
	function ecademy_related_products_args( $args ) {
		global $ecademy_opt;

		if( isset( $ecademy_opt['ecademy_related_product_count'] ) ):
		   $count = $ecademy_opt['ecademy_related_product_count'];
		else:
		   $count = '3';
		endif;

		$args['posts_per_page'] = $count; // related products
		
		global $ecademy_opt;
		if ( isset( $_GET['shop-sidebar'] ) ):
			if( $_GET['shop-sidebar'] == 'right' || $_GET['shop-sidebar'] == 'left' ):
				$args['columns'] = 2; // 2 products per row
			elseif( $_GET['shop-sidebar'] == 'none' ):
				$args['columns'] = 3; // 3 products per row
			endif;
		else:
			if ( $ecademy_opt['ecademy_product_sidebar'] == 'ecademy_product_no_sidebar' ):
				$args['columns'] = 3; // 3 products per row
			else:
				$args['columns'] = 2; // 2 products per row
			endif;
		endif;
		
		return $args;
	}

	if ( ! function_exists( 'ecademy_wc_refresh_mini_cart_count' ) ) :
		function ecademy_wc_refresh_mini_cart_count($fragments){
			ob_start();
			?>
			<span class="mini-cart-count"> 
				<?php echo WC()->cart->get_cart_contents_count(); ?>
			</span>
			<?php
				$fragments['.mini-cart-count'] = ob_get_clean();
			return $fragments;
		}
	endif;
	add_filter( 'woocommerce_add_to_cart_fragments', 'ecademy_wc_refresh_mini_cart_count');

	// Filter woocommerce_checkout_fields
	if ( ! function_exists( 'ecademy_field_class_add' ) ) :
		function ecademy_field_class_add($fields) {
		foreach ($fields as &$fieldset) {
			foreach ($fieldset as &$field) {
				$field['class'][] = 'form-group'; 
				$field['input_class'][] = 'form-control';
			}
		}
		return $fields;
	}
	endif;
	add_filter('woocommerce_checkout_fields', 'ecademy_field_class_add' );

	/**
	 * Post Per page
	 */
	add_filter( 'loop_shop_per_page', 'ecademy_redefine_products_per_page', 9999 );
	
	function ecademy_redefine_products_per_page( $per_page ) {
		global $ecademy_opt;

		if( isset( $ecademy_opt['products_page_count'] ) ):
		   $count = $ecademy_opt['products_page_count'];
		else:
		   $count = '6';
		endif;
		
		$per_page = $count;
		return $per_page;
	}

	if ( ! function_exists( 'ecademy_refresh_mini_cart_count' ) ) :
		function ecademy_refresh_mini_cart_count($fragments){
			ob_start();
			?>
			<span class="cart-count"> 
				<?php echo WC()->cart->get_cart_contents_count(); ?>
			</span>
			<?php
				$fragments['.cart-count'] = ob_get_clean();
			return $fragments;
		}
	endif;
	add_filter( 'woocommerce_add_to_cart_fragments', 'ecademy_refresh_mini_cart_count');

	
	/**
	 * Auto Complete all WooCommerce orders.
	 */
	add_action( 'woocommerce_thankyou', 'ecademy_custom_woocommerce_auto_complete_order' );
	function ecademy_custom_woocommerce_auto_complete_order( $order_id ) { 
		if ( ! $order_id ) {
			return;
		}
		global $ecademy_opt;
		if( $ecademy_opt['enable_auto_complete'] == 'yes' ):
			$order = wc_get_order( $order_id );
			$order->update_status( 'completed' );
		endif;

	}