/**
 * style vorgeben (muss früh sein, weil es schon in table updates genutzt wird)
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 17-Apr-2010
 */

function defaultStyle() {
	//farben
	jQuery.fn.qtip.styles.own = { // Last part is the name of the style
			tip: { 
		      color: '#fff'
		   }, 
			color: '#000',
			background: '#fff',
			//background: '#ffffff',
		   	border: {
				color: '#ccc'
				//color: '#CCCCCC'
			},
		   
		   	name: 'light' // Inherit the rest of the attributes from the preset style
	};
	
	jQuery.fn.qtip.styles.domstyle = { // Last part is the name of the style
	   tip: { 
	      corner: true, 
	      background: null, 
	      'z-index': '10'
	   }, 
	   content:{
		   'padding': '10px'
	   },
	   'font-size': 'small',
	   border: { 
	      width: 1, 
	      radius: 0 
	   },
//	   classes: { 
//	      tooltip: 'ui-widget', 
//	      tip: 'ui-widget', 
//	      title: 'ui-widget-header', 
//	      content: 'ui-widget-content' 
//	   },
	   
	   //style ist eine variable
	   name: 'own' // Inherit the rest of the attributes from the preset style
	};
	
	
	jQuery('#verplanwrapper').qtip( {
		content : {
            // Set the text to an image HTML string with the correct src URL to the loading image you want to use
            text: 'Dies ist ein langer Testtext, damit ich das Design testen kann.',
		    //text: 'Hey, du benutzt eine <strong>Vorabversion</strong>. Damit Fehler behoben werden und das Programm verbessert wird, gib bitte dein <strong>Feedback</strong> ab. Jedes einzelne ist wichtig für mich. <br>Vielen Dank und viel Spaß<br><p id="closefeedy" style="cursor: pointer; font-weight: bold; float:right;">schließen</p> '
            //url: jQuery(this).attr('href'), // Use the rel attribute of each element for the url to load
            title: {
            	text: 'Test', // Give the tooltip a title using each elements text
            	button: 'schließen' // Show a close link in the title
            }
        },
		show : 'focus',
		hide : 'click',
		position : {
			corner : {
				target : 'topMiddle',
				tooltip : 'bottomMiddle'
			}
		},
		style : {
			name: 'domstyle'
		}
	});
	//show test as default
	jQuery('#verplanwrapper').focus();
	
	
}