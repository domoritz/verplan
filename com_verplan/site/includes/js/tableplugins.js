//klasse, die gefiltert werden soll, der wert wird gespeichert
var filterKlasse = jQuery.cookie('Klasse');

//klasse, für filter, gilt nur bis zum nächsten ajax request
var filterKlasse_temp = null;

//tabelle
var theTable = jQuery('#jquerytable');


/**
 * initialisiert die tabelle
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
    	
    	    //entfernt leerzeichen am anfang und ende
    		s = jQuery.trim(s);
    		var reg = new RegExp("^[0-9]{0,2}( )*[a-z]{0,1}$", "i");
	    	//alert(is!=-1);
	    	//return false so this parser is not auto detected 
            return s.search(reg)!=-1;
        }, 
        format: function(s) { 
            // format your data for normalization
        	
        	//entfernt leerzeichen am anfang und ende
        	s = jQuery.trim(s);
        	s = s.toLowerCase();
        	//leeres, durch das ersetzt wird
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
        		s = s.replace(RegExp(array[int], "g"),replace);
			}
        	//alert(s);
            return s;
        }, 
        // set type, either numeric or text 
        type: 'numeric' 
    });           
    
    //plugin
	jQuery('#jquerytable').tablesorter({
		dateFormat:'de',
		decimal: ',',
		debug:false,
		sortMultiSortKey:'ctrlKey',
		textExtraction:'complex',
		cssDesc: 'ui-state-active headerSortDown',
		cssAsc: 'ui-state-active headerSortUp',
		//zebra
		widgets: ['zebra'],
		widgetZebra: {css: ["even","odd"]}
	});	

    /*
     * wenn neu sortiert wird, dann wird auch der indikator gestartet
     * assign the sortStart event 
     *
	jQuery("#jquerytable").bind("sortStart",function() { 
		//jQuery('#loading').fadeIn(200); 
		jQuery('#loader_overlay').fadeIn(200); 
    }).bind("sortEnd",function() { 
    	//jQuery('#loading').fadeOut(1000);
    	jQuery('#loader_overlay').fadeOut(1000);
    });

	
	/*
	 * tablefilter
	 * http://plugins.jquery.com/project/uiTableFilter
	 */

	jQuery("#filter_input").keyup(function() {
		//filter this - spalte, nach der gefiltert wird
		var filter_this = jQuery('#verplan_form [name=filter_this]').val();
		
		//debug
		console.log('Filter: '+filter_this+' '+this.value);
		
		//klassenfilter wird zurüchgesetzt
		resetKlassFilter();
		
		//tabelle filtern
		jQuery.uiTableFilter( theTable, this.value, filter_this);
		hideHint();
	});
	
	//clear input bei start
	jQuery('#filter_input').val('');
	
	//clearable input
	jQuery('#filter_input').clearableTextField();
	
	//falls sich bei filter ehis etwas ändert
	jQuery('#verplan_form [name=filter_this]').change(function(){
		jQuery(".text_clear_button").click();
		jQuery("#filter_input").val('');
		jQuery.uiTableFilter( theTable, '');
		
		//reset klasse filter
		resetKlassFilter();
		
		
		hideHint();
	});
	
	
	//filter klasse
	jQuery("#klasse").attr('selected', '');
	jQuery("#klasse option[value='']").attr('selected', 'selected');
	
	jQuery("#klasse").change(function() {
		//filter this - spalte, nach der gefiltert wird
		var filter_this = '(Klasse(n))';
		
		//filterKlasse,wird gesetzt
		filterKlasse = this.value;
		jQuery.cookie('Klasse', filterKlasse, { expires: 7 });
		
		//anderer filter wird zurüchgesetzt
		jQuery(".text_clear_button").click();
		jQuery("#filter_this").attr('selected', '');
		jQuery("#filter_this option[value='']").attr('selected', 'selected');
		
		//debug
		console.log('Filter Klasse: '+filter_this+' '+this.value);
		
		//tabelle filtern
		jQuery.uiTableFilter( theTable, this.value,filter_this);
		hideHint();
	});
	
	
	/*
	 * filter
	 * http://plugins.jquery.com/project/ColumnFilters
	 * http://www.tomcoote.co.uk/jQueryColumnFilters.aspx
	 */
	/*jQuery('#jquerytable').columnFilters({
		alternateRowClassNames:['even','odd'],
		underline:false,
		caseSensitive:false
	});*/
	
	/*
	 * resizer
	 * breite der spalten anpassen
	 * http://plugins.jquery.com/project/kiketable_colsizable
	 */
	/*jQuery("#jquerytable").kiketable_colsizable({
		dragMove : true,
		dragProxy : "area",
		dragOpacity: 0.3,
		fixWidth: true,
		minWidth: 40,
		title: 'Spaltenbreite verändern',
		onLoad: function(){}
	});*/
	
	
	
	/*
	 * jQuery column manager für options
	 * http://plugins.jquery.com/project/columnmanager
	 */
	
	//hint bei click ausblenden
	jQuery('#hint_table').click(function(){
		jQuery(this).hide('blind', 'slow');
	});
	
	table_update();
	
}

/**
 * falls noch der hinweis angezeigt wird, dass spalten 
 * ausgeblendet werden, wird dieser ausgeblendet
 */
function hideHint() {
	if (jQuery('#hint_table').css('display') != 'none') {
		//hint ausblenden
		jQuery('#hint_table').hide('blind', 'fast');
	}
}

/**
 * setzt alle einstellungen des klassenfilters zuück (auch cookie)
 */
function resetKlassFilter() {
	filterKlasse = null;
	jQuery("#klasse").attr('selected', '');
	jQuery("#klasse option[value='']").attr('selected', 'selected');
	jQuery.cookie('Klasse', null);
	jQuery.uiTableFilter( theTable, '');
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
	
	/*jQuery('#jquerytable tbody tr').mouseover(function(){
		jQuery(this).addClass('state-hover');
	});
	jQuery('#jquerytable tbody tr').mouseout(function(){
		jQuery(this).removeClass('state-hover');
	});
	
	jQuery("#jquerytable tbody tr").click(function(){
	jQuery(this).toggle(function() {
			jQuery(this).addClass("ui-state-highlight");
		}, function() {
			//jQuery(this).removeClass("ui-icon-plusthick");        
		});
    });*/

	
	
	/*
	 * tablesorter update
	 */
	jQuery('#jquerytable').trigger("update");
	
	
	//update filter all
	var theTable = jQuery('#jquerytable');
	var filter_input = jQuery('#verplan_form [name=filter_input]').val();
	var filter_this = jQuery('#verplan_form [name=filter_this]').val();
	jQuery.uiTableFilter( theTable, filter_input, filter_this);	
	
	//alert(filter_input != '');	
	if (filter_input != '') {
		show_hint('Achtung','Es werden Zeilen ausgeblendet, weil ein Filter aktiv ist.');
	}
	
	
	//update filter klasse
	//wähle die klasse, die vorher gewählt war
	jQuery("#klasse").attr('selected', '');
	jQuery("#klasse option[value='"+filterKlasse+"']").attr('selected', 'selected');
	
	var filter_this = '(Klasse(n))';
	filterKlasse_temp = jQuery("#klasse").val();
	console.log('filterKlasse '+filterKlasse);
	console.log('filterKlasse_temp '+filterKlasse_temp);
	
	jQuery.uiTableFilter( theTable, filterKlasse_temp, filter_this);
	
	if (filterKlasse_temp != '') {
		show_hint('Achtung','Es werden Zeilen ausgeblendet, weil ein Filter aktiv ist.');
	}

	
	/*
	 * highlight effect für tr
	 *
	jQuery("#jquerytable tbody tr").click(function(){
		jQuery(this);
	});	
	/**/
}