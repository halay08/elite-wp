<?php
/**
 * The sidebar containing the main widget area
 * @package eCademy
 */
if ( class_exists( 'WooCommerce' ) ) {
	if( is_woocommerce() ) {
		$sidebar = 'shop';
	}elseif ( is_product() ) {
		$sidebar = 'shop';
	}else {
		$sidebar = 'sidebar-1';
	}
}else{
	$sidebar = 'sidebar-1';
}

if ( ! is_active_sidebar( $sidebar ) ) { 
	return;
}
?>
<div class="col-lg-4 col-md-12">
	<?php if ( class_exists( 'WooCommerce' ) ) {
		if( is_woocommerce() ) { ?>
			<div id="secondary" class="sidebar shop-sidebar">
			<?php
		} elseif ( is_product() ) { ?>
			<div id="secondary" class="sidebar shop-sidebar">
		<?php
		} else { ?>
			<div id="secondary" class="sidebar">
		<?php
		}
	}else{ ?>
		<div id="secondary" class="sidebar">
	<?php } ?>
		<?php dynamic_sidebar( $sidebar );?>
	</div>
</div><!-- #secondary -->