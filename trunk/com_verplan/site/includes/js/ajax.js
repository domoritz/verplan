/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 08-Okt-2009
 */

jQuery(document).ready(function(){
	//neue funktion zur zeitverzögerung
	jQuery.fn.pause = function (n) {
		return this.queue(function () {
			var el = this;
			setTimeout(function () {
				return jQuery(el).dequeue();
			}, n);
		});
	};

	//laden ganz amanfang
	loadJsonTable(false);
	
	//tabelle am anfang mit plugins
	table_init();

	//falls sich im select etwas ändert
	jQuery('#select_date').change(function(){
		loadJsonTable(true);
	});

	/**
	 * funktion, die tbody mit JSON daten neu lädt
	 * und dabei ein paar effekte anzeigt
	 */
	function loadJsonTable(effects) {
		//geschwindigkeit der ein und ausblendeffekte
		var speed = 1000;

		if (effects) {
			jQuery('div#loading').fadeIn('fast');
			
			jQuery('#jquerytable tbody').
			hide('blind',speed).
			queue(function(){
				loadContent();
				jQuery(this).dequeue();
			});
			
		} else {
			jQuery('div#loading').fadeIn('fast');
			loadContent();	
		}


		function loadContent() {  
			var date = jQuery('#select_date').val();
			var stand = jQuery('#verplan_form [name=stand]').val();
			var options = jQuery('#verplan_form [name=options]').val();
			jQuery.getJSON('index.php?option=com_verplan&view=verplan&format=js&date='+date+'&stand='+stand+'&options='+options, function(json){
				var table = '';
				//alert("JSON Data: " + json.data[0].id);
				/*table += '<table style="width:80%; border:1px solid;"><thead>';
				jQuery.each(json.cols, function() {
					table+= '<th>';
					table+=this.name;
					table+= '<th>';
				});

				table+='</thead><tbody>';*/

				jQuery.each(json.rows, function() {
					table+= '<tr>';
					jQuery.each(this, function() {
						if (this != "") {
							table+= '<td>';
							table+=this;
							table+= '</td>';
						}						
					});
					table+= '</tr>';
				});

				//table+='</table>';
				jQuery('#jquerytable tbody').html(table);
				table_update();
				showNewContent();

			});
		}  
		function showNewContent() {
			if (effects) {
				
				jQuery('#jquerytable tbody').
				show('blind',speed).
				queue(function(){
					hideLoader();
					jQuery(this).dequeue();
				});	
				
			} else {
				jQuery('#jquerytable tbody').queue(function(){
					hideLoader();
					jQuery(this).dequeue();
				});			
			}

		}  
		function hideLoader() {  
			jQuery('div#loading').pause(500).fadeOut(1000);
		}  

	}
});