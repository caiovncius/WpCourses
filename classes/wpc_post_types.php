<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post types 
 * Register post type and taxonomies to WpCourses
 *
 * @package WpCourses/Post types
 * @author Colde
 */

class WpCourses_Post_types {


	/**
	 * Construct Post types class
	 */
	public function __construct() {

		add_action('init', array(__CLASS__, 'register_post_types'), 5);
		add_action('init', array(__CLASS__, 'register_taxonomies'), 5);
	}

	/**
	 * Rester post types
	 */
	public static function register_post_types () {

		register_post_type ('courses', array(
				'labels' => array(
					'name'             	   => _x( 'Courses', 'post type general name'),
					'singular_name'        => _x( 'Courses', 'post type singular name'),
					'menu_name'            => _x( 'Courses', 'admin menu', 'wpcourses'),
					'name_admin_bar'       => _x( 'New Course', 'add new on admin bar', 'wpcourses'),
					'add_new'              => _x( 'New Course', 'courses' ),
					'add_new_item'         => __( 'New Course', 'courses', 'wpcourses'),
					'new_item'             => __( 'New Course', 'wpcourses' ),
					'edit_item'            => __( 'Edit Course', 'wpcourses'),
					'view_item'            => __( 'View Course', 'wpcourses'),
					'all_items'            => __( 'All Courses', 'wpcourses'  ),
					'search_items'         => __( 'Search Course', 'wpcourses'),
					'parent_item_colon'    =>'' ,
					'not_found'            => __( 'Courses not found.', 'wpcourses'),
					'not_found_in_trash'   => __( 'Courses not found in trash.', 'wpcourses' ),
				),
				'hierarchical'          => true,
				'description'           => 'WpCourses Courses',
				'supports'              => array(
								'title', 
								'editor', 
								'thumbnail'
							 ),
				'public'                => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'show_in_nav_menus'     => true,
				'publicly_queryable'    => true,
				'exclude_from_search'   => false,
				'has_archive'           => true,
				'query_var'         	=> true,
				'rewrite'	            => array( 'slug' => 'courses' ),
				'can_export'         	=> true,
				'rewrite'            	=> true,
				'menu_position' 	 	=> null,
				'capability_type'    	=> 'post'
			)
		);

		register_post_type ('classes', array(
				'labels' => array(
					'name'             	   => _x( 'Classes', 'post type general name'),
					'singular_name'        => _x( 'Classes', 'post type singular name'),
					'menu_name'            => _x( 'Classes', 'admin menu', 'wpcourses'),
					'name_admin_bar'       => _x( 'New Class', 'add new on admin bar', 'wpcourses'),
					'add_new'              => _x( 'New Class', 'courses' ),
					'add_new_item'         => __( 'New Class', 'courses', 'wpcourses'),
					'new_item'             => __( 'New Class', 'wpcourses' ),
					'edit_item'            => __( 'Edit Class', 'wpcourses'),
					'view_item'            => __( 'View Class', 'wpcourses'),
					'all_items'            => __( 'All Class', 'wpcourses'  ),
					'search_items'         => __( 'Search Class', 'wpcourses'),
					'parent_item_colon'    =>'' ,
					'not_found'            => __( 'Classes not found.', 'wpcourses'),
					'not_found_in_trash'   => __( 'Classes not found in trash.', 'wpcourses' ),
				),
				'hierarchical'          => true,
				'description'           => 'WpCourses Classes Courses',
				'supports'              => array(
								'title'
							 ),
				'public'                => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'show_in_nav_menus'     => true,
				'publicly_queryable'    => true,
				'exclude_from_search'   => false,
				'has_archive'           => true,
				'query_var'         	=> true,
				'rewrite'	            => array( 'slug' => 'classes' ),
				'can_export'         	=> true,
				'rewrite'            	=> true,
				'menu_position' 	 	=> null,
				'capability_type'    	=> 'post'
			)
		);

		register_post_type ('enrollment', array(
				'labels' => array(
					'name'             	   => _x( 'Enrollments', 'post type general name'),
					'singular_name'        => _x( 'Enrollments', 'post type singular name'),
					'menu_name'            => _x( 'Enrollments', 'admin menu', 'wpcourses'),
					'name_admin_bar'       => _x( 'New ', 'add new on admin bar', 'wpcourses'),
					'add_new'              => _x( 'New Enrollment', 'courses' ),
					'add_new_item'         => __( 'New Enrollment', 'courses', 'wpcourses'),
					'new_item'             => __( 'New Enrollment', 'wpcourses' ),
					'edit_item'            => __( 'Edit Enrollment', 'wpcourses'),
					'view_item'            => __( 'View Enrollment', 'wpcourses'),
					'all_items'            => __( 'All Enrollments', 'wpcourses'  ),
					'search_items'         => __( 'Search Enrollments', 'wpcourses'),
					'parent_item_colon'    =>'' ,
					'not_found'            => __( 'Enrollments not found.', 'wpcourses'),
					'not_found_in_trash'   => __( 'Enrollments not found in trash.', 'wpcourses' ),
				),
				'hierarchical'          => true,
				'description'           => 'WpCourses Enrollment Courses',
				'supports'              => array(
								'revision'				
							 ),
				'public'                => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'show_in_nav_menus'     => true,
				'publicly_queryable'    => true,
				'exclude_from_search'   => false,
				'has_archive'           => true,
				'query_var'         	=> true,
				'rewrite'	            => array( 'slug' => 'enrollment' ),
				'can_export'         	=> true,
				'rewrite'            	=> true,
				'menu_position' 	 	=> null,
				'capability_type'    	=> 'post'
			)
		);
	}

	public static function register_taxonomies () {

		register_taxonomy ('category_course', array(courses), array(
				'labels' => array(
					'name' 				=> _x('Courses Categories', 'wpcourses'),
					'singular_name'		=> _x('Courses Category', 'taxonomy singular name'),
					'search_items'		=> _x('Search Course Category', 'search category'),
					'all_items'			=> _x('All Courses Categories', 'All Categories'),
					'parent_item'		=> _x('Parent Course Category', 'parent category'),
					'parent-item_colon'	=> _x('Parent Course Category', 'parent category column'),
					'edit_item'			=> _x('Edit Course Category', 'Edit course category'),
					'update_item'		=> _x('Update Course Category', 'update course category'),
					'add_new_item'		=> _x('New Course Category', 'add new category'),
					'new_item_name'		=> _x('New Course Category', 'new course category'),
					'menu_name'			=> _x('Course Categories', 'courses categories'),
				),
				'hierarchical'		=> true,
				'menu_position' 	=> false,	
				'show_ui'			=> true,
				'show_admin_column'	=> true,
				'query_var'			=> true,
				'rewrite'			=> array(
								'slug' => 'category_course'
							),
				'rewrite' 			=> true
			)
		);
	}
}

new WpCourses_Post_types();