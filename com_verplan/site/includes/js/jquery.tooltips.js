jQuery(document).ready(function() {
	/*
	 * tooltips http://craigsworks.com/projects/qtip/
	 */
	
	jQuery.fn.qtip.styles.domstyle = { // Last part is the name of the style
		tip : 'bottomLeft', // Notice the corner value is identical to the
		// previously mentioned positioning corners	
		background: '#333',
		color: '#fff',
		textAlign: 'center',
		padding: 4,
		'font-size': 'small',
	    border: {
	        width: 4,
	        radius: 5,
	        color: '#333'
	    } , 
		width: 200,	   
	    tip: 'bottomLeft',
	    name: 'dark' // Inherit the rest of the attributes from the preset dark style
	};
	
	
	//jQuery('._filterText').qtip("disable");
	jQuery('._filterText').qtip( {
		content : 'Daten filtern. Du kannst außerdem folgende Zeichen benutzen:<br>* - beliebige Zeichen<br>! - nicht',
		show : 'mouseover',
		hide : 'mouseout',
		position : {
			corner : {
				target : 'topMiddle',
				tooltip : 'bottomLeft'
			}
		},
		style : {
			name: 'domstyle',
			textAlign: 'left'
		}
	});
	
	jQuery('#filter_input').qtip( {
		content : 'Daten nach einer bestimmten Spalte filtern',
		position : {
			corner : {
				target : 'topMiddle',
				tooltip : 'bottomLeft'
			}
		},
		style : {
			name: 'domstyle'
		}
	});
	
	jQuery('.ui-selectmenu').qtip( {
		content : 'Geltungsdatum wählen',
		show : 'mouseover',
		hide : 'mouseout',
		position : {
			corner : {
				target : 'topMiddle',
				tooltip : 'bottomLeft'
			}
		},
		style : {
			name: 'domstyle'
		}
	});
	
	jQuery('#expander_options').qtip( {
		content : 'Erweiterte Einstellungen und Funktionen. z.B. Filter',
		show : 'mouseover',
		hide : 'mouseout',
		position : {
			corner : {
				target : 'bottomMiddle',
				tooltip : 'topLeft'
			}
		},
		style : {
			name: 'domstyle',
			textAlign: 'left',
			tip: 'topLeft'
		}
	});
	
	jQuery('#ui_themeswitcher').qtip( {
		content : 'Wähle ein Design aus, das dir gefällt.',
		show : 'mouseover',
		hide : 'mouseout',
		position : {
			corner : {
				target : 'topMiddle',
				tooltip : 'bottomLeft'
			}
		},
		style : {
			name: 'domstyle',
			textAlign: 'left'
		}
	});
	
	jQuery('#jquerytable thead th').qtip( {
		content : {
			text: 'Sortiere nach dieser Spalte',
			/*title: {
				text: 'Sortieren', // Give the tooltip a title using each elements text
				button: 'Schließen' // Show a close link in the title
			}*/
		},
		show : 'mouseover',
		hide : 'mouseout',
		position : {
			corner : {
				target : 'topMiddle',
				tooltip : 'bottomLeft'
			}
		},
		style : {
			name: 'domstyle',
			textAlign: 'left'
		}
	});
	
	
	//feedback
	jQuery('#feedy').qtip( {
		content : {
            // Set the text to an image HTML string with the correct src URL to the loading image you want to use
            text: 'Hey, du benutzt eine <strong>Vorabversion</strong>. Damit Fehler behoben werden und das Programm verbessert wird, gib bitte dein <strong>Feedback</strong> ab. Jedes einzelne ist wichtig für mich. <br>Vielen Dank und viel Spaß'
            //url: jQuery(this).attr('href'), // Use the rel attribute of each element for the url to load
            /*title: {
            	text: 'Feedback' // Give the tooltip a title using each elements text
            	//button: 'Close' // Show a close link in the title
            }*/		
        },
		show : 'focus',
		hide : 'click',
		position : {
			corner : {
				target : 'bottomMiddle',
				tooltip : 'topMiddle'
			}
		},
		style : {
			name: 'domstyle',
			background: '#A00000',
			color: '#fff',
			textAlign: 'left',
			padding: 5,
		    border: {
		        width: 4,
		        radius: 5,
		        color: '#A00000'
		    } , 
			width: 220,	  
			tip: 'topMiddle'
		}
	});
	jQuery('#feedy').focus();

});