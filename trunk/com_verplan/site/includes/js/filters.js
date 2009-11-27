/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
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
		
		//ruft die funktion filter auf
		filterTable();
	});
	
	
	//falls sich bei filter this etwas ändert
	jQuery('#filter_this').change(function(){
		console.log('filter_this change');
		
		jQuery('#klasse').val('');
		jQuery('#filter_input').val(null).change();
		filterTable();
	});
	
	//falls sich etwas in der select klasse ändert
	jQuery('#klasse').change(function(){
		console.log('klasse change');
		
		//bei all soll nichts gefiltert werden
		if (this.value == '') {
			jQuery("#filter_this").val('');
			//lösche cookie
			jQuery.cookie('Klasse', null);
			filterKlasse = '';
			console.log('cookie gelöscht');
		} else {
			jQuery("#filter_this").val(getColname());
			//speichere cookie und variable
			jQuery.cookie('Klasse', this.value, {expires: 7});
			filterKlasse = this.value;
			console.log('cookie gespeichert: ' + this.value);
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
	console.log('Filter: '+filter_this+' '+ input);
	
	//tabelle filtern
	jQuery.uiTableFilter(jQuery('#jquerytable'), input, filter_this);
}

/**
 * dies wird aufgerufen, wenn sich z.b. per ajax die tabelle ändert
 * oder am anfang die filterung geladen werden soll
 * @return
 */
function updateFilters() {
	//lädt die klasse in die auswahlliste klasse
	jQuery('#klasse').val(filterKlasse).change();
	
	if (jQuery('#filter_input').val() != '') {
		slideHint('Es werden Spalten ausgeblendet, weil ein Filter aktiv ist', 'warn', '400px');
	}
}

/**
 * funktion ,die ausgeführt wird, wenn auf das rote icon
 * geklickt wird
 * @return
 */
function clickOnClear() {
	jQuery('#klasse').val('').change();
}