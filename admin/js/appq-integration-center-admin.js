(function($) {
	'use strict';

	$(document).ready(function() {
		
		
		$('#custom_field_maps').on('click','.remove',function(){
			$(this).closest('.custom_field_map').remove()
		})
		function addCustomFieldToModal(){
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
				var cp_id = $('#cp_id').val()
				var formData = $('#add_custom_map :input').serializeArray()
				formData.push({'name':'cp_id', 'value':cp_id})
				formData.push({'name':'action', 'value':"appq_add_custom_field"})
				$.ajax({
					type: "post",
					dataType: "json",
					url: custom_object.ajax_url,
					data: formData
				}).then(function(res){
					console.log(res)
				})
			})
		}
		
		$('.nav-item').click(function(){
			$(this).closest('.nav').find('.nav-link').removeClass('active')
			$(this).find('.nav-link').addClass('active')
		})
		$('.nav-link').click(function(){
			$(this).parent().find('.nav-link').removeClass('active')
			$(this).addClass('active')
		})

		$('#bugs-tabs-content .fa.fa-upload').not(".text-secondary").click(function() {
			var cp_id = $('#cp_id').val()
			var bug_id = $(this).data('bug-id')
			var button = $(this)
			button.removeClass('fa-upload').addClass('fa-spinner fa-spin text-secondary')
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
						button.removeClass('text-secondary')
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
			var srcParams = new URLSearchParams(window.location.search)
			var cp_id = srcParams.has('id') ? srcParams.get('id') : -1
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
					console.log(msg);
				}
			});
		})

	});

})(jQuery);