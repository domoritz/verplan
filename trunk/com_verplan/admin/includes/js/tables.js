/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 31-Oct-2009
 */
jQuery(document).ready(function(){
	
	//zebra
	jQuery("#columntable tr:not([th]):even").addClass("row0");
	jQuery("#columntable tr:not([th]):odd").addClass("row1"); 
	
	
	//alle speichern
	jQuery('#save_all_cols').click(function() {
		//wählt nur die, die euch geändert wurden
		jQuery('#columntable tr.highlight').children('form').submit();
	});
	
});