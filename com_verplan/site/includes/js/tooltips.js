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
		padding: 5,
		'font-size': 'small',
	    border: {
	        width: 2,
	        radius: 5,
	        color: '#000'
	    } , 
	    /* hide: { 
	    	effect: { 
	    		type: 'slide',
	    		length: 600
	    	} 
	    },
	    show: { 
	    	effect: { 
	    		type: 'slide',
	    		length: 600
	    	} 
	    },*/
		width: 200,	   
	    tip: 'bottomLeft',
	    name: 'dark' // Inherit the rest of the attributes from the preset dark style
	};
	
	
	//tooltips for all
	jQuery('a[title]').qtip({ style: { name: 'domstyle', tip: true } });
	
	
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
	
	jQuery('#input_options').qtip( {
		content : 'nicht beachten',
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
	
	jQuery('#input_stand').qtip( {
		content : 'nicht beachten',
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
	
	jQuery('#filter_input').qtip( {
		content : 'Daten nach einer bestimmten Spalte filtern. Die Spalte, nach der gefiltert werden soll, kannst du in der Auswahlbox rechts neben dem Textfeld auswählen.',
		hide: {
			when: 'mouseout',
			fixed: true
		},
		show: 'mouseover',
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
	
	//schließen bei click
	jQuery('#filter_input').click(function(){
		jQuery(this).qtip("hide");
	});
	
	
	jQuery('.ui-selectmenu-status').qtip( {
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
				tooltip : 'topRight'
			}
		},
		style : {
			name: 'domstyle',
			textAlign: 'left',
			tip: 'topRight'
		}
	});
	
	jQuery('#ui_themeswitcher').qtip( {
		content : 'Wähle ein Design aus, das dir gefällt.',
		show : 'mouseover',
		hide : 'mouseout',
		position : {
			corner : {
				target : 'topMiddle',
				tooltip : 'bottomRight'
			}
		},
		style : {
			name: 'domstyle',
			textAlign: 'left',
			tip: 'bottomRight'
		}
	});
	
	jQuery('#jquerytable thead th').qtip( {
		content : {
			text: 'Sortiere nach dieser Spalte'
			/*title: {
				text: 'Sortieren', // Give the tooltip a title using each elements text
				button: 'Schließen' // Show a close link in the title
			}*/
		},
		show : 'mouseover',
		hide : 'mouseout',
		position : {
			corner : {
				target : 'bottomMiddle',
				tooltip : 'topMiddle'
			}
		},
		style : {
			name: 'domstyle',
			textAlign: 'left',
			tip: 'topMiddle'
		}
	});
	
	
	//feedback
	jQuery('#feedy').qtip( {
		content : {
            // Set the text to an image HTML string with the correct src URL to the loading image you want to use
            text: 'Hey, du benutzt eine <strong>Vorabversion</strong>. Damit Fehler behoben werden und das Programm verbessert wird, gib bitte dein <strong>Feedback</strong> ab. Jedes einzelne ist wichtig für mich. <br>Vielen Dank und viel Spaß<br><p id="closefeedy" style="cursor: pointer; font-weight: bold; float:right;">schließen</p> '
            //url: jQuery(this).attr('href'), // Use the rel attribute of each element for the url to load
            /*title: {
            	text: 'Feedback', // Give the tooltip a title using each elements text
            	button: 'schließen' // Show a close link in the title
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
			//name: 'domstyle',
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
			tip: 'topMiddle',
			'font-size': 'small'
		}
	});
	//show feedy as default
	jQuery('#feedy').focus();
	
	
	//schließen bei click
	jQuery('#closefeedy').click(function(){
		jQuery('#feedy').qtip("hide");
	});
	
	//meine website
	jQuery('#hpvd').qtip( {
		content : 'auf meine Website',
		show : 'mouseover',
		hide : 'mouseout',
		position : {
			corner : {
				target : 'topLeft',
				tooltip : 'bottomLeft'
			}
		},
		style : {
			name: 'domstyle',
			textAlign: 'left',
			tip: 'bottomMiddle'
		}
	});
	
	//projektseite
	jQuery('#hpvvp').qtip( {
		content : 'Zur Projektseite. Hier gibt es den gesamten Code, Anleitungen, Hilfe und das Programmm selber zum Downloaden. ',
		show : 'mouseover',
		hide : 'mouseout',
		position : {
			corner : {
				target : 'topMiddle',
				tooltip : 'bottomMiddle'
			}
		},
		style : {
			name: 'domstyle',
			textAlign: 'left',
			tip: 'bottomMiddle'
		}
	});
	
	
	//nach oben
	jQuery('#up_btn').qtip( {
		content : 'nach oben',
		show : 'mouseover',
		hide : 'mouseout',
		position : {
			corner : {
				target : 'topLeft',
				tooltip : 'bottomRight'
			}
		},
		style : {
			width: 50,
			name: 'domstyle',
			tip: 'bottomRight'
		}
	});

});