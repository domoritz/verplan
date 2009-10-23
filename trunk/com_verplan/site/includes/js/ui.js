function show_hint(head, text) {
		jQuery('#hint_table div').html('<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.3em; margin-top: 0.3em;"></span><p><strong>'+head+'</strong><br>'+text+'</p></p>');

		jQuery('#hint_table').show('blind', 'slow');
}

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
	
	jQuery('.ui-selectmenu').qtip( {
		content : 'Geltungsdatum wählen',
		show : 'mouseover',
		hide : 'mouseout',
		position : {
			corner : {
				target : 'topMiddle',
				tooltip : 'bottomLeft'
			}
		},
		style : {
			name: 'domstyle'
		}
	});
	
	//mouseover für die einzelnen spaltenköpfe
	jQuery('#jquerytable thead th').mouseover(function(){
		jQuery(this).addClass('ui-state-hover');
	});
	jQuery('#jquerytable thead th').mouseout(function(){
		jQuery(this).removeClass('ui-state-hover');
	});
	
	//mouseover für die einzelnen spaltenköpfe mit den filtern
	/*jQuery('.filterColumns td').mouseover(function(){
		jQuery(this).addClass('ui-state-hover');
	});
	jQuery('.filterColumns td').mouseout(function(){
		jQuery(this).removeClass('ui-state-hover');
	});*/
	
	//mouseover für den expander für die optionen
	jQuery('#expander_options').mouseenter(function(){
		jQuery(this).addClass('ui-state-hover');
		jQuery(this).removeClass('ui-state-default');
	});
	jQuery('#expander_options').mouseleave(function(){
		jQuery(this).removeClass('ui-state-hover');
		jQuery(this).addClass('ui-state-default');
	});
	
	
});