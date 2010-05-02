/**
 * qTips tooltips für das frontend
 * http://craigsworks.com/projects/qtip/
 * 
 * @version		$Id$
 * @package		verplan
 * @author		Dominik Moritz {@link http://www.dmoritz.bplaced.de}
 * @link		http://code.google.com/p/verplan/
 * @license		GNU/GPL
 * @author      Created on 14-Nov-2009
 */

defaultStyle();
jQuery(document).ready(function() {	
	createTooltips();
});

function createTooltips() {

	/*
	 * tooltips http://craigsworks.com/projects/qtip/
	 */	
	
	jQuery('#header_verplan a, #logo_verplan').not('#help_head').qtip( {
		content : {
			//keit content, damit der text aus dem title attribut genutzt wird
		},
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
	
	jQuery('#help_head').qtip( {
		content : {
			//keit content, damit der text aus dem title attribut genutzt wird
		},
		position : {
			corner : {
				target : 'topMiddle',
				tooltip : 'bottomRight'
			}
		},
		style : {
			name: 'domstyle'
		}
	});
	
	jQuery('#filter_label span.ui-icon').qtip( {
		content : {},
		hide: {
			when: 'mouseout',
			fixed: true
		},
		show: 'mouseover',
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
	
	//schließen bei click
	jQuery('#filter_label span.ui-icon').click(function(){
		jQuery(this).qtip("hide");
	});
	
	
	jQuery('#filter_label_klassen span.ui-icon').qtip( {
		content : {},
		hide: {
			when: 'mouseout',
			fixed: true
		},
		show: 'mouseover',
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
	
	//schließen bei click
	jQuery('#filter_label_klassen span.ui-icon').click(function(){
		jQuery(this).qtip("hide");
	});
	
	
	jQuery('#link_mobile span.ui-icon').qtip( {
		content : {},
		hide: {
			when: 'mouseout',
			fixed: true
		},
		show: 'mouseover',
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
	
	//schließen bei click
	jQuery('#link_mobile span.ui-icon').click(function(){
		jQuery(this).qtip("hide");
		return false;
	});
	
	
	jQuery('.ui-selectmenu-status').qtip( {
		content : 'Hier kannst Du das Geltungsdatum wählen',
		show : 'mouseover',
		hide : 'mouseout',
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
	
	jQuery('#refresh').qtip( {
		content : {},
		show : 'mouseover',
		hide : 'mouseout',
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
	
	jQuery('#expander_options').qtip( {
		content : {},
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
	
	jQuery('#ui_themeswitcher').qtip( {
		content : 'Wähle ein Design aus, das Dir gefällt.',
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
	
	//spaltentitel, es werden beschreibungen angezeigt
	jQuery('#jquerytable thead th[title]').qtip( {
		content : {},
		show : 'mouseover',
		hide: {
			when: 'mouseout',
			//hält tooltip auch, wenn man mit der maus aus den tootip fährt
			fixed: true
		},
		position : {
			corner : {
				target : 'topMiddle',
				tooltip : 'bottomMiddle'
			}
		},
		style : {
			name: 'domstyle',
			textAlign: 'center',
			tip: 'bottomMiddle'
		}
	});
	
	//feedback
	jQuery('#feedy').qtip( {
		content : {
            // Set the text to an image HTML string with the correct src URL to the loading image you want to use
            text: 'Gib Dein <strong>Feedback</strong>, damit ich das Programm verbessern kann!<br><p id="closefeedy" style="cursor: pointer; font-weight: bold; float:right;">schließen</p>'
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
		        radius: 1,
		        color: '#A00000'
		    } , 
			width: 220,	  
			tip: 'topMiddle',
			'font-size': 'small'
		}
	});
	//show feedy as default
	jQuery('#feedy').focus();
	
	//focus verschieben
	jQuery('#refresh').focus();
	
	
	//schließen bei click
	jQuery('#closefeedy').click(function(){
		jQuery('#feedy').qtip("hide");
	});
	
	//meine website
	jQuery('#link_homepage').qtip( {
		content : {},
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
	jQuery('#link_project_2').qtip( {
		content : {},
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
		content : {},
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