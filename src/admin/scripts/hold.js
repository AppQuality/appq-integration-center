/**
 * @Author: Davide Bizzi <clochard>
 * @Date:   08/05/2020
 * @Filename: appq-integration-center-admin.js
 * @Last modified by:   clochard
 * @Last modified time: 2020-06-08T10:48:16+02:00
 */



(function($) {
	'use strict';

	$(document).ready(function() {
		
		if ($('.delete_issue').length) {
			$('.delete_issue').click(function(e) {
				e.preventDefault()
				var cp_id = $('#cp_id').val()
				var bug_name = $(this).closest('tr').find('td.name').text()
				var bugtracker_id = $(this).attr('data-bugtracker-id')
				if (confirm("Are you sure you want to delete issue "+ bugtracker_id +" - " + bug_name + '?')) {
					var button_text = $(this).removeClass('fa-close')
					var self = this
					$(this).html('<span class="fa fa-spin fa-spinner"></span>')
					$.ajax({
						type: "post",
						dataType: "json",
						url: custom_object.ajax_url,
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
		
		
		$('#custom_field_maps').on('click','.remove',function(){
			$(this).closest('.custom_field_map').remove()
		})
		function addCustomFieldToModal(){
			$('#add_new_field').removeAttr('disabled')
			var current_maps = $('.custom_field_map').length
			while( $('#custom_field_maps input[name="custom_map['+current_maps+'][key]"]').length != 0) {
				current_maps++
			}
			var template = $($('#field_map_template').html())
			template.find('input[name="key"]').attr('name','custom_map['+current_maps+'][key]')
			template.find('input[name="value"]').attr('name','custom_map['+current_maps+'][value]')
			$('#custom_field_maps').append(template)
			return template
		}
		$('#addFieldModal').on('hidden.bs.modal', function (e) {
			$('#addFieldModal input').val("")
			$('#custom_field_maps *').remove()
		})
		
		if ($('.available_fields .custom').length) {
			$('.available_fields .custom').click(function(){
				var map = $(this).data('map')
				var source = $(this).data('source')
				var name = $(this).data('name')
				var modal = $($(this).data('target'))
				modal.find('input[name="custom_map_source"]').val(source)
				modal.find('input[name="custom_map_name"]').val(name)
				
				Object.keys(map).forEach((k) => {
					var field = addCustomFieldToModal()
					field.find('.key').val(k)
					field.find('.value').val(map[k])
				});
				
				
				modal.modal('show')
			})
		}
		
		if($('#add_new_field_map').length) {
			$('#add_new_field_map').click(function(e){
				addCustomFieldToModal()
			})
		}
		if ($('#add_new_field').length) {
			$('#add_new_field').click(function(e){
				e.preventDefault()
				var self = this
				var content = $(this).html()
				var cp_id = $('#cp_id').val()
				if ($('#add_custom_map').valid()) {
					$(this).html('<i class="fa fa-spinner fa-spin"></i>')
					var formData = $('#add_custom_map :input').serializeArray()
					formData.push({'name':'cp_id', 'value':cp_id})
					formData.push({'name':'action', 'value':"appq_add_custom_field"})
					$.ajax({
						type: "post",
						dataType: "json",
						url: custom_object.ajax_url,
						data: formData
					}).then(function(res){
						if (res.success) {
							location.reload()
						} else {
							toastr.error('There was an error adding custom map')
							$(self).html(content)
						}
					})
				}
			})
		}
		
		// $('.nav-item').click(function(){
		// 	$(this).closest('.nav').find('.nav-link').removeClass('active')
		// 	$(this).find('.nav-link').addClass('active')
		// })
		// $('.nav-link').click(function(){
		// 	$(this).parent().find('.nav-link').removeClass('active')
		// 	$(this).addClass('active')
		// })

		$('#bugs-tabs-content .upload_bug').not('.disabled').click(function() {
			var cp_id = $('#cp_id').val()
			var bug_id = $(this).data('bug-id')
			var button = $(this)
			button.removeClass('fa-upload').addClass('fa-spinner fa-spin text-secondary disabled')
			jQuery.ajax({
				type: "post",
				dataType: "json",
				url: custom_object.ajax_url,
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
						button.removeClass('text-secondary disabled')
						toastr.error(res.data, 'Oh no!')
					}
				},
				error: function(res) {
					button.removeClass('fa-spinner fa-spin text-secondary').addClass('fa-upload')
					toastr.error(JSON.stringify(res), 'Oh no!')
				}
			});
		})
		$('#bugs-tabs-content .update_bug').not('.disabled').click(function() {
			var cp_id = $('#cp_id').val()
			var bug_id = $(this).data('bug-id')
			var button = $(this)
			button.removeClass('fa-upload').addClass('fa-spinner fa-spin text-secondary disabled')
			jQuery.ajax({
				type: "post",
				dataType: "json",
				url: custom_object.ajax_url,
				data: {
					'action': 'appq_update_bugs_in_bugtracker',
					'cp_id': cp_id,
					'bug_id': bug_id
				},
				success: function(res) {
					button.removeClass('fa-spinner fa-spin').addClass('fa-upload')
					if (res.success) {
						toastr.success('Updated!')
					} else {
						button.removeClass('text-secondary disabled')
						toastr.error(res.data, 'Oh no!')
					}
				},
				error: function(res) {
					button.removeClass('fa-spinner fa-spin text-secondary').addClass('fa-upload')
					toastr.error(JSON.stringify(res), 'Oh no!')
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
			if (confirm('Are you sure you want to send ALL the bugs? It will take a while. The list can contain REFUSED and PENDING bugs, if you want to send only some bugs use Send Selected')) {
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
			if ($(this).attr('checked') == 'checked') {
				$('#bugs_list input.check').attr('checked','checked')
			} else {
				$('#bugs_list input.check').removeAttr('checked')
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
				url: custom_object.ajax_url,
				data: data,
				success: function(msg) {
					button.text(text)
				}
			});
		})	
		$('#import_default_bug').click(function(e){
			e.preventDefault()
			var cp_id = $('#cp_id').val()
			var bug_id = 'default'
			var button = $(this)
			var text = $(this).html()
			button.html('<i class="fa fa-spinner fa-spin"></i>')
			jQuery.ajax({
				type: "post",
				dataType: "json",
				url: custom_object.ajax_url,
				data: {
					'action': 'appq_upload_bugs_to_bugtracker',
					'cp_id': cp_id,
					'bug_id': bug_id
				},
				success: function(res) {
					button.html(text)
					if (!res.success) {
						toastr.error(res.data, 'Oh no!')
					} else {
						toastr.success('Default bug uploaded')
						button.prop('disabled',true)
						location.reload()
					}
				},
				error: function(res) {
					button.html(text)
					toastr.error(JSON.stringify(res), 'Oh no!')
				}
			});
		})
		$('#update_default_bug').click(function(e){
			e.preventDefault()
			var cp_id = $('#cp_id').val()
			var bug_id = 'default'
			var button = $(this)
			var text = $(this).html()
			button.html('<i class="fa fa-spinner fa-spin"></i>')
			jQuery.ajax({
				type: "post",
				dataType: "json",
				url: custom_object.ajax_url,
				data: {
					'action': 'appq_update_bugs_in_bugtracker',
					'cp_id': cp_id,
					'bug_id': bug_id
				},
				success: function(res) {
					button.html(text)
					if (!res.success) {
						toastr.error(res.data, 'Oh no!')
					} else {
						toastr.success('Default bug updated')
						// button.prop('disabled',true)
						// location.reload()
					}
				},
				error: function(res) {
					button.html(text)
					toastr.error(JSON.stringify(res), 'Oh no!')
				}
			});
		})
	});

})(jQuery);
