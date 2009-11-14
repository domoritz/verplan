/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 14-Nov-2009
 */

/**
 * initialisierung
 */
jQuery(document).ready(function(){
	//rooturl der joomlainstallation
	rooturl = getURL();
	
	//tabellenplugins initialiseren
	table_init();

	/**
	 * ajax
	 */

	//lade tabelle
	if (!gup('date')) {
		loadJsonTable(false, true);
	}

	//falls sich im select etwas ändert
	jQuery('#select_date').change(function(){
		loadJsonTable(false, true);
	});

});

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
 * jQuery queue Funktion zur 
 * zeitverzögerung
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
 * holt den hashwert aus der URL
 * 
 * @return hash string
 */
function getHash() {
	return window.location.hash;
}

/**
 * setzt den hashwert der url
 * 
 * @param hash der gestezt werden soll
 * @return hash der url
 */
function setHash(hash) {
	window.location.hash = hash;
	
	return window.location.hash;
}