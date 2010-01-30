/**
 * lädt einstellungen und leitet anschließend initialisierung ein
 * 
 * @version $Id$
 * @package verplan
 * @author  Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link    http://code.google.com/p/verplan/
 * @license GNU/GPL
 * @author  Created on 16-Jan-2010
 */

var settings;
var notify;


//einstellungen laden und dann in general init starten (bei erfolg)
/*jQuery(document).ready(function(){
	
	// setzt den hashwert, falls er noch nicht gesetzt ist
	hash = getHash();
	if (!hash) {
		hash = jQuery('#select_date_verplan').val();
		setHash(hash);
	}
	getSettings();
});*/
	
function getSettings(){
	//?option=com_verplan&view=settings&format=raw
	jQuery.ajax( {
		type : "GET",
		dataType : "json",
		contentType: "application/json; charset=utf-8",
		url : getURL() + "index.php",
		data : 'option=com_verplan&view=settings&format=raw&options=min',
		timeout: (5000),
		async : true,
		global : false,
		cache: false,
		success : function(XMLHttpRequest, textStatus) {
			if (!(XMLHttpRequest.version.name=='version')) {
				alert('Fehler beim Laden der Einstellungen !<br>'+'XMLHttpRequest:'+XMLHttpRequest+'\n'+'textStatus: '+textStatus);
			} else {
				settings = XMLHttpRequest;
				
				//notifications system setzen
				notify = settings.notify.value;
				
				//in general initialisierung
				initiate_everything();
			}
		},
		error : function(XMLHttpRequest, textStatus, errorThrown) {			
			switch (textStatus) {
			case 'timeout':
				var reload = confirm('Timeout Fehler beim Laden der Einstellungen.\n Willst du die Seite neu laden?');
				if (reload) {
					location.reload();
				}
				break;
			case '404':
				alert('Angeforderte URL nicht gefunden.\n Code 404\n(bei Einstellungen)');
				break;
			case '500':
				alert('Interner Servererror!\n Code 500\n(bei Einstellungen)');
				break;
			case '0':
				alert('Du bist offline. Bitte überprüfe dein Netzwerk.');
				break;
			case 'parsererror':
				alert('Error\nParsen des JSON fehlgeschlagen!\n(bei Einstellungen)');
				break;
			default:
				alert('Unbekannter Fehler beim Laden der Einstellungen!\n'+'XMLHttpRequest:'+XMLHttpRequest+'\n'+'textStatus: '+textStatus+'\n'+"Error: " +errorThrown);
			}
		}	
	});
}