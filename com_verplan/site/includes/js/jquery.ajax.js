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

	//laden ganz am anfang
	if (!gup('date')) {
		loadJsonTable(false, true);
	}	
	
	//tabelle am anfang mit plugins
	table_init();

	//falls sich im select etwas ändert
	jQuery('#select_date').change(function(){
		loadJsonTable(false, true);
	});
	
	/**
	 * funktion, die urlparameter ausliest
	 * http://www.netlobo.com/url_query_string_javascript.html
	 */
	function gup( name )
	{
	  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	  var regexS = "[\\?&]"+name+"=([^&#]*)";
	  var regex = new RegExp( regexS );
	  var results = regex.exec( window.location.href );
	  if( results == null )
	    return false;
	  else
	    return results[1];
	}

	/**
	 * funktion, die tbody mit JSON daten neu lädt
	 * und dabei ein paar effekte anzeigt
	 * 
	 * effects		- ein und ausblendeffekte
	 * effects indi	- ajax indikator
	 */
	function loadJsonTable(effects, effects_indi) {
		//geschwindigkeit der ein und ausblendeffekte
		var speed = 1000;
		
		if (effects_indi) {
			//jQuery('#loading').fadeIn('fast');
			jQuery('#loader_overlay').fadeIn('fast');
		}

		if (effects) {			
			jQuery('#jquerytable tbody').
			fadeOut(speed).
			//hide('blind',speed).
			queue(function(){
				loadContent(effects, effects_indi);
				jQuery(this).dequeue();
			});
			
		} else {
			loadContent(effects, effects_indi);	
		}


		function loadContent(effects, effects_indi) {
			//get alle daten auf dem formular
			var date = jQuery('#select_date').val();
			var stand = jQuery('#verplan_form [name=stand]').val();
			var options = jQuery('#verplan_form [name=options]').val();
			
			
			jQuery.getJSON('<?php echo JURI::base(true)."/"; ?>?option=com_verplan&view=verplan&format=js&date='+date+'&stand='+stand+'&options='+options, function(json){
				var table = '';
				//alert("JSON Data: " + json.data[0].id);
				/*table += '<table style="width:80%; border:1px solid;"><thead>';
				jQuery.each(json.cols, function() {
					table+= '<th>';
					table+=this.name;
					table+= '<th>';
				});
	
				table+='</thead><tbody>';*/
				
				//holt aus dem array immer die neuesten infos (höchster wert)
				var arr = json.infos;
				var length = arr.length - 1;
				if (json.infos[length].type == 'db') {
					
					//falls bisher der link zum plan angezeigt wurde
					if (jQuery('#no_db').css('display') != 'none') {
						jQuery('#no_db').hide('blind',speed);
					}
					
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
					showNewContent(effects, effects_indi);
					
				} else {
	
					jQuery('#no_db').html('<a href="'+json.infos[length].url+'">zum Vertretungsplan...</a>');
					effects = false;
					jQuery('#no_db').show('blind',speed);
					showNewContent(effects, effects_indi);
					
				}
				
			});
		}  
		function showNewContent(effects, effects_indi) {
			if (effects) {
				
				jQuery('#jquerytable tbody').
				fadeIn(speed).
				//show('blind',speed).
				queue(function(){					
					jQuery(this).dequeue();
				});	
				
			} else {
				jQuery('#jquerytable tbody').queue(function(){
					jQuery(this).dequeue();
				});			
			}
			hideLoader(effects_indi);

		}  
		function hideLoader(effects_indi) {  
			if (effects_indi) {
				//jQuery('#loading').pause(500).fadeOut(1000);			
				jQuery('#loader_overlay').pause(500).fadeOut(1000);
			} else {
				jQuery('#loader_overlay').hide();
			}
		}  

	}
});