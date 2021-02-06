<?php
/**
 * The eCademy_RT initiate the theme engine
 */

if ( !defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class eCademy_RT {

	/**
	 * Variables required for the theme updater
	 *
	 * @since 1.0.0
	 * @type string
	 */
	//  protected $remote_api_url = null;
	 protected $theme_slug = null;
	 protected $version = null;
	 protected $renew_url = null;
	 protected $strings = null;

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	function __construct( $config = array(), $strings = array() ) {

		$config = wp_parse_args( $config, array(
			'theme_slug'     => 'ecademy',
			'version'        => '',
			'author'         => 'envytheme',
			'renew_url'      => ''
		));

		// Set config arguments
		$this->theme_slug     = sanitize_key( $config['theme_slug'] );
		$this->version        = $config['version'];
		$this->author         = $config['author'];
		$this->renew_url      = $config['renew_url'];

		// Populate version fallback
		if ( '' == $config['version'] ) {
			$theme = wp_get_theme( $this->theme_slug );
			$this->version = $theme->get( 'Version' );
		}

		// Strings passed in from the updater config
		$this->strings = $strings;

		add_action( 'after_setup_theme', array( $this, 'init_hooks' ) );
		add_action( 'admin_init', array( $this, 'register_option' ) );
		add_filter( 'http_request_args', array( $this, 'disable_wporg_request' ), 5, 2 );
	}
	
	/**
	 * [init_hooks description]
	 * @method init_hooks
	 * @return [type]     [description]
	 */
	public function init_hooks() {

        if ( 'valid' != get_option( $this->theme_slug . '_purchase_code_status', false ) ) {

            if ( ( ! isset( $_GET['page'] ) || 'ecademy' != $_GET['page'] ) ) {
                add_action( 'admin_notices', array( $this, 'admin_error' ) );
            } else {
                add_action( 'admin_notices', array( $this, 'admin_notice' ) );

            }
        }
	}
	
	function admin_error() {
		$out = '<div class="notice notice-error is-dismissible ecademy-purchase-notice"><p>' . sprintf( wp_kses_post( __( 'The %s theme needs to be registered. %sRegister Now%s', 'ecademy' ) ), 'eCademy', '<a href="' . admin_url( 'admin.php?page=ecademy') . '">' , '</a>' ) . '</p></div>';
        if ( get_option('notice_dismissed') ) {
            return;
        }
		echo wp_kses_post($out);
	}
	
	function admin_notice() {
		$out = '<div class="notice is-dismissible ecademy-purchase-notice"><p>' .sprintf( wp_kses_post( __( 'Purchase key is invalid. Need a license? %sPurchase Now%s', 'ecademy' ) ), '<a target="_blank" href="https://1.envato.market/KM13e">', '</a>' ) .'</p></div>';
		if ( get_option('notice_dismissed') ) {
		    return;
        }
		echo wp_kses_post($out);
	}
	
	function messages() {
		$license = trim( get_option( $this->theme_slug . '_purchase_code' ) );
		$status = get_option( $this->theme_slug . '_purchase_code_status', false );
		if ( $status != '' ) {
			$license_icon = ($status == 'valid') ? '<i class="dashicons-yes"></i>' : '<i class="dashicons-warning"></i>';
			
			if($status == 'valid'){
				$title = esc_html__( 'Purchase Key Verified & Registered!', 'ecademy' );
			}elseif($status == 'already_registered'){
				$title = esc_html__( 'Purchase Key Already Registered', 'ecademy' );
			}else{
				$title = esc_html__( 'Purchase Key Invalid', 'ecademy' );
			}
        } else {
            $license_icon = ($status == 'valid') ? '<i class="dashicons-yes"></i>' : '<i class="dashicons-warning"></i>';
		    $title = esc_html__( 'Verify Theme Purchase Key. . .', 'ecademy' );
        }
		// Checks license status to display under license key
        $message    = '<h4>' . $license_icon . $title . '</h4>';
		echo wp_kses_post( $message );
	}
	
	/**
	 * Outputs the markup used on the theme license page
	 * since 1.0.0
	 */
	function form() {
		$strings = $this->strings;
		$license = trim( get_option( $this->theme_slug . '_purchase_code' ) );
		$email = get_option( $this->theme_slug . '_register_email', false );
		$status = get_option( $this->theme_slug . '_purchase_code_status', false );
		require get_template_directory().'/inc/verify/class.verify-purchase.php';
		?>
        <div id="show-result"></div>
		<form action="" method="post" id="verify-envato-purchase" class="et-theme-register-form">
			<?php settings_fields( $this->theme_slug . '-license' ); ?>
			<input id="ecademy_purchase_code" name="ecademy_purchase_code" type="text" value="<?php echo esc_attr( $license ); ?>" placeholder="<?php esc_attr_e( 'Enter purchase key', 'ecademy' ); ?>">
			<?php if( $status != 'valid' ){ ?>
				<input type="submit" value="<?php esc_attr_e( 'Verify Now', 'ecademy' ); ?>">
			<?php } ?>
			<?php
			if ( $status != '' ) {
				if( $status == 'valid' ){ ?>
					<input id="ecademy_purchase_code" name="ecademy_purchase_code" type="hidden" value="">
					<input type='submit' class='deactivate' value='Deregister Theme'>
					<?php
				}
			} ?>

			<?php if( get_option( 'ecademy_purchase_code_status' ) == 'already_registered' ): ?>
				<div class="et_warning">
					<span class="dashicons dashicons-warning"></span>
					<?php echo stripslashes( get_option( 'ecademy_already_registered' ) ); ?>
				</div>
			<?php endif; ?>

		</form>
		<?php
        if ( isset($_POST['ecademy_purchase_code']) ) {
			if( $_POST['ecademy_purchase_code'] != '' ){
				echo "<meta http-equiv='refresh' content='0'>";
				update_option( $this->theme_slug . '_purchase_code', $_POST['ecademy_purchase_code'] );
				$purchase_code = htmlspecialchars($_POST['ecademy_purchase_code']);

				$purchase_code = str_replace(' ', '', $purchase_code);

				$o = EnvatoApi2::verifyPurchase( $purchase_code );

				if ( is_object($o) && strpos($o->item_name, 'eCademy') !== false ) {

					// Check in localhost
					$whitelist = array(
						'127.0.0.1',
						'::1',
						'192.168.1',
						'192.168.0.1',
						'182.168.1.5',
						'192.168.1.4',
						'192.168.1.5',
						'192.168.1.4',
						'192.168',
						'10.0.2.2',
					);

					if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){ // In server
							$url 			= 'https://api.envytheme.com/api/v1/license';
							$purchaseKey 	= $purchase_code;
							$itemName 		= $o->item_name;
							$buyer 			= $o->buyer;
							$purchasedAt 	= $o->created_at;
							$supportUntil 	= $o->supported_until;
							$licenseType 	= $o->licence;
							$domain 		= get_site_url();
							$post_url 		= '';

							$post_url .= $url.'?purchaseKey='.$purchaseKey.'&itemName='.$itemName.'&buyer='.$buyer.'&purchasedAt='.$purchasedAt.'&supportUntil='.$supportUntil.'&licenseType='.$licenseType.'&domain='.$domain.'';
							
							$post_url = str_replace(' ', '%', $post_url);
						
							$curl = curl_init();

							curl_setopt_array($curl, array(
							CURLOPT_URL => $post_url,
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_ENCODING => "",
							CURLOPT_MAXREDIRS => 10,
							CURLOPT_TIMEOUT => 30,
							CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							CURLOPT_CUSTOMREQUEST => "POST",
							CURLOPT_HTTPHEADER => array(
								"cache-control: no-cache",
								"content-type: application/x-www-form-urlencoded"
							),
							CURLOPT_SSL_VERIFYPEER => false,
							));

							$response = curl_exec($curl);
							$err = curl_error($curl);
							curl_close($curl);

							if ($err) {
							echo "cURL Error #:" . $err;
							} else {
								$json = json_decode($response);
								$already_registered = $json->message[0]; // Already registered

								$new_response = '';
								$new_response .= 'Congratulations! Updated for this domain '.$domain.'';

								preg_match_all('#https?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $already_registered, $match);
								$url = $match[0];

								$protocols 		= array('http://', 'http://www.', 'www.', 'https://', 'https://www.');
								$domain_name 	= str_replace( $protocols, '', $url[0] );	
								$site_url 		= str_replace( $protocols, '', get_site_url() );	

								if( $already_registered != '' ){
									if( $already_registered == $new_response ):
										update_option('ecademy_purchase_code_status', 'valid', 'yes');
										update_option('ecademy_purchase_valid_code',  $purchase_code, 'yes');
										update_option('valid_url', get_site_url(), 'yes');
										
                                        ?><script>let date = new Date(Date.now() + 604800);	date = date.toUTCString(); document.cookie = "ECA_LSM_Status=<?php echo $purchase_code; ?>; expires=" + date; </script><?php

									elseif( $domain_name == $site_url ):
										/* Deregister  */
											$url 			= 'https://api.envytheme.com/api/v1/license';
											$purchaseKey 	= $purchase_code;
											$status 		= 'disabled';
											$post_url = '';
											$post_url .= $url.'?purchaseKey='.$purchaseKey.'&status='.$status.'';
											$post_url = str_replace(' ', '%', $post_url);
											$curl = curl_init();
											curl_setopt_array($curl, array(
												CURLOPT_URL 			=> $post_url,
												CURLOPT_RETURNTRANSFER 	=> true,
												CURLOPT_ENCODING 		=> "",
												CURLOPT_MAXREDIRS 		=> 10,
												CURLOPT_TIMEOUT 		=> 30,
												CURLOPT_HTTP_VERSION 	=> CURL_HTTP_VERSION_1_1,
												CURLOPT_CUSTOMREQUEST 	=> "PUT",
												CURLOPT_HTTPHEADER 		=> array(
													"cache-control: no-cache",
													"content-type: application/x-www-form-urlencoded"
												),
												CURLOPT_SSL_VERIFYPEER => false,
											));

											$response = curl_exec($curl);
											$err = curl_error($curl);
											curl_close($curl);
										/* Deregister */

										/* Register */
											$url 			= 'https://api.envytheme.com/api/v1/license';
											$purchaseKey 	= $purchase_code;
											$itemName 		= $o->item_name;
											$buyer 			= $o->buyer;
											$purchasedAt 	= $o->created_at;
											$supportUntil 	= $o->supported_until;
											$licenseType 	= $o->licence;
											$domain 		= get_site_url();
											$post_url 		= '';

											$post_url .= $url.'?purchaseKey='.$purchaseKey.'&itemName='.$itemName.'&buyer='.$buyer.'&purchasedAt='.$purchasedAt.'&supportUntil='.$supportUntil.'&licenseType='.$licenseType.'&domain='.$domain.'';
											
											$post_url = str_replace(' ', '%', $post_url);
										
											$curl = curl_init();

											curl_setopt_array($curl, array(
											CURLOPT_URL => $post_url,
											CURLOPT_RETURNTRANSFER => true,
											CURLOPT_ENCODING => "",
											CURLOPT_MAXREDIRS => 10,
											CURLOPT_TIMEOUT => 30,
											CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
											CURLOPT_CUSTOMREQUEST => "POST",
											CURLOPT_HTTPHEADER => array(
												"cache-control: no-cache",
												"content-type: application/x-www-form-urlencoded"
											),
											CURLOPT_SSL_VERIFYPEER => false,
											));

											$response = curl_exec($curl);
											$err = curl_error($curl);
											curl_close($curl);
										/* Register */

										update_option('ecademy_purchase_code_status', 'valid', 'yes');
										update_option('ecademy_purchase_valid_code',  $purchase_code, 'yes');
										update_option('valid_url', get_site_url(), 'yes');
									
                                        ?><script>let date = new Date(Date.now() + 604800);	date = date.toUTCString(); document.cookie = "ECA_LSM_Status=<?php echo $purchase_code; ?>; expires=" + date; </script><?php
									else:
										$target_site 	= $url[0];
										$src 			= file_get_contents( $target_site );
										preg_match("/\<link rel='stylesheet' id='ecademy-style-css'.*href='(.*?style\.css.*?)'.*\>/i", $src, $matches );

										if( $matches ) { // if theme found
											update_option('ecademy_purchase_code_status', 'already_registered', 'yes');
											update_option('ecademy_already_registered', $already_registered, 'yes');
										}else{
											/* Deregister  */
												$url 			= 'https://api.envytheme.com/api/v1/license';
												$purchaseKey 	= $purchase_code;
												$status 		= 'disabled';
												$post_url = '';
												$post_url .= $url.'?purchaseKey='.$purchaseKey.'&status='.$status.'';
												$post_url = str_replace(' ', '%', $post_url);
												$curl = curl_init();
												curl_setopt_array($curl, array(
													CURLOPT_URL 			=> $post_url,
													CURLOPT_RETURNTRANSFER 	=> true,
													CURLOPT_ENCODING 		=> "",
													CURLOPT_MAXREDIRS 		=> 10,
													CURLOPT_TIMEOUT 		=> 30,
													CURLOPT_HTTP_VERSION 	=> CURL_HTTP_VERSION_1_1,
													CURLOPT_CUSTOMREQUEST 	=> "PUT",
													CURLOPT_HTTPHEADER 		=> array(
														"cache-control: no-cache",
														"content-type: application/x-www-form-urlencoded"
													),
													CURLOPT_SSL_VERIFYPEER => false,
												));

												$response = curl_exec($curl);
												$err = curl_error($curl);
												curl_close($curl);
											/* Deregister */

											/* Register */
												$url 			= 'https://api.envytheme.com/api/v1/license';
												$purchaseKey 	= $purchase_code;
												$itemName 		= $o->item_name;
												$buyer 			= $o->buyer;
												$purchasedAt 	= $o->created_at;
												$supportUntil 	= $o->supported_until;
												$licenseType 	= $o->licence;
												$domain 		= get_site_url();
												$post_url 		= '';

												$post_url .= $url.'?purchaseKey='.$purchaseKey.'&itemName='.$itemName.'&buyer='.$buyer.'&purchasedAt='.$purchasedAt.'&supportUntil='.$supportUntil.'&licenseType='.$licenseType.'&domain='.$domain.'';
												
												$post_url = str_replace(' ', '%', $post_url);
											
												$curl = curl_init();

												curl_setopt_array($curl, array(
												CURLOPT_URL => $post_url,
												CURLOPT_RETURNTRANSFER => true,
												CURLOPT_ENCODING => "",
												CURLOPT_MAXREDIRS => 10,
												CURLOPT_TIMEOUT => 30,
												CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
												CURLOPT_CUSTOMREQUEST => "POST",
												CURLOPT_HTTPHEADER => array(
													"cache-control: no-cache",
													"content-type: application/x-www-form-urlencoded"
												),
												CURLOPT_SSL_VERIFYPEER => false,
												));

												$response = curl_exec($curl);
												$err = curl_error($curl);
												curl_close($curl);
											/* Register */
										}
									endif;
								}else {
									update_option('ecademy_purchase_code_status', 'valid', 'yes');
                                    update_option('ecademy_purchase_valid_code',  $purchase_code, 'yes');
									update_option('valid_url', get_site_url(), 'yes');
                                    
                                    ?><script>let date = new Date(Date.now() + 604800);	date = date.toUTCString(); document.cookie = "ECA_LSM_Status=<?php echo $purchase_code; ?>; expires=" + date; </script><?php
								}

							}
						
					}else{ // In local
						$domain = get_site_url();
						update_option('ecademy_purchase_code_status', 'valid', 'yes');
						update_option('ecademy_purchase_valid_code',  $purchase_code, 'yes');
					}
				} elseif( $purchase_code == '' ){
					update_option( 'ecademy_purchase_code_status', '', 'yes' );
					update_option( 'ecademy_purchase_code', '', 'yes' );
				} else {
					update_option( 'ecademy_purchase_code_status', 'invalid', 'yes' );
				}
			}else{
				echo "<meta http-equiv='refresh' content='0'>";
				
				$purchase_code = get_option( 'ecademy_purchase_valid_code' );

				$o = EnvatoApi2::verifyPurchase( $purchase_code );

				if ( is_object($o) && strpos($o->item_name, 'eCademy') !== false ) {

					// Check in localhost
					$whitelist = array(
						'127.0.0.1',
						'::1',
						'192.168.1',
						'192.168.0.1',
						'182.168.1.5',
						'192.168.1.4',
						'192.168.1.5',
						'192.168.1.4',
						'192.168',
						'10.0.2.2',
					);	

					if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){ // In server
							$url 			= 'https://api.envytheme.com/api/v1/license';
							$purchaseKey 	= $purchase_code;
							$status 		= 'disabled';
							
							$post_url = '';

							$post_url .= $url.'?purchaseKey='.$purchaseKey.'&status='.$status.'';
							
							$post_url = str_replace(' ', '%', $post_url);
						
							$curl = curl_init();

							curl_setopt_array($curl, array(
							CURLOPT_URL 			=> $post_url,
							CURLOPT_RETURNTRANSFER 	=> true,
							CURLOPT_ENCODING 		=> "",
							CURLOPT_MAXREDIRS 		=> 10,
							CURLOPT_TIMEOUT 		=> 30,
							CURLOPT_HTTP_VERSION 	=> CURL_HTTP_VERSION_1_1,
							CURLOPT_CUSTOMREQUEST 	=> "PUT",
							CURLOPT_HTTPHEADER 		=> array(
								"cache-control: no-cache",
								"content-type: application/x-www-form-urlencoded"
							),
							CURLOPT_SSL_VERIFYPEER => false,
							));

							$response = curl_exec($curl);
							$err = curl_error($curl);

							curl_close($curl);

							if ($err) {
							echo "cURL Error #:" . $err;
							} else {
								$json = json_decode($response);
								$response_message = $json->message[0]; // Already registered

								if( $response_message != '' ){
									update_option( 'ecademy_purchase_code', '', 'yes' );
									update_option( 'ecademy_purchase_code_status', '', 'yes' );
									
									?><script>let date = new Date(Date.now() - 604800);	date = date.toUTCString(); document.cookie = "ECA_LSM_Status=<?php echo $purchase_code; ?>; expires=" + date; </script><?php
								}

							}
						
					}else{ // In local
						update_option('ecademy_purchase_code_status', '', 'yes');
						update_option( 'ecademy_purchase_code', '', 'yes' );
					}
				}			
			}
		}
	}

	
	/**
	 * Registers the option used to store the license key in the options table.
	 *
	 * since 1.0.0
	 */
	function register_option() {
		register_setting(
			$this->theme_slug . '-license',
			$this->theme_slug . '_purchase_code',
			array( $this, 'sanitize_license' )
		);
		register_setting(
			$this->theme_slug . '-license',
			$this->theme_slug . '_register_email'
		);
	}

	/**
	 * Disable requests to wp.org repository for this theme.
	 *
	 * @since 1.0.0
	 */
	function disable_wporg_request( $r, $url ) {

		// If it's not a theme update request, bail.
		if ( 0 !== strpos( $url, 'https://api.wordpress.org/themes/update-check/1.1/' ) ) {
 			return $r;
 		}

 		// Decode the JSON response
 		$themes = json_decode( $r['body']['themes'] );

 		// Remove the active parent and child themes from the check
 		$parent = get_option( 'template' );
 		$child = get_option( 'stylesheet' );
 		unset( $themes->themes->$parent );
 		unset( $themes->themes->$child );

 		// Encode the updated JSON response
 		$r['body']['themes'] = json_encode( $themes );

 		return $r;
	}
	
}

new eCademy_RT;
?>