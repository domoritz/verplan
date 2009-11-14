/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 22-Okt-2009
 */

function show_hint(head, text) {
		jQuery('#hint_table div').html('<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.3em; margin-top: 0.3em;"></span><p><strong>'+head+'</strong><br>'+text+'</p></p>');

		jQuery('#hint_table').show('blind', 'slow');
}

jQuery(document).ready(function(){ 
	jQuery('#ui_themeswitcher').themeswitcher({
		width: 200,
		initialText: 'Theme wechseln'
		//loadTheme: 'ui-darkness'
	}); 
	
	jQuery('#ui_themeswitcher').append(''); 
	
	
	/*
	<li>
    	<a href="?ffDefault=Trebuchet+MS...[full theme path]">
      	<img src="theme image" alt="UI Lightness" title="UI Lightness" /

      	<span class="themeName">UI lightness</span>
    	</a>
 	</li>
	 */
	
	/*
	 * selectmenu plugin
	 * http://www.filamentgroup.com/lab/jquery_ui_selectmenu_an_aria_accessible_plugin_for_styling_a_html_select/
	 */
	jQuery('#select_date').selectmenu({
		//style:'dropdown', 
		//menuWidth: 300
		change: function() {
	    	//alert(jQuery(this).val());
			setHash(jQuery(this).val());
			//window.location.hash = jQuery(this).val();
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
	
	
	jQuery('#up_btn').mouseenter(function(){
		jQuery(this).addClass('ui-state-hover');
	}).mouseleave(function(){
		jQuery(this).removeClass('ui-state-hover');
	});
	
	
});