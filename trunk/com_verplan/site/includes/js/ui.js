/**
 * JS für jQuery UI Elemente
 * 
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
	
	/*Themeswitcher, Design wechseln */
	jQuery('#ui_themeswitcher').themeswitcher({
		width: 200,
		onSelect: function() {
			if (notify == 'pnotify' || notify == 'both') {
				jQuery.pnotify({
				    pnotify_title: 'Design',
				    pnotify_text: 'Das Design wurde geändert.<br>'+jQuery('#ui_themeswitcher').text(),
				    pnotify_notice_icon: 'ui-icon ui-icon-info',
				    pnotify_type: 'notice',
				    pnotify_delay: 4000
				});
			}
		},
		onOpen: function() {		
		},
		onClose: function() {		
		},
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
	 * selectmenu plugin, auswahlfeld im jqueryui style
	 * http://www.filamentgroup.com/lab/jquery_ui_selectmenu_an_aria_accessible_plugin_for_styling_a_html_select/
	 */
	jQuery('#select_date_verplan').selectmenu({
		//style:'dropdown', 
		//menuWidth: 300
		change: function() {
	    	//hashwert über das dropdown
			hash = jQuery(this).val();
			//debug
			console.log('Wert aus select: '+hash);
			//lädt neue tabelle und setzt hash
			jQuery.historyLoad(hash);	
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
	//gibt es nciht mehr
	/*jQuery('.filterColumns td').mouseover(function(){
		jQuery(this).addClass('ui-state-hover');
	});
	jQuery('.filterColumns td').mouseout(function(){
		jQuery(this).removeClass('ui-state-hover');
	});*/
	
	//mouseover für den expander (erweiterte optionen für das panel) für die optionen und den up button	(unten rechts)
	jQuery('#up_btn, #expander_options').mouseenter(function(){
		jQuery(this).addClass('ui-state-hover');
	}).mouseleave(function(){
		jQuery(this).removeClass('ui-state-hover');
	});
	
	
});