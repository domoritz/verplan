/**
 * kümmert sich darum, dass die erweiterten optionen aus und eingeblendet werden können
 * beim starten wird der zustand aus dem cookie geladen
 * 
 * diese funktionen sind unabhängig von der initialisierung in general.js
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 2-Oct-2009
 */

jQuery(document).ready(function(){
	
	/*
	 * versteckt optionen (es wird das übergeordnete span versteckt, 
	 * damit es keine probleme mit display gibt)
	 */	
	
	//zustand aus Cookie wieder herstellen
	if (jQuery.cookie('show_advanced_layer') == 'true') {
		toggleStuff();
	} else {
		jQuery('#options_panel').hide('');
		//nur sicherheitshalber
		jQuery.cookie('show_advanced_layer', null);
	}
	
	//einblenden
	jQuery('#expander_options:not(.ui-state-active)').click(function() {
		//wechsel des icons
		jQuery('#options_panel').slideToggle(600);
		toggleStuff();
		
		//setzt wert für cookie auf true
		jQuery.cookie('show_advanced_layer', 'true', { expires: 7 });
	});
	
	//ausblenden
	jQuery('#expander_options.ui-state-active').click(function() {
		//wechsel des icons
		jQuery('#options_panel').slideToggle(600);
		toggleStuff();
		
		//löscht cookie
		jQuery.cookie('show_advanced_layer', null);
	});
	
});

/**
 * wechselt ob, das panel aus doer eingeblendet werden soll
 */
function toggleStuff() {
	jQuery('#icon_options').toggleClass('ui-icon-circle-plus').toggleClass('ui-icon-circle-minus');
	jQuery('#expander_options').toggleClass('ui-state-default');
	jQuery('#expander_options').toggleClass('ui-state-active');
}