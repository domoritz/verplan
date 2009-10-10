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
	jQuery('#jquerytable').tablesorter({
		dateFormat:'de',
		decimal: ',',
		debug:false,
		sortMultiSortKey:'ctrlKey',
		textExtraction:'complex',
		//zebra
		widgets: ['zebra']
	});	

    /*
     * wenn neu sortiert wird, dann wird auch der indikator gestartet
     * assign the sortStart event 
     */
	jQuery("#jquerytable").bind("sortStart",function() { 
		jQuery('div#loading').fadeIn(200); 
    }).bind("sortEnd",function() { 
    	jQuery('div#loading').fadeOut(1000);
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
	 */
	jQuery('#jquerytable tbody').colorize({
		altColor: 'none',
		bgColor: 'none',
		hover: 'row', 
		click: 'row', 
		hiliteClass: 'marked', 
		hoverClass: 'hover'
	});
	
	/*
	 * tablesorter update
	 */
	jQuery('#jquerytable').trigger("update");
	
	/*
	 * highlight effect für tr
	 */
	jQuery("#jquerytable tbody tr").click(function(){
		jQuery(this).effect('highlight','slow');
	});	
	/**/
}