<?php 
/**
 * Plugin Name: WpCourses
 * Plugin URI: http://colde.com.br/wpcourses
 * Description: WpCourses it's a solution for Online schools and training centers, for show, and sale yours courses. Buy a pro version with this all features and <a href="http://codecanyon.net/item/wpcourses-pro/9170404" target="_blank">3 more</a>.
 * Version: 1.2.3
 * Text Domain: wpcourses
 * Author: Colde Codong <colde@colde.com.br>
 * Author URI: http://colde.com.br
 * License: GPLv2 or later
 * 
 * @package WpCourses
 * @author Colde Coding
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WpCourses {	

	/**
	 * WpCourses Constructor
	 * 
	 * @access public
	 * @return WpCourses
	 */
	public function __construct () {

		// Enable global variable to settings WpCourses
		global $wpcourses;

		// Initialize function in Wordpress
		$this->load_textdomain();
		$this->includes();
		$this->define_constants();
		
		// filters
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array ( $this, 'action_links' ) );
		add_filter( 'post_thumbnail_html'. plugin_basename( __FILE__ ), array ( $this, 'remove_thumbnail_dimensions', 10, 3 ));
		add_filter( 'image_send_to_editor'. plugin_basename( __FILE__ ), array ( $this, 'remove_thumbnail_dimensions', 10 ));

	}

	/**
	 * Define all constants
	 */
	public function define_constants () {

		define('WPCOURSES_PATH', plugin_dir_path(__FILE__));
		define('WPCOURSES_TEMPLATE_PATH', plugin_dir_path(__FILE__) . 'templates');
	}

	/**
	 * Show action links on the plugin screen.
	 *
	 * @return array
	 */
	public function action_links( $links ) {
		return array_merge( array(
			'<a href="http://colde.com.br/wpcourses">' . __( 'Buy Pro Version', 'wpcourses' ) . '</a>',
			'<a href="http://colde.com.br/wpcourses">' . __( 'Get Pro Support and License', 'wpcourses' ) . '</a>',
		), $links );
	}	
	

	/**
	 * Include all classes to WpCourse
	 *
	 * @return void
	 */
	public function includes () {
			
		// Include classes
		include_once('classes/wpc_post_types.php');
		include_once('classes/wpc_scripts.php');
		include_once('classes/wpc_meta_boxes.php');
		include_once('classes/wpc_classes.php');
		include_once('classes/wpc_shortcodes.php');
		include_once('classes/wpc_templates.php');
		include_once('classes/wpc_woocommerce.php');

		// Include functions hooks
		include_once('classes/wpc_content.php');
	}	

	/**
	 * Load textdomain
	 *
	 */
	public function load_textdomain () {	

		$locale = apply_filters( 'plugin_locale', get_locale(), 'wpcourses' );	

		load_textdomain( 'wpcourses', false,  plugin_basename( dirname( __FILE__ ) ) . "/i18n/languages" );
	}


	/**
	 * Remove dimensions atribute do post thumbnails. 
	 */
	function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
	    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
	    return $html;
	}

}

new WpCourses();




