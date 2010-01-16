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


//einstellungen laden und dann in general init starten (bei erfolg)
jQuery(document).ready(function(){	
	getSettings();
});
	
function getSettings(){
	//?option=com_verplan&view=settings&format=raw
	jQuery.ajax( {
		type : "GET",
		dataType : "json",
		url : getURL() + "index.php",
		data : 'option=com_verplan&view=settings&format=raw&options=min',
		timeout: (1000),
		async : true,
		global : false,
		success : function(XMLHttpRequest, textStatus) {
			console.log('Settings: '+textStatus);
			if (!(XMLHttpRequest.version.name=='version')) {
				alert('Fehler beim Laden der Einstellungen !<br>'+'XMLHttpRequest:'+XMLHttpRequest+'\n'+'textStatus: '+textStatus);
			} else {
				settings = XMLHttpRequest;
				//in general initialisierung
				initiate_everything();
			}
			
		},
		error : function(XMLHttpRequest, textStatus, errorThrown) {
			if (errorThrown) {
				alert('Fataler Fehler beim Laden der Einstellungen (AJAX)!<br>'+'XMLHttpRequest:'+XMLHttpRequest+'\n'+'textStatus: '+textStatus+'\n'+"Error: " +errorThrown);
			}
		}	
	});
}