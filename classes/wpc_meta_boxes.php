<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Meta boxes
 * Add meta box in post types WpCourses
 *
 * @package WpCourses/Scripts
 * @author Colde
 */

class WPC_Meta_boxes {


	/**
	 * Construct
	 */
	public function __construct () {

		// Add Meta box in Courses
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ));
		add_action('save_post', array( $this, 'after_save_course'));
		add_action('save_post', array( $this, 'after_save_classes'));
	}

	/**
	 * Add Meta boxes Wordpress hook
	 */
	public function add_meta_boxes () {

		// Meta box to confog sync course
		add_meta_box( 'wpc_courses_config_meta_box' , __('More Settings of this course', 'wpcourses'), array($this, 'course_meta_box_sync'), 'courses', 'normal', 'core');

		// Add meta box to configure classes
		add_meta_box( 'wpc_classes_config_meta_box' , __('Class Settings', 'wpcourses'), array($this, 'classes_meta_box_sync'), 'classes', 'normal', 'core');

	}

	/**
	 * Courses meta box to config sync in Moodle and Sale the course in Woocommerce
	 */
	public function course_meta_box_sync () {

		// load settings
		global $wpcourses;

		// load global data post
		global $post;

		$meta_wpc_course_hours 				= get_post_meta($post->ID, '_wpc_course_hours');
		$meta_wpc_course_requirements 		= get_post_meta($post->ID, '_wpc_course_requirements');

?>
		<div id="wpc_course_tabs">
			<div class="wpc_menu_tabs">
				<ul class="wpc_tabs">
					<li class="active"><a href="#wpctab1"><?php echo __('More information', 'wpcourses'); ?></a></li>
        		</ul>
			</div><!--- wpc_menu_tabs -->
			<div class="wpc_the_tabs">
				<div id="wpctab1">
					<div class="form-line">
					 	<div class="form-label">
					 		<label for="_wpc_course_hours">
					 			<?php echo __('Hours', 'wpcourses'); ?>
					 		</label>
					 	</div><!--- form-label -->
					 	<div class="form-field">
					 		<input type="text" name="_wpc_course_hours"  id="_wpc_course_hours" value="<?php echo $meta_wpc_course_hours[0]; ?>"/>
					 	</div><!--- form-field -->
					 </div><!--- form-line -->

					 <div class="form-line">
					 	<div class="form-label">
					 		<label for="_wpc_course_requirements">
					 			<?php echo __('Requirements', 'wpcourses'); ?>
					 		</label>
					 	</div><!--- form-label -->
					 	<div class="form-field">
					 	<textarea name="_wpc_course_requirements" id="_wpc_course_requirements" cols="40" rows="3"><?php echo $meta_wpc_course_requirements[0]; ?></textarea>
					 	</div><!--- form-field -->
					 </div><!--- form-line -->
				</div><!--- wpctbs1 -->				

			</div><!--- wpc_the_tabs -->

		</div><!--- course_tabs -->
<?php
	}

	/**
	 * Save Meta values to meta posts 
	 */

	public function after_save_course ($post_id) {

		global $post;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if(isset($_POST['_wpc_course_hours']))
			update_post_meta($post_id, '_wpc_course_hours', $_POST['_wpc_course_hours']);

		if(isset($_POST['_wpc_course_requirements']))
			update_post_meta($post_id, '_wpc_course_requirements', $_POST['_wpc_course_requirements']);

	}

	/**
	 * Meta box to settings classes
	 *
	 * @return void
	 */
	public function classes_meta_box_sync () {

		global $post;

		$list_courses = get_posts(array('post_type' => 'courses', 'posts_per_page' => -1));

		// get values to meta posts fo class

		$meta_wpc_class_course_id 			= get_post_meta($post->ID, '_wpc_class_course_id');
		$meta_wpc_class_start_date 			= get_post_meta($post->ID, '_wpc_class_start_date');
		$meta_wpc_class_end_date 			= get_post_meta($post->ID, '_wpc_class_end_date');
		$meta_wpc_class_course_days 		= get_post_meta($post->ID, '_wpc_class_course_days');
		$meta_wpc_class_time_start 			= get_post_meta($post->ID, '_wpc_class_time_start');
		$meta_wpc_class_time_end 			= get_post_meta($post->ID, '_wpc_class_time_end');
		$meta_wpc_class_more_information	= get_post_meta($post->ID, '_wpc_class_more_information');

?>
	<div id="wpc_settings">
		<div class="wpc_the_settings">
			<div class="form-line">
				<div class="form-label">
					<label for="_wpc_class_course_id">
						<?php echo __('Select course', 'wpcourses');?>
					</label>
				</div><!--- form-label -->
				<div class="form_field">
					<div id="wpc_select">
						<select name="_wpc_class_course_id" id="wpc_class_course_id">
							<option><?php echo __('Select on course', 'wpcourses'); ?></option>

							<?php foreach ($list_courses as $course ) : ?>
								<option value="<?php echo $course->ID; ?>" <?php if ( $meta_wpc_class_course_id[0] == $course->ID) echo 'selected="selected"'; ?>><?php echo $course->post_title; ?></option>
							<?php endforeach;?>
						</select>
					</div><!--- wpc_select -->
				</div><!--- form-field -->
			</div><!--- form-line -->

			<div class="form-line">
				<div class="form-label">
					<label for="_wpc_class_start_date">
						<?php echo __('Start Date', 'wpcourses');?>
					</label>
				</div><!--- form-label -->
				<div class="form_field">
					<input type="text" name="_wpc_class_start_date" class="wpc_start_datepicker" value="<?php echo $meta_wpc_class_start_date[0]; ?>"/>
				</div><!--- form-field -->
			</div><!--- form-line -->

			<div class="form-line">
				<div class="form-label">
					<label for="_wpc_class_end_date">
						<?php echo __('End Date', 'wpcourses');?>
					</label>
				</div><!--- form-label -->
				<div class="form_field">
					<input type="text" name="_wpc_class_end_date" class="wpc_start_datepicker" value="<?php echo $meta_wpc_class_end_date[0]; ?>"/>
				</div><!--- form-field -->
			</div><!--- form-line -->

			<div class="form-line">
				<div class="form-label">
					<label for="_wpc_class_course_days">
						<?php echo __('Day if Week', 'wpcourses');?>
					</label>
				</div><!--- form-label -->
				<div class="form_field">
					<div id="wpc_select">							
						<input type="checkbox" value="Sunday" name="_wpc_class_course_days[]" <?php if(!empty($meta_wpc_class_course_days)) echo (in_array('Sunday', $meta_wpc_class_course_days[0])) ? 'checked="checked"' : ''; ?> /> <?php echo __('Sunday', 'wpcourses'); ?> 
						<input type="checkbox" value="Monday" name="_wpc_class_course_days[]" <?php if(!empty($meta_wpc_class_course_days)) echo (in_array('Monday', $meta_wpc_class_course_days[0])) ? 'checked="checked"' : ''; ?> /> <?php echo __('Monday', 'wpcourses'); ?> 
						<input type="checkbox" value="Tuesday" name="_wpc_class_course_days[]" <?php if(!empty($meta_wpc_class_course_days)) echo (in_array('Tuesday', $meta_wpc_class_course_days[0])) ? 'checked="checked"' : ''; ?> /> <?php echo __('Tuesday', 'wpcourses'); ?> 
						<input type="checkbox" value="Wednesday" name="_wpc_class_course_days[]" <?php if(!empty($meta_wpc_class_course_days)) echo (in_array('Wednesday', $meta_wpc_class_course_days[0])) ? 'checked="checked"' : ''; ?>/> <?php echo __('Wednesday', 'wpcourses'); ?> 
						<input type="checkbox" value="Thursday" name="_wpc_class_course_days[]" <?php if(!empty($meta_wpc_class_course_days)) echo (in_array('Thursday', $meta_wpc_class_course_days[0])) ? 'checked="checked"' : ''; ?> /> <?php echo __('Thursday', 'wpcourses'); ?> 
						<input type="checkbox" value="Friday" name="_wpc_class_course_days[]" <?php if(!empty($meta_wpc_class_course_days)) echo (in_array('Friday', $meta_wpc_class_course_days[0])) ? 'checked="checked"' : ''; ?>/> <?php echo __('Friday', 'wpcourses'); ?> 
						<input type="checkbox" value="Saturday" name="_wpc_class_course_days[]" <?php if(!empty($meta_wpc_class_course_days)) echo (in_array('Saturday', $meta_wpc_class_course_days[0])) ? 'checked="checked"' : ''; ?>/> <?php echo __('Saturday', 'wpcourses'); ?> 
					</div><!--- wpc_select -->
				</div><!--- form-field -->
			</div><!--- form-line -->

			<div class="form-line">
				<div class="form-label">
					<label for="_wpc_class_time_start">
						<?php echo __('Time start', 'wpcourses');?>
					</label>
				</div><!--- form-label -->
				<div class="form_field">
					<input type="text" name="_wpc_class_time_start" value="<?php echo $meta_wpc_class_time_start[0]; ?>" />
				</div><!--- form-field -->
			</div><!--- form-line -->

			<div class="form-line">
				<div class="form-label">
					<label for="_wpc_class_time_end">
						<?php echo __('Time end', 'wpcourses');?>
					</label>
				</div><!--- form-label -->
				<div class="form_field">
					<input type="text" name="_wpc_class_time_end" value="<?php echo $meta_wpc_class_time_end[0]; ?>" />
				</div><!--- form-field -->
			</div><!--- form-line -->

			<div class="form-line">
				<div class="form-label">
					<label for="_wpc_class_more_information">
						<?php echo __('More information', 'wpcourses');?>
					</label>
				</div><!--- form-label -->
				<div class="form_field">
					<textarea name="_wpc_class_more_information" id="" cols="68" rows="5"><?php echo $meta_wpc_class_more_information[0]; ?></textarea>
				</div><!--- form-field -->
			</div><!--- form-line -->

		</div><!--- wpc_the_settings -->
	</div><!--- wpc_course_tabs -->

<?php
	}

	/**
	 * Save Meta values to meta posts 
	 */

	public function after_save_classes ($post_id) {

		global $post;

		global $wpcourses;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if(isset($_POST['_wpc_class_course_id']))
			update_post_meta($post_id, '_wpc_class_course_id', $_POST['_wpc_class_course_id']);

		if(isset($_POST['_wpc_class_start_date']))
			update_post_meta($post_id, '_wpc_class_start_date', $_POST['_wpc_class_start_date']);

		if(isset($_POST['_wpc_class_end_date']))
			update_post_meta($post_id, '_wpc_class_end_date', $_POST['_wpc_class_end_date']);

		if(isset($_POST['_wpc_class_course_days']))
			update_post_meta($post_id, '_wpc_class_course_days', $_POST['_wpc_class_course_days']);

		if(isset($_POST['_wpc_class_time_start']))
			update_post_meta($post_id, '_wpc_class_time_start', $_POST['_wpc_class_time_start']);

		if(isset($_POST['_wpc_class_time_end']))
			update_post_meta($post_id, '_wpc_class_time_end', $_POST['_wpc_class_time_end']);

		if(isset($_POST['_wpc_class_more_information']))
			update_post_meta($post_id, '_wpc_class_more_information', $_POST['_wpc_class_more_information']);
	}
}

new WPC_Meta_boxes();