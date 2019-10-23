(function($) {
	'use strict';

	$(document).ready(function() {

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
					button.closest('tr').find('td.is_uploaded').append('<span class="fa fa-check"></span>')
					if (!res.success) {
						toastr.error(res.data, 'Oh no!')
					}
				},
				error: function(res) {
					button.removeClass('fa-spinner fa-spin').addClass('fa-upload')
					button.closest('tr').find('td.is_uploaded').append('<span class="fa fa-check"></span>')
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