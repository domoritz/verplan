/**
 * dieses script enthält die grundlegenden funktionen
 * von hier aus wird auch die initialisierung gestartet
 * 
 * sehr wichtig ist die funktion loadverplan, die durch das 
 * jQuery history plugin aufgerufen wird
 * mehr dazu: http://www.mikage.to/jquery/jquery_history.html
 * 
 * @version $Id$
 * @package verplan
 * @author  Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link    http://code.google.com/p/verplan/
 * @license GNU/GPL
 * @author  Created on 14-Nov-2009
 */


/**
 * hash ist der teil der url nach dem #
 * diser wird nur vom browser interpretiert und kann nicht
 * vom server gelesen werden (also auch nicht von php)
 */
var hash;

/**
 * variable, welche zeigt, welches benachrichtigungssystem benutzt werden soll
 */
var notify;

/**
 * für umleitung des alert
 */
var _alert;

//initialisiert alles, nachdem das dokument fertig geladen wurde
jQuery(document).ready(function(){
	
	//weiterleitung, wenn unter ie7
	if (browserLessThanIE7()) {
		var redirect = confirm("Du benutzt den völlig veralteten Internetexplorer 6. Diser Browser wird offiziell nicht unterstützt.\nBitte update deinen Browser oder nutze die eingeschränkte Seite. \nWillst du auf die eingeschränkte Seite weitergeleitet werden?");
		if (redirect) {
			window.location.replace(rooturl+'?option=com_verplan&view=mobile');
		}
	}
	
	// setzt den hashwert, falls er noch nicht gesetzt ist
	hash = getHash();
	if (!hash) {
		hash = jQuery('#select_date_verplan').val();
		setHash(hash);
	}
	
	//startet anschließend initiate_everything
	//getSettings();
	initiate_everything();
});

/**
 * initialisierung, gestartet von settings.js aus
 */
function initiate_everything(){	
	
	notify = settings.notify.value;
	
	if ((notify == 'pnotify' || notify == 'both') && settings.message_title.value != '') {
		
		//Meldung
		jQuery.pnotify({
			pnotify_title: settings.message_title.value,
			pnotify_text: settings.message.value,
			pnotify_notice_icon: 'ui-icon ui-icon-star',
		    pnotify_type: 'notice',
		    pnotify_hide: true,
		    pnotify_delay: 20000
		});
		
		//alerts auf pnotify umleiten
		//consume_alert();
	}
	
	hash = getHash();
	
	// tabellenplugins initialiseren
	table_init();
	
	//gesamte seite neu laden, wenn man auf das logo klickt
	jQuery('#logo_verplan').click(function() {
		window.location.hash = '';
		window.location.href=window.location.href.slice(0, -1);
	});
	
	//plan neu laden, bei klick auf refresh
	jQuery('#refresh').click(function() {
		jQuery.historyLoad(getHash());
	});
	
	if (notify == 'pnotify' || notify == 'both') {
		//klicks anzeigen
		clicks_notice();
	}

	/**
	 * ajax
	 */
	
	// Check if url hash value exists (for bookmark)
	// und initialisierung der historyfunktion
	jQuery.historyInit(loadverplan,'index.php');
}

/**
 * initialisierung (aufgerufen von history)
 * @param hash
 */
function loadverplan(hash) {	
	//die intervalle beenden, die darauf warten, dass eine nachricht ausgeblendet wird
	clearInterval(myInterval);
	clearInterval(myInterval2);
	
	if (notify == 'pnotify' || notify == 'both') {
		//kein plan nachricht ausblenden
		if (note_noplan) {
			note_noplan.pnotify_remove();
		}
		
		//fehler nachricht ausblenden
		if (note_error_load) {
			note_error_load.pnotify_remove();
		}
		
		//filter nachricht ausblenden
		if (note_filter_general) {
			note_filter_general.pnotify_remove();
		}
		
		//nodb nachricht ausblenden
		if (note_nodb) {
			note_nodb.pnotify_remove();
		}
		
		//db nachricht ausblenden
		if (note_db) {
			note_db.pnotify_remove();
		}
		
		//lade nachricht ausblenden
		if (note_loader) {
			note_loader.pnotify_remove();
		}
	}
	
	// bei select das richtige auswählen
	jQuery("#select_date_verplan option").attr('selected', '');
	jQuery("#select_date_verplan option[value='"+hash+"']").attr('selected', 'selected');
	
	var selected = document.getElementById("select_date_verplan").selectedIndex;
	jQuery('#select_date_verplan').selectmenu('value',selected);
	
	
	// json laden und tabelle anzeigen
	
	//einstellungen für verplan api
	ajax_stand = 'latest';
	ajax_options = ',min';
	
	getAndUseJSON(hash, ajax_stand, ajax_options);
}

/**
 * funktion, die urlparameter ausliest
 * http://www.netlobo.com/url_query_string_javascript.html
 */
function gup( name )
{
	name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp( regexS );
	var results = regex.exec( window.location.href );
	if( results == null )
		return false;
	else
		return results[1];
}

/**
 * leitet alle alerts in pnotify um
 * @return
 */
function consume_alert() {
	if (_alert) return;
	_alert = window.alert;
	window.alert = function(message) {
		jQuery.pnotify({
			pnotify_title: 'Alert',
			pnotify_text: message
		});
	};
}

/**
 * macht consume_alert() rückgängig
 * @return
 */
function release_alert() {
	if (!_alert) return;
	window.alert = _alert;
	_alert = null;
}

/**
 * zeigt benachrichtigungen bei klicks auf links
 */
function clicks_notice() {
	//auf handbuch klicken
	jQuery('#help_head').click(function() {
		note_filter_general = jQuery.pnotify({
			pnotify_title: 'Handbuch',
		    pnotify_text: 'Das Handbuch wurde geöffnet.<br>Link: <a href="http://code.google.com/p/verplan/wiki/Benutzerhandbuch_Frontend">http://code.google.com/p/verplan/wiki/Benutzerhandbuch_Frontend</a>',
		    pnotify_notice_icon: 'ui-icon ui-icon-link',
		    pnotify_type: 'notice'
		});
	});
	
	//auf website klicken
	jQuery('#link_homepage').click(function() {
		note_filter_general = jQuery.pnotify({
			pnotify_title: 'Website',
		    pnotify_text: 'Die Homepage wurde aufgerufen.<br>Link: <a href="http://www.dmoritz.bplaced.de">http://www.dmoritz.bplaced.de</a>',
		    pnotify_notice_icon: 'ui-icon ui-icon-link',
		    pnotify_type: 'notice'
		});
	});
	
	//auf website klicken
	jQuery('#link_project').click(function() {
		note_filter_general = jQuery.pnotify({
			pnotify_title: 'Projektseite',
		    pnotify_text: 'Die Projektseite wurde geöffnet.<br>Link: <a href="http://verplan.googlecode.com">http://verplan.googlecode.com</a>',
		    pnotify_notice_icon: 'ui-icon ui-icon-link',
		    pnotify_type: 'notice'
		});
	});
	
	//auf feedback klicken
	jQuery('#feedy_oi').click(function() {
		note_filter_general = jQuery.pnotify({
			pnotify_title: 'Feedbackbogen',
		    pnotify_text: 'Der Feedbackbogen wurde geöffnet.<br>Link: <a href="http://verplan.googlecode.com">http://verplan.googlecode.com</a>',
		    pnotify_notice_icon: 'ui-icon ui-icon-link',
		    pnotify_type: 'notice'
		});
	});
	
	
	//auf link klicken
	/*jQuery('a').click(function() {
		if (jQuery(this).attr('href') != '#') {
			note_filter_general = jQuery.pnotify({
				pnotify_title: 'Link',
			    pnotify_text: 'Die Seite "'+jQuery(this).attr('href')+'" wurde geöffnet.',
			    pnotify_notice_icon: 'ui-icon ui-icon-link',
			    pnotify_type: 'notice'
			});
		}
	});*/
}

/**
 * jQuery queue Funktion zur zeitverzögerung
 * 
 * @param zeit in ms
 */
jQuery.fn.pause = function (n) {
	return this.queue(function () {
		var el = this;
		setTimeout(function () {
			return jQuery(el).dequeue();
		}, n);
	});
};

/**
 * holt den hashwert aus der URL ohne #
 * 
 * @return hash string
 */
function getHash() {
	var hash = window.location.hash.substr(1,document.location.hash.length);
	console.log('hash: '+hash);
	return hash;
	// hash = window.location.hash;
	// return hash.replace(/^.*#/, '');
}

/**
 * setzt den hashwert der url
 * 
 * @param hash, der gestezt werden soll
 * @return hash der url
 */
function setHash(hashP) {
	hash = hashP;
	window.location.hash = hash;
	console.log('setHash '+hash+' | '+window.location.hash);
	return window.location.hash;
}


/**
 * Good for serializing animations
 */
jQuery.fn.chain = function(fn) {
  var elements = this;
  var i = 0;
  function nextAction() {
    if (elements.eq(i)) fn.apply(elements.eq(i), [nextAction]);
    i++;
  }
  nextAction();
};

//ie6 erkennung
function browserLessThanIE7(){
   return (/MSIE ((5\\.5)|6)/.test(navigator.userAgent) && navigator.platform == "Win32");
}