/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
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
	if (!(jQuery.cookie('show_advanced_layer') == 'true')) {
		jQuery('#options_panel').hide('');
	} else {
		toggleStuff();
	}
	
	//einblenden
	jQuery('#expander_options:not(.ui-state-active)').click(function() {
		//wechsel des icons
		jQuery('#options_panel').slideToggle(600);
		toggleStuff();
		
		jQuery.cookie('show_advanced_layer', 'true', { expires: 7 });
	});
	
	//ausblenden
	jQuery('#expander_options.ui-state-active').click(function() {
		//wechsel des icons
		jQuery('#options_panel').slideToggle(600);
		toggleStuff();
		
		jQuery.cookie('show_advanced_layer', 'false', { expires: 7 });
	});
	
});

function toggleStuff() {
	jQuery('#icon_options').toggleClass('ui-icon-circle-plus').toggleClass('ui-icon-circle-minus');
	jQuery('#expander_options').toggleClass('ui-state-default');
	jQuery('#expander_options').toggleClass('ui-state-active');
}