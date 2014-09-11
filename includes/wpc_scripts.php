<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Scripts
 * Add Scripts in Admin and front end theme
 *
 * @package WpCourses/Scripts
 * @author Colde
 */

class WpCourses_Scripts {

	/**
	 * Constructor
	 */
	public function __construct () {

		add_action('init', array(__CLASS__, 'WPC_add_header_scripts'), 5);
		add_action( 'admin_footer', array(__CLASS__, 'WPC_add_footer_scripts' ), 5);
	}

	/**
	 * Add embed js and css files do wp_heade admin
	 *
	 * @return void
	 */

	public function WPC_add_header_scripts () {

		// Add tab script to used in metabox admin
		wp_enqueue_script( 'mytabs', plugins_url('/') . 'wpcourses/assets/js/mytabs.js', array( 'jquery-ui-tabs' ) );
		wp_enqueue_script( 'bootstrap_datepicker', plugins_url('/') . 'wpcourses/assets/js/bootstrap-datepicker.js' );
		wp_enqueue_script( 'select2', plugins_url('/') . 'wpcourses/assets/js/select2.js' );
		
		wp_register_style( 'get_bootstrapp_datepicker', plugins_url('/') . 'wpcourses/assets/css/datepicker3.css', false, '1.0.0' );
		wp_register_style( 'select2', plugins_url('/') . 'wpcourses/assets/css/select2.css', false, '1.0.0' );
		wp_enqueue_style( 'get_bootstrapp_datepicker' );
		wp_enqueue_style( 'select2' );
		wp_enqueue_style( 'mytabs', plugins_url('/') . 'wpcourses/assets/css/mytabs.css');
	}

	public function WPC_add_footer_scripts () {
?>
		<script type="text/javascript">

			// show woocommerce settings
			jQuery("#wpc_enable_sale_woocommerce").on('change', function(){	

				if (jQuery("#wpc_enable_sale_woocommerce:checked")) {	

					jQuery("#wpc_show_settings_woocommerce").toggle("fast");
				}
				else {	

					jQuery("#wpc_show_settings_woocommerce").toggle("fast");
				}
			});

			// show moodle settings
			jQuery("#wpc_enable_course_moodle").on('change', function(){	

				if (jQuery("#wpc_enable_course_moodle:checked")) {	

					jQuery("#wpc_show_settings_moodle").toggle("fast");
				}
				else {	

					jQuery("#wpc_show_settings_moodle").toggle("fast");
				}
			});

			jQuery('.wpc_start_datepicker').datepicker({
    			format: "dd-mm-yyyy",
    			todayBtn: "linked",
    			language: "pt-BR",
    			multidate: false,
    			autoclose: true,
    			todayHighlight: true
			});
		</script>
<?php
	}
}

$scripts = new WpCourses_Scripts();