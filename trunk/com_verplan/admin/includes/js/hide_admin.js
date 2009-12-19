/**
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 2-Oct-2009
 */
jQuery(document).ready(function(){

	jQuery("#accordion h3 a").click(function(event){
		window.location.hash=this.hash;
	});

	//alle divs verstecken, die für optionen sind
	jQuery('a.expander').next('div').hide('');

	//divs öffnen und schließen
	jQuery('.expander').click(function() {	

		//hash setzen, beim öffnen soll er gesetzt bleiben (aus link), beim schließen entfernt
		if (jQuery(this).attr('class').search('minus') >= 0) {
			window.location.hash = '#';
		} else {
			window.location.hash = jQuery(this).attr('id');
		}

		//alle anderen , die offen sind schließen		
		jQuery(".minus").not(this).addClass('plus').removeClass('minus').next('.verschwinder').toggle('blind','slow');

		//icon wechseln und dieses öffnen/schließen
		jQuery(this).toggleClass('plus').toggleClass('minus').next('.verschwinder').toggle('blind','slow');		
		
		return false;
	});

	var hash = window.location.hash;
	//alert (hash);
	if (hash) {
		jQuery("a"+hash).click();
	}	
});