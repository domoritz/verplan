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

	jQuery("#datepicker_date").datepicker({
		showOn: 'button', 
		numberOfMonths: 2,
		showButtonPanel: true,
		dateFormat: 'yy-m-d',
		buttonImage: 'components/com_verplan/includes/images/office_calendar.png',
		buttonText: 'Geltungsdatum wählen',
		buttonImageOnly: true,
		changeMonth: false
	},jQuery.datepicker.regional['de']);
	
	jQuery("#datepicker_stand").datepicker({
		showOn: 'button', 
		numberOfMonths: 1,
		showButtonPanel: true,
		dateFormat: 'yy-m-d',
		buttonImage: 'components/com_verplan/includes/images/office_calendar.png', 
		buttonText: 'Stand wählen',
		buttonImageOnly: true,
		changeMonth: false

	},jQuery.datepicker.regional['de']);
});
