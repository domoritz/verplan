/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 31-Oct-2009
 */
jQuery(document).ready(function(){
	
	//zebra noch bevor einmal sortiert
	jQuery("#columntable tr:not([th]):even").addClass("row0");
	jQuery("#columntable tr:not([th]):odd").addClass("row1"); 
	
	//sortierung für die tabelle columns in admin
	jQuery('#columntable').tablesorter({
		dateFormat:'de',
		decimal: ',',
		debug: false,
		sortMultiSortKey:'ctrlKey',
		textExtraction:'complex',
		cssDesc: '',
		cssAsc: '',
		//zebra
		widgets: ['zebra'],
		widgetZebra: {css: ["row0","row1"]}
	});	
	
});