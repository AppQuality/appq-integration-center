/**
 * @Author: Davide Bizzi <clochard>
 * @Date:   08/05/2020
 * @Filename: appq-integration-center-admin.js
 * @Last modified by:   clochard
 * @Last modified time: 2020-06-08T10:48:16+02:00
 */



(function($) {
	'use strict';
	var _x =  wp.i18n._x

	$(document).ready(function() {
		
		if ($('.delete_issue').length) {
			$('.delete_issue').click(function(e) {
				e.preventDefault()
				var cp_id = $('#campaign_id').val()
				var bug_name = $(this).closest('tr').find('td.name').text()
				var bugtracker_id = $(this).attr('data-bugtracker-id')
				if (confirm(_x("Are you sure you want to delete issue", "Integration Center delete issue", "appq-integration-center") + " " + bugtracker_id + " - " + bug_name + "?")) {
					var button_text = $(this).removeClass('fa-close')
					var self = this
					$(this).html('<span class="fa fa-spin fa-spinner"></span>')
					$.ajax({
						type: "post",
						dataType: "json",
						url: integration_center_obj.ajax_url,
						data: {
							'action': 'appq_delete_bug_from_bugtracker',
							'cp_id': cp_id,
							'bugtracker_id': bugtracker_id
						}
					}).then(function(res){
						if (res.success) {
							$(self).closest('td').find('.open_bug_menu').removeClass('fa-upload').addClass('fa-close').addClass('text-danger')
							$(self).closest('tr').find('.is_uploaded').html('')
							$(self).closest('td').find('button').prop('disabled',true)
							$(self).remove()
							if (res.data.auth_error) {
								toastr.warning(res.data.message)
							} else {
								toastr.success(res.data.message)
							}
						} else {
							$(self).html(button_text)
							toastr.error(res.data.message)
						}
					})
				}
			})
		}

		if($('.open_bug_menu').length) {
			$('.open_bug_menu').click(function(e) {
				e.preventDefault()
				
				if ($(this).closest('td').find('.bug_menu').is(':visible')) {
					$(this).closest('td').find('.bug_menu').hide()
				} else {
					$('.bug_menu').hide()
					$(this).closest('td').find('.bug_menu').show()
				}
			})
		}

		// Delete custom field map (row)
		$('#custom_field_maps').on('click','.remove',function(){
			$(this).closest('.custom_field_map').remove()
		})

		// Clean modal values when closed
		$('#add_field_modal, #edit_available_field_modal').on('hidden.bs.modal', function (e) {
			$('#add_field_modal').find('input').val("");
			$('#edit_available_field_modal').find('input').val("");
			$('#custom_field_maps_add *').remove();
			$('#custom_field_maps_edit *').remove();
		})
		
		if ($('.available_fields .custom').length) {
			$('.available_fields .custom').click(function(){
				var map = $(this).data('map')
				var source = $(this).data('source')
				var name = $(this).data('name')
				var modal = $($(this).data('target'))
				modal.find('input[name="custom_map_source"]').val(source)
				modal.find('input[name="custom_map_name"]').val(name)
				
				Object.keys(map).forEach(function(k) {
					var field = addCustomFieldToModal()
					field.find('.key').val(k)
					field.find('.value').val(map[k])
				});
				
				modal.modal('show');
			})
		}

		$('.add_new_field_map').click(function(e){
			addCustomFieldToModal($(this))
		})

		$('#add_new_field, #edit_field').click(function(e) {
			e.preventDefault()
			var self = this
			var content = $(this).html()
			var cp_id = $('#campaign_id').val()
			var form;
			var action;
			var fields_limit;
			var succ_mess;
			if ($(this).attr('id') === 'edit_field') {
				form = '#edit_available_field_form';
				action = 'appq_edit_custom_field';
				fields_limit = 4;
				succ_mess = _x("Custom field updated", "Integration Center edit available field", "appq-integration-center");
			} else if ($(this).attr('id') === 'add_new_field') {
				form = '#add_custom_map';
				action = 'appq_add_custom_field';
				fields_limit = 4;
				succ_mess = _x("Custom field added", "Integration Center add available field", "appq-integration-center");
			}
			var formData = $(form + ' input').serializeArray();
			$(this).html('<i class="fa fa-spinner fa-spin"></i>')
			if (formData.length >= fields_limit) {
				var valid = true;
				formData.forEach(function(v,i) {
					if (!v.value) valid = false;
				});
				if (valid) {
					$(self).prop('disabled', true);
					formData.push({'name':'cp_id', 'value':cp_id})
					formData.push({'name':'action', 'value':action})
					$.ajax({
						type: "post",
						dataType: "json",
						url: integration_center_obj.ajax_url,
						data: formData
					}).then(function(res){
						if (res.success) {
							toastr.success(succ_mess)
							location.reload()
						} else {
							toastr.error(_x("Something went wrong", "Integration Center available fields modal error", "appq-integration-center"));
						}

						$(self).html(content)
						$(self).prop('disabled', false);
					})
				} else {
					toastr.error(_x("Please fill the mapping fields", "Integration Center available fields modal error", "appq-integration-center"));
					$(self).html(content)
					$(self).prop('disabled', false);
				}
			} else {
				toastr.error(_x("Please fill the mapping fields", "Integration Center available fields modal error", "appq-integration-center"));
				$(self).html(content)
				$(self).prop('disabled', false);
			}
		})

		function addCustomFieldToModal(button_add) {
			var current_maps = $('.custom_field_map').length
			while (button_add.parent().find('[id^="custom_field_maps_wrap"] input[name="custom_map['+current_maps+'][key]"]').length != 0) {
				current_maps++
			}
			var template = $($('#field_map_template').html())
			template.find('input[name="key"]').attr('name','custom_map['+current_maps+'][key]')
			template.find('input[name="value"]').attr('name','custom_map['+current_maps+'][value]')
			button_add.parent().find('[id^="custom_field_maps"]').append(template)
			return template
		}

		$(document).on('click', '[data-target="#add_field_modal"]', function() {
			$('#add_new_field').prop('disabled', false);
		});

		$(document).on('click', '[data-target="#edit_available_field_modal"]', function() {
			var modal_id = $(this).attr('data-target');
			var modal = $(modal_id);
			var input_source = modal.find('input[name="custom_map_source"]');
			var input_name = modal.find('input[name="custom_map_name"]');
			var field_source = $(this).data('source');
			var field_name = $(this).data('name');
			var field_map = $(this).data('map');
			var count = 0;
			for (var value in field_map) {
				var map = field_map[value];
				addCustomFieldToModal($('#add_new_field_map'));
				modal.find('input[name="custom_map[' + count + '][key]"]').val(value);
				modal.find('input[name="custom_map[' + count + '][value]"]').val(map);
				count++;
			}

			input_source.val(field_source);
			input_name.val(field_name);
		});

		$(document).on('click', '[data-target="#delete_available_field_modal"]', function() {
			var modal_id = $(this).attr('data-target');
			var input_name = $(modal_id).find('input[name="name"]');

			input_name.val('');

			var name = $(this).data('name');
			if(!name) return;

			input_name.val(name);
		});

		$('#delete_available_field').click(function(e) {
			e.preventDefault();
			var self = this;
			var content = $(this).html();
			var cp_id = $('#campaign_id').val();
			$(this).html('<i class="fa fa-spinner fa-spin"></i>');
			$(this).prop('disabled', true);
			var name = $('#delete_available_field_form').find('input[name="name"]').val();
			var data = [];
			data.push({
				'name': 'cp_id',
				'value': cp_id
			});
			data.push({
				'name': 'name',
				'value': name
			});
			data.push({
				'name' : 'action',
				'value': 'appq_delete_custom_field'
			});
			$.ajax({
				type: "post",
				dataType: "json",
				url: integration_center_obj.ajax_url,
				data: data
			}).then(function(res){
				if (res.success) {
					$('#accordionFields').find('tr[data-name="' + name + '"]').remove();
					toastr.error(_x("Custom field deleted", "Integration Center delete custom field", "appq-integration-center"));
				} else {
					toastr.error(_x("There was an error deleting custom field", "Integration Center delete custom field error", "appq-integration-center"));
				}

				$(self).html(content);
				$(self).prop('disabled', false);

				$('#delete_available_field_modal').modal('toggle');
			})
		});

		$('#bugs-tabs-content .upload_bug').not('.disabled').click(function() {
			var cp_id = $('#campaign_id').val()
			var bug_id = $(this).data('bug-id')
			var button = $(this)
			button.removeClass('fa-upload').addClass('fa-spinner fa-spin text-secondary disabled')
			jQuery.ajax({
				type: "post",
				dataType: "json",
				url: integration_center_obj.ajax_url,
				data: {
					'action': 'appq_upload_bugs_to_bugtracker',
					'cp_id': cp_id,
					'bug_id': bug_id
				},
				success: function(res) {
					button.removeClass('fa-spinner fa-spin').addClass('fa-upload')
					if (res.success) {
						button.closest('tr').find('td.is_uploaded').append('<span class="fa fa-check"></span>')
					} else {
						if (res.data.warning) {
							button.closest('tr').find('td.is_uploaded').append('<span class="fa fa-check"></span>')
							toastr.warning(res.data.warning, 'Your bug was uploaded, but there was some errors')
						} else {
							button.removeClass('text-secondary disabled')
							toastr.error(res.data)
						}
					}
				},
				error: function(res) {
					button.removeClass('fa-spinner fa-spin text-secondary').addClass('fa-upload')
					toastr.error(JSON.stringify(res))
				}
			});
		})
		$('#bugs-tabs-content .update_bug').not('.disabled').click(function() {
			var cp_id = $('#campaign_id').val()
			var bug_id = $(this).data('bug-id')
			var button = $(this)
			button.removeClass('fa-upload').addClass('fa-spinner fa-spin text-secondary disabled')
			jQuery.ajax({
				type: "post",
				dataType: "json",
				url: integration_center_obj.ajax_url,
				data: {
					'action': 'appq_update_bugs_in_bugtracker',
					'cp_id': cp_id,
					'bug_id': bug_id
				},
				success: function(res) {
					button.removeClass('fa-spinner fa-spin').addClass('fa-upload')
					if (res.success) {
						toastr.success(_x('Updated!', "Integration Center available fields modal error", "appq-integration-center"))
					} else {
						button.removeClass('text-secondary disabled')
						toastr.error(res.data)
					}
				},
				error: function(res) {
					button.removeClass('fa-spinner fa-spin text-secondary').addClass('fa-upload')
					toastr.error(JSON.stringify(res))
				}
			});
		})

		$('#campaign-tabs .nav-link').click(function() {
			window.location.hash = $(this).attr('href')
		})

		var hash = window.location.hash;
		$('#campaign-tabs a[href="' + hash + '"]').click();


		var campaigns_list = new List('campaigns_list', {
			valueNames: ['id', 'name', 'bugtracker'],
			plugins: [
				ListFuzzySearch({
					searchClass: "fuzzy-search",
					location: 0,
					distance: 100,
					threshold: 0.4,
					multiSearch: true
				})
			]
		});

		var bugs_list = new List('bugs_list', {
			valueNames: [
				'id', 'name', 'category', 'status', 'severity',
				'tags',
				'uploaded',
				'duplicated'
			]
		});

		$('#bugs_list .send-all').click(function(e){
			e.preventDefault()
			if (confirm(_x("Are you sure you want to process ALL the bugs? It will take a while. The list could contain REFUSED and PENDING bugs. If you want to send only some bugs, please use the \"Send Selected\" button.", "Integration Center send all confirm", "appq-integration-center"))) {
				$('#bugs_list .fa-upload').not('.text-secondary').click()
			}
		})
		$('#bugs_list .send-selected').click(function(e){
			e.preventDefault()
			$('#bugs_list .check:checked').each(function(){
				$(this).closest('tr').find('.fa-upload').not('.text-secondary').click()
			})
		})
		$('#bugs_list .select_all').change(function(){
			if ($(this).prop('checked')) {
				$('#bugs_list input.check').prop('checked', true)
			} else {
				$('#bugs_list input.check').prop('checked', false);
			}
		})

		$('#bugs_list-search').on('keyup', function() {
			var searchString = $(this).val().split(' ');
			var searchStringOrList = searchString.map(function(word) {
				return word.split('+');
			})
			bugs_list.filter(function(item) {
				var values = item.values()
				values = Object.keys(values).map(function(key) {
					return values[key]
				})
				values = values.join(' ').toLowerCase()
				var found = false
				searchStringOrList.forEach(function(searchStringAndList) {
					var stringIsContained = true
					searchStringAndList.forEach(function(searchStringInAnd) {
						searchStringInAnd = searchStringInAnd.toLowerCase()
						stringIsContained = stringIsContained && values.includes(searchStringInAnd)
					})
					found = found || stringIsContained
				})
				return found
			})
		});
		$('#save_general_settings').click(function() {
			var cp_id = $('#campaign_id').val()
			var button = $(this)
			var text = button.text()
			var data = $('#general_settings').serializeArray()
			data.push({
				'name': 'action',
				'value': 'appq_integration_center_save_settings'
			})
			data.push({
				'name': 'cp_id',
				'value': cp_id
			})
			button.text("")
			button.append('<span class="fa fa-spinner fa-spin"></span>')
			jQuery.ajax({
				type: "post",
				dataType: "json",
				url: integration_center_obj.ajax_url,
				data: data,
				success: function(msg) {
					button.text(text)
				}
			});
		})	
		$('#import_default_bug').click(function(e){
			e.preventDefault()
			var cp_id = $('#campaign_id').val()
			var bug_id = 'default'
			var button = $(this)
			var text = $(this).html()
			button.html('<i class="fa fa-spinner fa-spin"></i>')
			jQuery.ajax({
				type: "post",
				dataType: "json",
				url: integration_center_obj.ajax_url,
				data: {
					'action': 'appq_upload_bugs_to_bugtracker',
					'cp_id': cp_id,
					'bug_id': bug_id
				},
				success: function(res) {
					button.html(text)
					if (!res.success) {
						toastr.error(res.data)
					} else {
						toastr.success(_x("Default bug uploaded", "Integration Center default bug upload", "appq-integration-center"))
						button.prop('disabled',true)
						location.reload()
					}
				},
				error: function(res) {
					button.html(text)
					toastr.error(JSON.stringify(res))
				}
			});
		})
		$('#update_default_bug').click(function(e){
			e.preventDefault()
			var cp_id = $('#campaign_id').val()
			var bug_id = 'default'
			var button = $(this)
			var text = $(this).html()
			button.html('<i class="fa fa-spinner fa-spin"></i>')
			jQuery.ajax({
				type: "post",
				dataType: "json",
				url: integration_center_obj.ajax_url,
				data: {
					'action': 'appq_update_bugs_in_bugtracker',
					'cp_id': cp_id,
					'bug_id': bug_id
				},
				success: function(res) {
					button.html(text)
					if (!res.success) {
						toastr.error(res.data)
					} else {
						toastr.success(_x("Default bug updated", "Integration Center default bug update", "appq-integration-center"))
					}
				},
				error: function(res) {
					button.html(text)
					toastr.error(JSON.stringify(res))
				}
			});
		})
	});
})(jQuery);
