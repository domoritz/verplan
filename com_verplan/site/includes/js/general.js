/**
 * @version $Id$
 * @package verplan
 * @author Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link http://code.google.com/p/verplan/
 * @license GNU/GPL
 * @author Created on 14-Nov-2009
 */

/**
 * initialisierung
 */
jQuery(document).ready(function(){
	// rooturl der joomlainstallation
	rooturl = getURL();
	
	// tabellenplugins initialiseren
	table_init();

	/**
	 * ajax
	 */

	/*
	 * lade tabelle falls url nicht gestezt if (!gup('date')) {
	 * loadJsonTable(false, true); }//
	 */
	
	var hash = getHash();
	
	// lade tabelle, falls hash nicht gesetzt
	if (!hash) {
		setHash(jQuery('#select_date').val());
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
	var date = getHash();
	var stand = jQuery('#verplan_form [name=stand]').val();
	var options = jQuery('#verplan_form [name=options]').val();
	
	getAndUseJSON(date, stand, options);
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
	return window.location.hash.substr(1,document.location.hash.length);
	// hash = window.location.hash;
	// return hash.replace(/^.*#/, '');
}

/**
 * setzt den hashwert der url
 * 
 * @param hash
 *            der gestezt werden soll
 * @return hash der url
 */
function setHash(hash) {
	window.location.hash = hash;
	
	return window.location.hash;
}