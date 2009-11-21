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

var date;
var stand;
var options;


function getAndUseJSON() {	
	/*
	 * hidetable hat als Callback ajaxCall, welches wiederum JSONsuccsss
	 * aufruft. von dort aus wird dann show table aufgerufen (falls type=db)
	 * 
	 * hideTable()->ajaxCall()->JSONsuccess()+buildTable->showTable()
	 */
	hideTable();
	
}

function ajaxCall() {
	jQuery.ajax( {
		type : "GET",
		dataType : "json",
		url : rooturl + "index.php",
		data : 'option=com_verplan&view=verplan&format=js&date=' + date
				+ '&stand=' + stand + '&options=' + options,
		timeout : 5000,
		async : true,
		global : true,
		success : function(XMLHttpRequest, textStatus) {
			JSONsuccess(XMLHttpRequest, textStatus);
		},
		error : function(XMLHttpRequest, textStatus, errorThrown) {
			// typically only one of textStatus or errorThrown
		// will have info
		alert(textStatus + '<br>' + errorThrown); // the options for this ajax
													// request
	}
	});
}

function JSONsuccess(json, textStatus) {
	console.log('JSON status: ' + textStatus);

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
		
		showTable();

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
	// tabelle leeren
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