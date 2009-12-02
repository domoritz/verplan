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

var ajax_date;
var ajax_stand;
var ajax_options;

//intervall zum warten, dass keine nachricht angezeigt wird
var myInterval2;

function getAndUseJSON(date, stand, options) {
	ajax_date = date;
	ajax_stand = stand;
	ajax_options = options;
	
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
		data : 'option=com_verplan&view=verplan&format=js&date=' + ajax_date
				+ '&stand=' + ajax_stand + '&options=' + ajax_options,
		timeout : 4000,
		async : true,
		global : true,
		success : function(XMLHttpRequest, textStatus) {
			console.log(textStatus);
			if (XMLHttpRequest.infos == '') {
				JSONfail(XMLHttpRequest, textStatus);
			} else {
				JSONsuccess(XMLHttpRequest, textStatus);
			}
		},
		error : function(XMLHttpRequest, textStatus, errorThrown) {
			alert(textStatus + '<br>' + errorThrown); 
		}
	});
}

function JSONsuccess(json, textStatus) {
	
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
		
		//filter für die klassen
		filterKlassen(json.rows);
		
		// update der plugins
		table_update();
		
	} else if (json.infos[length].type == 'none') {
		jQuery('#no_db')
		.html('Hurra! Keine Vertretungen für diesen Tag <br>(Stand: '+ json.infos[length].Stand +')');
		showNoDB();
	} else {
		jQuery('#no_db')
				.html('<a href="' + json.infos[length].url + '">zum Vertretungsplan...</a> <br>(Stand: '+ json.infos[length].Stand +')');
		showNoDB();
	}
}

function JSONfail(json, textStatus){
	// tabelle leeren
	jQuery('#jquerytable tbody').html('');
	//no_db verstecken
	jQuery('#no_db').hide();
	
	//intervall, warten, dass nachricht angezeigt werden kann
	
	clearInterval(myInterval2);
	
	console.log('start listener');
	myInterval2 = setInterval(function() {
		console.log('wait for hint');
		if (hintshown == false) {
			clearInterval(myInterval2);
			hintshown == true;
			setTimeout("showHint('Fehler. Es existiert kein Plan für das gewählte Datum.', 'warn', '400px', 'noplan');", 200);
		}
	},100);
}

function buildTableFromJSON(tbody, json) {
	console.time('tablebuild');
	// tabelle leeren
	tbody.html('');

	var table = '';
	jQuery.each(json, function() {
		table = '<tr>';
		jQuery.each(this, function(name, content) {
			table += '<td title="' + name + '">';
			//table += '<td>';
			// console.log(a,b);
				table += (content) ? content : '';
				table += '</td>';
			});
		table += '</tr>';

		// tabellenzeile anhängen
		tbody.append(table);
	});
	
	console.timeEnd('tablebuild');
}

function filterKlassen(rows) {
	console.time('filterklassen');
	
	//select leeren
	jQuery('#klasse').html('');
	
	var klassehead = getVarname();
	
	var klassenArray = new Array();
	var klasse = null;
	var nummer = null;
	jQuery.each(rows, function(id, subarray) {
		klasse = subarray[klassehead];
		nummer = klassenArray.length;
		if (klasse != null) {
			klasse.trim;
			if (!contains(klassenArray,klasse)) {
				klassenArray[nummer] = klasse;
			}
		}
	});
	
	klassenArray.sort(sortfunction);
	
	//uniqueArr(klassenArray);
	
	//debug
	console.log(klassenArray);

	jQuery('#klasse').append('<option value="">alle</option>');
	jQuery.each(klassenArray, function(id, klasse) {
		jQuery('#klasse').append('<option value="'+klasse+'">' + klasse + '</option>');
	});
	
	console.timeEnd('filterklassen');
}

function sortfunction(first, second) {
	//Less than 0: Sort "a" to be a lower index than "b" 
	//Zero: "a" and "b" should be considered equal, and no sorting performed
	//Greater than 0: Sort "b" to be a lower index than "a".
	//entfernt leerzeichen am anfang und ende
	a = jQuery.trim(first);
	a = a.toLowerCase();
	
	b = jQuery.trim(second);
	b = b.toLowerCase();
	
	var replace = null;
	//array mit alles buchstaben
	var array = new Array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
	//alle buchstaben werden durch zahlen mit führenden nullen ersetzt
	for ( var int = 0; int < array.length; int++) {
		if (int >= 10){
			replace = int;
		} else {
			replace = "0" + int;
		}
		a = a.replace(RegExp(array[int], "g"),replace);
		b = b.replace(RegExp(array[int], "g"),replace);
	}
	//console.log(first+a);
	//console.log(second+b);
	//console.log(a-b);
	
	return(a - b);
}

/**
 * removes dublicates from array
 * @param a array
 */
function uniqueArr(a) {
	for(i=0; i<a.length; i++){
		if(contains(a, a[i])){
			//removes one of the dublicates
			a.splice(a.indexOf(a[i]),1);
		}
	}
	return a;
}
 
/**
 * Will check for the Uniqueness
 * 
 * @param a array
 * @param e value to look for
 */
function contains(a, e) {
	var inarray = false;
	for(j=0;j<a.length;j++){
		if (a[j]==e) {
			inarray = true;
		}
	}
	return inarray;
}