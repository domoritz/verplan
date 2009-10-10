/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 2-Oct-2009
 */
jQuery(document).ready(function(){
	//versteckt optionen
	jQuery('#options_div').hide('');
	jQuery('#options_header').click(function() {
		//wechsel des icons
		jQuery('#options_div').toggle('blind','normal');
		jQuery(this).toggleClass('plus').toggleClass('minus');
	});
});