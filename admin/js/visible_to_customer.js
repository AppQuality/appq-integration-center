jQuery( document ).ready(function() {
    jQuery('.visible_to_customer').on('change', setVisibleStatus);
});

const setVisibleStatus = function setVisibleStatus() {
    let visible_to_customer = (jQuery(this).prop('checked')) ? 1 : 0;
    let slug = jQuery(this).data('integration');
    
    jQuery.ajax( {
        url: custom_object.ajax_url,
        type: "POST",
        data: {
            action: "appq_set_visible_to_customer",
            slug: slug,
            visible_to_customer: visible_to_customer
        },
        beforeSend: function() {
            jQuery(this).prop('disabled', true);
        },
        success: function() {
            jQuery(this).prop('disabled', false);
        },
        error: function( response ) {
            console.log( response );
            jQuery(this).prop('disabled', false);
        }
    });
};