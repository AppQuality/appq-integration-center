(function($) {
	'use strict';
	var _x =  wp.i18n._x
	
	$(document).ready(function() {
		
		var steps = []
		
		steps.push(	{ 
			intro: _x("Read carefully the following steps to learn to integrate AppQuality's Issue Tracker with your company's one.","Integration Center Introjs", "integration-center"),
			action: 'click-on-bugs'
		})
		steps.push(	{ 
			element: $('#bugs-tabs-content .table')[0],
			intro: _x("This is the full list of bugs created by tester for this specific Campaign","Integration Center Introjs", "integration-center")
		})
		if ($('#bugs-tabs-content .table .upload_bug').length) {
			steps.push(	{ 
				element: $('#bugs-tabs-content .table .upload_bug')[0],
				intro: _x("Click here to upload a specific bug","Integration Center Introjs", "integration-center")
			})
		} 
		if ($('#bugs-tabs-content .table .update_bug').length) {
			steps.push(	{ 
				element: $('#bugs-tabs-content .table .update_bug')[0],
				intro: _x("Click here to update a specific bug","Integration Center Introjs", "integration-center")
			})
		} 
		if ($('#bugs-tabs-content .table .delete_issue').length) {
			steps.push(	{ 
				element: $('#bugs-tabs-content .table .delete_issue')[0],
				intro: _x("Click here to delete a specific bug","Integration Center Introjs", "integration-center")
			})
		} 
		if ($('#bugs-tabs-content .table .is_uploaded *').length) {
			steps.push(	{ 
				element: $('#bugs-tabs-content .table .is_uploaded > *').parent()[0],
				intro: _x("Click here to go to bug on your tracker","Integration Center Introjs", "integration-center")
			})
		} 
		steps.push(	{ 
			element: $('#bugs_list-search')[0],
			intro: _x(`Here you can filter the bug list.
						The search is really powerful, you can search by ID or text if you are looking for a specific bug,
						but most likely you will be willing to look groups of bugs by status etc.
						You can see a list of feature below the search bar.`,"Integration Center Introjs", "integration-center")
		})
		steps.push(	{ 
			element: $('.send-all')[0],
			intro: _x("You can upload all the list","Integration Center Introjs", "integration-center")
		})
		steps.push(	{ 
			element: $('.send-selected')[0],
			intro: _x("You can upload all the selected bugs","Integration Center Introjs", "integration-center")
		})
		steps.push(	{ 
			intro: _x("But first, you need to setup the connection with your Issue Tracker","Integration Center Introjs", "integration-center"),
			action: 'click-on-bugs' 
		})
		steps.push(	{ 
			element: $('#settings-tab')[0],
			intro: _x("This is the summary of your settings for this campaign","Integration Center Introjs", "integration-center"), // popup ridondante?! #1
			action: 'click-on-settings'
		})
		if ($('#settings .settings-wizard').length) {
			var wizardBtn = $('[data-target="#custom_tracker_settings_modal"]')
			.closest('.wrapper')
			var importBtn = $('[data-target="#import_tracker_settings_modal"]')
				.closest('.wrapper')
			if (wizardBtn.length) {
				steps.push(	{ 
					element: wizardBtn[0], // FIXME: forse se scriviamo i lorem ipsum e la doc ci risparmiamo l'intro JS qui
					intro: _x("Configure a connection to your Issue Tracker if it's the first time you're pushing some bugs to it","Integration Center Introjs", "integration-center")
				})
			}
			if (importBtn.length) {
				steps.push(	{ 
					element: importBtn[0],
					intro: "Or Import a previously configured connection and mapping"
				})
			}
		} else if ($('#bugs-tabs-content #settings').length) {
			steps.push(	{ 
				element: $('#bugs-tabs-content #settings')[0],
				intro: _x(`In order to be able to fill this settings make sure you have enough rights on your Issue Tracker and a bit of knowledge about how its API works, but don't worry, we're here to help`,"Integration Center Introjs", "integration-center") // popup ridondante?! #1 
			})
			if ($('#import_default_bug').length) {
				steps.push(	{ 
					element: $('#import_default_bug')[0], // mi è uscito tra i primi step dopo Settings, non è che dovrebbe uscire dopo le password e endpoint o è solo che erano già configurati? 
					intro: _x("You can create a new fake bug at anytime to test the settings","Integration Center Introjs", "integration-center")
				})
			}
			if ($('#update_default_bug').length) {
				steps.push(	{ 
					element: $('#update_default_bug')[0],
					intro: _x("Update the fake bug used to test settings","Integration Center Introjs", "integration-center")
				})
			}
			steps.push(	{ 
				element: $('[data-target="#custom_tracker_settings_modal"]')[0],
				intro: _x("Edit settings, this might come in handy also in the future if the token is expired or you change the project ID","Integration Center Introjs", "integration-center")
			})
			steps.push(	{ 
				element: $('[data-target="#reset_tracker_settings"]')[0],
				intro: _x("Delete settings","Integration Center Introjs", "integration-center")
			})
			if ($('[data-target="#get_from_bug"]').length) {
				steps.push(	{ 
					element: $('[data-target="#get_from_bug"]')[0],
					intro: _x("Read bugs from your tracker","Integration Center Introjs", "integration-center")
				})
			}
			steps.push(	{ 
				element: $('[data-target="#add_mapping_field_modal"]')[0],
				intro: _x("This is the most important part, where you decide how to map and write the bug on your side starting from the info you have here.","Integration Center Introjs", "integration-center")
			})
			steps.push(	{ 
				element: $('.fields-list .row')[0],
				intro: _x(`Each row maps a Content to a Name, that is a Key in the Issue Tracker API and the name of the label that you should see.
								In Content we invite you to use all the informations you find useful from our platform, format them as you prefer and then send it over, you can choose any field from the Available Field (also listed above).
								In Name you need to use the proper naming that your Issue Tracker expects.`,"Integration Center Introjs", "integration-center")
			})
			steps.push(	{ 
				element: $('.fields-list .row .actions .edit-mapping-field')[0],
				intro: _x(`Here you will find a modal to better customize the mapping for a single field`,"Integration Center Introjs", "integration-center") // non è allineato al bottone
			})
			steps.push(	{ 
				element: $('.fields-list .row .actions .delete-mapping-field')[0],
				intro: _x("Delete a single mapping","Integration Center Introjs", "integration-center")
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
			doneLabel: _x("Done","Integration Center Introjs","integration-center"),
			skipLabel: _x("Skip","Integration Center Introjs","integration-center"),
			prevLabel: _x("← Back","Integration Center Introjs","integration-center"),
			nextLabel: _x("Next →","Integration Center Introjs","integration-center"),

		})
		
		tutorial.onbeforechange(function() {
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
