/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 25-Oct-2009
 */

jQuery(function() {
	
	//datepicker
	
	jQuery('#datepicker_date').datepicker({		
		showOn: 'button', 
		numberOfMonths: 2,
		showButtonPanel: true,
		dateFormat: 'yy-mm-dd',
		buttonImage: 'components/com_verplan/includes/images/office_calendar.png',
		buttonText: 'Geltungsdatum wählen',
		buttonImageOnly: true,
		changeMonth: false
	});  

	/*jQuery("#datepicker_date").datepicker({
		showOn: 'button', 
		numberOfMonths: 2,
		showButtonPanel: true,
		dateFormat: 'yy-m-d',
		buttonImage: 'components/com_verplan/includes/images/office_calendar.png',
		buttonText: 'Geltungsdatum wählen',
		buttonImageOnly: true,
		changeMonth: false
	},jQuery.datepicker.regional['de']);*/
	
	
	//mit unter
	/*
	jQuery('#datepicker_stand').datetimepicker({
		timeFormat: ' hh-ii-ss',
		
		
		showOn: 'button', 
		numberOfMonths: 1,
		showButtonPanel: true,
		dateFormat: 'yy-m-d',
		buttonImage: 'components/com_verplan/includes/images/office_calendar.png', 
		buttonText: 'Stand wählen',
		buttonImageOnly: true,
		changeMonth: false
	},jQuery.datepicker.regional['de']);
	*/
	
	jQuery('#datepicker_stand').datepicker({
		duration: '',
        showTime: false,
        constrainInput: false,
        stepMinutes: 10,
        stepHours: 10,
        altTimeField: '',
        time24h: true,
		
		
		showOn: 'button', 
		numberOfMonths: 1,
		showButtonPanel: true,
		dateFormat: 'yy-mm-dd',
		buttonImage: 'components/com_verplan/includes/images/office_calendar.png', 
		buttonText: 'Stand wählen',
		buttonImageOnly: true,
		changeMonth: false
	},jQuery.datepicker.regional['de']);
	
	/*
	jQuery('#datepicker_stand_time').kmTimepicker({
		time24h: true
	});
	*/
	
	/*http://code.google.com/p/jquery-utils/wiki/UiTimepickr*/
	$('#datepicker_stand_time').timepickr({
		convention: 24,
		val: '00:00',
		format24: '{h:02.d}:{m:02.d}' 
	}); 
	
});
