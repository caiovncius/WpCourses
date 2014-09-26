<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Woocommerce
 * Integrating WpCourses with Woocommerce
 *
 * @package WpCourses/Woocommerce
 * @author Colde
 */

class WPC_Woocommerce {

	/**
	 * Construct
	 */
	public function __construct () {

		add_action ( 'save_post', array( $this, 'create_course_product' ) );
		add_action ( 'woocommerce_checkout_order_processed', array( $this, 'pre_enrollment_checkout' ) );
		add_action( 'woocommerce_order_status_completed', array ( $this, 'complete_order_enrol_user_moodle' ));

		add_action ('woocommerce_before_cart', array ( $this, 'teste'));
	}

	/**
	 * Create Product in Woocommerce
	 * 
	 * @param array
	 * @return void
	 */
	public function create_course_product($post) {

		$course 			= get_post ( $post );
		$course_product 	= get_post_meta ( $post, '_wpc_course_product');

		$data = $_POST;
		
		if ( $course->post_type == 'courses') {

			if ( isset ( $data['_wpc_enable_sale_woocommerce'] ) == 'on' ) {

				if( empty ($course_product) ) {

					$data_product = array(
						'post_title' 	=> $course->post_title,
						'post_content' 	=> $course->post_content,
						'post_status' 	=> 'publish',
						'post_type' 	=> 'product',
						'post_author'	=> $user->ID,
						'post_category' => ''
					);

					$product_saved = wp_insert_post($data_product);

					if( $product_saved ) {	

						// save featured image
						$post_thumbnail_id = get_post_thumbnail_id( $course->ID );

						// saving post meta woocommerce 
						update_post_meta($product_saved, '_product_image_gallery', '');
						update_post_meta($product_saved, '_stock', '');
						update_post_meta($product_saved, '_backorders', 'no');
						update_post_meta($product_saved, '_manage_stock', 'no');
						update_post_meta($product_saved, '_sold_individually', '');
						update_post_meta($product_saved, '_price', $data['_wpc_course_shop_price']);
						update_post_meta($product_saved, '_sale_price_dates_to', '');
						update_post_meta($product_saved, '_sale_price_dates_from', '');
						update_post_meta($product_saved, '_product_attributes', 'a:0:{}');
						update_post_meta($product_saved, '_sku', $data['_wpc_course_shop_sku']);
						update_post_meta($product_saved, '_height', '');
						update_post_meta($product_saved, '_width', '');
						update_post_meta($product_saved, '_length', '');
						update_post_meta($product_saved, '_weight', '');
						update_post_meta($product_saved, '_featured', 'no');
						update_post_meta($product_saved, '_purchase_note', '');
						update_post_meta($product_saved, '_sale_price', '');
						update_post_meta($product_saved, '_regular_price', $data['_wpc_course_shop_price']);
						update_post_meta($product_saved, '_virtual', 'yes');
						update_post_meta($product_saved, '_downloadable', 'no');
						update_post_meta($product_saved, 'total_sales', '0');
						update_post_meta($product_saved, '_stock_status', 'instock');
						update_post_meta($product_saved, '_visibility', 'hidden');
						update_post_meta($product_saved, '_thumbnail_id', $post_thumbnail_id );
						update_post_meta($product_saved, '_course_id', $course->ID);			

						// save id of product to postmeta of course
						update_post_meta($course->ID, '_wpc_course_product', $product_saved);
					}
				} else {

					$data_product = array(
						'ID' 			=> $course_product[0],
						'post_title' 	=> $course->post_title,
						'post_content' 	=> $course->post_content,
						'post_status' 	=> 'publish',
						'post_type' 	=> 'product',
						'post_author'	=> $user->ID,
						'post_category' => ''
					);

					$product_saved = wp_update_post($data_product);

					if( $product_saved ) {

						$post_thumbnail_id = get_post_thumbnail_id( $course->ID );

						// saving post meta woocommerce 
						update_post_meta($product_saved, '_product_image_gallery', '');
						update_post_meta($product_saved, '_stock', '');
						update_post_meta($product_saved, '_backorders', 'no');
						update_post_meta($product_saved, '_manage_stock', 'no');
						update_post_meta($product_saved, '_sold_individually', '');
						update_post_meta($product_saved, '_price', $data['_wpc_course_shop_price']);
						update_post_meta($product_saved, '_sale_price_dates_to', '');
						update_post_meta($product_saved, '_sale_price_dates_from', '');
						update_post_meta($product_saved, '_product_attributes', 'a:0:{}');
						update_post_meta($product_saved, '_sku', $data['_wpc_course_shop_sku']);
						update_post_meta($product_saved, '_height', '');
						update_post_meta($product_saved, '_width', '');
						update_post_meta($product_saved, '_length', '');
						update_post_meta($product_saved, '_weight', '');
						update_post_meta($product_saved, '_featured', 'no');
						update_post_meta($product_saved, '_purchase_note', '');
						update_post_meta($product_saved, '_sale_price', '');
						update_post_meta($product_saved, '_regular_price', $data['_wpc_course_shop_price']);
						update_post_meta($product_saved, '_virtual', 'yes');
						update_post_meta($product_saved, '_downloadable', 'no');
						update_post_meta($product_saved, 'total_sales', '0');
						update_post_meta($product_saved, '_stock_status', 'instock');
						update_post_meta($product_saved, '_visibility', 'hidden');
						update_post_meta($product_saved, '_thumbnail_id', $post_thumbnail_id);
						update_post_meta($product_saved, '_course_id', $course->ID);			

						// save id of product to postmeta of course
						update_post_meta($course->ID, '_wpc_course_product', $product_saved);
					}			
				}
			}
		}
	}

	/**
	 * Create Pre enrollment in order checkout
	 */
	public function pre_enrollment_checkout ( $order_id ) {

		global $woocommerce;

		$order = new WC_Order($order_id);
		$items = $order->get_items();

			
		foreach ($items as $item) {

			
			$customer = $order->user_id;	
			$data_customer = get_userdata($customer);	
			$user = wp_get_current_user();	

			$courseID = get_post_meta($item['product_id'], '_course_id');

			if( !empty( $courseID ) ) {

				$data_enrol = array(
					'post_title' 	=> '#_',
					'post_content' 	=> '',
					'post_author'  	=> $user->ID,
					'post_status' 	=> 'pending',
					'post_type' 	=> 'enrollment'
				);		

				$create_enrol = wp_insert_post($data_enrol);
						
				if($create_enrol) {
						
					update_post_meta($create_enrol, '_wpc_enrol_user_id', $customer);
					update_post_meta($create_enrol, '_wpc_enrol_info', __('Enrol created by sale number #', 'wpcourses') . $order_id);
					update_post_meta($create_enrol, '_wpc_enrol_course_id', $courseID[0]);
					update_post_meta($create_enrol, '_wpc_enrol_sale_id', $order_id);			
					update_post_meta($create_enrol, '_wpc_enrol_type', 'wdl_manual_enrol');		
					
					// saving enrol in post meta order
					add_post_meta($order_id, '_wpc_enrol_order_id', $create_enrol);			

					$data_update_enrol = array(
						'ID' 			=> $create_enrol,
						'post_title' 	=> '#' . $create_enrol
					);
					wp_update_post($data_update_enrol);
				}
			}
		}	
	}

	function complete_order_enrol_user_moodle( $order_id ) {
	
		// get enrol id
		$enrolId = get_post_meta($order_id, '_wpc_enrol_order_id');
		// get last key of array to total courses buy in order.
		$latsKey = count($enrolId) -1;	

		// Loop to enrol
		for($i = 0; $i <= $latsKey; $i++) {	

			$post = $enrolId[$i];	

			// cahnge status to enrol post type
			$enrol = array();
		  	$enrol['ID'] = $post;
		  	$enrol['post_status'] = 'publish';
		  	
		  	wp_update_post( $enrol );
		}	

	}
}

new WPC_Woocommerce();