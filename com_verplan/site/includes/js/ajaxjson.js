/**
 * @version $Id$
 * @package verplan
 * @author Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link http://code.google.com/p/verplan/
 * @license GNU/GPL
 * @author Created on 21-Nov-2009
 */

jQuery(document).ajaxSend(function() {
	showIndicator();
});

jQuery(document).ajaxStop(function() {
	hideIndicator();
});

function getAndUseJSON(date, stand, options) {
	jQuery.getJSON(rooturl
			+ 'index.php?option=com_verplan&view=verplan&format=js&date='
			+ date + '&stand=' + stand + '&options=' + options, function(json,
			textstatus) {
		JSONsuccess(json, textstatus);

	});
}

function JSONsuccess(json, textstatus) {
	console.log('JSON status: ' + textstatus);

	// holt aus dem array immer die neuesten infos (höchster
	// wert)
	var infoarr = json.infos;
	var length = infoarr.length - 1;

	// wenn der typ datenbank ist
	if (json.infos[length].type == 'db') {

		// falls bisher der link zum plan angezeigt wurde
		hideNoDB();

		// baut die tabelle zusammen
		buildTableFromJSON(jQuery('#jquerytable tbody'), json.rows);

		// update der plugins
		table_update();
	} else {
		jQuery('#no_db')
				.html(
						'<a href="' + json.infos[length].url + '">zum Vertretungsplan...</a>');
		showNoDB();
	}
}

function buildTableFromJSON(tbody, json) {
	//tabelle leeren
	jQuery('#jquerytable tbody').html('');
	
	var table = '';
	jQuery.each(json, function() {
		table = '<tr>';
		jQuery.each(this, function(name, content) {
			table += '<td title="' + name + '">';
			// console.log(a,b);
				table += (content) ? content : '';
				table += '</td>';
			});
		table += '</tr>';

		// tabellenzeile anhängen
			tbody.append(table);
		});

}