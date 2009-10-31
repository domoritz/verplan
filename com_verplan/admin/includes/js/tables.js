/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 31-Oct-2009
 */
jQuery(document).ready(function(){
	jQuery('#columntable').tablesorter({
		dateFormat:'de',
		decimal: ',',
		debug: false,
		sortMultiSortKey:'ctrlKey',
		textExtraction:'complex',
		cssDesc: 'ui-state-active headerSortDown',
		cssAsc: 'ui-state-active headerSortUp',
		//zebra
		widgets: ['zebra'],
		widgetZebra: {css: ["even","odd"]}
	});	
});