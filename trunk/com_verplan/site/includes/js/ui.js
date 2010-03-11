/**
 * JS für jQuery UI Elemente
 * wichtig ist das selectmenu
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 22-Okt-2009
 */

jQuery(document).ready(function(){
	//counter verhindert, dass die nachricht über themewechsel beim start angezeigt wird
	var counter = 0;
		
	/*Themeswitcher, Design wechseln */
	jQuery('#ui_themeswitcher').themeswitcher({
		width: 200,
		onSelect: function() {
			if ((notify == 'pnotify' || notify == 'both') && counter > 0) {
				jQuery.pnotify({
				    pnotify_title: 'Design',
				    pnotify_text: 'Das Design wurde geändert.<br>'+jQuery('#ui_themeswitcher').text(),
				    pnotify_notice_icon: 'ui-icon ui-icon-info',
				    pnotify_type: 'notice'
				    //pnotify_delay: 6000
				});
				counter = 1;
			}
		},
		initialText: 'Theme wechseln'
	}); 
	
	jQuery('#ui_themeswitcher').append('');
	
	counter = 1;
	
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
			//console.log('Wert aus select: '+hash);
			
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
	
	//mouseover für refresh
	jQuery('#refresh').mouseover(function(){
		jQuery(this).addClass('ui-state-hover');
	});
	jQuery('#refresh').mouseout(function(){
		jQuery(this).removeClass('ui-state-hover');
	});
	
	
	//mouseover für den expander (erweiterte optionen für das panel) für die optionen und den up button	(unten rechts)
	jQuery('#up_btn, #expander_options').mouseenter(function(){
		jQuery(this).addClass('ui-state-hover');
	}).mouseleave(function(){
		jQuery(this).removeClass('ui-state-hover');
	});
	
	
});