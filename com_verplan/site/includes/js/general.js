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
var debugging = true; // true -> an; false -> aus
if (typeof console == "undefined") { 
	var console = { 
		log: function() {},
		time: function() {},
		timeEnd: function() {} 
	};
} else if (!debugging || typeof console.log == "undefined") {
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
 * initialisierung
 */
jQuery(document).ready(function(){
	// rooturl der joomlainstallation
	rooturl = getURL();
	hash = getHash();
	
	// tabellenplugins initialiseren
	table_init();

	/**
	 * ajax
	 */

	/*
	 * lade tabelle falls url nicht gestezt if (!gup('date')) {
	 * loadJsonTable(false, true); }//
	 */
	
	// setzt den hashwert, falls er noch nicht gesetzt ist
	if (!hash) {
		hash = jQuery('#select_date').val();
		setHash(hash);
	}
	
	// Check if url hash value exists (for bookmark)
	// und initialisierung
	jQuery.history.init(initverplan);

});

function initverplan(hash) {
	
	// bei select das richtige auswählen
	jQuery("#select_date option").attr('selected', '');
	jQuery("#select_date option[value='"+hash+"']").attr('selected', 'selected');
	
	var selected = document.getElementById("select_date").selectedIndex;
	jQuery('#select_date').selectmenu('value',selected); 
	
	
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