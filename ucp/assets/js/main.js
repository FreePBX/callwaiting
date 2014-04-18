var Callwaiting = new function() {
	this.initalized = false;
	this.init = function() {
		//prevent multiple loads of this class which end up destroying content and rebinding a gazillon times
		if(this.initalized) {
			return false;
		}
	};
};

//MUST REMAIN AT BOTTOM!
//This might not be needed as most browser seem to run doc ready anyways
//TODO: This should be in the higher up. each module should have this functionality from here on out!
$(function() {
	Callwaiting.init();
	$('#cwenable').change(function() {
		$.post( "index.php?quietmode=1&module=callwaiting&command=enable", {enable: $(this).is(':checked'), ext: ext}, function( data ) {
			$('#module-Callwaiting .message').text(data.message).addClass('alert-'+data.alert).fadeIn('fast', function() {
				$('.masonry-container').packery();
				$(this).delay(2000).fadeOut('fast', function() {
					$('.masonry-container').packery();
				});
			});
		});
	});
});
