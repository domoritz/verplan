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
	    border: {
	        width: 4,
	        radius: 5,
	        color: '#333'
	    } , 
		width: 200,	   
	    textAlign: 'center',
	    tip: 'bottomLeft',
	    name: 'dark' // Inherit the rest of the attributes from the preset dark style
	};
	
	jQuery('#select_date').qtip( {
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


});