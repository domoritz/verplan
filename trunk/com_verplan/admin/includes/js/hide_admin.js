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
		
		//alle anderen , die offen sind schließen		
		jQuery(".minus").not(this).addClass('plus').removeClass('minus').next('.verschwinder').toggle('blind','slow');
		
		//icon wechseln und dieses öffnen
		jQuery(this).toggleClass('plus').toggleClass('minus').next('.verschwinder').toggle('blind','slow');		
	});
	
	var hash = window.location.hash;
	//alert (hash);
	if (hash) {
		jQuery("a"+hash).click();
	}	
});