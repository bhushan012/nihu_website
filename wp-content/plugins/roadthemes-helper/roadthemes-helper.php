<?php
/**
 * Plugin Name: RoadThemes Helper
 * Plugin URI: http://roadthemes.com/
 * Description: The helper plugin for RoadThemes themes.
 * Version: 1.0.0
 * Author: RoadThemes
 * Author URI: http://roadthemes.com/
 * Text Domain: flaton
 * License: GPL/GNU.
 /*  Copyright 2015  RoadThemes  (email : roadthemez@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

require_once( plugin_dir_path( __FILE__ ).'loader.php' );

//Add less compiler
function compileLessFile($input, $output, $params) {
   require_once( plugin_dir_path( __FILE__ ).'less/lessc.inc.php' );
   
	$less = new lessc;
	$less->setVariables($params);
	
    // input and output location
    $inputFile = get_template_directory().'/less/'.$input;
    $outputFile = get_template_directory().'/css/'.$output;

    try {
		$less->compileFile($inputFile, $outputFile);
	} catch (Exception $ex) {
		echo "lessphp fatal error: ".$ex->getMessage();
	}
}
function compileChildLessFile($input, $output, $params) {
	require_once( plugin_dir_path( __FILE__ ).'less/lessc.inc.php' );
	$less = new lessc;
	$less->setVariables($params);
	
    // input and output location
    $inputFile = get_stylesheet_directory().'/less/'.$input;
    $outputFile = get_stylesheet_directory().'/css/'.$output;

    try {
		$less->compileFile($inputFile, $outputFile);
	} catch (Exception $ex) {
		echo "lessphp fatal error: ".$ex->getMessage();
	}
}

function james_brands_shortcode( $atts ) {
	global $james_opt;
	$brand_index = 0;
	$brandfound=count($james_opt['brand_logos']);
	
	$atts = shortcode_atts( array(
							'rowsnumber' => '1',
							'colsnumber' => '6',
							), $atts, 'ourbrands' );
	$html = '';
	
	if($james_opt['brand_logos']) {
		$html .= '<div class="brands-carousel" data-col="'.$atts['colsnumber'].'">';
			foreach($james_opt['brand_logos'] as $brand) {
				if(is_ssl()){
					$brand['image'] = str_replace('http:', 'https:', $brand['image']);
				}
				$brand_index ++;
				if ( (0 == ( $brand_index - 1 ) % $atts['rowsnumber'] ) || $brand_index == 1) {
					$html .= '<div class="group">';
				}
				$html .= '<div>';
				$html .= '<a href="'.$brand['url'].'" title="'.$brand['title'].'">';
					$html .= '<img src="'.$brand['image'].'" alt="'.$brand['title'].'" />';
				$html .= '</a>';
				$html .= '</div>';
				if ( ( ( 0 == $brand_index % $atts['rowsnumber'] || $brandfound == $brand_index ))  ) {
					$html .= '</div>';
				}
			}
		$html .= '</div>';
	}
	
	return $html;
}
add_shortcode( 'ourbrands', 'james_brands_shortcode' );

function james_popular_categories_shortcode( $atts ) {

	$atts = shortcode_atts( array(
		'category' => '',
		'image' => ''
	), $atts, 'popular_categories' );
	
	$html = '';
	
	$html .= '<div class="category-wrapper">';
		$pcategory = get_term_by( 'slug', $atts['category'], 'product_cat', 'ARRAY_A' );
		if($pcategory){
			$html .= '<div class="category-list">';
				$html .= '<h3><a href="'. get_term_link($pcategory['slug'], 'product_cat') .'">'. $pcategory['name'] .'</a></h3>';
				
				$html .= '<ul>';
					$args2 = array(
						'taxonomy'     => 'product_cat',
						'child_of'     => 0,
						'parent'       => $pcategory['term_id'],
						'orderby'      => 'name',
						'show_count'   => 0,
						'pad_counts'   => 0,
						'hierarchical' => 0,
						'title_li'     => '',
						'hide_empty'   => 0
					);
					$sub_cats = get_categories( $args2 );

					if($sub_cats) {
						foreach($sub_cats as $sub_category) {
							$html .= '<li><a href="'.get_term_link($sub_category->slug, 'product_cat').'">'.$sub_category->name.'</a></li>';
						}
					}
				$html .= '</ul>';
			$html .= '</div>';

			if ($atts['image']!='') {
			$html .= '<div class="cat-img">';
				$html .= '<a href="'.get_term_link($pcategory['slug'], 'product_cat').'"><img class="category-image" src="'.esc_attr($atts['image']).'" alt="" /></a>';
			$html .= '</div>';
			}
		}
	$html .= '</div>';
	
	return $html;
}
add_shortcode( 'popular_categories', 'james_popular_categories_shortcode' );

function james_categoriescarousel_shortcode( $atts ) {
	global $james_opt;
	$categories_index = 0;
	if(isset($james_opt['cate_images'])){
		$categoriesfound = count($james_opt['cate_images']);
	}
	
	$atts = shortcode_atts( array(
							'rowsnumber' => '1',
							'colsnumber' => '6',
							), $atts, 'categoriescarousel' );
	$html = '';
	
	if(isset($james_opt['cate_images'])){
		$html .= '<div class="categories-carousel" data-col="'.$atts['colsnumber'].'">';
			foreach($james_opt['cate_images'] as $categories) {
				if(is_ssl()){
					$categories['image'] = str_replace('http:', 'https:', $categories['image']);
				}
				$categories_index ++;
				if ( (0 == ( $categories_index - 1 ) % $atts['rowsnumber'] ) || $categories_index == 1) {
					$html .= '<div class="group">';
				}
				$html .= '<div>';
				$html .= '<a href="'.$categories['url'].'" class="image" title="'.$categories['title'].'">';
					$html .= '<img src="'.$categories['image'].'" alt="'.$categories['title'].'" />';
				$html .= '</a>';
					$html .= '<div class="description">'.$categories['description'].'</div>';
				$html .= '</div>';
				if ( ( ( 0 == $categories_index % $atts['rowsnumber'] || $categoriesfound == $categories_index ))  ) {
					$html .= '</div>';
				}
			}
		$html .= '</div>';
	}
	
	return $html;
}
add_shortcode( 'categoriescarousel', 'james_categoriescarousel_shortcode' );

function james_latestposts_shortcode( $atts ) {
	global $james_opt;
	$post_index = 0;
	$atts = shortcode_atts( array(
		'posts_per_page' => 5,
		'order' => 'DESC',
		'orderby' => 'post_date',
		'image' => 'wide', //square
		'length' => 20,
		'rowsnumber' => '1',
		'colsnumber' => '4',
	), $atts, 'latestposts' );
	
	if($atts['image']=='wide'){
		$imagesize = 'sozo-post-thumbwide';
	} else {
		$imagesize = 'sozo-post-thumb';
	}
	$html = '';

	$postargs = array(
		'posts_per_page'   => $atts['posts_per_page'],
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => $atts['orderby'],
		'order'            => $atts['order'],
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'post',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'suppress_filters' => true );
	
	$postslist = get_posts( $postargs );

	$html.='<div class="posts-carousel" data-col="'.$atts['colsnumber'].'">';

			foreach ( $postslist as $post ) {
				$post_index ++;
				if ( (0 == ( $post_index - 1 ) % $atts['rowsnumber'] ) || $post_index == 1) {
					$html .= '<div class="group">';
				}
				$html.='<div class="item-col">';
					$html.='<div class="post-wrapper">';
						
						$html.='<div class="post-thumb">';
							$html.='<a href="'.get_the_permalink($post->ID).'">'.get_the_post_thumbnail($post->ID, $imagesize).'</a>';
						$html.='</div>';
						
						$html.='<div class="post-info">';
						
							$html.='<h3 class="post-title"><a href="'.get_the_permalink($post->ID).'">'.get_the_title($post->ID).'</a></h3>';
							
							$html.='<span class="post-date"><span class="day">'.get_the_date('d', $post->ID).'</span><span class="month">'.get_the_date('M', $post->ID).'</span></span>';
							
							$html.='<div class="post-excerpt">';
								$html.= JamesTheme::james_excerpt_by_id($post, $length = $atts['length']);
							$html.='</div>';
							$html.='<a class="readmore" href="'.get_the_permalink($post->ID).'">'.esc_html($james_opt['readmore_text']).'</a>';
							
						$html.='</div>';

					$html.='</div>';
				$html.='</div>';
				if ( ( ( 0 == $post_index % $atts['rowsnumber'] || $atts['posts_per_page'] == $post_index ))  ) {
					$html .= '</div>';
				}
			}
	$html.='</div>';

	wp_reset_postdata();
	
	return $html;
}
add_shortcode( 'latestposts', 'james_latestposts_shortcode' );

function james_contact_map( $atts ) {
	global $james_mapid;
	
	if(!isset($james_mapid)){
		$james_mapid = 1;
	} else {
		$james_mapid++;
	}
	$atts = shortcode_atts( array(
		'map_height' => 400,
		'map_zoom' => 17,
		'lat1' => '',
		'long1' => '',
		'address1' => '',
		'marker1' => '',
		'description1' => '',
		'lat2' => '',
		'long2' => '',
		'address2' => '',
		'marker2' => '',
		'description2' => '',
		'lat3' => '',
		'long3' => '',
		'address3' => '',
		'marker3' => '',
		'description3' => '',
		'lat4' => '',
		'long4' => '',
		'address4' => '',
		'marker4' => '',
		'description4' => '',
		'lat5' => '',
		'long5' => '',
		'address5' => '',
		'marker5' => '',
		'description5' => '',
		
	), $atts, 'james_map' );
	
	$map_zoom = 17;
	if(intval($atts['map_zoom'])){
		$map_zoom = intval($atts['map_zoom']);
	}
	$map_height = 400;
	if(intval($atts['map_height'])){
		$map_height = intval($atts['map_height']);
	}
	
	$markers = array(
		array(
			'lat1' => $atts['lat1'],
			'long1' => $atts['long1'],
			'address1' => $atts['address1'],
			'marker1' => $atts['marker1'],
			'description1' => $atts['description1'],
		),
		array(
			'lat2' => $atts['lat2'],
			'long2' => $atts['long2'],
			'address2' => $atts['address2'],
			'marker2' => $atts['marker2'],
			'description2' => $atts['description2'],
		),
		array(
			'lat3' => $atts['lat3'],
			'long3' => $atts['long3'],
			'address3' => $atts['address3'],
			'marker3' => $atts['marker3'],
			'description3' => $atts['description3'],
		),
		array(
			'lat4' => $atts['lat4'],
			'long4' => $atts['long4'],
			'address4' => $atts['address4'],
			'marker4' => $atts['marker4'],
			'description4' => $atts['description4'],
		),
		array(
			'lat5' => $atts['lat5'],
			'long5' => $atts['long5'],
			'address5' => $atts['address5'],
			'marker5' => $atts['marker5'],
			'description5' => $atts['description5'],
		),
	);
	
	$html = '';
	
	$html.='<div class="map-wrapper">';
		$html.='<div id="map'.$james_mapid.'" class="map" style="height: '.$map_height.'px"></div>';
	$html.='</div>';
	
	//Add google map API
	wp_enqueue_script( 'gmap-api-js', 'http://maps.google.com/maps/api/js?sensor=false' , array(), '3', false );
	// Add jquery.gmap.js file
	wp_enqueue_script( 'jquery.gmap-js', get_template_directory_uri() . '/js/jquery.gmap.js', array(), '2.1.5', false );

	?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('#map<?php echo esc_attr($james_mapid);?>').gMap({
				scrollwheel: false,
				zoom: <?php echo esc_js($map_zoom);?>,
				
				markers:[
					<?php 
					$markeridx = 0;
					foreach($markers as $marker){
						$markeridx++;
						
						$map_desc = str_replace(array("\r\n", "\r", "\n"), "", $marker['description'.$markeridx]);
						$map_desc = addslashes($map_desc);
						
						if( $marker['address'.$markeridx]!='' || ($marker['lat'.$markeridx]!='' && $marker['long'.$markeridx]!='') ){ ?>
							{
								<?php if($marker['address'.$markeridx]!=''){ ?>
								address: '<?php echo  esc_js($marker['address'.$markeridx]);?>',
								<?php } else { ?>
								latitude: <?php echo  esc_js($marker['lat'.$markeridx]);?>,
								longitude: <?php echo  esc_js($marker['long'.$markeridx]);?>,
								<?php } ?>
								html: '<?php echo wp_kses($map_desc, array(
												'a' => array(
													'href' => array(),
													'title' => array()
												),
												'i' => array(
													'class' => array()
												),
												'br' => array(),
												'em' => array(),
												'strong' => array(),
												'h1' => array(),
												'h2' => array(),
												'h3' => array(),
											)); ?>',
								icon: {
									<?php if( isset($marker['marker'.$markeridx]) && $marker['marker'.$markeridx]!='') : ?>
									image: '<?php echo  wp_get_attachment_url( $marker['marker'.$markeridx]); ?>',
									<?php else : ?>
									image: '<?php echo get_template_directory_uri() . '/images/marker.png'; ?>',
									<?php endif; ?>
									iconsize: [40, 40],
									iconanchor: [40, 40]
								},
								popup: true
							},
						
						<?php }
					
					} ?>
				]
			});
		});
	</script>
	<?php
	
	return $html;
}
add_shortcode( 'james_map', 'james_contact_map' );