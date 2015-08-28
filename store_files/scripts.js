var layer_state = false;
var layer_pop = function() {
	
	if( layer_state == false ) {
		$('div#body_layer').fadeIn('fast').removeClass("hidden").addClass("block");
		$('div#body_layer-fog').fadeIn('fast').removeClass("hidden").addClass("block");
		$('div#body_layer-inner').fadeIn('fast', function() {
			layer_state = true;
		}).removeClass("hidden").addClass("block");
	} else {
		$('div#body_layer').fadeOut('fast').removeClass("block").addClass("hidden");
		$('div#body_layer-fog').fadeOut('fast').removeClass("block").addClass("hidden");
		$('div#body_layer-inner').fadeOut('fast', function() {
			layer_state = false;
		}).removeClass("block").addClass("hidden");
	}
	
}


$(document).ready(function() {
	$('div#body_layer-close img, .layer_pop').click( function() {
		layer_pop();
	});
});