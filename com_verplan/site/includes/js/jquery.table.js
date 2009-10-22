/**
 * initialisiert die tabelle
 * @return
 */
function table_init(){
	table_update();
	
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
        	var replace = "";
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
     */
	jQuery("#jquerytable").bind("sortStart",function() { 
		jQuery('#loading').fadeIn(200); 
    }).bind("sortEnd",function() { 
    	jQuery('#loading').fadeOut(1000);
    }); 
	
	
	/*
	 * filter
	 * http://plugins.jquery.com/project/ColumnFilters
	 * http://www.tomcoote.co.uk/jQueryColumnFilters.aspx
	 */
	jQuery('#jquerytable').columnFilters({
		alternateRowClassNames:['even','odd'],
		underline:false,
		caseSensitive:false
	});
	
	/*
	 * resizer
	 * breite der spalten anpassen
	 * http://plugins.jquery.com/project/kiketable_colsizable
	 */
	jQuery("#jquerytable").kiketable_colsizable({
		dragMove : true,
		dragProxy : "area",
		dragOpacity: 0.3,
		fixWidth: true,
		minWidth: 40,
		title: 'Spaltenbreite verändern',
		onLoad: function(){}
	});
	
	
	
	/*
	 * jQuery column manager für options
	 * http://plugins.jquery.com/project/columnmanager
	 */
	
}

/**
 * update/repaint nach ajax update
 * @return
 */
function table_update() {
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
		hiliteClass: 'ui-state-active', 
		hoverClass: 'ui-state-hover',
		oneClick: false
	});
	
	/*
	 * tablesorter update
	 */
	jQuery('#jquerytable').trigger("update");
	
	
	//neue funktion zur zeitverzögerung
	jQuery.fn.pause = function (n) {
		return this.queue(function () {
			var el = this;
			setTimeout(function () {
				return jQuery(el).dequeue();
			}, n);
		});
	};
	
	/*
	 * highlight effect für tr
	 */
	jQuery("#jquerytable tbody tr").click(function(){
		jQuery(this);
	});	
	/**/
}