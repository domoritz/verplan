jQuery(document).ready(function(){ 
	jQuery('#ui_themeswitcher').themeswitcher(); 
	
	/*
	 * selectmenu plugin
	 * http://www.filamentgroup.com/lab/jquery_ui_selectmenu_an_aria_accessible_plugin_for_styling_a_html_select/
	 */
	jQuery('#select_date').selectmenu({
		//style:'dropdown', 
		//menuWidth: 300
	});
	
	jQuery('#jquerytable thead th').mouseover(function(){
		jQuery(this).addClass('ui-state-hover');
	});
	jQuery('#jquerytable thead th').mouseout(function(){
		jQuery(this).removeClass('ui-state-hover');
	});
	
	
	jQuery('.filterColumns td').mouseover(function(){
		jQuery(this).addClass('ui-state-hover');
	});
	jQuery('.filterColumns td').mouseout(function(){
		jQuery(this).removeClass('ui-state-hover');
	});
	
	
	jQuery('#expander_options').mouseenter(function(){
		jQuery(this).addClass('ui-state-hover');
		jQuery(this).removeClass('ui-state-default');
	});
	jQuery('#expander_options').mouseleave(function(){
		jQuery(this).removeClass('ui-state-hover');
		jQuery(this).addClass('ui-state-default');
	});
	
	
	
});