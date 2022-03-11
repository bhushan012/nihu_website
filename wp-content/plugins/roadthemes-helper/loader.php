<?php

// Replace {$redux_opt_name} with your opt_name.
// Also be sure to change this function name!


function james_redux_register_extension_loader($ReduxFramework) {
	$path    = dirname( __FILE__ ) . '/extensions/';
		$folders = scandir( $path, 1 );
		foreach ( $folders as $folder ) {
			if ( $folder === '.' or $folder === '..' or ! is_dir( $path . $folder ) ) {
				continue;
			}
			$extension_class = 'ReduxFramework_Extension_' . $folder;
			if ( ! class_exists( $extension_class ) ) {
				// In case you wanted override your override, hah.
				$class_file = $path . $folder . '/extension_' . $folder . '.php';
				$class_file = apply_filters( 'redux/extension/' . $ReduxFramework->args['opt_name'] . '/' . $folder, $class_file );
				if ( $class_file ) {
					require_once( $class_file );
				}
			}
			if ( ! isset( $ReduxFramework->extensions[ $folder ] ) ) {
				$ReduxFramework->extensions[ $folder ] = new $extension_class( $ReduxFramework );
			}
		}
}
// Modify {$redux_opt_name} to match your opt_name
add_action("redux/extensions/james_opt/before", 'james_redux_register_extension_loader', 0);

// Import slider, setup menu locations, setup home page

function james_wbc_extended_example( $demo_active_import , $demo_directory_path ) {

	reset( $demo_active_import );
	$current_key = key( $demo_active_import );

	/************************************************************************
	* Import slider(s) for the current demo being imported
	*************************************************************************/

	if ( class_exists( 'RevSlider' ) ) {

		//If it's Fashion or Furniture
		$wbc_sliders_array = array(
			'Shoes' => 'home-slider1.zip', //Set slider zip name
			//'Furniture' => 'home-slider2.zip', //Set slider zip name
		);

		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_sliders_array ) ) {
			$wbc_slider_import = $wbc_sliders_array[$demo_active_import[$current_key]['directory']];

			if ( file_exists( $demo_directory_path.$wbc_slider_import ) ) {
				$slider = new RevSlider();
				$slider->importSliderFromPost( true, true, $demo_directory_path.$wbc_slider_import );
			}
		}
	}

	/************************************************************************
	* Setting Menus
	*************************************************************************/

	// If it's demo1 - demo6
	$wbc_menu_array = array( 'Shoes' );

	if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && in_array( $demo_active_import[$current_key]['directory'], $wbc_menu_array ) ) {
		$primary_menu = get_term_by( 'name', 'Horizontal Menu', 'nav_menu' );
		$top_menu = get_term_by( 'name', 'Top Menu', 'nav_menu' );
		$mobile_menu = get_term_by( 'name', 'Horizontal Menu', 'nav_menu' );
		
		if ( isset( $top_menu->term_id ) ) {
			set_theme_mod( 'nav_menu_locations', array(
					'primary' => $primary_menu->term_id,
					'topmenu'  => $top_menu->term_id,
					'mobilemenu'  => $mobile_menu->term_id
				)
			);
		}

	}
	
	/************************************************************************
	* Import Mega Menu Options
	*************************************************************************/
	
	global $mega_main_menu;
	
	$exported_file = $demo_directory_path.'mega-main-menu-backup.txt';
	
	if ( file_exists( $exported_file ) ) {
		//$backup_file_content = mm_common::get_url_content( $_FILES[ $mega_main_menu->constant[ 'MM_OPTIONS_NAME' ] . '_backup' ]['tmp_name'] );
		$backup_file_content = file_get_contents ( $exported_file );
		
		if ( $backup_file_content !== false && ( $options_backup = json_decode( $backup_file_content, true ) ) ) {
			update_option( $mega_main_menu->constant[ 'MM_OPTIONS_NAME' ], $options_backup );
		}
	}

	/************************************************************************
	* Set HomePage
	*************************************************************************/

	// array of demos/homepages to check/select from
	$wbc_home_pages = array(
		'Shoes' => 'Home Shop 1',
	);
	$wbc_blog_page = array(
		'Shoes' => 'Blog',
	);

	if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_home_pages ) ) {
		$page = get_page_by_title( $wbc_home_pages[$demo_active_import[$current_key]['directory']] );
		$blogpage = get_page_by_title( $wbc_blog_page[$demo_active_import[$current_key]['directory']] );
		if ( isset( $page->ID ) ) {
			update_option( 'page_on_front', $page->ID );
			update_option( 'show_on_front', 'page' );
			update_option( 'page_for_posts', $blogpage->ID );
		}
	}

}

// Uncomment the below
add_action( 'wbc_importer_after_content_import', 'james_wbc_extended_example', 10, 2 );