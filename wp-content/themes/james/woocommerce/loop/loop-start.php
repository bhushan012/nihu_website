<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     31.3.0
 */

$shoplayout = 'sidebar';
if(isset($james_opt['shop_layout']) && $james_opt['shop_layout']!=''){
	$shoplayout = $james_opt['shop_layout'];
}
if(isset($_GET['layout']) && $_GET['layout']!=''){
	$shoplayout = $_GET['layout'];
}
 $james_viewmode = JamesTheme::james_show_view_mode();
?> 
<div class="shop-products products row <?php echo esc_attr($james_viewmode);?> <?php echo esc_attr($shoplayout);?>">