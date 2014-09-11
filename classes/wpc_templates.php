<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Templates
 * Manage Templates WpCourses
 *
 * @package WpCourses/Templates
 * @author Colde
 */

class WPC_Templates {

	/**
	 * Constructor
	 */
	public function __construct () {

		add_filter('template_include', array( $this, 'insert_templates'));
	}

	/**
	 * Insert templates of courses in theme.
	 *
	 * @return void
	 */

	public function insert_templates ( $template ) {

		global $post;

		// insert template of single course
		if ( $post->post_type == 'courses') {

			$course_template 	= array ( 'wpc_single-courses.php');
			$exists_in_theme 	= locate_template ( $course_template, false);

			if ( $exists_in_theme != '' ) {

				return $exists_in_theme;
			
			} else {

				return WPCOURSES_TEMPLATE_PATH . '/wpc_single-courses.php';
			}

		// insert template archive of category_course taxonomy
		} elseif ( is_tax ( 'category_course' )) {

			$cat_course_template = array ( 'wpc_archive-category_course.php', plugin_dir_path ( __FILE__ ) . 'templates/wpc_archive-category_course.php' );

			$exists_in_theme = locate_template ( $cat_course_template, false );

			if ( $exists_in_theme != '' ) {
				
				return $exists_in_theme;
			} else {

				return plugin_dir_path ( __FILE__ ) . 'templates/wpc_archive-category_course.php';
			}
		}


		return $template;

	}

}

new WPC_Templates();