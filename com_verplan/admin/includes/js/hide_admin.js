$(document).ready(function(){
	$('#admin_settings_div').hide('');
	$('#options_header').click(function() {
		$('#admin_settings_div').toggle('blind','normal');
		$(this).toggleClass('plus').toggleClass('minus');
	});
});