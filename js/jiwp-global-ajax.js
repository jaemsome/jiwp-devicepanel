function JIWP_AjaxClick(button, data, message_container, BeforeAjax_Callback_Function, BeforeSend_Callback_Function, Success_Callback_Function)
{
    button.click(function(){
        // Cancel event if already disabled
        if(button.hasClass('jiwp-disabled')) return false;
        
        if(BeforeAjax_Callback_Function)
            BeforeAjax_Callback_Function(button, data);
        
        jQuery.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: data,
            beforeSend: function() {
                // Disable the button while processing
                button.addClass('jiwp-disabled');
                
                if(BeforeSend_Callback_Function)
                    BeforeSend_Callback_Function(button);
            },
            success: function(response) {
                // Delete previous message
                jQuery('p.jiwp-message').remove();
                
                // Check for the message container if it exists
                if(message_container) {
                    if(response.success) {
                        ajax_response = response.success;
                        // Add success message
                        message_container.prepend('<p class="jiwp-success jiwp-message">'+response.success+'</p>');
                    } else if(response.error) {
                        // Add error message
                        message_container.prepend('<p class="jiwp-error jiwp-message">'+response.error+'</p>');
                    }
                }
                // Enable the button
                button.removeClass('jiwp-disabled');
                
                if(Success_Callback_Function)
                    Success_Callback_Function(response);
            },
            error: function(xhr, error) {
                // Enable the button
                button.removeClass('jiwp-disabled');
            }
        });
        // Cancel the event, no need to process by the server
        return false;
    });
}