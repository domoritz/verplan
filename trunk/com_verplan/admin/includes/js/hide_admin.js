/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 2-Oct-2009
 */
jQuery(document).ready(function(){
	jQuery('#admin_settings_div').hide('');
	jQuery('#options_header').click(function() {
		jQuery('#admin_settings_div').toggle('blind','normal');
		jQuery(this).toggleClass('plus').toggleClass('minus');
	});
});