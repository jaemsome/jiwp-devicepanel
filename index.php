<?php

/*
 * Plugin Name: JIWP Device Panel
 * Plugin URI: 
 * Description: Plugin to manage device configuration settings.
 * Author: JaemSome
 * Version: 1.0
 * Author URI:  
 */

if(!defined('ABSPATH')) exit; // Exit if accessed directly

require_once 'ui/index.php';
require_once 'jiwp-devicepanel.php';

// Plugin activation
register_activation_hook(__FILE__, 'activate_jiwp_devicepanel');
// Callback function 
function activate_jiwp_devicepanel()
{
    error_log('JIWP Device Panel plugin activated.');
}

// Plugin Deactivation
register_deactivation_hook(__FILE__, 'deactivate_jiwp_devicepanel');
// Callback function
function deactivate_jiwp_devicepanel()
{
    error_log('JIWP Device Panel plugin deactivated.');
}