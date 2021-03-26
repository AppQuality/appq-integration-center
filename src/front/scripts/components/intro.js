(function($) {
	'use strict';
	var _x =  wp.i18n._x
	
	$(document).ready(function() {
		
		var steps = []
		
		steps.push(	{ 
			intro: "Brief intro",
			action: 'click-on-bugs' 
		})
		steps.push(	{ 
			element: $('#bugs-tabs-content .table')[0],
			intro: "Here you can upload bugs"
		})
		
		if ($('#bugs-tabs-content .table .upload_bug').length) {
			steps.push(	{ 
				element: $('#bugs-tabs-content .table .upload_bug')[0],
				intro: "Click here to upload bug"
			})
		} 
		
		if ($('#bugs-tabs-content .table .update_bug').length) {
			steps.push(	{ 
				element: $('#bugs-tabs-content .table .update_bug')[0],
				intro: "Click here to update bug"
			})
		} 
		
		if ($('#bugs-tabs-content .table .delete_issue').length) {
			steps.push(	{ 
				element: $('#bugs-tabs-content .table .delete_issue')[0],
				intro: "Click here to delete bug"
			})
		} 
		
		if ($('#bugs-tabs-content .table .is_uploaded *').length) {
			steps.push(	{ 
				element: $('#bugs-tabs-content .table .is_uploaded > *').parent()[0],
				intro: "Click here to go to bug on tracker"
			})
		} 
		
		steps.push(	{ 
			element: $('#bugs_list')[0],
			intro: "You can filter bugs"
		})
		
		steps.push(	{ 
			element: $('.send-all')[0],
			intro: "You can send all"
		})
		
		steps.push(	{ 
			element: $('.send-selected')[0],
			intro: "You can send all the selected bugs"
		})
		
		
		steps.push(	{ 
			intro: "You need to setup first",
			action: 'click-on-bugs' 
		})
		
		
		steps.push(	{ 
			element: $('#settings-tab')[0],
			intro: "Setup here",
			action: 'click-on-settings'
		})
		
		if ($('#settings .settings-wizard').length) {
			var wizardBtn = $('[data-target=#custom_tracker_settings_modal]')
			.closest('.wrapper')
			var importBtn = $('[data-target=#import_tracker_settings_modal]')
				.closest('.wrapper')
			
			if (wizardBtn.length) {
				steps.push(	{ 
					element: wizardBtn[0],
					intro: "Wizard"
				})
			}
			if (importBtn.length) {
				steps.push(	{ 
					element: importBtn[0],
					intro: "Import"
				})
			}
			
		} else if ($('#bugs-tabs-content #settings').length) {
			
			steps.push(	{ 
				element: $('#bugs-tabs-content #settings')[0],
				intro: "Settings"
			})
			
			if ($('#import_default_bug').length) {
				steps.push(	{ 
					element: $('#import_default_bug')[0],
					intro: "Create a new fake bug to test settings"
				})
			}
			if ($('#update_default_bug').length) {
				steps.push(	{ 
					element: $('#update_default_bug')[0],
					intro: "Update fake bug to test settings"
				})
			}
			
			steps.push(	{ 
				element: $('[data-target="#custom_tracker_settings_modal"]')[0],
				intro: "Edit settings"
			})
			
			steps.push(	{ 
				element: $('[data-target="#reset_tracker_settings"]')[0],
				intro: "Delete settings"
			})
			
			if ($('[data-target="#get_from_bug"]').length) {
				steps.push(	{ 
					element: $('[data-target="#get_from_bug"]')[0],
					intro: "Read bugs from your tracker"
				})
			}
			
			steps.push(	{ 
				element: $('[data-target="#add_mapping_field_modal"]')[0],
				intro: "Add new mapping"
			})
			
			steps.push(	{ 
				element: $('.fields-list .row')[0],
				intro: "Mapping "
			})
			
			steps.push(	{ 
				element: $('.fields-list .row .actions .edit-mapping-field')[0],
				intro: "Edit "
			})
			steps.push(	{ 
				element: $('.fields-list .row .actions .delete-mapping-field')[0],
				intro: "Delete "
			})
		}
		
		
		
		var tutorial = introJs().setOptions({
			tooltipPosition : 'auto',
			positionPrecedence: ["top", "bottom","right", "left"],
			showBullets: false,
			showProgress: true,
			scrollToElement: true,
			scrollPadding: "50px",
			hideNext: true,
			hidePrev: true,
			buttonClass: "btn",
		  steps: steps,
			doneLabel: _x("Done","introJS","appqtutorial"),
			skipLabel: _x("Skip","introJS","appqtutorial"),
			prevLabel: _x("← Back","introJS","appqtutorial"),
			nextLabel: _x("Next →","introJS","appqtutorial"),

		})
		
		tutorial.onbeforechange(function(a,b,c) {
			if (
				this._introItems[this._currentStep]
				&& this._introItems[this._currentStep].action
			) {
				var action = this._introItems[this._currentStep].action
				if (action == 'click-on-settings') {
					$('#settings-tab').click();
				} else if (action == 'click-on-bugs') {
					$('#bugs-tab').click();
				}
			}
		})
		function integrationCenterTutorial() {
			tutorial.start();
		}
		
		$('#start-introjs').click(function(e){
			e.preventDefault()
			integrationCenterTutorial()
		})
	})
})(jQuery);
