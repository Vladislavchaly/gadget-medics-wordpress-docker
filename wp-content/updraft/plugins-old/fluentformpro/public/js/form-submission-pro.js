jQuery(document).ready(function() {
	(function(fluentFormVars, $) {
		$.each(fluentFormVars.forms, function(formId, form) {

			/**
			 * Current form
			 * @type jQuery object
			 */
			var $theForm = $('#' + formId);

			(function() {

				/**
				 * Run Initializer
				 * @return {void}
				 */
				var init = function() {
					registerRepeaterButtons();
				};

				/**
				 * Register event handlers for repeater
				 * input to dynamically add/remove items
				 * 
				 * @return void
				 */
				var registerRepeaterButtons = function() {
					$theForm.on('click', '.repeat-plus', function(e) {
						var target, cloned, newId;

						target = $(this).parent().parent();
						cloned = target.clone();
						newId = 'ffrpt-' + (new Date).getTime();
						cloned.find('label').remove();
						cloned.find('input').prop({value: '', id: newId});
						cloned.find('.repeat-minus').removeClass('first');
						cloned.insertAfter(target).find('input').focus();
					});

					$('.fluentform').on('click', '.repeat-minus:not(".first")', function(e) {
						$(this).parent().parent().remove();
					});
				};

				init();

			})();
		});
	})(fluentFormVars, jQuery);
});
