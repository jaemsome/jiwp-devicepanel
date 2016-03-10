//document.getElementById('btn4CHTally').onclick = function(event) {
//    event.preventDefault();
//    // Get all messages DOM
//    var msgsDOM = document.getElementsByClassName('jiwp-message');
//    // Remove all messages
//    while(msgsDOM.length > 0) {
//        msgsDOM[0].parentNode.removeChild(msgsDOM[0]);
//    }
//    // Form DOM
//    var form4CHTally = document.getElementById('form4CHTally');
//    // Create new message paragraph DOM
//    var msgDOM = document.createElement('p');
//    // Assigned Device IP Address value
//    var devIPAddress = document.getElementById('txtDevIPAddress').value;
//    // Assigned Ethernet IP Address value
//    var ethIPAddress = document.getElementById('txtEthIPAddress1').value+'.';
//    ethIPAddress += document.getElementById('txtEthIPAddress2').value+'.';
//    ethIPAddress += document.getElementById('txtEthIPAddress3').value+'.';
//    ethIPAddress += document.getElementById('txtEthIPAddress4').value;
//    // Assigned Ethernet MAC Address value
//    var ethMACAddress = document.getElementById('txtEthMACAddress1').value+':';
//    ethMACAddress += document.getElementById('txtEthMACAddress2').value+':';
//    ethMACAddress += document.getElementById('txtEthMACAddress3').value+':';
//    ethMACAddress += document.getElementById('txtEthMACAddress4').value+':';
//    ethMACAddress += document.getElementById('txtEthMACAddress5').value+':';
//    ethMACAddress += document.getElementById('txtEthMACAddress6').value;
//    // Assigned ATEM switcher IP Address value
//    var atemIPAddress = document.getElementById('txtATEMIPAddress1').value+'.';
//    atemIPAddress += document.getElementById('txtATEMIPAddress2').value+'.';
//    atemIPAddress += document.getElementById('txtATEMIPAddress3').value+'.';
//    atemIPAddress += document.getElementById('txtATEMIPAddress4').value;
//    // URL query string
//    // IP and MAC address
//    var addressesQueryString = 'eth_ip_addr='+ethIPAddress;
//    addressesQueryString += '&eth_mac_addr='+ethMACAddress;
//    addressesQueryString += '&atem_ip_addr='+atemIPAddress;
//    // No cache value
//    var nocache = '&nocache='+Math.random() * 1000000;
//    // Create new HTTP request
//    var httpRequest = new XMLHttpRequest();
//    try {
//        // Opera 8.0+, Firefox, Chrome, Safari
//        httpRequest = new XMLHttpRequest();
//    }
//    catch(e) {
//        // Internet Explorer Browsers
//        try {
//            httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
//        }
//        catch(e) {
//            try {
//                httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
//            }
//            catch(e) {
//                // Something went wrong
//                msgDOM.className = 'jiwp-error jiwp-message';
//                msgDOM.innerHTML = 'Your browser broke!';
//                form4CHTally.insertBefore(msgDOM, form4CHTally.firstElementChild);
//                return false;
//            }
//        }
//    }
//    // Handle ajax HTTP response
//    httpRequest.onreadystatechange = function() {
//        // Request is compete
//        if(httpRequest.readyState === 4 && httpRequest.status === 200) {
//            // Convert HTTP response into json
//            var response = this.responseXML;
//            // Get message element
//            var message = response.getElementsByTagName('message')[0];
//            
//            if(message.attributes[0].nodeValue === 'success') {
//                msgDOM.className = 'jiwp-success jiwp-message';
//                msgDOM.innerHTML = message.childNodes[0].nodeValue;
//            }
//            else if(message.attributes[0].nodeValue === 'error') {
//                msgDOM.className = 'jiwp-error jiwp-message';
//                msgDOM.innerHTML = message.childNodes[0].nodeValue;
//            }
//            // Prepend message into the form
//            form4CHTally.insertBefore(msgDOM, form4CHTally.firstElementChild);
//        }
//        else if(httpRequest.readyState === 4 && httpRequest.status !== 200) {
//            msgDOM.className = 'jiwp-error jiwp-message';
//            msgDOM.innerHTML = 'Something wrong with the request.';
//            form4CHTally.insertBefore(msgDOM, form4CHTally.firstElementChild);
//        }
//    };
//    // Send HTTP request for assigning addresses
//    httpRequest.open('GET', encodeURI('http://'+devIPAddress+'/?action=set_address&'+addressesQueryString+nocache), true);
////    httpRequest.setRequestHeader('Content-Type', 'application/json', true);
//    httpRequest.send();
//};

jQuery(document).ready(function($){
    $.fn.extend({
        JIWP_ActivateDevice: function() {
            var deviceActivationForm = $('form#formDeviceActivation');
            var data = {action: 'activatedevice'};
            
            // Function to be executed before calling the jQuery ajax method
            function BeforeAjax_Callback_Function(button, data) {
                // Set form data
                var form_data = deviceActivationForm.serializeArray();
                data.form_data = form_data;
            }
            
            function Success_Callback_Function(response) {
                if(response.success) {
                    // Send activation code into the device
                    $.ajax({
                        url: response.dev_ipaddress,
                        type: 'GET',
                        dataType: 'xml',
                        data: 'action=activatedevice&acode='+response.activation_code,
                        beforeSend: function() {
                            
                        },
                        success: function(response) {
                            $(response).find('message').each(function(){
                                if($(this).attr('type') === 'success') {
                                    // Delete previous message
                                    $('p.jiwp-message').remove();
                                    // Add success message
                                    deviceActivationForm.prepend('<p class="jiwp-success jiwp-message">'+$(this).text()+'</p>');
                                }
                            });
                        },
                        error: function(xhr, error) {
                            // Delete previous message
                            $('p.jiwp-message').remove();
                            // Add error message
                            deviceActivationForm.prepend('<p class="jiwp-error jiwp-message">An error occur, please check the device IP address if correct.</p>');
                        }
                    });
                }
            }
            
            JIWP_AjaxClick($(this), data, deviceActivationForm, BeforeAjax_Callback_Function, null, Success_Callback_Function);
        },
        JIWP_ConfigureDevice: function(deviceType) {
            var deviceConfigForm = $('form#jiwp_devicepanel_configform');
            var data = {action: 'configuredevice'};
            
            // Function to be executed before calling the jQuery ajax method
            function BeforeAjax_Callback_Function(button, data) {
                // Set form data
                var form_data = deviceConfigForm.serializeArray();
                data.form_data = form_data;
                data.form_data[21] = {name: 'dev_type', value: deviceType};
            }
            
            function Success_Callback_Function(response) {
                if(response.success) {
                    var data = 'action=configdevice&acode='+response.activation_code;
                    if(response.eth_ipaddress) {
                        data += '&ethip='+response.eth_ipaddress;
                    }
                    if(response.smartscope1_ipaddress) {
                        data += '&ss1ip='+response.smartscope1_ipaddress;
                    }
                    if(response.smartscope2_ipaddress) {
                        data += '&ss2ip='+response.smartscope2_ipaddress;
                    }
                    if(response.smartscope3_ipaddress) {
                        data += '&ss3ip='+response.smartscope3_ipaddress;
                    }
                    if(response.smartscope4_ipaddress) {
                        data += '&ss4ip='+response.smartscope4_ipaddress;
                    }
                    // Send config request into the device
                    $.ajax({
                        url: response.dev_ipaddress,
                        type: 'GET',
                        dataType: 'xml',
                        data: data,
                        beforeSend: function() {
                            
                        },
                        success: function(response) {
                            $(response).find('message').each(function(){
                                if($(this).attr('type') === 'success') {
                                    // Delete previous message
                                    $('p.jiwp-message').remove();
                                    // Add success message
                                    deviceConfigForm.prepend('<p class="jiwp-success jiwp-message">'+$(this).text()+'</p>');
                                }
                            });
                        },
                        error: function(xhr, error) {
                            // Delete previous message
                            $('p.jiwp-message').remove();
                            // Add error message
                            deviceConfigForm.prepend('<p class="jiwp-error jiwp-message">An error occur, please check the device IP address if correct.</p>');
                        }
                    });
                }
            }
            
            JIWP_AjaxClick($(this), data, deviceConfigForm, BeforeAjax_Callback_Function, null, Success_Callback_Function);
        }
    });
    // Plugin implementations
    $('#btnActivateDevice').JIWP_ActivateDevice();
    $('#btnConfigSmartScope').JIWP_ConfigureDevice('ingot_model_11');
    $('#btnConfigVideoHub').JIWP_ConfigureDevice('ingot_model_12');
});