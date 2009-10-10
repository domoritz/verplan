/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 08-Okt-2009
 */

jQuery(document).ready(function(){

	jQuery.fn.pause = function (n) {
		return this.queue(function () {
			var el = this;
			setTimeout(function () {
				return jQuery(el).dequeue();
			}, n);
		});
	};

	loadJsonTable(false);

	jQuery('#select_date').change(function(){
		loadJsonTable(true);

	});

	function loadJsonTable(effects) {
		//jQuery('#ajaxtable').load("index.php?option=com_verplan&view=verplan&format=js&date=2009-09-24");

//		jQuery("div#loading").ajaxStart(function(){
//			jQuery(this).fadeIn('fast');
//		}).ajaxComplete(function(){
//			//hideLoader();
//		});

		var speed = 1000;

		if (effects) {
			jQuery('div#loading').fadeIn('fast');
			jQuery('#ajaxtable tbody').toggle('blind',speed).queue(function(){
				loadContent();
				jQuery(this).dequeue();
			});
		} else {
			jQuery('div#loading').fadeIn('fast');
			loadContent();	
		}


		function loadContent() {  
			var date = jQuery('#select_date').val();
			jQuery.getJSON('index.php?option=com_verplan&view=verplan&format=js&date='+date+'&stand=newest', function(json){
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
				jQuery('#ajaxtable tbody').html(table);
				showNewContent();

			});
		}  
		function showNewContent() {  
			if (effects) {
				jQuery('#ajaxtable tbody').toggle('blind',speed).queue(function(){
					hideLoader();
					jQuery(this).dequeue();
				});			
			} else {
				jQuery('#ajaxtable tbody').queue(function(){
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