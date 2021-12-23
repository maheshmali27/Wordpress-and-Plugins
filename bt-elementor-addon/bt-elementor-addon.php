<?php
/*
* Plugin Name: BT Addon for Elementor
* Plugin URI: http://gadgetguruji.in/
* Version: 1.0.0
* Author: Mahesh
* Description: Powerful ACF and Elementor intigration plungin.
* Text Domain: btea
*/

if ( ! defined( 'ABSPATH' ) ) exit();

final class Acf_Extended {

    // Plugin version
    const VERSION = '1.0.0';

    // Minimum Elementor Version
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    // Minimum PHP Version
    const MINIMUM_PHP_VERSION = '7.0';

	private static $_instance = null;

	/**
    * SIngletone Instance Method
    * @since 1.0.0
    */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/** 
	* Construct Method
	* We add Everything to this to start constructor
	* @since 1.0.0
	*/
	public function __construct() {
		
		/** Adding Defined Constant */
		$this->define_constants();

		/* Adding init function to plugin loded action */
		add_action( 'plugins_loaded', [ $this, 'init' ]);

		/* Adding Styles and Scripts */
		add_action( 'wp_enqueue_scripts', [ $this, 'link_styles' ] );

	}

	/**
    * Define Plugin Constants
    * @since 1.0.0
    */
    public function define_constants() {

		/** To Assign Plugin Directory or Relative Path */
        define( 'BTEA_PLUGIN_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );

		/** Absolute Path */
        define( 'BTEA_PLUGIN_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );

    }

	/**
	* Register Styles and Scripts
	*/
	public function link_styles(){
		wp_register_style( 'btea-styles', BTEA_PLUGIN_URL . 'assets/source/css/style.css', [], rand(), 'all' );
		
		wp_enqueue_style( 'btea-styles' );
	}

	/**
	* Initialize the plugin
	* This is added in __construct function where it loads after plugin is loaded
	* @since 1.0.0
	*/
	public function init() {

		/** 
		 * Adding TextDomain Loader here so it will load after plugin loaded 
		*/
		$this->i18n();

		/**
		* Checking Plugin Requirements
		*/
		$this->plugin_requirements();

		/**
		* Adding category to init hook
		* @since 1.0.0
		* We can also add action to this --->
		* add_action( 'elementor/elements/categories_registered', 'add_elementor_widget_categories' );
		* in this we need to pass veriable '$elements_manager' then apply 'add_category()' method on it
		* which accepts two parameters ('category_slug, array[]') array has two parameters title and icon
		* [ 'title' => __( 'First Category', 'plugin-name' ),'icon' => 'fa fa-plug',]
		*/
		add_action('elementor/init', [ $this, 'init_category' ] );

		/**
		* Adding category to init hook
		* @since 1.0.0
		*/
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

	}

	/**
    * Load Text Domain added in init();
    * @since 1.0.0
    */
	public function i18n() {

		load_plugin_textdomain( 'btea', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

	}
	/**
    * Init Category Section
    * Creating a New Category for Widgets
    * @since 1.0.0
	*/
    public function init_category() {
		Elementor\Plugin::instance()->elements_manager->add_category(
            'btea-category',
            [
                'title' => __('BT Elements', 'btea')
            ],
            1
        );       
    }

	/**
    * Init Widgets
	* All Widgets list goes here.
    * @since 1.0.0
    */
	public function init_widgets() {

		require_once BTEA_PLUGIN_PATH . '/widgets/btea-flexible-widget.php';
		
		require_once BTEA_PLUGIN_PATH . '/widgets/btea-nested-flexible-widget.php';

    }


	/**
	* Plugin Reqirements Function added in init();
	*/
	public function plugin_requirements() {

		// Calling function for the ELementor installed and activated
		if( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
				return;
		}

		// Calling function for elementor minimum version is installed
		if( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Calling function for elementor minimum version is installed
		if( ! version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}
	} 

	/**
	* Admin Notice Functions
	* Warning when the site doesn't have installed Elementor Plugin.
	* Warning when the site doesn't have a minimum required Elementor version.
	* Warning when the site doesn't have a minimum required PHP version.
	* @since 1.0.0
	*/
	
	// Warning when the site doesn't have installed Elementor Plugin.
	public function admin_notice_missing_main_plugin() {
		if( isset( $_GET[ 'activate' ] ) ) unset( $_GET[ 'activate' ] );
		$message = sprintf(
		esc_html__( '"%1$s" requires "%2$s" to be installed and activated', 'btea' ),
			'<strong>'.esc_html__( 'ACF Extended', 'btea' ).'</strong>',
			'<strong>'.esc_html__( 'Elementor', 'acf-extendd' ).'</strong>'
		);

        printf( '<div class="notice notice-warning is-dimissible"><p>%1$s</p></div>', $message );
	}

	// Warning when the site doesn't have a minimum required Elementor version.
	public function admin_notice_minimum_elementor_version() {
        if( isset( $_GET[ 'activate' ] ) ) unset( $_GET[ 'activate' ] );
        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater', 'btea' ),
            '<strong>'.esc_html__( 'ACF Extended', 'btea' ).'</strong>',
            '<strong>'.esc_html__( 'Elementor', 'btea' ).'</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf( '<div class="notice notice-warning is-dimissible"><p>%1$s</p></div>', $message );
    }

	// Warning when the site doesn't have a minimum required PHP version.
	public function admin_notice_minimum_php_version() {
        if( isset( $_GET[ 'activate' ] ) ) unset( $_GET[ 'activate' ] );
        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater', 'btea' ),
            '<strong>'.esc_html__( 'My Elementor Widget', 'btea' ).'</strong>',
            '<strong>'.esc_html__( 'PHP', 'btea' ).'</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf( '<div class="notice notice-warning is-dimissible"><p>%1$s</p></div>', $message );
    }

}
Acf_Extended::instance();

?>