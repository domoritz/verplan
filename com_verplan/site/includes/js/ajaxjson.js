/**
 * die funktonen dieser datei soregn dafür, dass die daten für die tabelle per json geladen werden
 * und dann eine tabelle aufgebaut wird (danach muss ein table update geschehen). 
 * im unteren teil stehen noch ein paar funktionen, die das auswahlfeld für die klassen ausbauen
 * 
 * @version $Id$
 * @package verplan
 * @author Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link http://code.google.com/p/verplan/
 * @license GNU/GPL
 * @author Created on 21-Nov-2009
 */

var ajax_date, ajax_stand, ajax_options;

/**
 * anzahl der zeilen, wichtig für änderungen
 */
var num_cols = 0;


/**
 * notifications
 */
var note_noplan, note_error_load, note_nodb, note_db;

//intervall zum warten, dass keine nachricht angezeigt wird
var myInterval2;

function getAndUseJSON(date, stand, options) {
	//console.log('getAndUseJSON'+date+stand+options);
	
	ajax_date = date;
	ajax_stand = stand;
	ajax_options = options;
	
	//zeige meldung
	showIndicator();
	
	jQuery('#miniindi').show();
	
	/*
	 * hidetable hat als Callback ajaxCall, welches wiederum JSONsuccsss
	 * aufruft. von dort aus wird dann show table aufgerufen (falls type=db)
	 * 
	 * hideTable()->ajaxCall()->JSONsuccess()+buildTable->showTable()
	 */
	hideTable();
}

function ajaxCall() {
	//starte ajax
	jQuery.ajax( {
		type : "GET",		
		dataType: (jQuery.browser.msie) ? "text" : "json",
		contentType: "application/json; charset=utf-8",
		cache: false,
		url : rooturl + "index.php",
		data : {
			'option':'com_verplan',
			'view':'data', 
			'format':'json', 
			'date':ajax_date, 
			'stand':ajax_stand, 
			'options':ajax_options
		},
		timeout: (20000),
		async : true,
		global : true,
		success : function(XMLHttpRequest, textStatus) {
			if (XMLHttpRequest.infos == '') {
				JSONfail(XMLHttpRequest, textStatus);
			} else {
				JSONsuccess(XMLHttpRequest, textStatus);
			}
		},
		error : function(XMLHttpRequest, textStatus, errorThrown) {
			//fehler bei ajax
			switch (textStatus) {
			case 'timeout':
				var load = confirm('Timeout Fehler beim Laden des Vertretungsplans.\n Willst du auf eine alternative Seite weitergeleitet werden?');
				if (load) {
					window.location.replace(rooturl+'?option=com_verplan&view=mobile');
				}
				break;
			case '404':
				alert('Angeforderte URL nicht gefunden.\n Code 404');
				break;
			case '500':
				alert('Interner Servererror!\n Code 500');
				break;
			case '0':
				alert('Du bist offline. Bitte überprüfe dein Netzwerk.');
				break;
			case 'parsererror':
				alert('Error\nParsen des JSON fehlgeschlagen!\n'.textStatus);
				break;
			default:
				alert('Unbekannter Fehler beim Laden des Vertretungsplanes!\n'+'XMLHttpRequest:'+XMLHttpRequest+'\n'+'textStatus: '+textStatus+'\n'+"Error: " +errorThrown);
			}
		},
		complete: hideIndicator		
	});
}

function JSONsuccess(json, textStatus) {
	
	//problem mit ie beheben
	if (jQuery.browser.msie) {
		json = eval("(" + json + ")");
	}
	
	// holt aus dem array immer die neuesten infos (höchster wert)
	infoarr = json.infos;
	
	var length = infoarr.length - 1;
	
	//vorgehen nach typ auswählen
	switch (json.infos[length].type) {
	case 'no_access':
		
		//filternachricht ausblenden und elemente abschalten		
		jQuery('#nachrichtenbereich_tabelle:visible').slideUp('fast');
		jQuery('#filter_input').attr('disabled', 'disabled');
		jQuery('#filter_this').attr('disabled', 'disabled');
		jQuery('#klasse').attr('disabled', 'disabled');
		
		//sucht die richtige loginkomponente für joomla 1.5 oder 1.6
		var component = "com_users";		
		if (joomlaversion == 1.5) {
			component = "com_user";
		}
		
		jQuery('#no_db')
		.html('<p>Zugang verweigert! Bitte logge dich ein. </p>zum <a href="'+rooturl+'index.php?option='+component+'&view=login&return=aW5kZXgucGhwP29wdGlvbj1jb21fdmVycGxhbiZ2aWV3PXZlcnBsYW4=">Login</a>');
		showNoDB();
		
		if (notify == 'pnotify' || notify == 'both') {
			note_db = jQuery.pnotify({
			    pnotify_title: 'Zugang verweigert',
			    pnotify_text: 'Der Vertretungsplan ist nicht öffentlich. Bitte logge dich ein. ',
			    pnotify_notice_icon: 'ui-icon ui-icon-error',
			    pnotify_type: 'error',
			    pnotify_hide: false
			});
		}
		break;
	case 'db':
		// wenn der typ datenbank ist
		
		//elemente anschalten		
		jQuery('#filter_input').removeAttr('disabled');
		jQuery('#filter_this').removeAttr('disabled');
		jQuery('#klasse').removeAttr('disabled');
		
		// falls bisher der link zum plan angezeigt wurde
		hideNoDB();

		// baut die tabelle zusammen
		buildTableFromJSON(jQuery('#jquerytable tbody'), json.rows);

		showTable();
		
		//filter für die klassen
		filterKlassen(json.rows);
		
		// update der plugins
		table_update();
		
		if (notify == 'pnotify' || notify == 'both') {
			note_db = jQuery.pnotify({
			    pnotify_title: 'Vertretungsplan geladen',
			    pnotify_text: 'Der Vertretungsplan für den '+ json.infos[length].Geltungsdatum.substring(0,10) +' (Stand: <strong>'+ json.infos[length].Stand +'</strong>) wurde erfolgreich geladen. ',
			    pnotify_notice_icon: 'ui-icon ui-icon-info',
			    pnotify_type: 'notice'
			});
		}
		
		break;
	case 'none':
		//keine vertretungen
		
		//filternachricht ausblenden und elemente abschalten		
		jQuery('#nachrichtenbereich_tabelle:visible').slideUp('fast');
		jQuery('#filter_input').attr('disabled', 'disabled');
		jQuery('#filter_this').attr('disabled', 'disabled');
		jQuery('#klasse').attr('disabled', 'disabled');
		
		jQuery('#no_db')
		.html('<p>Hurra! Keine Vertretungen für diesen Tag </p>(Stand: '+ json.infos[length].Stand +')');
		showNoDB();
		
		if (notify == 'pnotify' || notify == 'both') {
			note_nodb = jQuery.pnotify({
			    pnotify_title: 'keine Vertretungen',
			    pnotify_text: 'Für den gewählten Tag gibt es keine Vertretungen. Das heißt, der Unterricht findet wie geplant statt. Bitte beachte, dass sich der Vertretungsplan ständig ändern kann.',
			    pnotify_notice_icon: 'ui-icon ui-icon-lightbulb',
			    pnotify_type: 'notice',
			    pnotify_hide: false
			});
		}
		
		break;
	default:
		//es wurde eine datei hochgeladen
		
		//filternachricht ausblenden und elemente abschalten		
		jQuery('#nachrichtenbereich_tabelle:visible').slideUp('fast');
		jQuery('#filter_input').attr('disabled', 'disabled');
		jQuery('#filter_this').attr('disabled', 'disabled');
		jQuery('#klasse').attr('disabled', 'disabled');
		
		jQuery('#no_db')
		.html('<p><a href="' + json.infos[length].url + '">zum Vertretungsplan...</a> </p>(Stand: '+ json.infos[length].Stand +')');
		showNoDB();
		
		if (notify == 'pnotify' || notify == 'both') {
			note_nodb = jQuery.pnotify({
			    pnotify_title: 'Datei',
			    pnotify_text: 'Für den gewählten Tag wurde ein Vertretungsplan hochgeladen. Dieser liegt als "'+ json.infos[length].type +'" vor. Um den Vertretungsplan zu sehen, musst du die Datei öffnen. Klicke dazu auf den <a href="' + json.infos[length].url + '">Link</a>.',
			    pnotify_notice_icon: 'ui-icon ui-icon-lightbulb',
			    pnotify_type: 'notice',
			    pnotify_hide: false
			});
		}
		break;
	}
	
	jQuery('#miniindi').hide();
}

/**
 * ex existiert kein plan für das datum
 * @param json
 * @param textStatus
 * @return
 */
function JSONfail(json, textStatus){
	// tabelle leeren
	jQuery('#jquerytable tbody').html('');
	//no_db verstecken
	jQuery('#no_db').hide();
	
	if (notify == 'pnotify' || notify == 'both') {
		note_noplan = jQuery.pnotify({
		    pnotify_title: 'Fehler',
		    pnotify_text: 'Es wurdet kein Plan für das gewählte Datum gefunden. Bitte wähle ein anderes Datum!',
		    pnotify_error_icon: 'ui-icon ui-icon-alert',
		    pnotify_type: 'error',
		    pnotify_hide: false
		});
	}
}

/**
 * tabelle aus daten zusammensetzen
 * 
 * @param tbody
 * @param json
 * @return
 */
function buildTableFromJSON(tbody, json) {
	// tabelle leeren
	tbody.html('');

	var table = '';
	jQuery.each(json, function() {
		table += '<tr>';
		jQuery.each(this, function(name, content) {
			table += '<td title="' + name + '">';
				table += (content) ? content : '';
				table += '</td>';
		});
		table += '</tr>';		
	});
	
	// tabelle in DOM setzen
	tbody.append(table);
	
	//anzahl der zeilen setzen
	num_cols = json.length;

}

/**
 * filter für die klassen
 * (klasse auswälen-> nur diese angezeigt)
 * 
 * hier wird die liste erzeugt
 * 
 * @param rows
 * @return
 */
function filterKlassen(rows) {	
	//select leeren
	jQuery('#klasse').html('');
	
	var klassehead = settings.class_name.value;
	
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
}

function sortfunction(first, second) {
	//Less than 0: Sort "a" to be a lower index than "b" 
	//Zero: "a" and "b" should be considered equal, and no sorting performed
	//Greater than 0: Sort "b" to be a lower index than "a".
	
	//entfernt alles nach ,
	//wichtig bei 7a, 7b, 7c, 
	var komma = first.search(',');
	if (komma<0){
	    komma=first.length;
	}
	first = first.substring(0,komma);
	
	var komma = second.search(',');
	if (komma<0){
	    komma=second.length;
	}
	second = second.substring(0,komma);
	
	//entfernt klammern und anders störendes
	first = first.replace(/[^a-zA-Z 0-9]+/g,'');
	second = second.replace(/[^a-zA-Z 0-9]+/g,'');
	
	//entfernt leerzeichen am anfang und ende
	a = jQuery.trim(first);
	a = a.toLowerCase();
	
	b = jQuery.trim(second);
	b = b.toLowerCase();
	
	var replace = null;
	var replaced_a = false;
	var replaced_b = false;
	//array mit alles buchstaben
	var array = new Array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
	//alle buchstaben werden durch zahlen mit führenden nullen ersetzt
	for ( var i = 0; i < array.length; i++) {
		if (i >= 10){
			replace = i;
		} else {
			replace = "0" + (i + 1);
		}
		//a
		if (a.search(RegExp(array[i], "g"),replace) > 0) {
			a = a.replace(RegExp(array[i], "g"),replace);
			replaced_a = true;
		}   
		//b
		if (b.search(RegExp(array[i], "g"),replace) > 0) {
			b = b.replace(RegExp(array[i], "g"),replace);
			replaced_b = true;
		}  
	}
	
	//falls nichts ersetzt wurde
	if (!replaced_a){
		a = a+'00';
	}
	if (!replaced_b){
		b = b+'00';
	}
	
	//console.log(first+' '+a);
	//console.log(second+' '+b);
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