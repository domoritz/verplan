$(document).ready(function() {
	$('#dataTables').dataTable( {		
		"bProcessing": true,		
		"sAjaxSource": 'http://www.datatables.net/examples/examples_support/json_source.txt'
		//"sAjaxSource": 'index.php?option=com_verplan&view=verplan&Itemid=11&format=jsplugin&date=2009-09-24 00:00:00&stand=newest'
	} );
} );