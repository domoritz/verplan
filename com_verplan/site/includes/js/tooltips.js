/**
 * qTips tooltips für das frontend
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.net}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 14-Nov-2009
 */


var style = '';

function updateTooltipStyle() {
	var theme = jQuery.cookie('jquery-ui-theme');
	
	console.log('jQuery UI theme: '+theme);
	
	switch (theme) {
	case 'UI darkness':
		style = "own";
		break;
		
	case 'UI lightness':
		style = "dark";
		break;
		
	case 'Start':
		style = "dark";
		break;

	default:
		style = "own";
		break;
	}
	
	console.log('Tooltipstyle: '+style);
}

jQuery(document).ready(function() {
	updateTooltipStyle();
	
	defaultStyle();
	createTooltips();
});

function defaultStyle() {
	
	jQuery.fn.qtip.styles.domstyle = { // Last part is the name of the style
	   tip: { 
	      corner: true, 
	      background: null 
	   }, 
	   'font-size': 'small',
	   border: { 
	      width: 3, 
	      radius: 2 
	   },
//	   classes: { 
//	      tooltip: 'ui-widget', 
//	      tip: 'ui-widget', 
//	      title: 'ui-widget-header', 
//	      content: 'ui-widget-content' 
//	   },
	   
	   //style ist eine variable
	   name: style // Inherit the rest of the attributes from the preset style
	};
	
	jQuery.fn.qtip.styles.own = { // Last part is the name of the style
		color: '#000',
		background: '#DCEDFF',
		//background: '#ffffff',
	   	border: {
			color: '#59B4D4'
			//color: '#CCCCCC'
		},
	   
	   	name: 'blue' // Inherit the rest of the attributes from the preset style
	};
}

function createTooltips() {

	/*
	 * tooltips http://craigsworks.com/projects/qtip/
	 */	
	
	//tooltips für alle links
	jQuery('a[title]').qtip({ 
		style: { 
			name: 'domstyle', 
			tip: true 
		},
		position : {
			corner : {
				target : 'topMiddle',
				tooltip : 'bottomLeft'
			}
		}
	});
	
	jQuery('#help_head').qtip( {
		content : 'Benutzerhandbuch und Hilfe',
		position : {
			corner : {
				target : 'leftMiddle',
				tooltip : 'rightMiddle'
			}
		},
		style : {
			name: 'domstyle'
		}
	});
	
	jQuery('#options_label').qtip( {
		content : 'nicht beachten',
		position : {
			corner : {
				target : 'topRight',
				tooltip : 'bottomLeft'
			}
		},
		style : {
			name: 'domstyle'
		}
	});
	
	jQuery('#stand_label').qtip( {
		content : 'nicht beachten',
		position : {
			corner : {
				target : 'topRight',
				tooltip : 'bottomLeft'
			}
		},
		style : {
			name: 'domstyle'
		}
	});
	
	jQuery('#filter_label').qtip( {
		content : 'Daten nach einer bestimmten Spalte filtern. Die Spalte, nach der gefiltert werden soll, kannst du in der Auswahlbox rechts neben dem Textfeld auswählen.',
		hide: {
			when: 'mouseout',
			fixed: true
		},
		show: 'mouseover',
		position : {
			corner : {
				target : 'topRight',
				tooltip : 'bottomLeft'
			}
		},
		style : {
			name: 'domstyle'
		}
	});
	
	//schließen bei click
	jQuery('#filter_label').click(function(){
		jQuery(this).qtip("hide");
	});
	
	
	jQuery('#filter_label_klassen').qtip( {
		content : 'Filtere die Tabelle nach deiner Klasse. Die Eingabe bleibt auch erhalten, wenn du einen neuen Plan wählst oder sogar die Seite neu aufrufst. ',
		hide: {
			when: 'mouseout',
			fixed: true
		},
		show: 'mouseover',
		position : {
			corner : {
				target : 'topRight',
				tooltip : 'bottomLeft'
			}
		},
		style : {
			name: 'domstyle'
		}
	});
	
	//schließen bei click
	jQuery('#filter_label_klassen').click(function(){
		jQuery(this).qtip("hide");
	});
	
	
	jQuery('#link_mobile').qtip( {
		content : 'Zur mobilen Ansicht wechseln. Diese Ansicht ist für Handys, Smartphones und Subnoteboks optimiert.',
		hide: {
			when: 'mouseout',
			fixed: true
		},
		show: 'mouseover',
		position : {
			corner : {
				target : 'topRight',
				tooltip : 'bottomLeft'
			}
		},
		style : {
			name: 'domstyle'
		}
	});
	
	//schließen bei click
	jQuery('#link_mobile').click(function(){
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
	
	//spaltentitel, es werden beschreibungen angezeigt
	jQuery('#jquerytable thead th[title]').qtip( {
		content : {
			//keit content, damit der text aus dem title attribut genutz wird
		},
		show : 'mouseover',
		hide: {
			when: 'mouseout',
			//hält tooltip auch, wenn man mit der maus aus den tootip fährt
			fixed: true
		},
		position : {
			corner : {
				target : 'bottomMiddle',
				tooltip : 'topMiddle'
			}
		},
		style : {
			name: 'domstyle',
			textAlign: 'center',
			tip: 'topMiddle'
		}
	});
	
	//feedback
	jQuery('#feedy').qtip( {
		content : {
            // Set the text to an image HTML string with the correct src URL to the loading image you want to use
            text: 'Gib dein <strong>Feedback</strong> ab!<br><p id="closefeedy" style="cursor: pointer; font-weight: bold; float:right;">schließen</p>'
		    //text: 'Hey, du benutzt eine <strong>Vorabversion</strong>. Damit Fehler behoben werden und das Programm verbessert wird, gib bitte dein <strong>Feedback</strong> ab. Jedes einzelne ist wichtig für mich. <br>Vielen Dank und viel Spaß<br><p id="closefeedy" style="cursor: pointer; font-weight: bold; float:right;">schließen</p> '
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

};