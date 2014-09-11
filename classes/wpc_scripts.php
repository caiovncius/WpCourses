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

		add_action('init', array( $this, 'add_header_scripts'), 5);
		add_action( 'admin_footer', array( $this, 'add_footer_scripts' ), 5);
	}

	/**
	 * Add embed js and css files do wp_heade admin
	 *
	 * @return void
	 */

	public function add_header_scripts () {

		// Add tab script to used in metabox admin
		if ( is_admin() ) {
			wp_enqueue_script( 'mytabs', plugins_url('/') . 'wpcourses/assets/js/mytabs.js', array( 'jquery-ui-tabs' ) );
			wp_enqueue_script( 'bootstrap_datepicker', plugins_url('/') . 'wpcourses/assets/js/bootstrap-datepicker.js' );
			wp_enqueue_script( 'select2', plugins_url('/') . 'wpcourses/assets/js/select2.js' );
			
			wp_register_style( 'get_bootstrapp_datepicker', plugins_url('/') . 'wpcourses/assets/css/datepicker3.css', false, '1.0.0' );
			wp_register_style( 'select2', plugins_url('/') . 'wpcourses/assets/css/select2.css', false, '1.0.0' );
			wp_enqueue_style( 'get_bootstrapp_datepicker' );
			wp_enqueue_style( 'select2' );
			wp_enqueue_style( 'mytabs', plugins_url('/') . 'wpcourses/assets/css/mytabs.css');
		}

		wp_enqueue_style( 'wpcourses', plugins_url('/') . 'wpcourses/assets/css/wpcourses.css');
		
	}

	public function add_footer_scripts () {
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

			// add datepicker to dates fields
			jQuery('.wpc_start_datepicker').datepicker({
    			format: "yyyy-mm-dd",
    			todayBtn: "linked",
    			language: "pt-BR",
    			multidate: false,
    			autoclose: true,
    			todayHighlight: true
			});
			// add select2 plugin to select fields
			jQuery("#wpc_class_course_id").select2({
				placeholder: '<?php echo __('Select Course', 'woordle'); ?>'
			});

			jQuery("#wpc_class_course_days").select2({
				placeholder: '<?php echo __('Select days of Week', 'woordle'); ?>'
			});
		</script>
<?php
	}
}

$scripts = new WpCourses_Scripts();