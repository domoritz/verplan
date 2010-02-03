/**
 * Lightbox für inhalte, wie z.B. den feedbackbogen. 
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 07-Nov-2009
 */

jQuery(document).ready(function(){
	//http://www.no-margin-for-errors.com/projects/prettyPhoto-jquery-lightbox-clone/#themes
	jQuery("a[rel^='prettyPhoto']").prettyPhoto();
	
	jQuery('#feedy').click(function() {
		jQuery.prettyPhoto.open('http://spreadsheets.google.com/viewform?formkey=dGdDanZxa2k4RHhKbHJaS1RxT0Q2eWc6MA&iframe=true&width=95%&height=100%','Feedbackbogen','Gib hier dein Feedback zum Programm ab und melde Fehler. ');
		return false;
	});

});