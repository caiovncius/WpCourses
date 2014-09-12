<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classes
 * Manipule classes
 *
 * @package WpCourses/Classes
 * @author Colde
 */

class WPC_Classes {

	/**
	 * Constructor
	 */
	public function __construct () {

		// change column class
		add_filter( 'manage_edit-classes_columns', array( $this, 'set_custom_edit_classes_columns' ));
		add_action( 'manage_classes_posts_custom_column', array( $this, 'custom_classes_column'), 10, 2 );

		add_filter( 'posts_join', array ( $this, 'search_post_meta' ));
		add_filter( 'posts_where', array ( $this, 'search_classes_where' ));
		add_filter( 'parse_query',  array ( $this, 'meta_filter_classes' ));
		add_action( 'restrict_manage_posts', array ( $this, 'filter_classes' ));	
	}

	/**
	 * Set news columns to list all classes
	 *
	 * @return void
	 */
	function set_custom_edit_classes_columns($columns) {

		unset( $columns['date'] );
    	
    	$columns['class_course'] 	= __( 'Course', 'wpcourses' );
    	$columns['period'] 		= __( 'Period', 'wpcpurses' );
    	$columns['shift'] 		= __( 'Shift', 'wpcpurses' );

    	return $columns;
	}

	/**
	 * define news columns to list all classes
	 *
	 * @return void
	 */
	function custom_classes_column( $column, $post_id ) {	

		global $post;	

		$course_id 	= get_post_meta ($post_id, '_wpc_class_course_id');
		$course 	= get_post ($course_id[0]);	

		$start_day 	= get_post_meta ($post->ID, '_wpc_class_start_date');
		$end_day 	= get_post_meta ($post->ID, '_wpc_class_end_date');	

		$start_time 	= get_post_meta ($post->ID, '_wpc_class_time_start');
		$end_time	 	= get_post_meta ($post->ID, '_wpc_class_time_end');	

		$days		= get_post_meta ($post->ID, '_wpc_class_course_days');	

	    switch ( $column ) {	

	        case 'class_course' :	

	        	echo $course->post_title;	

	        	break;
	       	case 'period':	

	       		echo '<b>' . $start_day[0] . '</b> ' . __('to', 'wpcourses') . ' <b>' . $end_day[0] . '</b>';	

	       		break;
	       	case 'shift' :	

	       		foreach ($days[0] as $day) {
	       			
	       			echo $day . ', ';
	       		}	

	       		echo ' ' . $start_time[0] . ' ' . __('to', 'wpcourses') . ' ' . $end_time[0];	

	       		break;	

	    }
	}

	/**
	 * Change columns of list all classes
	 */

	public function classes_columns ( $column ) {

		global $post;

		switch ( $column ) {
			case 'class_course' :

				return 'Teste';

			break;
		}
	}

	/**
	 * Add post meta of custom post types in search queries
	 *
	 * @return void
	 */	

	public function search_post_meta ($join){
		
		global $pagenow, $wpdb;	

		if ( is_admin() && $pagenow=='edit.php' && $_GET['post_type']=='classes' && $_GET['s'] != '') 
		{
			$join .='LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
		}
		return $join;
	}	

	/**
	 * Construct querie of classes
	 *
	 * @return void
	 */	

	public function search_classes_where ( $where ){
		
		global $pagenow, $wpdb;	

		if ( is_admin() && $pagenow=='edit.php' && !empty( $_GET['post_type'] )=='classes' && $_GET['s'] != '') {
			$where = preg_replace(
				"/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
				"(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
		}	

		return $where;
	}

	/**
	 * Parse query to search by GET
	 *
	 * @return void
	 */	

	function meta_filter_classes ( $query ) {	

		if( !is_admin())
			return $query;	

		if( isset($_GET['courseid'])) {
			
			if($_GET['post_type'] == 'classes')
			{
				$query->set( 'meta_key', '_wpc_class_course_id' );	
			}
			elseif($_GET['post_type'] == 'classes')
			{
				$query->set( 'meta_key', '_wpc_class_course_id' );
			}	

			$query->set( 'meta_value', $_GET['courseid'] );
		}
		
		return $query;
	}	

	/**
	 * Create field and queries to search enrols by course.
	 *
	 * @return void
	 */	

	function filter_classes () {
		global $typenow;	

		if($typenow == 'classes')
		{
			global $wpdb;
		    $sql = 'SELECT * FROM '.$wpdb->posts.' WHERE post_type="courses" AND post_status = "publish" ORDER BY 1 ' ;
		    $fields = $wpdb->get_results($sql, ARRAY_N);	

	?>
			<select name="courseid" id="wpcourses_course_id">
			<option value=""><?php echo __('Select One Course', 'wpcourses'); ?></option>
			<?php
			    $current = isset($_GET['courseid'])? $_GET['courseid']:'';
			    $current_v = isset($_GET['courseid'])? $_GET['courseid']:'';
			    foreach ($fields as $field) {
			        if (substr($field[0],0,1) != "_"){
			        printf
			            (
			                '<option value="%s"%s>%s</option>',
			                $field[0],
			                $field[0] == $current? ' selected="selected"':'',
			                $field[5]
			            );
			        }
			    }
			?>
			</select>
	<?php
		}
		elseif ($typenow == 'classes')
		{
			global $wpdb;
		    $sql = 'SELECT * FROM '.$wpdb->posts.' WHERE post_type="courses" AND post_status = "publish" ORDER BY 1 ' ;
		    $fields = $wpdb->get_results($sql, ARRAY_N);	

	?>
			<select name="courseid" id="wpcourses_course_id">
			<option value=""><?php echo __('Select One Course', 'wpcourses'); ?></option>
			<?php
			    $current = isset($_GET['courseid'])? $_GET['courseid']:'';
			    $current_v = isset($_GET['courseid'])? $_GET['courseid']:'';
			    foreach ($fields as $field) {
			        if (substr($field[0],0,1) != "_"){
			        printf
			            (
			                '<option value="%s"%s>%s</option>',
			                $field[0],
			                $field[0] == $current? ' selected="selected"':'',
			                $field[5]
			            );
			        }
			    }
			?>
			</select>
	<?php
		}
	}	
}

new  WPC_Classes();
