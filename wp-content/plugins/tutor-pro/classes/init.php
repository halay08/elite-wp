<?php
namespace TUTOR_PRO;

if ( ! defined( 'ABSPATH' ) )
	exit;

class init{
	public $version = TUTOR_PRO_VERSION;
	public $path;
	public $url;
	public $basename;

	private $admin;
	private $assets;
	private $general;
	private $quiz;

	private $updater;

	//Components

	function __construct() {
		if ( ! function_exists('is_plugin_active')){
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		$this->path = plugin_dir_path(TUTOR_PRO_FILE);
		$this->url = plugin_dir_url(TUTOR_PRO_FILE);
		$this->basename = plugin_basename(TUTOR_PRO_FILE);

		if ( is_plugin_active('tutor/tutor.php')){
			add_action('tutor_loaded', array($this, 'load_constructors_asset'));
		}else{
			spl_autoload_register(array($this, 'loader'));
			$this->admin = new Admin();
			$this->assets = new Assets();
		}
		$this->includes();

		//$this->load_constructors_asset();
	}


	public function load_constructors_asset(){
		/**
		 * Loading Autoloader
		 */

		spl_autoload_register(array($this, 'loader'));

		do_action('tutor_pro_before_load');
		//Load Component from Class
		$this->admin = new Admin();
		$this->assets = new Assets();
		$this->general = new General();
		$this->quiz = new Quiz();

		$this->course_duplicator = new Course_Duplicator();
		$this->instructor_percentage = new Instructor_Percentage();

		$this->updater = new Updater();
		$this->load_addons();

		do_action('tutor_pro_loaded');
	}

	/**
	 * @param $className
	 *
	 * Auto Load class and the files
	 */
	private function loader($className) {
		if ( ! class_exists($className)){
			$className = preg_replace(
				array('/([a-z])([A-Z])/', '/\\\/'),
				array('$1$2', DIRECTORY_SEPARATOR),
				$className
			);

			$className = str_replace('TUTOR_PRO'.DIRECTORY_SEPARATOR, 'classes'.DIRECTORY_SEPARATOR, $className);
			$file_name = $this->path.$className.'.php';

			if (file_exists($file_name) && is_readable( $file_name ) ) {
				require_once $file_name;
			}
		}
	}

	//Run the TUTOR right now
	public function run(){
		do_action('tutor_pro_before_run');

		register_activation_hook( TUTOR_PRO_FILE, array( $this, 'tutor_pro_activate' ) );

		do_action('tutor_pro_after_run');
	}

	/**
	 * Do some task during plugin activation
	 */
	public function tutor_pro_activate(){
		$version = get_option('tutor_pro_version');
		//Save Option
		if ( ! $version){
			update_option('tutor_pro_version', TUTOR_PRO_VERSION);
		}
	}


	public function includes(){
		include tutor_pro()->path.'includes/functions.php';
	}

	public function load_addons(){
		if ( ! $this->updater->is_valid){
			//return;
		}
		$addonsDir = array_filter(glob(tutor_pro()->path."addons".DIRECTORY_SEPARATOR."*"), 'is_dir');
		if (count($addonsDir) > 0) {
			foreach ($addonsDir as $key => $value) {
				$addon_dir_name = str_replace(dirname($value).DIRECTORY_SEPARATOR, '', $value);
				$file_name = tutor_pro()->path . 'addons'.DIRECTORY_SEPARATOR.$addon_dir_name.DIRECTORY_SEPARATOR.$addon_dir_name.'.php';
				if ( file_exists($file_name) ){
					include_once $file_name;
				}
			}
		}
	}

}