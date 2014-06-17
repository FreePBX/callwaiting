var CallwaitingC = UCPMC.extend({
	init: function(){
	},
	settingsDisplay: function() {
		$('#cwenable').change(function() {
			$.post( "index.php?quietmode=1&module=callwaiting&command=enable", {enable: $(this).is(':checked'), ext: ext}, function( data ) {
				$('#module-Callwaiting .message').text(data.message).addClass('alert-'+data.alert).fadeIn('fast', function() {
					$(this).delay(2000).fadeOut('fast', function() {
						$('.masonry-container').packery();
					});
				});
				$('.masonry-container').packery();
			});
		});
	},
	settingsHide: function() {
		$('#cwenable').off('change');
	}
});
var Callwaiting = new CallwaitingC();
