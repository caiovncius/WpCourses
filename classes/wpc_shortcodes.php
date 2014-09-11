<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shortcodes
 * Create Shortcodes
 *
 * @package WpCourses/Shortcodes
 * @author Colde
 */

class WPC_Shortcodes {

	/**
	 * Constructor
	 */
	public function __construct () {

		add_shortcode('course_calendar', array( $this, 'course_calendar'));
		add_shortcode('all_courses_calendar', array( $this, 'all_courses_calendar'));
		add_shortcode('display_courses', array( $this, 'display_courses'));

		add_image_size( 'course-thumb', 300, 200, true );
		add_image_size( 'featured-img', 960, 310, true );
		
	}

	/**
	 * Calendar with all classes per course
	 *
	 * @param post_id
	 * @return void
	 */
	public function course_calendar ($atts) {

		global $post;

		extract(shortcode_atts(array(
				'course' 	=> '',
			), $atts
		));

		if(empty($course))
		{
			$course = $post->ID;
		}

		$classes= get_posts( array(
			'post_type'			=> 'classes', 
			'posts_per_page' 	=> -1,
			'meta_key' 			=> '_wpc_class_course_id',
			'meta_value' 		=> $course
			)
		);

		if ( count ($classes) < 1) {

			return __('No class scheduled yet.', 'wpcourses');
		}
		else {

			$output  = '<div class="wpc_calendar">';
			$output .= '<h2 class="title_calendar">' . __('Calendar of Course', 'wpcourses') . '</h2>';
			$output .= '<table class="wpc_calendar_table">';
			$output .= '<thead>';
			$output .= '<th width="100">';
			$output .= __('Month', 'wpcourses');
			$output .= '</th>';
			$output .= '<th width="210">';
			$output .= __('Period', 'wpcourses');
			$output .= '</th>';
			$output .= '<th width="140">';
			$output .= __('Shift', 'wpcourses');
			$output .= '</th>';
			$output .= '<th>';
			$output .= __('Days of Weeks', 'wpcourses');
			$output .= '</th>';
			$output .= '</tr>';
			$output .= '</thead>';
			$output .= '<body>';	

			foreach ($classes as $class) {	

				$meta_start_date 	= get_post_meta ($class->ID, '_wpc_class_start_date');
				$meta_end_date 		= get_post_meta ($class->ID, '_wpc_class_end_date');	

				$class_month = date('F', strtotime($meta_start_date[0]));	

				$meta_start_time 	= get_post_meta ($class->ID, '_wpc_class_time_start');
				$meta_end_time 		= get_post_meta ($class->ID, '_wpc_class_time_end');

				$meta_days_week 		= get_post_meta ($class->ID, '_wpc_class_course_days');

				$meta_class_more_info 	= get_post_meta ($class->ID, '_wpc_class_more_information');
				
				$output .= '<tr>';
				$output .= '<td>';
				$output .= '<b>' . $class_month . '</b>';
				$output .= '</td>';
				$output .= '<td>';
				$output .= '<b>' . $meta_start_date[0] . '</b> ' . __('to', 'wpcourses') . ' <b>' . $meta_end_date[0] . '</b>';
				$output .= '</td>';
				$output .= '<td>';
				$output .= '<b>' . $meta_start_time[0] . '</b> ' . __('to', 'wpcourses') . ' <b>' . $meta_end_time[0] . '<b>';
				$output .= '</td>';
				$output .= '<td>';

				if ( in_array (array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'), $meta_days_week)) {

					$output .= '<span class="wpc_day">' . __('All week', 'wpcourses') . '</span>';
				}
				elseif ( in_array (array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'), $meta_days_week)) {

					$output .= '<span class="wpc_day">' . __('Monday to Friday', 'wpcourses') . '</span>';
				}
				else {

					foreach ($meta_days_week[0] as $day) {

						$output .= '<span class="wpc_day">' . $day . '</span>, ';
					}
				}

				$output .= '</td>';
				$output .= '</tr>';

			}	

			$output .= '</body>';
			$output .= '</table>';
			$output .= '</div><!--- wpc-calendar -->'; // wpc_calendar	

			return $output;
		}
	}

	/**
	 * Calendar with all classes and all courses
	 *
	 * @return void
	 */
	public function all_courses_calendar ($atts) {

		global $post;

		$classes= get_posts( array(
			'post_type'			=> 'classes', 
			'posts_per_page' 	=> -1,
			)
		);

		if ( count ($classes) < 1) {

			return __('No class scheduled yet.', 'wpcourses');
		}
		else {

			$output  = '<div class="wpc_calendar">';
			$output .= '<h2 class="title_calendar">' . __('Next Classes', 'wpcourses') . '</h2>';
			$output .= '<table class="wpc_calendar_table">';
			$output .= '<thead>';
			$output .= '<tr>';
			$output .= '<th width="100">';
			$output .= __('Month', 'wpcourses');
			$output .= '</th>';
			$output .= '<th width="210">';
			$output .= __('Period', 'wpcourses');
			$output .= '</th>';
			$output .= '<th width="140">';
			$output .= __('Shift', 'wpcourses');
			$output .= '</th>';
			$output .= '<th>';
			$output .= __('Days of Weeks', 'wpcourses');
			$output .= '</th>';
			$output .= '</tr>';
			$output .= '</thead>';
			$output .= '<body>';	

			foreach ($classes as $class) {	

				$meta_start_date 	= get_post_meta ($class->ID, '_wpc_class_start_date');
				$meta_end_date 		= get_post_meta ($class->ID, '_wpc_class_end_date');	

				$class_month = date('F', strtotime($meta_start_date[0]));	

				$meta_start_time 	= get_post_meta ($class->ID, '_wpc_class_time_start');
				$meta_end_time 		= get_post_meta ($class->ID, '_wpc_class_time_end');

				$meta_days_week 		= get_post_meta ($class->ID, '_wpc_class_course_days');

				$meta_class_more_info 	= get_post_meta ($class->ID, '_wpc_class_more_information');
				
				$output .= '<tr>';
				$output .= '<td>';
				$output .= '<b>' . $class_month . '</b>';
				$output .= '</td>';
				$output .= '<td>';
				$output .= '<b>' . $meta_start_date[0] . '</b> ' . __('to', 'wpcourses') . ' <b>' . $meta_end_date[0] . '</b>';
				$output .= '</td>';
				$output .= '<td>';
				$output .= '<b>' . $meta_start_time[0] . '</b> ' . __('to', 'wpcourses') . ' <b>' . $meta_end_time[0] . '<b>';
				$output .= '</td>';
				$output .= '<td>';

				if ( in_array (array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'), $meta_days_week)) {

					$output .= '<span class="wpc_day">' . __('All week', 'wpcourses') . '</span>';
				}
				elseif ( in_array (array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'), $meta_days_week)) {

					$output .= '<span class="wpc_day">' . __('Monday to Friday', 'wpcourses') . '</span>';
				}
				else {

					foreach ($meta_days_week[0] as $day) {

						$output .= '<span class="wpc_day">' . $day . '</span>, ';
					}
				}

				$output .= '</td>';
				$output .= '</tr>';

			}	

			$output .= '</body>';
			$output .= '</table>';
			$output .= '</div><!--- wpc-calendar -->'; // wpc_calendar	

			return $output;
		}
	}

	/**
	 * List all courses to sale
	 *
	 * @return void
	 */
	public function display_courses ($atts) {

		extract(shortcode_atts(array(
				'show_enrol_button' => '',
				'show_price'		=> '',
				'featured' 			=> '',
			), $atts
		));

		$courses = get_posts( array(
				'post_type' => 'courses'
			)
		);

		$output = 	'<div class="wpc_list_courses">';

					if ($featured != '' ) {

						$featured = get_post($featured);

		$output .= 		'<div class="featured-course">' . 
							'<div class="featured-img">';
								if ( get_the_post_thumbnail ($featured->ID)) {

									$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $featured->ID ), 'featured-img' );

									$output .= 	'<a href="'. get_permalink( $featured->ID ) . '" alt="'. __('See more') . ' ' . $featured->post_title . '" title="'. __('See more') . ' ' . $featured->post_title . '">' .
												'<img src="' . $thumbnail[0] . '" alt="" title="" class="img-responsive"/>' .
												'</a>';
									}
									else {

										$output .= 	'<a href="'. get_permalink( $featured->ID ) . '" alt="'. __('See more') . ' ' . $featured->post_title . '" title="'. __('See more') . ' ' . $featured->post_title . '">' .
													'<img src="" alt="" title="" class="img-featured"/>' .
													'</a>';
									}

		$output .=			'</div><!--- featured-img -->' .
							'<div class="course_featured_content">' . 
								'<div class="course_featured_title">' . 

									'<a href="'. get_permalink( $featured->ID ) . '" alt="'. __('See more') . ' ' . $featured->post_title . '" title="'. __('See more') . ' ' . $featured->post_title . '">' .
										'<h2>' . $featured->post_title . '</h2>' . 
									'</a>' .

								'</div><!--- course_featured_title -->' .

								'<div class="course_featured_excerpt">' . 
									'<div class="the_course_excerpt">' . 
										$featured->post_content . 
									'</div><!--- the_course_excerpt -->' . 
										'<p>' .
											'<a href="'. get_permalink( $featured->ID ) . '" alt="'. __('See more') . ' ' . $featured->post_title . '" title="'. __('See more') . ' ' . $featured->post_title . '">' .
											__('See more', 'wpcourses') . 
											'</a>' .
										'</p>' .
								'</div><!--- course_featured_excerpt -->' .

							'</div><!--- featured-course -->' . 		
						'</div><!--- featured-course -->';
					
					}


		$output .=	'<div class="more_courses">';

						foreach ($courses as $course) {

		$output .= 			'<div class="course_list_item">' .
								'<div class="course_list_item_img">';
									if ( get_the_post_thumbnail ($course->ID)) {

									$output .= 	'<a href="'. get_permalink( $course->ID ) . '" alt="'. __('See more') . ' ' . $course->post_title . '" title="'. __('See more') . ' ' . $course->post_title . '">' .
												get_the_post_thumbnail ( $course->ID, 'course-thumb' ) .
												'</a>';
									}
									else {

										$output .= 	'<a href="'. get_permalink( $course->ID ) . '" alt="'. __('See more') . ' ' . $course->post_title . '" title="'. __('See more') . ' ' . $course->post_title . '">' .
													'<img src="" alt="" title="" class="img-featured"/>' .
													'</a>';
									}
		$output .=				'</div><!--- course_list_item_img -->' .
								'<div class="course_list_item_title">' .
									'<a href="'. get_permalink( $course->ID ) . '" alt="'. __('See more') . ' ' . $course->post_title . '" title="'. __('See more') . ' ' . $course->post_title . '">' .
										'<h4>' . $course->post_title . '</h4>' .
									'</a>' .
								'</div><!--- course_list_item_title -->' .
							'</div><!--- course_list_item -->';

						}

		$output .=		'</div><!--- more_courses -->' .
					'</div><!--- wpc_list_courses -->';

		return $output;
	}
}

new WPC_Shortcodes();