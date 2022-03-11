"use strict";
// product-magnifier var
var james_magnifier_vars;
var james_magnifier_vars;

var yith_magnifier_options = {
	showTitle: false,
	zoomWidth: james_magnifier_vars.zoomWidth,
	zoomHeight: james_magnifier_vars.zoomHeight,
	position: james_magnifier_vars.position,
	lensOpacity: james_magnifier_vars.lensOpacity,
	softFocus: james_magnifier_vars.softFocus,
	adjustY: 0,
	disableRightClick: false,
	phoneBehavior: james_magnifier_vars.phoneBehavior,
	loadingLabel: james_magnifier_vars.loadingLabel,
}
var sliderOptions = {
		responsive: james_magnifier_vars.responsive,
		circular: james_magnifier_vars.circular,
		infinite: james_magnifier_vars.infinite,
		direction: 'left',
		debug: false,
		auto: false,
		align: 'left', 
		prev    : {
			button  : "#slider-prev",
			key     : "left"
		},
		next    : {
			button  : "#slider-next",
			key     : "right"
		},
		scroll : {
			items     : 1,
			pauseOnHover: true
		},
		items   : {
			visible: Number(james_magnifier_vars.visible),
		},
		swipe : {
			onTouch:    true,
			onMouse:    true
		},
		mousewheel : {
			items: 1
		}
	};
		
jQuery('ul.yith_magnifier_gallery').carouFredSel(sliderOptions);