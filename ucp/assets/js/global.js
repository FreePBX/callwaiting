var CallwaitingC = UCPMC.extend({
	init: function(){
		this.stopPropagation = {};
	},
	prepoll: function() {
		var exts = [];
		$(".grid-stack-item[data-rawname=callwaiting]").each(function() {
			exts.push($(this).data("widget_type_id"));
		});
		return exts;
	},
	poll: function(data) {
		console.log(data);
		var self = this;
		var change = function(extension, state, el) {
			if(!el.length) {
				return;
			}
			var current = el.is(":checked");
			if(state && !current) {
				self.stopPropagation[extension] = true;
				el.bootstrapToggle('on');
				self.stopPropagation[extension] = false;
			} else if(!state && current) {
				self.stopPropagation[extension] = true;
				el.bootstrapToggle('off');
				self.stopPropagation[extension] = false;
			}
		};
		$.each(data.states, function(ext,v) {
			var state = (v == "ENABLED") ? true : false;

			change(ext, state, $(".grid-stack-item[data-rawname=callwaiting][data-widget_type_id='"+ext+"'] input[name='cwenable']"));
			change(ext, state, $(".widget-extra-menu[data-module='callwaiting'][data-widget_type_id='"+ext+"'] input[name='cwenable']"));
		});
	},
	displayWidget: function(widget_id,dashboard_id) {
		var self = this;
		$("div[data-id='"+widget_id+"'] .widget-content input[name='cwenable']").change(function(e) {
			var extension = $("div[data-id='"+widget_id+"']").data("widget_type_id"),
					checked = $(this).is(':checked');
			if(typeof self.stopPropagation[extension] !== "undefined" && self.stopPropagation[extension]) {
				return;
			}
			self.saveSettings(extension, {enable: checked}, function(data) {
				var el = $(".widget-extra-menu[data-module='callwaiting'][data-widget_type_id='"+extension+"'] input[name='cwenable']");
				if(el.length) {
					if(checked) {
						el.bootstrapToggle('on');
					} else {
						el.bootstrapToggle('off');
					}
				}
			});
		});
	},
	saveSettings: function(extension, data, callback) {
		var self = this;
		self.stopPropagation[extension] = true;
		data.ext = extension;
		data.module = "Callwaiting";
		data.command = "enable";
		$.post( UCP.ajaxUrl, data, callback).always(function() {
			self.stopPropagation[extension] = false;
		});
	},
	displaySimpleWidget: function(widget_type_id) {
		var self = this;
		$(".widget-extra-menu[data-module=callwaiting] input[name='cwenable']").change(function(e) {
			var extension = widget_type_id,
					checked = $(this).is(':checked');
			if(typeof self.stopPropagation[extension] !== "undefined" && self.stopPropagation[extension]) {
				return;
			}
			self.saveSettings(extension, {enable: $(this).is(':checked')}, function(data){
				if (data.status) {
					//update elements on the current dashboard if there are any
					var el = $(".grid-stack-item[data-rawname='callwaiting'][data-widget_type_id='"+extension+"'] input[name='cwenable']");
					if(el.length) {
						if(checked) {
							el.bootstrapToggle('on');
						} else {
							el.bootstrapToggle('off');
						}
					}
				}
			});
		});
	}
});
