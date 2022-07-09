(function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return c(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
'use strict';

jQuery(document).ready(function ($) {
	$('#use_multiple_locations').click(function () {
		if ($(this).is(':checked')) {
			$('#use_multiple_locations').attr('disabled', true);
			$('#single-location-settings').slideUp(function () {
				$('#multiple-locations-settings').slideDown();
				$('#sl-settings').slideDown();
				$('#opening-hours-hours').slideUp(function () {
					$('#use_multiple_locations').removeAttr('disabled');
				});
			});
			$('.open_247_wrapper').slideUp();
			$('.default-setting').show();
		} else {
			$('#use_multiple_locations').attr('disabled', true);
			$('#multiple-locations-settings').slideUp(function () {
				$('#single-location-settings').slideDown();
				if (!$('#hide_opening_hours').is(':checked')) {
					$('#opening-hours-hours').slideDown();
				}
				$('#sl-settings').slideUp();
				$('#use_multiple_locations').removeAttr('disabled');
			});
			$('.open_247_wrapper').slideDown();
			$('.default-setting').hide();
		}
	});

	$('.wpseo_local_help').on('click', function () {
		$(this).closest('.wpseo-local-help-wrapper').find('.wpseo-local-help-text').slideToggle();
	});

	$('#hide_opening_hours').click(function () {
		if ($(this).is(':checked')) {
			$('#opening-hours-hours, #opening-hours-settings').slideUp();
		} else {
			$('#opening-hours-settings').slideDown();
			if (!$('#use_multiple_locations').is(':checked')) {
				$('#opening-hours-hours').slideDown();
			}
		}
	});
	$('#multiple_opening_hours, #wpseo_multiple_opening_hours').click(function () {
		if ($(this).is(':checked')) {
			$('.opening-hours .opening-hours-second').slideDown();
		} else {
			$('.opening-hours .opening-hours-second').slideUp();
		}
	});
	$('#opening_hours_24h').click(function () {
		$('#opening-hours-container select').each(function () {
			$(this).find('option').each(function () {
				if ($('#opening_hours_24h').is(':checked')) {
					// Use 24 hour
					if ($(this).val() != 'closed') {
						$(this).text($(this).val());
					}
				} else {
					// Use 12 hour
					if ($(this).val() != 'closed') {
						// Split the string between hours and minutes
						var time = $(this).val().split(':');

						// use parseInt to remove leading zeroes.
						var hour = parseInt(time[0]);
						var minutes = time[1];
						var suffix = 'AM';
						// if the hours number is greater than 12, subtract 12.
						if (hour >= 12) {
							if (hour > 12) {
								hour = hour - 12;
							}
							suffix = 'PM';
						}
						if (hour == 0) {
							hour = 12;
						}

						$(this).text(hour + ':' + minutes + ' ' + suffix);
					}
				}
			});
		});
	});

	// The 24h format on single location page (if multiple locations is set)
	$('#wpseo_format_24h, #wpseo_format_12h').click(function () {
		$('#hide-opening-hours select').each(function () {
			$(this).find('option').each(function () {
				if ($('#wpseo_format_24h').length > 0 && $('#wpseo_format_24h').is(':checked') || $('#wpseo_format_12h').length > 0 && !$('#wpseo_format_12h').is(':checked')) {
					// Use 24 hour
					if ($(this).val() != 'closed') {
						$(this).text($(this).val());
					}
				} else {
					// Use 12 hour
					if ($(this).val() != 'closed') {
						// Split the string between hours and minutes
						var time = $(this).val().split(':');

						// use parseInt to remove leading zeroes.
						var hour = parseInt(time[0]);
						var minutes = time[1];
						var suffix = 'AM';
						// if the hours number is greater than 12, subtract 12.
						if (hour >= 12) {
							if (hour > 12) {
								hour = hour - 12;
							}
							suffix = 'PM';
						}
						if (hour == 0) {
							hour = 12;
						}

						$(this).text(hour + ':' + minutes + ' ' + suffix);
					}
				}
			});
		});
	});

	// General Settings: Enable/disable Open 24/7 on click
	$('#open_247').on('click', function () {
		if (!$('#use_multiple_locations').is(":checked")) {
			maybeCloseOpeningHours(this);
			$('.open_247_wrapper').show();
		}
	});

	// Single Location: Enable/disable Open 24/7 on click
	$('#wpseo_open_247').on('click', function () {
		maybeCloseOpeningHours(this);
	});

	// Disable hours 24/7 on click
	$('.wpseo_open_24h input').on('click', function (e) {
		if ($(this).is(":checked")) {
			$('select', $('.openinghours-wrapper', $(this).closest('.opening-hours'))).attr('disabled', true);
		} else {
			$('select', $('.openinghours-wrapper', $(this).closest('.opening-hours'))).attr('disabled', false);
		}
	});

	function maybeCloseOpeningHours(elem) {
		if ($(elem).is(':checked')) {
			$('#opening-hours-rows, .opening-hours-wrap').slideUp();
		} else {
			$('#opening-hours-rows, .opening-hours-wrap').slideDown();
		}
	}

	$('.widget-content').on('click', '#wpseo-checkbox-multiple-locations-wrapper input[type=checkbox]', function () {
		wpseo_show_all_locations_selectbox($(this));
	});

	// Show locations metabox before WP SEO metabox
	if ($('#wpseo_locations').length > 0 && $('#wpseo_meta').length > 0) {
		$('#wpseo_locations').insertBefore($('#wpseo_meta'));
	}

	$('.openinghours_from').change(function () {
		var to_id = $(this).attr('id').replace('_from', '_to_wrapper');
		var second_id = $(this).attr('id').replace('_from', '_second');

		if ($(this).val() == 'closed') {
			$('#' + to_id).css('display', 'none');
			$('#' + second_id).css('display', 'none');
		} else {
			$('#' + to_id).css('display', 'inline');
			$('#' + second_id).css('display', 'block');
		}
	}).change();
	$('.openinghours_from_second').change(function () {
		var to_id = $(this).attr('id').replace('_from', '_to_wrapper');

		if ($(this).val() == 'closed') {
			$('#' + to_id).css('display', 'none');
		} else {
			$('#' + to_id).css('display', 'inline');
		}
	}).change();
	$('.openinghours_to').change(function () {
		var from_id = $(this).attr('id').replace('_to', '_from');
		var to_id = $(this).attr('id').replace('_to', '_to_wrapper');
		if ($(this).val() == 'closed') {
			$('#' + to_id).css('display', 'none');
			$('#' + from_id).val('closed');
		}
	});
	$('.openinghours_to_second').change(function () {
		var from_id = $(this).attr('id').replace('_to', '_from');
		var to_id = $(this).attr('id').replace('_to', '_to_wrapper');
		if ($(this).val() == 'closed') {
			$('#' + to_id).css('display', 'none');
			$('#' + from_id).val('closed');
		}
	});

	if ($('.set_custom_images').length > 0) {
		if (typeof wp !== 'undefined' && wp.media && wp.media.editor) {
			$('.wrap').on('click', '.set_custom_images', function (e) {
				e.preventDefault();
				var button = $(this);
				var id = button.attr('data-id');
				wp.media.editor.send.attachment = function (props, attachment) {
					if (attachment.hasOwnProperty('sizes')) {
						var url = attachment.sizes[props.size].url;
					} else {
						var url = attachment.url;
					}

					$('#' + id + '_image_container').attr('src', url);
					$('.wpseo-local-' + id + '-wrapper .wpseo-local-hide-button').show();
					$('#hidden_' + id).attr('value', attachment.id);
				};
				wp.media.editor.open(button);
				return false;
			});
		}
	}

	$('.remove_custom_image').on('click', function (e) {
		e.preventDefault();

		var id = $(this).attr('data-id');
		$('#' + id).attr('src', '').hide();
		$('#hidden_' + id).attr('value', '');
		$('.wpseo-local-' + id + '-wrapper .wpseo-local-hide-button').hide();
	});

	// Copy location data
	$('#wpseo_copy_from_location').change(function () {
		var location_id = $(this).val();

		if (location_id == '') return;

		$.post(wpseo_local_data.ajaxurl, {
			location_id: location_id,
			security: wpseo_local_data.sec_nonce,
			action: 'wpseo_copy_location'
		}, function (result) {
			if (result.charAt(result.length - 1) == 0) {
				result = result.slice(0, -1);
			} else if (result.substring(result.length - 2) == "-1") {
				result = result.slice(0, -2);
			}

			var data = $.parseJSON(result);
			if (data.success == 'true' || data.success == true) {

				for (var i in data.location) {
					var value = data.location[i];

					if (value != null && value != '' && typeof value != 'undefined') {
						if (i == 'is_postal_address' || i == 'multiple_opening_hours') {
							if (value == '1') {
								$('#wpseo_' + i).attr('checked', 'checked');
								$('.opening-hours .opening-hour-second').slideDown();
							}
						} else if (i.indexOf('opening_hours') > -1) {
							$('#' + i).val(value);
						} else {
							$('#wpseo_' + i).val(value);
						}
					}
				}
			}
		});
	});
});

window.wpseo_show_all_locations_selectbox = function (obj) {
	$ = jQuery;

	$obj = $(obj);
	var parent = $obj.parents('.widget-inside');
	var $locationsWrapper = $('#wpseo-locations-wrapper', parent);

	if ($obj.is(':checked')) {
		$locationsWrapper.slideUp();
	} else {
		$locationsWrapper.slideDown();
	}
};

},{}]},{},[1])
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9icm93c2VyLXBhY2svX3ByZWx1ZGUuanMiLCJqcy9zcmMvd3Atc2VvLWxvY2FsLWdsb2JhbC5qcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTs7O0FDQUEsT0FBTyxRQUFQLEVBQWlCLEtBQWpCLENBQXVCLFVBQVUsQ0FBVixFQUFhO0FBQ25DLEdBQUUseUJBQUYsRUFBNkIsS0FBN0IsQ0FBbUMsWUFBWTtBQUM5QyxNQUFJLEVBQUUsSUFBRixFQUFRLEVBQVIsQ0FBVyxVQUFYLENBQUosRUFBNEI7QUFDM0IsS0FBRSx5QkFBRixFQUE2QixJQUE3QixDQUFrQyxVQUFsQyxFQUE4QyxJQUE5QztBQUNBLEtBQUUsMkJBQUYsRUFBK0IsT0FBL0IsQ0FBdUMsWUFBWTtBQUNsRCxNQUFFLDhCQUFGLEVBQWtDLFNBQWxDO0FBQ0EsTUFBRSxjQUFGLEVBQWtCLFNBQWxCO0FBQ0EsTUFBRSxzQkFBRixFQUEwQixPQUExQixDQUFrQyxZQUFZO0FBQzdDLE9BQUUseUJBQUYsRUFBNkIsVUFBN0IsQ0FBd0MsVUFBeEM7QUFDQSxLQUZEO0FBR0EsSUFORDtBQU9BLEtBQUUsbUJBQUYsRUFBdUIsT0FBdkI7QUFDQSxLQUFFLGtCQUFGLEVBQXNCLElBQXRCO0FBQ0EsR0FYRCxNQVdPO0FBQ04sS0FBRSx5QkFBRixFQUE2QixJQUE3QixDQUFrQyxVQUFsQyxFQUE4QyxJQUE5QztBQUNBLEtBQUUsOEJBQUYsRUFBa0MsT0FBbEMsQ0FBMEMsWUFBWTtBQUNyRCxNQUFFLDJCQUFGLEVBQStCLFNBQS9CO0FBQ0EsUUFBSSxDQUFDLEVBQUUscUJBQUYsRUFBeUIsRUFBekIsQ0FBNEIsVUFBNUIsQ0FBTCxFQUE4QztBQUM3QyxPQUFFLHNCQUFGLEVBQTBCLFNBQTFCO0FBQ0E7QUFDRCxNQUFFLGNBQUYsRUFBa0IsT0FBbEI7QUFDQSxNQUFFLHlCQUFGLEVBQTZCLFVBQTdCLENBQXdDLFVBQXhDO0FBQ0EsSUFQRDtBQVFBLEtBQUUsbUJBQUYsRUFBdUIs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QUZNLE1BRUE7QUFDTixTQUFFLFlBQVksQ0FBZCxFQUFpQixHQUFqQixDQUFxQixLQUFyQjtBQUNBO0FBQ0Q7QUFDRDtBQUNEO0FBQ0QsR0EvQkQ7QUFnQ0EsRUF0Q0Q7QUF1Q0EsQ0EvUUQ7O0FBaVJBLE9BQU8sa0NBQVAsR0FBNEMsVUFBVSxHQUFWLEVBQWU7QUFDMUQsS0FBSSxNQUFKOztBQUVBLFFBQU8sRUFBRSxHQUFGLENBQVA7QUFDQSxLQUFJLFNBQVMsS0FBSyxPQUFMLENBQWEsZ0JBQWIsQ0FBYjtBQUNBLEtBQUksb0JBQW9CLEVBQUUsMEJBQUYsRUFBOEIsTUFBOUIsQ0FBeEI7O0FBRUEsS0FBSSxLQUFLLEVBQUwsQ0FBUSxVQUFSLENBQUosRUFBeUI7QUFDeEIsb0JBQWtCLE9BQWxCO0FBQ0EsRUFGRCxNQUVPO0FBQ04sb0JBQWtCLFNBQWxCO0FBQ0E7QUFDRCxDQVpEIiwiZmlsZSI6ImdlbmVyYXRlZC5qcyIsInNvdXJjZVJvb3QiOiIiLCJzb3VyY2VzQ29udGVudCI6WyIoZnVuY3Rpb24oKXtmdW5jdGlvbiByKGUsbix0KXtmdW5jdGlvbiBvKGksZil7aWYoIW5baV0pe2lmKCFlW2ldKXt2YXIgYz1cImZ1bmN0aW9uXCI9PXR5cGVvZiByZXF1aXJlJiZyZXF1aXJlO2lmKCFmJiZjKXJldHVybiBjKGksITApO2lmKHUpcmV0dXJuIHUoaSwhMCk7dmFyIGE9bmV3IEVycm9yKFwiQ2Fubm90IGZpbmQgbW9kdWxlICdcIitpK1wiJ1wiKTt0aHJvdyBhLmNvZGU9XCJNT0RVTEVfTk9UX0ZPVU5EXCIsYX12YXIgcD1uW2ldPXtleHBvcnRzOnt9fTtlW2ldWzBdLmNhbGwocC5leHBvcnRzLGZ1bmN0aW9uKHIpe3ZhciBuPWVbaV1bMV1bcl07cmV0dXJuIG8obnx8cil9LHAscC5leHBvcnRzLHIsZSxuLHQpfXJldHVybiBuW2ldLmV4cG9ydHN9Zm9yKHZhciB1PVwiZnVuY3Rpb25cIj09dHlwZW9mIHJlcXVpcmUmJnJlcXVpcmUsaT0wO2k8dC5sZW5ndGg7aSsrKW8odFtpXSk7cmV0dXJuIG99cmV0dXJuIHJ9KSgpIiwialF1ZXJ5KGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbiAoJCkge1xuXHQkKCcjdXNlX211bHRpcGxlX2xvY2F0aW9ucycpLmNsaWNrKGZ1bmN0aW9uICgpIHtcblx0XHRpZiAoJCh0aGlzKS5pcygnOmNoZWNrZWQnKSkge1xuXHRcdFx0JCgnI3VzZV9tdWx0aXBsZV9sb2NhdGlvbnMnKS5hdHRyKCdkaXNhYmxlZCcsIHRydWUpO1xuXHRcdFx0JCgnI3NpbmdsZS1sb2NhdGlvbi1zZXR0aW5ncycpLnNsaWRlVXAoZnVuY3Rpb24gKCkge1xuXHRcdFx0XHQkKCcjbXVsdGlwbGUtbG9jYXRpb25zLXNldHRpbmdzJykuc2xpZGVEb3duKCk7XG5cdFx0XHRcdCQoJyNzbC1zZXR0aW5ncycpLnNsaWRlRG93bigpO1xuXHRcdFx0XHQkKCcjb3BlbmluZy1ob3Vycy1ob3VycycpLnNsaWRlVXAoZnVuY3Rpb24gKCkge1xuXHRcdFx0XHRcdCQoJyN1c2VfbXVsdGlwbGVfbG9jYXRpb25zJykucmVtb3ZlQXR0cignZGlzYWJsZWQnKTtcblx0XHRcdFx0fSk7XG5cdFx0XHR9KTtcblx0XHRcdCQoJy5vcGVuXzI0N193cmFwcGVyJykuc2xpZGVVcCgpO1xuXHRcdFx0JCgnLmRlZmF1bHQtc2V0dGluZycpLnNob3coKTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0JCgnI3VzZV9tdWx0aXBsZV9sb2NhdGlvbnMnKS5hdHRyKCdkaXNhYmxlZCcsIHRydWUpO1xuXHRcdFx0JCgnI211bHRpcGxlLWxvY2F0aW9ucy1zZXR0aW5ncycpLnNsaWRlVXAoZnVuY3Rpb24gKCkge1xuXHRcdFx0XHQkKCcjc2luZ2xlLWxvY2F0aW9uLXNldHRpbmdzJykuc2xpZGVEb3duKCk7XG5cdFx0XHRcdGlmICghJCgnI2hpZGVfb3BlbmluZ19ob3VycycpLmlzKCc6Y2hlY2tlZCcpKSB7XG5cdFx0XHRcdFx0JCgnI29wZW5pbmctaG91cnMtaG91cnMnKS5zbGlkZURvd24oKTtcblx0XHRcdFx0fVxuXHRcdFx0XHQkKCcjc2wtc2V0dGluZ3MnKS5zbGlkZVVwKCk7XG5cdFx0XHRcdCQoJyN1c2VfbXVsdGlwbGVfbG9jYXRpb25zJykucmVtb3ZlQXR0cignZGlzYWJsZWQnKTtcblx0XHRcdH0pO1xuXHRcdFx0JCgnLm9wZW5fMjQ3X3dyYXBwZXInKS5zbGlkZURvd24oKTtcblx0XHRcdCQoJy5kZWZhdWx0LXNldHRpbmcnKS5oaWRlKCk7XG5cdFx0fVxuXHR9KTtcblxuICAgICQoJy53cHNlb19sb2NhbF9oZWxwJykub24oJ2NsaWNrJywgZnVuY3Rpb24gKCkge1xuICAgICAgICAkKHRoaXMpLmNsb3Nlc3QoJy53cHNlby1sb2NhbC1oZWxwLXdyYXBwZXInKS5maW5kKCcud3BzZW8tbG9jYWwtaGVscC10ZXh0Jykuc2xpZGVUb2dnbGUoKTtcbiAgICB9KTtcblxuXHQkKCcjaGlkZV9vcGVuaW5nX2hvdXJzJykuY2xpY2soZnVuY3Rpb24gKCkge1xuXHRcdGlmICgkKHRoaXMpLmlzKCc6Y2hlY2tlZCcpKSB7XG5cdFx0XHQkKCcjb3BlbmluZy1ob3Vycy1ob3VycywgI29wZW5pbmctaG91cnMtc2V0dGluZ3MnKS5zbGlkZVVwKCk7XG5cdFx0fSBlbHNlIHtcblx0XHRcdCQoJyNvcGVuaW5nLWhvdXJzLXNldHRpbmdzJykuc2xpZGVEb3duKCk7XG5cdFx0XHRpZiAoISQoJyN1c2VfbXVsdGlwbGVfbG9jYXRpb25zJykuaXMoJzpjaGVja2VkJykpIHtcblx0XHRcdFx0JCgnI29wZW5pbmctaG91cnMtaG91cnMnKS5zbGlkZURvd24oKTtcblx0XHRcdH1cblx0XHR9XG5cdH0pO1xuXHQkKCcjbXVsdGlwbGVfb3BlbmluZ19ob3VycywgI3dwc2VvX211bHRpcGxlX29wZW5pbmdfaG91cnMnKS5jbGljayhmdW5jdGlvbiAoKSB7XG5cdFx0aWYgKCQodGhpcykuaXMoJzpjaGVja2VkJykpIHtcblx0XHRcdCQoJy5vcGVuaW5nLWhvdXJzIC5vcGVuaW5nLWhvdXJzLXNlY29uZCcpLnNsaWRlRG93bigpO1xuXHRcdH0gZWxzZSB7XG5cdFx0XHQkKCcub3BlbmluZy1ob3VycyAub3BlbmluZy1ob3Vycy1zZWNvbmQnKS5zbGlkZVVwKCk7XG5cdFx0fVxuXHR9KTtcblx0JCgnI29wZW5pbmdfaG91cnNfMjRoJykuY2xpY2soZnVuY3Rpb24gKCkge1xuXHRcdCQoJyNvcGVuaW5nLWhvdXJzLWNvbnRhaW5lciBzZWxlY3QnKS5lYWNoKGZ1bmN0aW9uICgpIHtcblx0XHRcdCQodGhpcykuZmluZCgnb3B0aW9uJykuZWFjaChmdW5jdGlvbiAoKSB7XG5cdFx0XHRcdGlmICgkKCcjb3BlbmluZ19ob3Vyc18yNGgnKS5pcygnOmNoZWNrZWQnKSkge1xuXHRcdFx0XHRcdC8vIFVzZSAyNCBob3VyXG5cdFx0XHRcdFx0aWYgKCQodGhpcykudmFsKCkgIT0gJ2Nsb3NlZCcpIHtcblx0XHRcdFx0XHRcdCQodGhpcykudGV4dCgkKHRoaXMpLnZhbCgpKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0Ly8gVXNlIDEyIGhvdXJcblx0XHRcdFx0XHRpZiAoJCh0aGlzKS52YWwoKSAhPSAnY2xvc2VkJykge1xuXHRcdFx0XHRcdFx0Ly8gU3BsaXQgdGhlIHN0cmluZyBiZXR3ZWVuIGhvdXJzIGFuZCBtaW51dGVzXG5cdFx0XHRcdFx0XHR2YXIgdGltZSA9ICQodGhpcykudmFsKCkuc3BsaXQoJzonKTtcblxuXHRcdFx0XHRcdFx0Ly8gdXNlIHBhcnNlSW50IHRvIHJlbW92ZSBsZWFkaW5nIHplcm9lcy5cblx0XHRcdFx0XHRcdHZhciBob3VyID0gcGFyc2VJbnQodGltZVswXSk7XG5cdFx0XHRcdFx0XHR2YXIgbWludXRlcyA9IHRpbWVbMV07XG5cdFx0XHRcdFx0XHR2YXIgc3VmZml4ID0gJ0FNJztcblx0XHRcdFx0XHRcdC8vIGlmIHRoZSBob3VycyBudW1iZXIgaXMgZ3JlYXRlciB0aGFuIDEyLCBzdWJ0cmFjdCAxMi5cblx0XHRcdFx0XHRcdGlmIChob3VyID49IDEyKSB7XG5cdFx0XHRcdFx0XHRcdGlmIChob3VyID4gMTIpIHtcblx0XHRcdFx0XHRcdFx0XHRob3VyID0gaG91ciAtIDEyO1xuXHRcdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0XHRcdHN1ZmZpeCA9ICdQTSc7XG5cdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0XHRpZiAoaG91ciA9PSAwKSB7XG5cdFx0XHRcdFx0XHRcdGhvdXIgPSAxMjtcblx0XHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdFx0JCh0aGlzKS50ZXh0KGhvdXIgKyAnOicgKyBtaW51dGVzICsgJyAnICsgc3VmZml4KTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdH0pO1xuXHRcdH0pO1xuXHR9KTtcblxuXHQvLyBUaGUgMjRoIGZvcm1hdCBvbiBzaW5nbGUgbG9jYXRpb24gcGFnZSAoaWYgbXVsdGlwbGUgbG9jYXRpb25zIGlzIHNldClcblx0JCgnI3dwc2VvX2Zvcm1hdF8yNGgsICN3cHNlb19mb3JtYXRfMTJoJykuY2xpY2soZnVuY3Rpb24gKCkge1xuXHRcdCQoJyNoaWRlLW9wZW5pbmctaG91cnMgc2VsZWN0JykuZWFjaChmdW5jdGlvbiAoKSB7XG5cdFx0XHQkKHRoaXMpLmZpbmQoJ29wdGlvbicpLmVhY2goZnVuY3Rpb24gKCkge1xuXHRcdFx0XHRpZiAoKCQoJyN3cHNlb19mb3JtYXRfMjRoJykubGVuZ3RoID4gMCAmJiAkKCcjd3BzZW9fZm9ybWF0XzI0aCcpLmlzKCc6Y2hlY2tlZCcpKSB8fCAoKCQoJyN3cHNlb19mb3JtYXRfMTJoJykubGVuZ3RoID4gMCAmJiAhJCgnI3dwc2VvX2Zvcm1hdF8xMmgnKS5pcygnOmNoZWNrZWQnKSkpKSB7XG5cdFx0XHRcdFx0Ly8gVXNlIDI0IGhvdXJcblx0XHRcdFx0XHRpZiAoJCh0aGlzKS52YWwoKSAhPSAnY2xvc2VkJykge1xuXHRcdFx0XHRcdFx0JCh0aGlzKS50ZXh0KCQodGhpcykudmFsKCkpO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHQvLyBVc2UgMTIgaG91clxuXHRcdFx0XHRcdGlmICgkKHRoaXMpLnZhbCgpICE9ICdjbG9zZWQnKSB7XG5cdFx0XHRcdFx0XHQvLyBTcGxpdCB0aGUgc3RyaW5nIGJldHdlZW4gaG91cnMgYW5kIG1pbnV0ZXNcblx0XHRcdFx0XHRcdHZhciB0aW1lID0gJCh0aGlzKS52YWwoKS5zcGxpdCgnOicpO1xuXG5cdFx0XHRcdFx0XHQvLyB1c2UgcGFyc2VJbnQgdG8gcmVtb3ZlIGxlYWRpbmcgemVyb2VzLlxuXHRcdFx0XHRcdFx0dmFyIGhvdXIgPSBwYXJzZUludCh0aW1lWzBdKTtcblx0XHRcdFx0XHRcdHZhciBtaW51dGVzID0gdGltZVsxXTtcblx0XHRcdFx0XHRcdHZhciBzdWZmaXggPSAnQU0nO1xuXHRcdFx0XHRcdFx0Ly8gaWYgdGhlIGhvdXJzIG51bWJlciBpcyBncmVhdGVyIHRoYW4gMTIsIHN1YnRyYWN0IDEyLlxuXHRcdFx0XHRcdFx0aWYgKGhvdXIgPj0gMTIpIHtcblx0XHRcdFx0XHRcdFx0aWYgKGhvdXIgPiAxMikge1xuXHRcdFx0XHRcdFx0XHRcdGhvdXIgPSBob3VyIC0gMTI7XG5cdFx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHRcdFx0c3VmZml4ID0gJ1BNJztcblx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHRcdGlmIChob3VyID09IDApIHtcblx0XHRcdFx0XHRcdFx0aG91ciA9IDEyO1xuXHRcdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0XHQkKHRoaXMpLnRleHQoaG91ciArICc6JyArIG1pbnV0ZXMgKyAnICcgKyBzdWZmaXgpO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXHRcdFx0fSk7XG5cdFx0fSk7XG5cdH0pO1xuXG5cdC8vIEdlbmVyYWwgU2V0dGluZ3M6IEVuYWJsZS9kaXNhYmxlIE9wZW4gMjQvNyBvbiBjbGlja1xuXHQkKCcjb3Blbl8yNDcnKS5vbignY2xpY2snLCBmdW5jdGlvbiAoKSB7XG5cdFx0aWYgKCEkKCcjdXNlX211bHRpcGxlX2xvY2F0aW9ucycpLmlzKFwiOmNoZWNrZWRcIikpIHtcblx0XHRcdG1heWJlQ2xvc2VPcGVuaW5nSG91cnModGhpcyk7XG5cdFx0XHQkKCcub3Blbl8yNDdfd3JhcHBlcicpLnNob3coKVxuXHRcdH1cblx0fSk7XG5cblx0Ly8gU2luZ2xlIExvY2F0aW9uOiBFbmFibGUvZGlzYWJsZSBPcGVuIDI0Lzcgb24gY2xpY2tcblx0JCgnI3dwc2VvX29wZW5fMjQ3Jykub24oJ2NsaWNrJywgZnVuY3Rpb24gKCkge1xuXHRcdG1heWJlQ2xvc2VPcGVuaW5nSG91cnModGhpcyk7XG5cdH0pO1xuXG5cdC8vIERpc2FibGUgaG91cnMgMjQvNyBvbiBjbGlja1xuXHQkKCcud3BzZW9fb3Blbl8yNGggaW5wdXQnKS5vbignY2xpY2snLCBmdW5jdGlvbiAoZSkge1xuXHRcdGlmICgkKHRoaXMpLmlzKFwiOmNoZWNrZWRcIikpIHtcblx0XHRcdCQoJ3NlbGVjdCcsICQoJy5vcGVuaW5naG91cnMtd3JhcHBlcicsICQodGhpcykuY2xvc2VzdCgnLm9wZW5pbmctaG91cnMnKSkpLmF0dHIoJ2Rpc2FibGVkJywgdHJ1ZSk7XG5cdFx0fSBlbHNlIHtcblx0XHRcdCQoJ3NlbGVjdCcsICQoJy5vcGVuaW5naG91cnMtd3JhcHBlcicsICQodGhpcykuY2xvc2VzdCgnLm9wZW5pbmctaG91cnMnKSkpLmF0dHIoJ2Rpc2FibGVkJywgZmFsc2UpO1xuXHRcdH1cblx0fSk7XG5cblx0ZnVuY3Rpb24gbWF5YmVDbG9zZU9wZW5pbmdIb3VycyhlbGVtKSB7XG5cdFx0aWYgKCQoZWxlbSkuaXMoJzpjaGVja2VkJykpIHtcblx0XHRcdCQoJyNvcGVuaW5nLWhvdXJzLXJvd3MsIC5vcGVuaW5nLWhvdXJzLXdyYXAnKS5zbGlkZVVwKCk7XG5cdFx0fSBlbHNlIHtcblx0XHRcdCQoJyNvcGVuaW5nLWhvdXJzLXJvd3MsIC5vcGVuaW5nLWhvdXJzLXdyYXAnKS5zbGlkZURvd24oKTtcblx0XHR9XG5cdH1cblxuXHQkKCcud2lkZ2V0LWNvbnRlbnQnKS5vbignY2xpY2snLCAnI3dwc2VvLWNoZWNrYm94LW11bHRpcGxlLWxvY2F0aW9ucy13cmFwcGVyIGlucHV0W3R5cGU9Y2hlY2tib3hdJywgZnVuY3Rpb24gKCkge1xuXHRcdHdwc2VvX3Nob3dfYWxsX2xvY2F0aW9uc19zZWxlY3Rib3goJCh0aGlzKSk7XG5cdH0pO1xuXG5cdC8vIFNob3cgbG9jYXRpb25zIG1ldGFib3ggYmVmb3JlIFdQIFNFTyBtZXRhYm94XG5cdGlmICgkKCcjd3BzZW9fbG9jYXRpb25zJykubGVuZ3RoID4gMCAmJiAkKCcjd3BzZW9fbWV0YScpLmxlbmd0aCA+IDApIHtcblx0XHQkKCcjd3BzZW9fbG9jYXRpb25zJykuaW5zZXJ0QmVmb3JlKCQoJyN3cHNlb19tZXRhJykpO1xuXHR9XG5cblx0JCgnLm9wZW5pbmdob3Vyc19mcm9tJykuY2hhbmdlKGZ1bmN0aW9uICgpIHtcblx0XHR2YXIgdG9faWQgPSAkKHRoaXMpLmF0dHIoJ2lkJykucmVwbGFjZSgnX2Zyb20nLCAnX3RvX3dyYXBwZXInKTtcblx0XHR2YXIgc2Vjb25kX2lkID0gJCh0aGlzKS5hdHRyKCdpZCcpLnJlcGxhY2UoJ19mcm9tJywgJ19zZWNvbmQnKTtcblxuXHRcdGlmICgkKHRoaXMpLnZhbCgpID09ICdjbG9zZWQnKSB7XG5cdFx0XHQkKCcjJyArIHRvX2lkKS5jc3MoJ2Rpc3BsYXknLCAnbm9uZScpO1xuXHRcdFx0JCgnIycgKyBzZWNvbmRfaWQpLmNzcygnZGlzcGxheScsICdub25lJyk7XG5cdFx0fSBlbHNlIHtcblx0XHRcdCQoJyMnICsgdG9faWQpLmNzcygnZGlzcGxheScsICdpbmxpbmUnKTtcblx0XHRcdCQoJyMnICsgc2Vjb25kX2lkKS5jc3MoJ2Rpc3BsYXknLCAnYmxvY2snKTtcblx0XHR9XG5cdH0pLmNoYW5nZSgpO1xuXHQkKCcub3BlbmluZ2hvdXJzX2Zyb21fc2Vjb25kJykuY2hhbmdlKGZ1bmN0aW9uICgpIHtcblx0XHR2YXIgdG9faWQgPSAkKHRoaXMpLmF0dHIoJ2lkJykucmVwbGFjZSgnX2Zyb20nLCAnX3RvX3dyYXBwZXInKTtcblxuXHRcdGlmICgkKHRoaXMpLnZhbCgpID09ICdjbG9zZWQnKSB7XG5cdFx0XHQkKCcjJyArIHRvX2lkKS5jc3MoJ2Rpc3BsYXknLCAnbm9uZScpO1xuXHRcdH0gZWxzZSB7XG5cdFx0XHQkKCcjJyArIHRvX2lkKS5jc3MoJ2Rpc3BsYXknLCAnaW5saW5lJyk7XG5cdFx0fVxuXHR9KS5jaGFuZ2UoKTtcblx0JCgnLm9wZW5pbmdob3Vyc190bycpLmNoYW5nZShmdW5jdGlvbiAoKSB7XG5cdFx0dmFyIGZyb21faWQgPSAkKHRoaXMpLmF0dHIoJ2lkJykucmVwbGFjZSgnX3RvJywgJ19mcm9tJyk7XG5cdFx0dmFyIHRvX2lkID0gJCh0aGlzKS5hdHRyKCdpZCcpLnJlcGxhY2UoJ190bycsICdfdG9fd3JhcHBlcicpO1xuXHRcdGlmICgkKHRoaXMpLnZhbCgpID09ICdjbG9zZWQnKSB7XG5cdFx0XHQkKCcjJyArIHRvX2lkKS5jc3MoJ2Rpc3BsYXknLCAnbm9uZScpO1xuXHRcdFx0JCgnIycgKyBmcm9tX2lkKS52YWwoJ2Nsb3NlZCcpO1xuXHRcdH1cblx0fSk7XG5cdCQoJy5vcGVuaW5naG91cnNfdG9fc2Vjb25kJykuY2hhbmdlKGZ1bmN0aW9uICgpIHtcblx0XHR2YXIgZnJvbV9pZCA9ICQodGhpcykuYXR0cignaWQnKS5yZXBsYWNlKCdfdG8nLCAnX2Zyb20nKTtcblx0XHR2YXIgdG9faWQgPSAkKHRoaXMpLmF0dHIoJ2lkJykucmVwbGFjZSgnX3RvJywgJ190b193cmFwcGVyJyk7XG5cdFx0aWYgKCQodGhpcykudmFsKCkgPT0gJ2Nsb3NlZCcpIHtcblx0XHRcdCQoJyMnICsgdG9faWQpLmNzcygnZGlzcGxheScsICdub25lJyk7XG5cdFx0XHQkKCcjJyArIGZyb21faWQpLnZhbCgnY2xvc2VkJyk7XG5cdFx0fVxuXHR9KTtcblxuXHRpZiAoJCgnLnNldF9jdXN0b21faW1hZ2VzJykubGVuZ3RoID4gMCkge1xuXHRcdGlmICh0eXBlb2Ygd3AgIT09ICd1bmRlZmluZWQnICYmIHdwLm1lZGlhICYmIHdwLm1lZGlhLmVkaXRvcikge1xuXHRcdFx0JCgnLndyYXAnKS5vbignY2xpY2snLCAnLnNldF9jdXN0b21faW1hZ2VzJywgZnVuY3Rpb24gKGUpIHtcblx0XHRcdFx0ZS5wcmV2ZW50RGVmYXVsdCgpO1xuXHRcdFx0XHR2YXIgYnV0dG9uID0gJCh0aGlzKTtcblx0XHRcdFx0dmFyIGlkID0gYnV0dG9uLmF0dHIoJ2RhdGEtaWQnKTtcblx0XHRcdFx0d3AubWVkaWEuZWRpdG9yLnNlbmQuYXR0YWNobWVudCA9IGZ1bmN0aW9uIChwcm9wcywgYXR0YWNobWVudCkge1xuXHRcdFx0XHRcdGlmIChhdHRhY2htZW50Lmhhc093blByb3BlcnR5KCdzaXplcycpKSB7XG5cdFx0XHRcdFx0XHR2YXIgdXJsID0gYXR0YWNobWVudC5zaXplc1twcm9wcy5zaXplXS51cmw7XG5cdFx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRcdHZhciB1cmwgPSBhdHRhY2htZW50LnVybDtcblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHQkKCcjJyArIGlkICsgJ19pbWFnZV9jb250YWluZXInKS5hdHRyKCdzcmMnLCB1cmwpO1xuXHRcdFx0XHRcdCQoJy53cHNlby1sb2NhbC0nICsgaWQgKyAnLXdyYXBwZXIgLndwc2VvLWxvY2FsLWhpZGUtYnV0dG9uJykuc2hvdygpO1xuXHRcdFx0XHRcdCQoJyNoaWRkZW5fJyArIGlkKS5hdHRyKCd2YWx1ZScsIGF0dGFjaG1lbnQuaWQpO1xuXHRcdFx0XHR9O1xuXHRcdFx0XHR3cC5tZWRpYS5lZGl0b3Iub3BlbihidXR0b24pO1xuXHRcdFx0XHRyZXR1cm4gZmFsc2U7XG5cdFx0XHR9KTtcblx0XHR9XG5cdH1cblxuXHQkKCcucmVtb3ZlX2N1c3RvbV9pbWFnZScpLm9uKCdjbGljaycsIGZ1bmN0aW9uIChlKSB7XG5cdFx0ZS5wcmV2ZW50RGVmYXVsdCgpO1xuXG5cdFx0dmFyIGlkID0gJCh0aGlzKS5hdHRyKCdkYXRhLWlkJyk7XG5cdFx0JCgnIycgKyBpZCkuYXR0cignc3JjJywgJycpLmhpZGUoKTtcblx0XHQkKCcjaGlkZGVuXycgKyBpZCkuYXR0cigndmFsdWUnLCAnJyk7XG5cdFx0JCgnLndwc2VvLWxvY2FsLScgKyBpZCArICctd3JhcHBlciAud3BzZW8tbG9jYWwtaGlkZS1idXR0b24nKS5oaWRlKCk7XG5cdH0pO1xuXG5cdC8vIENvcHkgbG9jYXRpb24gZGF0YVxuXHQkKCcjd3BzZW9fY29weV9mcm9tX2xvY2F0aW9uJykuY2hhbmdlKGZ1bmN0aW9uICgpIHtcblx0XHR2YXIgbG9jYXRpb25faWQgPSAkKHRoaXMpLnZhbCgpO1xuXG5cdFx0aWYgKGxvY2F0aW9uX2lkID09ICcnKVxuXHRcdFx0cmV0dXJuO1xuXG5cdFx0JC5wb3N0KHdwc2VvX2xvY2FsX2RhdGEuYWpheHVybCwge1xuXHRcdFx0bG9jYXRpb25faWQ6IGxvY2F0aW9uX2lkLFxuXHRcdFx0c2VjdXJpdHk6IHdwc2VvX2xvY2FsX2RhdGEuc2VjX25vbmNlLFxuXHRcdFx0YWN0aW9uOiAnd3BzZW9fY29weV9sb2NhdGlvbidcblx0XHR9LCBmdW5jdGlvbiAocmVzdWx0KSB7XG5cdFx0XHRpZiAocmVzdWx0LmNoYXJBdChyZXN1bHQubGVuZ3RoIC0gMSkgPT0gMCkge1xuXHRcdFx0XHRyZXN1bHQgPSByZXN1bHQuc2xpY2UoMCwgLTEpO1xuXHRcdFx0fSBlbHNlIGlmIChyZXN1bHQuc3Vic3RyaW5nKHJlc3VsdC5sZW5ndGggLSAyKSA9PSBcIi0xXCIpIHtcblx0XHRcdFx0cmVzdWx0ID0gcmVzdWx0LnNsaWNlKDAsIC0yKTtcblx0XHRcdH1cblxuXHRcdFx0dmFyIGRhdGEgPSAkLnBhcnNlSlNPTihyZXN1bHQpO1xuXHRcdFx0aWYgKGRhdGEuc3VjY2VzcyA9PSAndHJ1ZScgfHwgZGF0YS5zdWNjZXNzID09IHRydWUpIHtcblxuXHRcdFx0XHRmb3IgKHZhciBpIGluIGRhdGEubG9jYXRpb24pIHtcblx0XHRcdFx0XHR2YXIgdmFsdWUgPSBkYXRhLmxvY2F0aW9uW2ldO1xuXG5cdFx0XHRcdFx0aWYgKHZhbHVlICE9IG51bGwgJiYgdmFsdWUgIT0gJycgJiYgdHlwZW9mIHZhbHVlICE9ICd1bmRlZmluZWQnKSB7XG5cdFx0XHRcdFx0XHRpZiAoaSA9PSAnaXNfcG9zdGFsX2FkZHJlc3MnIHx8IGkgPT0gJ211bHRpcGxlX29wZW5pbmdfaG91cnMnKSB7XG5cdFx0XHRcdFx0XHRcdGlmICh2YWx1ZSA9PSAnMScpIHtcblx0XHRcdFx0XHRcdFx0XHQkKCcjd3BzZW9fJyArIGkpLmF0dHIoJ2NoZWNrZWQnLCAnY2hlY2tlZCcpO1xuXHRcdFx0XHRcdFx0XHRcdCQoJy5vcGVuaW5nLWhvdXJzIC5vcGVuaW5nLWhvdXItc2Vjb25kJykuc2xpZGVEb3duKCk7XG5cdFx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHRcdH0gZWxzZSBpZiAoaS5pbmRleE9mKCdvcGVuaW5nX2hvdXJzJykgPiAtMSkge1xuXHRcdFx0XHRcdFx0XHQkKCcjJyArIGkpLnZhbCh2YWx1ZSk7XG5cdFx0XHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdFx0XHQkKCcjd3BzZW9fJyArIGkpLnZhbCh2YWx1ZSk7XG5cdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fSk7XG5cdH0pO1xufSk7XG5cbndpbmRvdy53cHNlb19zaG93X2FsbF9sb2NhdGlvbnNfc2VsZWN0Ym94ID0gZnVuY3Rpb24gKG9iaikge1xuXHQkID0galF1ZXJ5O1xuXG5cdCRvYmogPSAkKG9iaik7XG5cdHZhciBwYXJlbnQgPSAkb2JqLnBhcmVudHMoJy53aWRnZXQtaW5zaWRlJyk7XG5cdHZhciAkbG9jYXRpb25zV3JhcHBlciA9ICQoJyN3cHNlby1sb2NhdGlvbnMtd3JhcHBlcicsIHBhcmVudCk7XG5cblx0aWYgKCRvYmouaXMoJzpjaGVja2VkJykpIHtcblx0XHQkbG9jYXRpb25zV3JhcHBlci5zbGlkZVVwKCk7XG5cdH0gZWxzZSB7XG5cdFx0JGxvY2F0aW9uc1dyYXBwZXIuc2xpZGVEb3duKCk7XG5cdH1cbn1cbiJdfQ==
