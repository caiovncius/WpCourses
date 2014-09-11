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
		add_action( 'add_meta_boxes', array( $this, 'WPC_add_meta_boxes' ));
		add_action('save_post', array( $this, 'WPC_after_save_course'));
	}

	/**
	 * Add Meta boxes Wordpress hook
	 */
	public function WPC_add_meta_boxes () {

		// Meta box to confog sync course
		add_meta_box( 'wpc_courses_config_meta_box' , __('Configure this course', 'wpcourses'), array($this, 'WPC_course_meta_box_sync'), 'courses', 'normal', 'core');
	}

	/**
	 * Courses meta box to config sync in Moodle and Sale the course in Woocommerce
	 */
	public function WPC_course_meta_box_sync () {

		// load settings
		global $wpcourses;

		// load global data post
		global $post;

		// get meta posts this course
		$meta_wpc_enable_sale_woocommerce 	= get_post_meta($post->ID, '_wpc_enable_sale_woocommerce');
		$meta_wpc_course_shop_sku 			= get_post_meta($post->ID, '_wpc_course_shop_sku');
		$meta_wpc_course_shop_price 		= get_post_meta($post->ID, '_wpc_course_shop_price');
		$meta_wpc_enable_course_moodle 		= get_post_meta($post->ID, '_wpc_enable_course_moodle');
		$meta_wpc_moodle_summary 			= get_post_meta($post->ID, '_wpc_moodle_summary');
		$meta_wpc_moodle_start_date			= get_post_meta($post->ID, '_wpc_moodle_start_date');
		$meta_wpc_moodle_format 			= get_post_meta($post->ID, '_wpc_moodle_format');
		$meta_wpc_moodle_summary 			= get_post_meta($post->ID, '_wpc_moodle_summary');
		$meta_wpc_moodle_number_topics 		= get_post_meta($post->ID, '_wpc_moodle_number_topics');
		$meta_wpc_moodle_type_topics		= get_post_meta($post->ID, '_wpc_moodle_type_topics');

?>
		<div id="wpc_course_tabs">
			<div class="wpc_menu_tabs">
				<ul class="wpc_tabs">
					<?php if ($wpcourses['wpcourses_enable_woocommerce'] == 1) : ?>
            		<li class="active"><a href="#wpctab1"><?php echo __('Sale this course', 'wpcourses'); ?></a></li>
            		<?php endif; ?>
            		<?php if ($wpcourses['wpcourses_enable_moodle'] == 1) : ?>
            		<li><a href="#wpctab2"><?php echo __('Moodle Settings', 'wpcourses'); ?></a></li>
            		<?php endif; ?>
        		</ul>
			</div><!--- wpc_menu_tabs -->
			<div class="wpc_the_tabs">
				<?php if ($wpcourses['wpcourses_enable_woocommerce'] == 1) : ?>
				<div id="wpctab1">

					 <div class="form-line">
					 	<div class="form-label">
					 		<label for="_wpc_enable_sale_course">
					 			<?php echo __('Sale this Course with Woocommerce', 'wpcourses'); ?>
					 		</label>
					 	</div><!--- form-label -->
					 	<div class="form-field">
					 		<input type="checkbox" name="_wpc_enable_sale_woocommerce"  id="wpc_enable_sale_woocommerce" <?php if ( $meta_wpc_enable_sale_woocommerce[0] == 'on' ) echo 'checked'; ?>/>
					 	</div><!--- form-field -->
					 </div><!--- form-line -->

					 <div id="wpc_show_settings_woocommerce" style="display:none;">
					 	<div class="form-line">
					 		<div class="form-label">
					 			<label for="_wpc_enable_sale_course">
					 				<?php echo __('SKU', 'wpcourses'); ?>
					 			</label>
					 		</div><!--- form-label -->
					 		<div class="form-field">
						 		<input type="text" name="_wpc_course_shop_sku" value="<?php echo $meta_wpc_course_shop_sku[0]; ?>"/>
						 	</div><!--- form-field -->
						 </div><!--- form-line -->

						 <div class="form-line">
					 		<div class="form-label">
					 			<label for="_wpc_enable_sale_course">
					 				<?php echo __('Price', 'wpcourses'); ?>
					 			</label>
					 		</div><!--- form-label -->
					 		<div class="form-field">
						 		<input type="text" name="_wpc_course_shop_price" value="<?php echo $meta_wpc_course_shop_price[0]; ?>"/>
						 	</div><!--- form-field -->
						 </div><!--- form-line -->
					 </div><!--- wpc_show_settings_woocommerce -->

				</div><!--- wpctab1 -->
				<?php endif; ?>

				<?php if ($wpcourses['wpcourses_enable_moodle'] == 1) : ?>
				<div id="wpctab2">
					<div class="form-line">
					 	<div class="form-label">
					 		<label for="_wpc_enable_sale_course">
					 			<?php echo __('Enable this course in Moodle', 'wpcourses'); ?>
					 		</label>
					 	</div><!--- form-label -->
					 	<div class="form-field">
					 		<input type="checkbox" name="_wpc_enable_course_moodle"  id="wpc_enable_course_moodle" <?php if ( $meta_wpc_enable_course_moodle[0] == 'on' ) echo 'checked'; ?>/>
					 	</div><!--- form-field -->
					 </div><!--- form-line -->

					 <div id="wpc_show_settings_moodle" style="display:none;">
						 <div class="form-line">
						 	<div class="form-label">
						 		<label for="_wpc_moodle_summary">
						 			<?php echo __('Sumary', 'wpcourses'); ?>
						 			<br>
						 		</label>
						 	</div><!--- form-label -->
						 	<div class="form-field">
								<?php  
									$argumentsEditor = array(
										'wpautop' 			=> true,
										'textarea_rows'		=> 15,
										'textarea_name' 	=> '_wpc_moodle_summary',
										'drag_drop_upload' 	=> true,	

									);

									$content_id = $meta_wpc_moodle_summary[0];

									wp_editor($meta_wpc_moodle_summary[0], 'wpc_moodle_summary', $argumentsEditor);
								?>
							</div><!--- form-field -->
						 </div><!--- form-line -->
						 <div class="form-line">
						 	<div class="form-label">
						 		<label for="_wpc_moodle_start_date">
						 			<?php echo __('Date Start', 'wpcourses'); ?>
						 			<br>
						 		</label>
						 	</div><!--- form-label -->
						 	<div class="form-field">
						 		<input type="text" name="_wpc_moodle_start_date" class="wpc_start_datepicker" value="<?php echo $meta_wpc_moodle_start_date[0];?>" />
						 	</div><!--- form-field -->
						 </div><!--- form-line -->	

						 <div class="form-line">
						 	<div class="form-label">
						 		<label for="_wpc_moodle_format">
						 			<?php echo __('Format Settings', 'wpcourses'); ?>
						 			<br>
						 		</label>
						 	</div><!--- form-label -->
						 	<div class="form-field">
						 		<select name="_wpc_moodle_format" id="">
						 			<option value="scorm" <?php if($meta_wpc_moodle_format[0] == 'scorm') echo 'selected="selected"'; ?> > <?php echo  __('SCORM', 'wpcourses');?></option>
									<option value="social" <?php if($meta_wpc_moodle_format[0] == 'social') echo 'selected="selected"'; ?> > <?php echo __('Social', 'wpcourses');?> </option>
									<option value="topics" <?php if($meta_wpc_moodle_format[0] == 'topics') echo 'selected="selected"'; ?> > <?php echo __('Topics', 'wpcourses');?></option>
									<option value="weeks" <?php if($meta_wpc_moodle_format[0] == 'weeks') echo 'selected="selected"'; ?> > <?php echo __('Weekly','wpcourses');?></option>
						 		</select>
						 	</div><!--- form-field -->
						 </div><!--- form-line -->	

						  <div class="form-line">
						 	<div class="form-label">
						 		<label for="_wpc_moodle_number_topics">
						 			<?php echo __('Number Topics', 'wpcourses'); ?>
						 			<br>
						 		</label>
						 	</div><!--- form-label -->
						 	<div class="form-field">
						 		<select name="_wpc_moodle_number_topics" id="">
						 			<?php 
						 				for ($i = 0; $i < 50; $i++){
						 					if($meta_wpc_moodle_number_topics[0] == $i)
						 					{
						 						$checked = 'selected="selected"';
						 					}
						 					else
						 					{
						 						$checked = ' ';
						 					}
						 					echo '<option value="' . $i . '" ' . $checked. '>' . $i . '</option>';
						 				} 
						 			?>
						 		</select>
						 	</div><!--- form-field -->
						 </div><!--- form-line -->	

						 <div class="form-line">
						 	<div class="form-label">
						 		<label for="_wpc_moodle_type_topics">
						 			<?php echo __('Hide Sections', 'wpcourses'); ?>
						 			<br>
						 		</label>
						 	</div><!--- form-label -->
						 	<div class="form-field">
						 		<select name="_wpc_moodle_type_topics" id="">
						 			<option value="0" selected="selected"><?php echo  __('Hidden sections are shown contracted', 'wpcourses'); ?></option>
									<option value="1"><?php echo  __('Hidden sections are completely invisible', 'wpcourses');?></option>
						 		</select>
						 	</div><!--- form-field -->
						 </div><!--- form-line -->
					</div><!--- wpc_show_settings_moodle -->
				</div><!--- wpctab2 -->
				<?php endif; ?>

			</div><!--- wpc_the_tabs -->

		</div><!--- course_tabs -->
<?php
	}

	/**
	 * Save Meta values to meta posts 
	 */

	public function WPC_after_save_course ($post_id) {

		global $post;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if(isset($_POST['_wpc_enable_sale_woocommerce']))
			update_post_meta($post_id, '_wpc_enable_sale_woocommerce', $_POST['_wpc_enable_sale_woocommerce']);

		if(isset($_POST['_wpc_course_shop_sku']))
			update_post_meta($post_id, '_wpc_course_shop_sku', $_POST['_wpc_course_shop_sku']);

		if(isset($_POST['_wpc_course_shop_price']))
			update_post_meta($post_id, '_wpc_course_shop_price', $_POST['_wpc_course_shop_price']);

		if(isset($_POST['_wpc_enable_course_moodle']))
			update_post_meta($post_id, '_wpc_enable_course_moodle', $_POST['_wpc_enable_course_moodle']);

		if(isset($_POST['_wpc_moodle_summary']))
			update_post_meta($post_id, '_wpc_moodle_summary', $_POST['_wpc_moodle_summary']);

		if(isset($_POST['_wpc_moodle_start_date']))
			update_post_meta($post_id, '_wpc_moodle_start_date', $_POST['_wpc_moodle_start_date']);

		if(isset($_POST['_wpc_moodle_format']))
			update_post_meta($post_id, '_wpc_moodle_format', $_POST['_wpc_moodle_format']);

		if(isset($_POST['_wpc_moodle_number_topics']))
			update_post_meta($post_id, '_wpc_moodle_number_topics', $_POST['_wpc_moodle_number_topics']);

		if(isset($_POST['_wpc_moodle_type_topics']))
			update_post_meta($post_id, '_wpc_moodle_type_topics', $_POST['_wpc_moodle_type_topics']);

	}
}

new WPC_Meta_boxes();