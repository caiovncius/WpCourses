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


/**
 * Get title for course
 * 
 * @param post_id
 * @return void
 */
function get_hours ($title = null, $description = null) {

	global $post;

	$hours = get_post_meta ($post->ID, '_wpc_course_hours');

	if (empty($description)) {
		$description = __('Hours', 'wpcourses');
	}

	if(!empty($title)) {

		echo  $title . ' ' . $hours[0] . ' ' . $description;	
	} else {

		echo  $hours[0] . ' ' . $description;	
	}		
}

/**
 * Get Requirements of course
 *
 * @param title string
 * @param post_id int
 * @return void
 */
function get_requirements ($title = null) {
	
	global $post;

	$requirements = get_post_meta ($post->ID, '_wpc_course_requirements');

	if (!empty($requirements)) {

		if(!empty($title)) {

			echo  $title . ' ' . $requirements[0];	
		} else {

			echo  $requirements[0];	
		}		
	}

}