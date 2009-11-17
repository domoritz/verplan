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
	jQuery('#options_panel').hide('');
	jQuery('#expander_options').click(function() {
		//wechsel des icons
		jQuery('#options_panel').slideToggle(600);
		jQuery('#icon_options').toggleClass('ui-icon-circle-plus').toggleClass('ui-icon-circle-minus');
		jQuery('#expander_options').toggleClass('ui-state-default');
		jQuery('#expander_options').toggleClass('ui-state-active');
	});
});