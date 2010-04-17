/**
 * es gibt zwei funktionen
 * die erste ist dafür verantwortlich, dass alle jQuery plugins für die tabelle
 * am anfang initialisiert werden
 * die zweite funktion sorgt dafür, dass bestimmte plugins und funktionen aufgerufen
 * werden, falls sich etwas an der struktur der tabelle ändert. dann müssen auch ein 
 * paar funktionen erneut ausgeführt werden
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 10-Oct-2009
 */

/**
 * initialisiert die tabellenplugins
 * @return
 */
function table_init(){	
	/*
	 * tablesorter plugin
	 * http://tablesorter.com/docs/
	 */
	
	/*
	 * add parser through the tablesorter addParser method 
	 * neuer parser für klassen, da sie sonst nicht richtig sortiert werden
	 * hilfe: 	http://tablesorter.com/docs/example-parsers.html
	 * 			http://www.javascriptkit.com/javatutors/re.shtml
	 */ 
    jQuery.tablesorter.addParser({ 
        // set a unique id 
        id: 'klasse', 
        is: function(s) {
    		//prüft mittels eines reguläres ausdrucks, ob der string eine klasse ist
    	
	    	//entfernt klammern und anders störendes
	    	s = s.replace(/[^a-zA-Z 0-9]+/g,'');
    	
    	    //entfernt leerzeichen am anfang und ende
    		s = jQuery.trim(s);
    		//regulärer ausdruck zum erkennen, ob die spalte als "klasse" behandelt werden soll
    		var reg = new RegExp("^[0-9]{1,2}( )*[a-z]{0,1}$", "i");
	    	//alert(is!=-1);
	    	//return false so this parser is not auto detected 
            return s.search(reg)!=-1;
        }, 
        format: function(s) { 
        	// format your data for normalization
        	
        	//entfernt alles nach ,
        	//wichtig bei 7a, 7b, 7c, 
        	var komma = s.search(',');
        	if (komma<0){
        	    komma=s.length;
        	}
        	s = s.substring(0,komma);
        	
        	//entfernt klammern und anders störendes
        	s = s.replace(/[^a-zA-Z 0-9]+/g,'');        	
        	
        	//entfernt leerzeichen
        	s = jQuery.trim(s);
        	//console.log(s);
        	s = s.toLowerCase();
        	//console.log(s);
        	//leeres, durch das ersetzt wird
        	var replace = null;
        	//wurde ausgetauscht?
        	var replaced = false;
        	//array mit alles buchstaben
        	var array = new Array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
        	//alle buchstaben werden durch zahlen mit führenden nullen ersetzt
        	//wenn && !replaced entfern wird, dann wird immer das gesamte array durch gegangen
        	for ( var i = 0; i < array.length && !replaced; i++) {
        		//führende 0
        		if (i >= 10){
        			replace = i;
        		} else {
        			replace = "0" + (i + 1);
        		}
        		
        		if (s.search(RegExp(array[i], "g"),replace) > 0) {
        			s = s.replace(RegExp(array[i], "g"),replace);
        			replaced = true;
        		}        	    
        	}
        	//falls kein buchstabe drin war (z.b bei 7,8... ohne a,b,c...)
        	if (!replaced){
        		s = s+'00';
        	}
        	//alert(s);
        	return s;
        }, 
        // set type, either numeric or text 
        type: 'numeric' 
    });           
    
    //plugin
	jQuery('#jquerytable').tablesorter({
		//anfangssortierung
		sortList: eval(settings.init_sort.value),
		dateFormat: 'de',
		decimal: ',',
		//debug: true,
		sortMultiSortKey: 'ctrlKey',
		textExtraction: 'complex',
		cssDesc: 'ui-state-active headerSortUp',
		cssAsc: 'ui-state-active headerSortDown',
		//zebra
		widgets: ['zebra'],
		widgetZebra: {css: ["even","odd"]}
	});	

    /*
     * wenn neu sortiert wird, dann wird auch der indikator gestartet
     * assign the sortStart event 
     *
	jQuery("#jquerytable").bind("sortStart",function() { 
		jQuery('#loading').fadeIn(200); 
		//jQuery('#loader_overlay').fadeIn(200); 
    }).bind("sortEnd",function() { 
    	jQuery('#loading').fadeOut(1000);
    	//jQuery('#loader_overlay').fadeOut(1000);
    });	
	
	/*
	 * filter initialisierung
	 */
	iniFilters();
	
	
	table_update();
	
}


/**
 * update/repaint nach ajax update
 * @return
 */
function table_update() {
	
	if (jQuery('#hint_table').css('display') != 'none') {
		//hint ausblenden
		jQuery('#hint_table').hide('blind', 'slow');
	}
	
	/*
	 * zebramuster
	 */
	jQuery("#jquerytablebody tr").removeClass("even");
	jQuery("#jquerytablebody tr").removeClass("odd");
	jQuery("#jquerytable tbody tr:even").addClass('even');
	jQuery("#jquerytable tbody tr:odd").addClass('odd');
	
	/*
	 * colorize farben
	 * http://plugins.jquery.com/project/Colorize
	 * http://franca.exofire.net/jq/colorize
	 */
	jQuery('#jquerytable tbody').colorize({
		altColor: 'none',
		bgColor: 'none',
		hover: 'row', 
		click: 'row', 
		hiliteClass: 'ui-state-hover', 
		hoverClass: 'state-hover',
		oneClick: false
	});	
	
	/*
	 * tablesorter update
	 */
	jQuery('#jquerytable').trigger("update");
	
	//damit die sortierung wieder übernommen wird
	jQuery('#jquerytable thead th.ui-state-active').click().click();
	
	/*
	 * filter update
	 */
	updateFilters();
	
	/*
	 * tooltips für tabellenzellen
	 * resourcenverbrauch
	 */
	/*console.time('tooltips');
	jQuery('#jquerytable tbody td').qtip( {
		content : {
			//keit content, damit der text aus dem title attribut genutz wird
		},
		position : {
			corner : {
				target : 'topMiddle',
				tooltip : 'bottomMiddle'
			}
		},
		style : {
			name: 'domstyle'
		}
	});
	console.timeEnd('tooltips');*/
	
	/**/
}