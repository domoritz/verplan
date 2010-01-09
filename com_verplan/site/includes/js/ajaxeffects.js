/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 21-Nov-2009
 */

var speed = 500;
var effects = true;
var effects_indi = true;

var note_loader;

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
		jQuery('#loading').fadeIn('fast');
		//jQuery('#loader_overlay').fadeIn('fast');
		
		showHint('Lade Daten...', 'info', '250px', 'loady');
		
		if (notify == 'pnotify' || notify == 'both') {
			note_loader = jQuery.pnotify({
				pnotify_title: "Lade Daten...",
				pnotify_text: "Daten des Vertretungsplanes werden geladen. Bitte warten.",
				//pnotify_notice_icon: '',
				pnotify_hide: false,
				pnotify_history: false
			});
		}

	}
}

function hideIndicator() {
	if (effects_indi) {
		jQuery('#loading').pause(500).fadeOut(1000);
		//jQuery('#loader_overlay').pause(0).fadeOut(1500);		
		
		hideHint(1500);
		
		setTimeout(function(){
			// Remove the loader.
			if (note_loader) {
				note_loader.pnotify_remove();
			}			
		}, 2000);

	}
}

function showTable() {
	if (effects) {
		jQuery('#jquerytable tbody')
		//.slideDown(speed)
		//.show('blind',speed)
		.fadeIn(speed)
		;
		jQuery('#miniindi').hide();
	}
}

function hideTable() {
	if (effects) {
		jQuery('#jquerytable tbody')
		//.slideUp(speed)
		//.hide('blind',speed)
		.fadeOut(speed,ajaxCall)
		;
		jQuery('#miniindi').show();
	}
}

function ajaxcomplete() {
	jQuery('#miniindi').hide();
}

