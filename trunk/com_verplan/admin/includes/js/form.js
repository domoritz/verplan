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
			beforeSubmit:  showRequest,  // pre-submit callback 
			success:       showResponse  // post-submit callback 
	};
	
	// bind to the form's submit event 
    jQuery('#form_verplan').submit(function() { 
        //falls ajax in dem select aktiviert ist, wird ajax verwendet, sonst wird man einfach weitergeleitet
    	var ajax = jQuery('#select_ajax').val();
    	//alert (ajax);
    	if (ajax == 'true') {
    		// inside event callbacks 'this' is the DOM element so we first 
            // wrap it in a jQuery object and then invoke ajaxSubmit 
            jQuery(this).ajaxSubmit(options_0); 
            jQuery('.ajaxresmess_0').show('blind','normal').focus();
     
            // !!! Important !!! 
            // always return false to prevent standard browser submit and page navigation 
            return false; 
		} else {
			return true;
		}
    	
    }); 
	
	
    /*COLUMNS*/
	//wenn daten geändert werden
	jQuery('#columntable input').change(function() {
		jQuery(this).parent().parent().addClass('highlight');
	});

	jQuery('#columntable select').change(function() {
		jQuery(this).parent().parent().addClass('highlight');
	});
	

	// ajax formular für columns
	// http://jquery.malsup.com/form/
	var options_2 = { 
			target:        '#ajaxresponse_2',   // target element(s) to be updated with server response 
			beforeSubmit:  showRequest,  // pre-submit callback 
			success:       showResponse  // post-submit callback 
	};
	
	// bind to the form's submit event 
    jQuery('#columnsform').submit(function() { 
        jQuery(this).ajaxSubmit(options_2).parent().removeClass('highlight'); 
        jQuery('.ajaxresmess_2').show('blind','normal').focus();
        return false; 
    }); 

});


//pre-submit callback 
function showRequest(formData, jqForm, options) { 
    // formData is an array; here we use $.param to convert it to a string to display it 
    // but the form plugin does this for you automatically when it submits the data 
    var queryString = $.param(formData); 
 
    // jqForm is a jQuery object encapsulating the form element.  To access the 
    // DOM element for the form do this: 
    // var formElement = jqForm[0]; 
 
    //alert('About to submit: \n\n' + queryString); 
 
    // here we could return false to prevent the form from being submitted; 
    // returning anything other than false will allow the form submit to continue 
    return true; 
} 
 
// post-submit callback 
function showResponse(responseText, statusText)  { 
    // for normal html responses, the first argument to the success callback 
    // is the XMLHttpRequest object's responseText property 
 
    // if the ajaxForm method was passed an Options Object with the dataType 
    // property set to 'xml' then the first argument to the success callback 
    // is the XMLHttpRequest object's responseXML property 
 
    // if the ajaxForm method was passed an Options Object with the dataType 
    // property set to 'json' then the first argument to the success callback 
    // is the json data object returned by the server 
 
   // alert('status: ' + statusText + '\n\nresponseText: \n' + responseText + 
   //     '\n\nThe output div should have already been updated with the responseText.'); 
	
	//jQuery('.ajaxresmess').show('blind','normal').focus();
} 
