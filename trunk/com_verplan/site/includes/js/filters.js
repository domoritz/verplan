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
	
	//behebt problem, dass kreuz an falscher stelle ist, indem das panel
	//mit den erweiterten einstellungen geöffnet wird, wenn es so sein soll
	if (filterKlasse != '') {
		if (!jQuery('#options_panel').is(':visible')) {
			jQuery('#options_panel').show();
		}
	}
	
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
		
		//ruft die funktion filter auf
		filterTable();
	});
	
	
	//falls sich bei filter this etwas ändert
	jQuery('#filter_this').change(function(){
		//console.log('filter_this change');
		
		jQuery('#klasse').val('');
		removeCookie();	
		
		jQuery('#filter_input').val(null).change();
		filterTable();
	});
	
	//falls sich etwas in der select klasse ändert
	jQuery('#klasse').change(function(){
		//console.log('klasse change ' + this.value);
		
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
		}
		
		//zeigt das rote icon und schreibt die klasse
		jQuery('#filter_input').val(this.value).change();
		
		//filtern
		filterTable();
		
		jQuery('#nachrichtenbereich_tabelle_nachricht').html("Es werden nur die Zeilen der Klasse "+this.value+" angezeigt");
		
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
	
	var size = jQuery('#jquerytable tbody tr:visible').size();
	if (input != '' && (size < num_cols)){

		if (num_cols - size == 1) {
			var werden_wird = "wird";
		} else {
			var werden_wird = "werden";
		}
		jQuery('#nachrichtenbereich_tabelle_nachricht').html("Es "+werden_wird+" "+(num_cols - size)+" von "+num_cols+" Zeilen nicht angezeigt");
		jQuery('#nachrichtenbereich_tabelle').not(':visible').slideDown('fast');
		
	} else {
		jQuery('#nachrichtenbereich_tabelle:visible').slideUp('fast');
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
	
	//filtern, ersetzt
	/*var filter_this = jQuery('#filter_this').val();
	var input = jQuery('#filter_input').val();
	jQuery.uiTableFilter(jQuery('#jquerytable'), input, filter_this);*/
	
	filterTable();
	
	if (filterKlasse!= "") {
		jQuery('#nachrichtenbereich_tabelle_nachricht').html("Es werden nur die Zeilen der Klasse "+filterKlasse+" angezeigt");
	}
}

/**
 * funktion, die ausgeführt wird, wenn auf das rote icon
 * geklickt wird
 */
function clickOnClear() {
	jQuery('#klasse').val('').change();
}