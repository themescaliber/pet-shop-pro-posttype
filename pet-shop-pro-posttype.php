<?php
/*
 Plugin Name: Pet Shop Pro Posttype
 Plugin URI: http://www.themescaliber.com/
 Description: Creating new post type for Themes Caliber.
 Author: Themescaliber
 Version: 1.1
 Author URI: http://www.themescaliber.com/
*/

define( 'PET_SHOP_PRO_POSTTYPE_VERSION', '1.0' );

add_action( 'init', 'pet_shop_pro_posttype_create_post_type' );

function pet_shop_pro_posttype_create_post_type() {
	register_post_type( 'our_team',
		array(
			'labels' => array(
				'name' => __( 'Our Team','pet-shop-pro-posttype' ),
				'singular_name' => __( 'Our Team','pet-shop-pro-posttype' )
				),
			'capability_type' =>  'post',
			'menu_icon'  => 'dashicons-groups',
			'public' => true,
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				)
			)
		);
		register_post_type( 'pet_service',
		array(
			'labels' => array(
				'name' => __( 'Pet Service','pet-shop-pro-posttype' ),
				'singular_name' => __( 'Pet Service','pet-shop-pro-posttype' )
				),
			'capability_type' =>  'post',
			'menu_icon'  => 'dashicons-universal-access-alt',
			'public' => true,
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				)
			)
		);
	register_post_type( 'testimonials',
		array(
			'labels' => array(
				'name' => __( 'Testimonials','pet-shop-pro-posttype' ),
				'singular_name' => __( 'Testimonials','pet-shop-pro-posttype' )
				),
			'capability_type' => 'post',
			'menu_icon'  => 'dashicons-businessman',
			'public' => true,
			'supports' => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				)
			)
		);

}

add_action('admin_menu', 'pet_shop_pro_posttype_bn_custom_meta_team');

/* Adds a meta box to the Trainer editing screen */
 function pet_shop_pro_posttype_bn_custom_meta_team() {

 	add_meta_box( 'pet-shop-pro-posttype-trainer-meta', __( 'Enter Social URL', 'pet-shop-pro-posttype' ), 'pet_shop_pro_posttype_meta_callback_team', 'our_team',  'normal', 'high' );
}

add_action('admin_menu', 'pet_shop_pro_posttype_bn_custom_meta_testimonial');

/* Adds a meta box to the Trainer editing screen */
 function pet_shop_pro_posttype_bn_custom_meta_testimonial() {

 	add_meta_box( 'pet-shop-pro-posttype-trainer-meta', __( 'Enter Social URL', 'pet-shop-pro-posttype' ), 'pet_shop_pro_posttype_meta_callback_team', 'testimonials',  'normal', 'high' );
}

/* Adds a meta box for custom post */
function pet_shop_pro_posttype_meta_callback_team( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'pet_shop_pro_posttype_team_meta_nonce' );
	$facebookurl = get_post_meta( $post->ID, 'pet_shop_pro_posttype_facebookurl', true );
	$twitterurl = get_post_meta( $post->ID, 'pet_shop_pro_posttype_twitterurl', true );
	$googleplusurl = get_post_meta( $post->ID, 'pet_shop_pro_posttype_googleplusurl', true );
	$linkdenurl = get_post_meta( $post->ID, 'pet_shop_pro_posttype_linkedinurl', true );
	?>
	<div id="postcustom">
		<table id="list-table">
			<tbody id="the-list" data-wp-lists="list:meta">
				<tr id="meta-1">
					<td class="left">
						<?php esc_html_e( 'Facebook URL', 'pet-shop-pro-posttype' )?>
					</td>
					<td class="left">
						<input type="url" name="pet_shop_pro_posttype_facebookurl" id="pet_shop_pro_posttype_facebookurl" value="<?php echo esc_url( $facebookurl ); ?>" />
					</td>
				</tr>
				<tr id="meta-2">
					<td class="left">
						<?php esc_html_e( 'Twitter URL', 'pet-shop-pro-posttype' )?>
					</td>
					<td class="left">
						<input type="url" name="pet_shop_pro_posttype_twitterurl" id="pet_shop_pro_posttype_twitterurl" value="<?php echo esc_url( $twitterurl ); ?>" />
					</td>
				</tr>
				<tr id="meta-3">
					<td class="left">
						<?php esc_html_e( 'GooglePlus URL', 'pet-shop-pro-posttype' )?>
					</td>
					<td class="left" >
						<input type="url" name="pet_shop_pro_posttype_googleplusurl" id="pet_shop_pro_posttype_googleplusurl" value="<?php echo esc_url( $googleplusurl ); ?>" />
					</td>
				</tr>
				<tr id="meta-4">
					<td class="left">
						<?php esc_html_e( 'Linkedin URL', 'pet-shop-pro-posttype' )?>
					</td>
					<td class="left" >
						<input type="url" name="pet_shop_pro_posttype_linkedinurl" id="pet_shop_pro_posttype_linkedinurl" value="<?php echo esc_url( $linkdenurl ); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
}

/* Saves the custom meta input */
function pet_shop_pro_posttype_bn_meta_save_team( $post_id ) {

	if (!isset($_POST['pet_shop_pro_posttype_team_meta_nonce']) || !wp_verify_nonce($_POST['pet_shop_pro_posttype_team_meta_nonce'], basename(__FILE__))) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	// Save facebookurl
	if( isset( $_POST[ 'pet_shop_pro_posttype_facebookurl' ] ) ) {
		update_post_meta( $post_id, 'pet_shop_pro_posttype_facebookurl', esc_url_raw($_POST[ 'pet_shop_pro_posttype_facebookurl']) );
	}

	// Save linkdenurl
	if( isset( $_POST[ 'pet_shop_pro_posttype_linkedinurl' ] ) ) {
		update_post_meta( $post_id, 'pet_shop_pro_posttype_linkedinurl', esc_url_raw($_POST[ 'pet_shop_pro_posttype_linkedinurl']) );
	}

	if( isset( $_POST[ 'pet_shop_pro_posttype_twitterurl' ] ) ) {
		update_post_meta( $post_id, 'pet_shop_pro_posttype_twitterurl', esc_url_raw($_POST[ 'pet_shop_pro_posttype_twitterurl']) );
	}

	// Save googleplusurl
	if( isset( $_POST[ 'pet_shop_pro_posttype_googleplusurl' ] ) ) {
		update_post_meta( $post_id, 'pet_shop_pro_posttype_googleplusurl', esc_url_raw($_POST[ 'pet_shop_pro_posttype_googleplusurl']) );
	}

}

add_action( 'save_post', 'pet_shop_pro_posttype_bn_meta_save_team' );

/* Team shorthcode */
function pet_shop_pro_posttype_our_team_func( $atts ) {
	$Trainers = '';
	$Trainers = '<div class="row">';
	$query = new WP_Query( array( 'post_type' => 'our_team') );

	if ( $query->have_posts() ) :

		$k=1;

    	$new = new WP_Query('post_type=our_team');

    	while ($new->have_posts()) : $new->the_post();

	    	$content = get_the_content();

			$post_id = get_the_ID();

			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'large' );

		  	$facebookurl= get_post_meta($post_id,'pet_shop_pro_posttype_facebookurl',true);

		  	$linkedin=get_post_meta($post_id,'pet_shop_pro_posttype_linkedinurl',true);

			$twitter=get_post_meta($post_id,'pet_shop_pro_posttype_twitterurl',true);

			$googleplus=get_post_meta($post_id,'pet_shop_pro_posttype_googleplusurl',true);
			if(has_post_thumbnail()) { $thumb_url = $thumb['0']; }

			else { $thumb_url = esc_url(get_template_directory_uri().'/images/people-blank.jpg'); }

			$Trainers .= '<div class="col-md-6">';
	    	$Trainers .= '<div class="page-team-box">
	    		<div class="row complete_box">
	    		    <div class="col-md-5 image-box">';
			$Trainers.='<img src="'.esc_url($thumb_url).'" alt="" />
		                </div>
						<div class="col-md-6 col-md-offset-1">
							<div class="member-name"><h4>'. get_the_title() .'</h4><small class="member-designation"></small></div>
							<div class="content-tc">'.$content.'</div>
		                    <div class="about-socialbox">
		                    <span>'.esc_html('Find us on :- ','pet-shop-pro').'</span>';
		                    	if($facebookurl != ''){
									$Trainers.='<a href="'.esc_url($facebookurl).'"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
								}if($twitter != ''){
									$Trainers.='<a href="'.esc_url($twitter).'"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
								}if($googleplus != ''){
									$Trainers.='<a href="'.esc_url($googleplus).'"><i class="fa fa-google-plus" aria-hidden="true"></i></a>';
								}if($linkedin != ''){
									$Trainers.='<a href="'.esc_url($linkedin).'"><i class="fa fa-linkedin" aria-hidden="true"></i></a>';
								}
							$Trainers.='</div>
				        </div>
				      </div>
				    </div>
		            
				</div>';
			    if($k%2 == 0){
			    	$Trainers.= '<div class="clear"></div>';
			    }
      		$k++;
		endwhile;
		else :
			$Trainers = '<h2 class="center">'.esc_html__('Post Not Found','pet-shop-pro-posttype').'</h2>';
		endif;
		$Trainers .= '</div>';
		return $Trainers;
}

add_shortcode( 'tc-team', 'pet_shop_pro_posttype_our_team_func' );

add_action('admin_menu', 'pet_shop_pro_posttype_bn_testimonial_meta_box');

/* Adds a meta box for Designation */
function pet_shop_pro_posttype_bn_testimonial_meta_box() {
	add_meta_box( 'pet-shop-pro-posttype-testimonial-meta', __( 'Enter Designation', 'pet-shop-pro-posttype' ), 'pet_shop_pro_posttype_bn_testimonial_meta_callback', 'testimonials', 'normal', 'high' );
}

/* Adds a meta box for custom post */
function pet_shop_pro_posttype_bn_testimonial_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'pet_shop_pro_posttype_testimonial_meta_nonce' );
	$desig = get_post_meta( $post->ID, 'pet_shop_pro_posttype_desig', true );
	?>
	<div id="postcustomstuff">
		<table id="list">
			<tbody id="the-list" data-wp-lists="list:meta">
				<tr id="meta-1">
					<td class="left">
						<?php esc_html_e( 'Designation', 'pet-shop-pro-posttype' )?>
					</td>
					<td class="left" >
						<input type="text" name="pet_shop_pro_posttype_desig" id="pet_shop_pro_posttype_desig" value="<?php echo esc_attr( $desig ); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
}

/* Saves the custom Designation meta input */
function pet_shop_pro_posttype_bn_metadesig_save( $post_id ) {
	if (!isset($_POST['pet_shop_pro_posttype_testimonial_meta_nonce']) || !wp_verify_nonce($_POST['pet_shop_pro_posttype_testimonial_meta_nonce'], basename(__FILE__))) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	// Save desig.
	if( isset( $_POST[ 'pet_shop_pro_posttype_desig' ] ) ) {
		update_post_meta( $post_id, 'pet_shop_pro_posttype_desig', sanitize_text_field($_POST[ 'pet_shop_pro_posttype_desig']) );
	}
}
add_action( 'save_post', 'pet_shop_pro_posttype_bn_metadesig_save' );

/* Testimonials shorthcode */
function pet_shop_pro_posttype_team_func( $atts ) {
	$testimonial = '';
	$testimonial = '<div class="row testimonial-short">';
	$query = new WP_Query( array( 'post_type' => 'testimonials') );

    if ( $query->have_posts() ) :

	$k=1;
	$new = new WP_Query('post_type=testimonials');

	while ($new->have_posts()) : $new->the_post();
    	$content = get_the_content();

		$post_id = get_the_ID();
	  	$facebookurl= get_post_meta($post_id,'pet_shop_pro_posttype_facebookurl',true);

	  	$linkedin=get_post_meta($post_id,'pet_shop_pro_posttype_linkedinurl',true);

		$twitter=get_post_meta($post_id,'pet_shop_pro_posttype_twitterurl',true);

		$googleplus=get_post_meta($post_id,'pet_shop_pro_posttype_googleplusurl',true);
    	$image_url = get_theme_mod('quote_image2',get_template_directory_uri().'/images/quote-background.png');
    	$excerpt = wp_trim_words(get_the_excerpt(),10);
      
    	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), '' );

        if(has_post_thumbnail()) { $thumb_url = $thumb['0']; } else { $thumb_url = get_template_directory_uri(); }

      	$desg= get_post_meta($post_id,'pet_shop_pro_posttype_desig',true);

    	$testimonial .= '
			<div id="clients" class=" col-lg-4 col-md-6 col-sm-12 testimonialwrapper-box">
				<div class="client">
				<img class="client-img" src="'.esc_url($thumb_url).'" alt="" />
					<div class="client_name"><h3><a href="'.get_permalink().'">'.esc_html(get_the_title()).'</a></h3></div>
					<div class="client-designation">'.esc_html($desg).'</div>
					<div class="content">'.esc_html($excerpt).'</div>
					 <div class="about-socialbox">
                    <span>'.esc_html('Find us on :- ','pet-shop-pro').'</span>';
                    	if($facebookurl != ''){
							$testimonial.='<a href="'.esc_url($facebookurl).'"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
						}if($twitter != ''){
							$testimonial.='<a href="'.esc_url($twitter).'"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
						}if($googleplus != ''){
							$testimonial.='<a href="'.esc_url($googleplus).'"><i class="fa fa-google-plus" aria-hidden="true"></i></a>';
						}if($linkedin != ''){
							$testimonial.='<a href="'.esc_url($linkedin).'"><i class="fa fa-linkedin" aria-hidden="true"></i></a>';
						}
					$testimonial.='</div>
				</div>
	               
	                <div class="clearfix"></div>
				
			</div>';
		if($k%3 == 0){
			$testimonial.= '<div class="clearfix"></div>';
		}
      $k++;
  endwhile;
  else :
  	$testimonial = '<h2 class="center">'.esc_html__('Post Not Found','pet-shop-pro-posttype').'</h2>';
  endif;
  $testimonial .= '</div>';
  return $testimonial;
}

add_shortcode( 'tc-testimonial', 'pet_shop_pro_posttype_team_func' );

function pet_shop_pro_posttype_pet_service_123_func( $atts ) {
	$testimonial = '';
	//$testimonial = '<div class="row">';
	$query = new WP_Query( array( 'post_type' => 'pet_service') );

    if ( $query->have_posts() ) :

	$k=1;
	
	$new = new WP_Query( array('post_type' => 'pet_service'));
	while ($new->have_posts()) : $new->the_post();
    	$image_url = get_theme_mod('quote_image2',get_template_directory_uri().'/images/quote-background.png');
    	$excerpt = wp_trim_words(get_the_excerpt(),10);
      	$post_id = get_the_ID();

    	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), '' );

        if(has_post_thumbnail()) { $thumb_url = $thumb['0']; } else { $thumb_url = get_template_directory_uri(); }

      	$desg= get_post_meta($post_id,'pet_shop_pro_posttype_desig',true);
      	if($k%2 == 0){
    	$testimonial .= '
			<div id="service_menu_'.esc_html(get_the_ID()).'" class="col-md-12 col-sm-12 testimonialwrapper-box" >
				<div class="client">
					
	                <div class="row">
						
						<div class="col-md-6 col-sm-12 content-box">
							<h2 class="client_name"><a href="'.get_permalink().'">'.esc_html(get_the_title()).'</a></h2>
							<div class="text-box">
								<span class="client-designation">'.esc_html($desg).'</span>
							</div>
							<div class="text-box-designation">
					            <p>'.esc_html($excerpt).'</p>
					        </div>
						</div>
						<div class="col-md-6 col-sm-12 image-box">
							<img class="client-img" src="'.esc_url($thumb_url).'" alt="" />
						</div>
	                </div>
	             
	                <div class="clearfix"></div>
				</div>
			</div>';
		}else{
			$testimonial .= '
			<div id="service_menu_'.esc_html(get_the_ID()).'" class="col-md-12 col-sm-12 testimonialwrapper-box">
				<div class="client">
					
	                <div class="row">
						<div class="col-md-6 col-sm-12 image-box">
							<img class="client-img" src="'.esc_url($thumb_url).'" alt="" />
						</div>
						<div class="col-md-6 col-sm-12 content-box">
							<h2 class="client_name"><a href="'.get_permalink().'">'.esc_html(get_the_title()).'</a></h2>
							<div class="text-box">
								<span class="client-designation">'.esc_html($desg).'</span>
							</div>
							<div class="text-box-designation">
					            <p>'.esc_html($excerpt).'</p>
					        </div>
						</div>
						
	                </div>             
	                <div class="clearfix"></div>
				</div>
			</div>';
		}
		
      $k++;
  endwhile;
  else :
  	$testimonial = '<h2 class="center">'.esc_html__('Post Not Found','pet-shop-pro-posttype').'</h2>';
  endif;
  return $testimonial;
}

add_shortcode( 'tc-pet-service', 'pet_shop_pro_posttype_pet_service_123_func' );
/*Services shorthcode */
function pet_shop_pro_posttype_services_func( $atts ) {
	$services = '<div class="serv_len"><div class="row">';
		$serviceimage = '';
		$serviceimage = array(
		'1' =>  get_template_directory_uri().'/images/fitness-icon.png',
		'2' =>  get_template_directory_uri().'/images/fitness-icon.png',
		'3' =>  get_template_directory_uri().'/images/fitness-icon.png',
		'4' =>  get_template_directory_uri().'/images/fitness-icon.png',
		);
		$number=get_theme_mod('pet_shop_pro_posttype_service_number', 4);
		for ($i=1; $i<=$number; $i++) {
			if ( get_theme_mod('pet_shop_pro_posttype_service_number'.$i, true) != "" ) {
				$services .= '
					<div class="col-md-3 col-3 work_serv">
						<img class="service-img" src="'.esc_url(get_theme_mod('pet_shop_pro_posttype_service_image'.$i, $serviceimage[$i])).'" alt=""/>
					</div>
					<div class="col-md-3 col-9 serv_title">
						<h4>'.esc_html(get_theme_mod('pet_shop_pro_posttype_service_title'.$i,__('WORKOUT','pet-shop-pro-posttype'))).'</h4>
				        <p>'.esc_html(get_theme_mod ('pet_shop_pro_posttype_service_subcontent'.$i,__('Lorem Ipsum is simply dummy text of the printing and typesetting industry.','pet-shop-pro-posttype'))).'</p>
					</div>';
	        }
        }
	$services .= '</div></div>';
	return $services;
}
add_shortcode( 'tc-services', 'pet_shop_pro_posttype_services_func' );
