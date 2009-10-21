jQuery(document).ready(function(){ 
	jQuery('<div style="position: absolute; top: 20px; right: 10px;" />').appendTo('body').themeswitcher(); 
	jQuery('#select_date').selectmenu({
		style:'dropdown', 
		menuWidth: 300
	});
	
	/*
	jQuery('.ui-icon').mouseenter(function(){
		jQuery(this).toggleClass('ui-state-hover');
	});
	jQuery('.ui-icon').mouseleave(function(){
		jQuery(this).toggleClass('ui-state-hover');
	});*/
	
	jQuery('#jquerytable thead th').mouseenter(function(){
		jQuery(this).toggleClass('ui-state-hover');
	});
	jQuery('#jquerytable thead th').mouseleave(function(){
		jQuery(this).toggleClass('ui-state-hover');
	});
	
	jQuery('#').mouseenter(function(){
		jQuery(this).toggleClass('ui-state-hover');
	});
	jQuery('#').mouseleave(function(){
		jQuery(this).toggleClass('ui-state-hover');
	});
	
	
	
});