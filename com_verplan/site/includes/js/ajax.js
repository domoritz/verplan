jQuery(document).ready(function(){
	
	loadJsonTable(false);
	
	function loadJsonTable(effects) {
		//jQuery('#ajaxtable').load("index.php?option=com_verplan&view=verplan&format=js&date=2009-09-24");
		
		jQuery('#ajaxtable').append('<span id="load"></span>');  
		jQuery('#load').fadeIn('normal');
		
		var speed = 1000;
		
		if (effects) {					
			jQuery('#ajaxtable').toggle('blind',speed, loadContent());		
		} else {
			jQuery('#ajaxtable').toggle('blind',1, loadContent());	
		}
		
		
		function loadContent() {  
			var date = jQuery('#select_date').val();
			jQuery.getJSON('index.php?option=com_verplan&view=verplan&format=js&date='+date+'&stand=newest', function(json){
				var table = '';
				//alert("JSON Data: " + json.data[0].id);
				table += '<table style="width:80%; border:1px;"><thead>';
				jQuery.each(json.colnames, function() {
					table+= '<th>';
					table+=this;
					table+= '<th>';
				});
				
				table+='</thead></table>';
				jQuery('#ajaxtable').html(table);
				showNewContent();
				  
			});

			//jQuery('#ajaxtable').load('index.php?option=com_verplan&view=verplan&format=js&date='+date+'&stand=newest','',showNewContent());
			/*jQuery.ajax({
				type: "GET",
				url: "index.php",
				data: "?option=com_verplan&view=verplan&format=js&date=2009-09-24",
				success: function(html){
					jQuery('#ajaxtable').html(html);
					showNewContent();
					alert( "Data Saved: ");
				}
			});*/
			//alert( "date: "+date);
		 }  
		function showNewContent() {  
			//jQuery('#ajaxtable').show('normal',hideLoader());
			if (effects) {
				jQuery('#ajaxtable').toggle('blind',speed,hideLoader());
			} else {
				jQuery('#ajaxtable').toggle('blind',1,hideLoader());
			}
			
		}  
		function hideLoader() {  
			jQuery('#load').fadeOut('slow');  
		}  
		
		/*jQuery.ajax({
			type: "GET",
			url: "index.php",
			data: "?option=com_verplan&view=verplan&format=js&date=2009-09-24",
			success: function(html){
				jQuery('#ajaxtable').html(html);
				alert( "Data Saved: ");
			}
		});*/
	}
	jQuery('#select_date').change(function(){
		loadJsonTable(true);
		
	});
});