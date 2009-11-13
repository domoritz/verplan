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
	
	//verstecke optionen
	jQuery('#admin_options_div').hide('');
	jQuery('#options_header').click(function() {
		
		//alle anderen , die offen sind schließen
		/*jQuery('#options_header.minus').click();
		jQuery('#settings_header.minus').click();
		jQuery('#columns_header .minus').click();
		jQuery('#about_header .minus').click();*/
		jQuery('.minus:not(this)').toggleClass('plus').toggleClass('minus').next('.verschwinder').toggle('blind','slow');
		//wechsel des icons
		jQuery('#admin_options_div').toggle('blind','slow');
		jQuery(this).toggleClass('plus').toggleClass('minus');
	});
	
	//versteckt einstellungen
	jQuery('#admin_settings_div').hide('');
	jQuery('#settings_header').click(function() {
		
		jQuery('.minus:not(this)').toggleClass('plus').toggleClass('minus').next('.verschwinder').toggle('blind','slow');
		//wechsel des icons
		jQuery('#admin_settings_div').toggle('blind','slow');
		jQuery(this).toggleClass('plus').toggleClass('minus');
	});
	
	//versteckt spalteneinstellungen
	jQuery('#admin_columns_div').hide('');
	jQuery('#columns_header').click(function() {
		
		jQuery('.minus:not(this)').toggleClass('plus').toggleClass('minus').next('.verschwinder').toggle('blind','slow');
		//wechsel des icons
		jQuery('#admin_columns_div').toggle('blind','slow');
		jQuery(this).toggleClass('plus').toggleClass('minus');
	});
	
	//versteckt about
	jQuery('#about_div').hide('');
	jQuery('#about_header').click(function() {
		
		jQuery('.minus:not(this)').toggleClass('plus').toggleClass('minus').next('.verschwinder').toggle('blind','slow');
		//wechsel des icons
		jQuery('#about_div').toggle('blind','slow');
		jQuery(this).toggleClass('plus').toggleClass('minus');
	});
	
	var hash = window.location.hash;
	//alert (hash);
	if (hash) {
		jQuery("a"+hash).click();
	}	
});