/**
 * @version $Id$
 * @package verplan
 * @author Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link http://code.google.com/p/verplan/
 * @license GNU/GPL
 * @author Created on 14-Nov-2009
 */

/**
 * It will cause Javascript errors, terminating the execution of the block of Javascript containing the error. 
 * You could, however, define a dummy function that's a no-op when Firebug is not active:
 * 
 * diese zeilen lenken die consolenausgaben ins leere, falls keine console vorhanden ist. 
 * das ist wichtig, weil es sonst zu js fehlern kommt. 
 */
var debugging = getDebug(); // true -> an; false -> aus
if (typeof console == "undefined") { 
	var console = { 
		log: function() {},
		time: function() {},
		timeEnd: function() {} 
	};
} else if (!debugging && typeof console.log != "undefined") {
	console.log = function() {};
	console.time = function() {};
	console.timeEnd = function() {};
}

/**
 * hash ist der teil der url nach dem #
 * diser wird nur vom browser interpretiert und kann nicht
 * vom server gelesen werden (also auch nicht von php)
 */
var hash;

/**
 * für umleitung des alert
 */
var _alert;

jQuery(document).ready(function(){
	
	// setzt den hashwert, falls er noch nicht gesetzt ist
	hash = getHash();
	if (!hash) {
		hash = jQuery('#select_date_verplan').val();
		setHash(hash);
	}
	
	// startet anschließend initiate_everything
	getSettings();
});

/**
 * initialisierung, gestartet von settings.js aus
 */
function initiate_everything(){	
	console.log('initiate everything');
	
	if ((notify == 'pnotify' || notify == 'both') && settings.message_title.value != '') {
		//Meldung
		jQuery.pnotify({
			pnotify_title: settings.message_title.value,
			pnotify_text: settings.message.value,
		    //pnotify_title: 'Vorabversion',
		    //pnotify_text: 'Hey, du benutzt eine <strong>Vorabversion</strong>. Damit Fehler behoben werden und das Programm verbessert wird, gib bitte dein <a title="Feedbackbogen" href="http://spreadsheets.google.com/viewform?formkey=dGdDanZxa2k4RHhKbHJaS1RxT0Q2eWc6MA" target="_blank" id="feedy_oi"><strong>Feedback</strong></a> ab. Jedes einzelne ist wichtig für mich. <br>Vielen Dank und viel Spaß',
		    pnotify_notice_icon: 'ui-icon ui-icon-star',
		    pnotify_type: 'notice',
		    pnotify_hide: false
		});
		
		//alerts umleiten
		consume_alert();
	}	
	
	// rooturl der joomlainstallation
	rooturl = getURL();
	hash = getHash();
	
	// tabellenplugins initialiseren
	table_init();
	
	//neu laden, wenn man auf das logo klickt
	jQuery('#logo_verplan').click(function() {
		window.location.hash = '';
		window.location.href=window.location.href.slice(0, -1);
	});
	
	if (notify == 'pnotify' || notify == 'both') {
		//klicks anzeigen
		clicks_notice();
	}

	/**
	 * ajax
	 */

	/*
	 * lade tabelle falls url nicht gestezt if (!gup('date')) {
	 * loadJsonTable(false, true); }//
	 */
	
	// setzt den hashwert, falls er noch nicht gesetzt ist
	/*if (!hash) {
		hash = jQuery('#select_date_verplan').val();
		setHash(hash);
	}*/
	
	// Check if url hash value exists (for bookmark)
	// und initialisierung der historyfunktion
	jQuery.historyInit(loadverplan,'index.php');

}

/**
 * initialisierung (aufgerufen von history)
 * @param hash
 * @return
 */
function loadverplan(hash) {
	console.log('loadverplan');
	
	//die intervalle beenden, die darauf warten, dass eine nachricht ausgeblendet wird
	//clearInterval(myInterval);
	//clearInterval(myInterval2);
	
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
	ajax_stand = jQuery('#verplan_form [name=stand]').val();
	ajax_options = jQuery('#verplan_form [name=options]').val();
	
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
 * zeigt benachrichtigungen bei clicks auf links
 * @return
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
		    pnotify_text: 'Die Homepage wurde aufgerufen.<br>Link: <a href="http://www.dmoritz.bplaced.net">http://www.dmoritz.bplaced.net</a>',
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
 * @param zeit
 *            in ms
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


/*own notification system*/

/**
 * variable, die anzeigt, ob ein hinweis angezeigt wird
 */
var hintshown = false;


/**
 * zeigt eine benachrichtigung
 * 
 * @param text Nachrichtentext
 * @param type warnung, info oder kritisch
 * @param width breite der nachricht
 * @param name name attribut
 * 
 * @return
 */
function showHint(text, type, width, name) {
	if (notify == 'own' || notify == 'both') {
		hintshown = true;
		
		console.log('hintshown');
		
		if (!width) {
			width = '400px';
		}
		
		if (type == 'warn') {
			text = '<span class="icon_verplan icon_warn">&nbsp;</span><strong>Achtung:</strong> ' + text;
		}
		
		if (type == 'info') {
			text = '<span class="icon_verplan icon_info">&nbsp;</span><strong>Info:</strong> ' + text;
		}
			
		if (type == 'critical') {
			text = '<span class="icon_verplan icon_critical">&nbsp;</span><strong style="color: red; ">Kritischer Fehler:</strong> ' + text;
		}
			
		jQuery('#notify #text').html(text).parent().css('width', width).css('left', 0).attr('name', name).show('slide', {direction: 'right'}, 500); 
		
		console.log(type+' '+text+' '+width+' '+name);
	}
}

/**
 * lässt den hinweis hinausfahren
 * @return
 */
function hideHint(time) {
	if (notify == 'own' || notify == 'both') {
		if (hintshown == true) {
			jQuery('#notify:visible').stop().pause(time).hide('slide', {direction: 'right'}, 1000, function() {
				console.log('hinthidden');
				hintshown = false;
			});
		}
	}
}