jQuery( document ).ready(function() {
    jQuery('#save_visibility').on('click', setVisibleStatus);
});

const setVisibleStatus = function setVisibleStatus() {
    let integrations = {};
    let checkboxes = jQuery('.visible_to_customer');
    for (let i = 0; i < checkboxes.length; i++) {
        integrations[checkboxes[i].dataset.integration] = (jQuery(checkboxes[i]).prop('checked')) ? 1 : 0;
    }

    let jsonIntegrations = JSON.stringify(integrations);
    
    jQuery.ajax( {
        url: custom_object.ajax_url,
        type: "POST",
        data: {
            action: "appq_set_visible_to_customer",
            integrations: jsonIntegrations
        },
        beforeSend: function() {
            jQuery(this).prop('disabled', true);
        },
        success: function(response) {
            jQuery(this).prop('disabled', false);

            // Parse Result
            if ( typeof response !== "undefined" ) {
                let result = response;

                if (result.data) {
                    if (result.data.message) {
                        toastr[ result.data.type ]( result.data.message );
                    }
                }

                location.reload();
            }
        },
        error: function( response ) {
            console.log( response );
            jQuery(this).prop('disabled', false);
        }
    });
};