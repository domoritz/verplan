/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 30-Oct-2009
 */
jQuery(document).ready(function(){
	
	//wenn daten geändert werden
	jQuery('#columntable input').change(function() {
		jQuery(this).parent().parent().addClass('highlight');
	});
	
	jQuery('#columntable select').change(function() {
		jQuery(this).parent().parent().addClass('highlight');
	});
	
	//bei reset
	jQuery('#columntable input:reset').click(function() {
		jQuery(this).parent().parent().removeClass('highlight');
	});
});