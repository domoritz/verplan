/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 30-Oct-2009
 */
jQuery(document).ready(function(){

	/*UPLOAD*/
	//ajax für dateiupload form
	var options_0 = { 
			target:        '#ajaxresponse_0',   // target element(s) to be updated with server response 
			url:  'index.php?option=com_verplan',
			success:       showResponse_0  // post-submit callback 
	};

	// bind to the form's submit event 
	jQuery('#form_verplan').submit(function() { 
		//falls ajax in dem select aktiviert ist, wird ajax verwendet, sonst wird man einfach weitergeleitet
		var ajax = jQuery('#select_ajax').val();
		//alert (ajax);
		if (ajax == 'true') {
			// inside event callbacks 'this' is the DOM element so we first 
			// wrap it in a jQuery object and then invoke ajaxSubmit
			jQuery('#ajax_indicator_0').show();
			jQuery(this).ajaxSubmit(options_0); 
			
			// !!! Important !!! 
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		} else {
			return true;
		}

	});
	
	//post-submit callback 
	function showResponse_0(responseText, statusText)  { 
		jQuery('.ajaxresmess_0').show('blind','normal').focus();
		jQuery('#ajax_indicator_0').fadeOut('slow');
	} 
	
	

	/*SETTINGS*/
	//ajax für einstellungen form
	var options_1 = { 
			target:        '#ajaxresponse_1',   // target element(s) to be updated with server response 
			url: 'index.php?option=com_verplan&ajax=true',
			success:       showResponse_1  // post-submit callback 
	};

	// bind to the form's submit event 
	jQuery('#settings_form').submit(function() {
		var ajax = jQuery('#select_ajax').val();
		if (ajax == 'true') {
			jQuery('#ajax_indicator_1').show();
			jQuery(this).ajaxSubmit(options_1);

			return false;
		} else {
			return true;
		}
	});	
	
	//post-submit callback 
	function showResponse_1(responseText, statusText)  { 
		jQuery('.ajaxresmess_1').show('blind','normal').focus();
		jQuery('#ajax_indicator_1').fadeOut('slow');
	} 


	/*COLUMNS*/
	//wenn daten geändert werden
	jQuery('#columntable input').change(function() {
		jQuery(this).parent().parent().addClass('highlight');
	});
	
	jQuery('#columntable textarea').change(function() {
		jQuery(this).parent().parent().addClass('highlight');
	});

	jQuery('#columntable select').change(function() {
		jQuery(this).parent().parent().addClass('highlight');
	});
	
	jQuery('#columntable .columnsbutton:reset').click(function() {
		jQuery(this).parent().parent().removeClass('highlight');
	});


	// ajax formular für columns
	// http://jquery.malsup.com/form/
	var options_2 = { 
			target:        '#ajaxresponse_2',   // target element(s) to be updated with server response 
			url: 'index.php?option=com_verplan&ajax=true',
			success:       showResponse_2  // post-submit callback 
	};

	// bind to the form's submit event 
	jQuery('#columnsform').submit(function() { 
		var ajax = jQuery('#select_ajax').val();
		if (ajax == 'true') {
			jQuery('#ajax_indicator_2').show();
			jQuery(this).ajaxSubmit(options_2).parent().removeClass('highlight'); 
			
			return false;
		} else {
			return true;
		}
	}); 
	
	//post-submit callback 
	function showResponse_2(responseText, statusText)  {
		
		jQuery('.ajaxresmess_2').show('blind','normal').focus();
		jQuery('#ajax_indicator_2').fadeOut('slow');
	} 

});
