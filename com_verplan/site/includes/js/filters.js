/**
 * js datei, in der alles zu dem filter und klassenfilter des frontends steht
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 27-Nov-2009
 */



/*
 * klasse, die gefiltert werden soll, der wert wird nur gespeichert, wenn 
 * es vertretungsen für die klasse gibt, da sonst die auswahlmöglichkeit nciht besteht
 * und nach diesem select (#klasse) der cookie gesetzt wird
 */
var filterKlasse = jQuery.cookie('Klasse');
if (filterKlasse == null) {
	filterKlasse = '';
}

/**
 * intervall für hint listener
 */
var myInterval;

/**
 * für notify
 */
var note_filter, note_filter_general, note_klasse;

function iniFilters() {
	
	//clearable input
	jQuery('#filter_input').clearableTextField();
	
	
	/*
	 * tablefilter
	 * http://plugins.jquery.com/project/uiTableFilter
	 */

	//falls sich in dem eingabefeld des filters etwas ändert
	jQuery("#filter_input").keyup(function() {	
		jQuery('#klasse').val('');
		removeCookie();
		
		//note ausblenden
		if (note_klasse) {
			note_klasse.pnotify_remove();
		}
		
		//ruft die funktion filter auf
		filterTable();
	});
	
	
	//falls sich bei filter this etwas ändert
	jQuery('#filter_this').change(function(){
		//console.log('filter_this change');
		
		jQuery('#klasse').val('');
		removeCookie();
		
		//note ausblenden
		if (note_klasse) {
			note_klasse.pnotify_remove();
		}		
		
		jQuery('#filter_input').val(null).change();
		filterTable();
	});
	
	//falls sich etwas in der select klasse ändert
	jQuery('#klasse').change(function(){
		//console.log('klasse change ' + this.value);
		
		//note ausblenden
		if (note_klasse) {
			note_klasse.pnotify_remove();
		}
		
		//bei all soll nichts gefiltert werden
		if (this.value == '') {
			jQuery("#filter_this").val('');
			removeCookie();
		} else {
			jQuery("#filter_this").val(settings.class_col.value);
			//speichere cookie und variable
			jQuery.cookie('Klasse', this.value, {expires: 7});
			filterKlasse = this.value;
			console.log('cookie gespeichert: ' + this.value);
			
			if (notify == 'pnotify' || notify == 'both') {
				note_klasse = jQuery.pnotify({
				    pnotify_title: 'Klasse',
				    pnotify_text: 'Es werden nur die Spalten der Klasse '+this.value+' angezeigt. <a href="http://code.google.com/p/verplan/wiki/Benutzerhandbuch_Frontend#Filter_-_Klassen" target="_blank">Hilfe</a>',
				    pnotify_notice_icon: 'ui-icon ui-icon-search',
				    pnotify_type: 'notice',
				    pnotify_remove: true,
				    pnotify_hide: false
				});
			}
		}
		
		//zeigt das rote icon und schreibt die klasse
		jQuery('#filter_input').val(this.value).change();
		
		//filtern
		filterTable();
		
	});
}

/**
 * filtert die tabelle
 */
function filterTable() {
	//filter this - spalte, nach der gefiltert wird
	var filter_this = jQuery('#filter_this').val();
	
	//das inputfeld als quelle
	var input = jQuery('#filter_input').val();
	
	//debug
	//console.log('Filter: '+filter_this+' '+ input);
	
	//tabelle filtern
	jQuery.uiTableFilter(jQuery('#jquerytable'), input, filter_this);
	
	if (notify == 'pnotify' || notify == 'both') {
		if (input != '' & !(note_filter_general)) {
			note_filter_general = jQuery.pnotify({
			    pnotify_text: 'Ein Filter ist aktiv. <a href="http://code.google.com/p/verplan/wiki/Benutzerhandbuch_Frontend#Filter" target="_blank">Hilfe</a>',
			    pnotify_notice_icon: 'ui-icon ui-icon-search',
			    pnotify_type: 'notice',
			    pnotify_remove: true,
			    pnotify_hide: false
			});
		}
		
		if (input == '') {
			if (note_filter_general) {
				note_filter_general.pnotify_remove();
				note_filter_general = null;
			}	
		}
	}
	
	
	hideHint(0);
	
	if (note_filter) {
		note_filter.pnotify_remove();
	}	
}

/**
 * lösche den cookie mit klasse
 */
function removeCookie(){
	//lösche cookie
	jQuery.cookie('Klasse', null);
	filterKlasse = '';
	console.log('cookie gelöscht');
}

/**
 * dies wird aufgerufen, wenn sich z.b. per ajax die tabelle ändert
 * oder am anfang die filterung geladen werden soll
 */
function updateFilters() {
	
	//lädt die klasse in die auswahlliste klasse
	jQuery("#klasse").val(filterKlasse);
	if (filterKlasse == '') {
	} else {
		jQuery("#filter_this").val(settings.class_col.value);
		jQuery("#filter_input").val(filterKlasse);
	}
	
	//zeigt das rote icon und schreibt die klasse
	jQuery('#filter_input').change();
	
	//filtern
	var filter_this = jQuery('#filter_this').val();
	var input = jQuery('#filter_input').val();
	jQuery.uiTableFilter(jQuery('#jquerytable'), input, filter_this);
	
	if (notify == 'pnotify' || notify == 'both') {
		if (jQuery('#filter_input').val() != '') {	
			if (note_filter) {
				note_filter.pnotify_remove();
			}
			note_filter = jQuery.pnotify({
			    pnotify_title: 'Filter aktiv',
			    pnotify_text: 'Es werden Spalten ausgeblendet, weil ein Filter aktiv ist. Wenn du wieder alle Spalten sehen möchtest, klicke bitte <a href="javascript: clickOnClear()">hier</a><br><a href="http://code.google.com/p/verplan/wiki/Benutzerhandbuch_Frontend#Filter" target="_blank">Hilfe</a>',
			    pnotify_error_icon: 'ui-icon ui-icon-search',
			    pnotify_type: 'error',
			    pnotify_hide: false
			});
		}
	}
	
	//falls spalten gefiltert werden, soll darauf gewartet werden, dass kein hinweis 
	//angezeigt wird und dann soll der eigene hinweis angezeigt werden
	
	if (jQuery('#filter_input').val() != '') {	
		if (notify == 'own' || notify == 'both') {
			clearInterval(myInterval);
			
			console.log('start listener');
			myInterval = setInterval(function() {
				console.log('wait for hint');
				if (hintshown == false) {
					clearInterval(myInterval);
					hintshown == true;
					setTimeout("showHint('Es werden Spalten ausgeblendet, weil ein Filter aktiv ist', 'warn', '420px', 'filty');",500);
				}
			},100);
		}
	}
}

/**
 * funktion, die ausgeführt wird, wenn auf das rote icon
 * geklickt wird
 */
function clickOnClear() {
	jQuery('#klasse').val('').change();
}