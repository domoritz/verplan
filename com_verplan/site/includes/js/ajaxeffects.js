/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 21-Nov-2009
 */

var speed = 2000;
var effects = true;
var effects_indi = true;

function hideNoDB() {
	if (jQuery('#no_db').css('display') != 'none') {
		if (effects) {
			jQuery('#no_db').hide('blind', speed);
		} else {
			jQuery('#no_db').hide();
		}
	}
}

function showNoDB() {
	if (effects) {
		jQuery('#no_db').show('blind', speed);
	} else {
		jQuery('#no_db').show();
	}
}

function showIndicator() {
	if (effects_indi) {
		// jQuery('#loading').fadeIn('fast');
		jQuery('#loader_overlay').fadeIn('fast');
	}
}

function hideIndicator() {
	if (effects_indi) {
		// jQuery('#loading').pause(500).fadeOut(1000);
		jQuery('#loader_overlay').pause(0).fadeOut(1500);
	}
}

function showTable() {
	if (effects) {
		jQuery('#jquerytable tbody')
		//.slideDown(speed)
		//.show('blind',speed)
		.fadeIn(speed)
		;
	}
}

function hideTable() {
	if (effects) {
		jQuery('#jquerytable tbody')
		//.slideUp(speed)
		//.hide('blind',speed)
		.fadeOut(speed)
		;
	}
}

