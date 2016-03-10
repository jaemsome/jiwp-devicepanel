<?php

if(!defined('ABSPATH')) exit; // Exit if accessed directly

class JIWP_DevicePanel
{
    public $devicepanel_menu_option = array();
    private $__activationcode_settings_key = 'activationcode_settings';
    private $__plugin_options_key = 'jiwp_devicepanel_menu_option';
    private $__plugin_settings_tabs = array();
    
    /*
     * Holds the JIWP_DevicePanel object
     */
    private static $__instance = null;
    
    /*
     * Holds global messages
     */
    private $__message_arr = array();
    
    /*
     * Holds global variables
     */
    private $__var_arr = array();
    
    private function __construct()
    {
        $this->__Setup_Shortcodes();
        $this->__Setup_FilterHooks();
        $this->__Setup_ActionHooks();
    }
    
    /*
     * Add shortcodes
     */
    private function __Setup_Shortcodes()
    {
        // Device panel UI
        add_shortcode('jiwp_deviceactivationUI', array($this, 'DeviceActivationUI'));
        add_shortcode('jiwp_ingotmodel11UI', array($this, 'INGOTModel11UI'));
        add_shortcode('jiwp_ingotmodel12UI', array($this, 'INGOTModel12UI'));
        add_shortcode('jiwp_ingotmodel13UI', array($this, 'INGOTModel13UI'));
    }
    
    /*
     * Add filter hooks
     */
    private function __Setup_FilterHooks()
    {
        
    }
    
    /*
     * Add action hooks
     */
    private function __Setup_ActionHooks()
    {
        // Add option page in the admin panel
        add_action('admin_menu', array($this, 'Add_OptionPage'));
        // Register the settings to use in the device panel option pages
        add_action('admin_init', array($this, 'Register_Settings'));
        // Setup all the things needed for the plugin first thing
        add_action('init', array($this, 'Initialization'));
        // Add front-end css and scripts
        add_action('wp_enqueue_scripts', array($this, 'Add_StylesAndScripts'));
        // AJAX functions
        add_action('wp_ajax_activatedevice', array($this, 'ActivateDevice'));
        add_action('wp_ajax_nopriv_activatedevice', array($this, 'ActivateDevice'));
        add_action('wp_ajax_configuredevice', array($this, 'ConfigureDevice'));
        add_action('wp_ajax_nopriv_configuredevice', array($this, 'ConfigureDevice'));
    }
    
    /*
     * Create or retrieve the current object instance
     */
    public static function GetInstance()
    {
        if(self::$__instance == NULL) {
            self::$__instance = new JIWP_DevicePanel();
        }
        return self::$__instance;
    }
    
    public function DeviceActivationUI()
    {
        // Ouput form
        echo JIWP_DevicePanelForms::DeviceActivationForm();
    }
    
    public function INGOTModel11UI()
    {
        // Ouput form
        echo JIWP_DevicePanelForms::INGOTModel11Form();
    }
    
    public function INGOTModel12UI()
    {
        // Ouput form
        echo JIWP_DevicePanelForms::INGOTModel12Form();
    }
    
    public function INGOTModel13UI()
    {
        // Ouput form
        echo JIWP_DevicePanelForms::INGOTModel13Form();
    }
    
    /*
     * Adding css and scripts in to the front-end pages
     */
    public function Add_StylesAndScripts()
    {
        if(!wp_style_is('jiwp_global_style', 'registered')) {
            wp_register_style('jiwp_global_style', plugins_url('css/global.css', __FILE__));
        }
        
        if(!wp_style_is('jiwp_global_style', 'enqueued')) {
            wp_enqueue_style('jiwp_global_style');
        }
        
        if(!wp_script_is('jiwp_global_ajax', 'registered'))
        {
            // Register the script that contains the global ajax functions
            wp_register_script('jiwp_global_ajax', plugins_url('js/jiwp-global-ajax.js', __FILE__), false, false, true);
        }
        
        if(!wp_script_is('jiwp_devicepanel_script', 'registered')) {
            wp_register_script('jiwp_devicepanel_script', plugins_url('js/jiwp-devicepanel.js', __FILE__), array('jquery', 'jiwp_global_ajax'), false, true);
        }
        
        if(!wp_script_is('jiwp_devicepanel_script', 'enqueued')) {
            wp_enqueue_script('jiwp_devicepanel_script');
        }
        
        wp_localize_script('jiwp_global_ajax', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    }
    
    /*
     * Add menu options into the dashboard panel
     */
    public function Add_OptionPage()
    {
        if(empty($GLOBALS['admin_page_hooks']['jiwp_menuoptions'])) {
            add_menu_page('JIWP Options', 'JIWP Options', 'manage_options', 'jiwp_menuoptions', array($this, 'JIWP_OptionsPage'));
        }
        
        if(empty($GLOBALS['admin_page_hooks'][$this->__plugin_options_key])) {
            $option_page = add_submenu_page('jiwp_menuoptions', 'JIWP Device Panel', 'Device Panel', 'manage_options', $this->__plugin_options_key, array($this, 'DevicePanel_OptionPage'));
            // Add css to the option page
            add_action('admin_print_styles-'.$option_page, array($this, 'Add_OptionPage_Styles'));
        }
    }
    
    /*
     * JIWP option page UI
     */
    public function JIWP_OptionsPage()
    {
        ?>
        <div class="wrap">
            <h2>Welcome to JIWP plugins. You can select the items under this menu to edit the desired plugin settings.</h2>
        </div>
        <?php
    }
    
    /*
     * Device panel option page under JIWP menu
     */
    public function DevicePanel_OptionPage()
    {
        ?>
        <div class="wrap">
            <form method="POST" action="options.php">
                <?php
                    settings_fields($this->__activationcode_settings_key);
                    
                    do_settings_sections($this->__activationcode_settings_key);
                    
                    submit_button();
                ?>
            </form>
        </div>
        <?php
    }
    
    /*
     * Adding css for the option page
     */
    public function Add_OptionPage_Styles()
    {
        if(!wp_style_is('jiwp_global_style', 'registered')) {
            wp_register_style('jiwp_global_style', plugins_url('css/global.css', __FILE__));
        }
        
        if(!wp_style_is('jiwp_global_style', 'enqueued')) {
            wp_enqueue_style('jiwp_global_style');
        }
    }
    
    /*
     * Adds the device panel option page input fields
     */
    public function Register_Settings()
    {
        // Register activation code settings tab
        $this->__plugin_settings_tabs[$this->__activationcode_settings_key] = 'Activation Code';
        register_setting($this->__activationcode_settings_key, $this->__activationcode_settings_key, array($this, 'Sanitize_ActivationCode_Settings'));
        // Add activation code settings section
        add_settings_section('jiwp_devicepanel_activationcode_section', 'Activation Code Section', array($this, 'ActivationCode_Section'), $this->__activationcode_settings_key);
        // Add fields on the activation code settings
        add_settings_field('jiwp_activationcode_ingot_model_11_v1', 'INGOT Model 11 Activation Code Version 1', array($this, 'DisplayINGOTModel11_ActivationCodeVersion1_Field'), $this->__activationcode_settings_key, 'jiwp_devicepanel_activationcode_section');
        add_settings_field('jiwp_activationcode_ingot_model_12_v1', 'INGOT Model 12 Activation Code Version 1', array($this, 'DisplayINGOTModel12_ActivationCodeVersion1_Field'), $this->__activationcode_settings_key, 'jiwp_devicepanel_activationcode_section');
    }
    
    /*
     * Cleans the activation code input field values when the form is submitted
     */
    public function Sanitize_ActivationCode_Settings($input)
    {
        $new_input = array();
        
        if(isset($input['jiwp_activationcode_ingot_model_11_v1'])) {
            $new_input['jiwp_activationcode_ingot_model_11_v1'] = sanitize_text_field($input['jiwp_activationcode_ingot_model_11_v1']);
        }
        if(isset($input['jiwp_activationcode_ingot_model_12_v1'])) {
            $new_input['jiwp_activationcode_ingot_model_12_v1'] = sanitize_text_field($input['jiwp_activationcode_ingot_model_12_v1']);
        }

        return $new_input;
    }
    
    /*
     * Outputs activation code section description
     */
    public function ActivationCode_Section() { echo 'List of device\'s activation codes goes here.'; }
    
    /*
     * Output activation code version 1 list input field
     */
    public function DisplayINGOTModel11_ActivationCodeVersion1_Field()
    {
        ?>
        <textarea rows="20" class="regular-text jiwp-onecolumn jiwp-resizevertical" id="jiwp_activationcode_ingot_model_11_v1" name="<?php echo $this->__activationcode_settings_key; ?>[jiwp_activationcode_ingot_model_11_v1]"><?php echo $this->devicepanel_menu_option[$this->__activationcode_settings_key]['jiwp_activationcode_ingot_model_11_v1']; ?></textarea>
        <?php
    }
    
    /*
     * Output activation code version 1 list input field
     */
    public function DisplayINGOTModel12_ActivationCodeVersion1_Field()
    {
        ?>
        <textarea rows="20" class="regular-text jiwp-onecolumn jiwp-resizevertical" id="jiwp_activationcode_ingot_model_12_v1" name="<?php echo $this->__activationcode_settings_key; ?>[jiwp_activationcode_ingot_model_12_v1]"><?php echo $this->devicepanel_menu_option[$this->__activationcode_settings_key]['jiwp_activationcode_ingot_model_12_v1']; ?></textarea>
        <?php
    }
    
    /*
     * Setup the things needed for the plugin
     */
    public function Initialization()
    {
        $this->devicepanel_menu_option[$this->__activationcode_settings_key] = get_option($this->__activationcode_settings_key);
    }
    
    /*
     * Activate device through ajax call
     */
    public function ActivateDevice()
    {
        $response_arr = array();
        
        if(is_user_logged_in()) {
            // Holds the form data
            $form_data_arr = $this->__ConvertJSSerializeToAssociativeArray($_POST['form_data']);
            // Check for empty device ip address
            if(empty($form_data_arr['dev_ipaddress'])) {
                $response_arr['error'] = 'Device IP Address cannot be empty.';
            }
            // Check for empty device type
            if(empty($form_data_arr['dev_type'])) {
                $response_arr['error'] .= 'Device type cannot be empty.';
            }
            // Proceed to device activation if no errors occur
            if(empty($response_arr['error'])) {
                $device_model = strtolower(str_replace(' ', '_', $form_data_arr['dev_type']));
                // Get the used activation codes
                $used_activation_codes = get_option($device_model.'_v1');
                // Check if activation code is already used
                if(strpos($used_activation_codes, $form_data_arr['dev_activationcode']) !== false) {
                    $response_arr['error'] = 'Activation code already being used.';
//                    delete_option($device_model.'_v1');
                }
                // Check if activation code exists
                else if(strpos($this->devicepanel_menu_option[$this->__activationcode_settings_key]['jiwp_activationcode_'.$device_model.'_v1'], $form_data_arr['dev_activationcode']) !== false) {
                    $user_id = get_current_user_id();
                    // Register the new activation code
                    if(update_user_meta($user_id, $device_model.'_v1', $form_data_arr['dev_activationcode']) !== false) {
                        // For already used reference
                        if($used_activation_codes !== false) {
                            // The option already exists, so we just update it
                            update_option($device_model.'_v1', $used_activation_codes.'|'.$form_data_arr['dev_activationcode']);
                        }
                        else {
                            add_option($device_model.'_v1', $form_data_arr['dev_activationcode'], null, 'no');
                        }
                        $response_arr['dev_ipaddress'] = esc_url($form_data_arr['dev_ipaddress']);
                        $response_arr['activation_code'] = $form_data_arr['dev_activationcode'];
                        $response_arr['success'] = 'Activation code accepted. Waiting for the device\'s response.';
                    }
                    else {
                        $response_arr['error'] = 'Unable to process activation code, please try again.';
//                        delete_user_meta($user_id, $device_model.'_v1');
                    }
                }
                else {
                    $response_arr['error'] = 'Invalid activation code, please try again.';
                }
            }
        }
        else {
            $response_arr['error'] = 'Sorry, you must first <a href="'.esc_url(site_url('/login-logout/')).'">log in</a> to view this page. You can <a href="'.esc_url(site_url('/register/')).'">register free here</a>.';
        }
        
        echo json_encode($response_arr);
        wp_die();
    }
    
    /*
     * Configure device through ajax call
     */
    public function ConfigureDevice()
    {
        $response_arr = array();
        
        if(is_user_logged_in()) {
            // Holds the form data
            $form_data_arr = $this->__ConvertJSSerializeToAssociativeArray($_POST['form_data']);
            // Check for empty device ip address
            if(empty($form_data_arr['dev_ipaddress'])) {
                $response_arr['error'] = 'Device IP Address cannot be empty.';
            }
            // Check for empty device type
            if(empty($form_data_arr['dev_type'])) {
                $response_arr['error'] .= 'Device type cannot be empty.';
            }
            // Proceed to device activation if no errors occur
            if(empty($response_arr['error'])) {
                $user_id = get_current_user_id();
                $device_model = strtolower(str_replace(' ', '_', $form_data_arr['dev_type']));
                $activation_code = get_user_meta($user_id, $device_model.'_v1', true);
                // Check if there's a registered device for this account
                if(empty($activation_code) || !$activation_code) {
                    $device_model = ucwords(str_replace('_', ' ', $device_model));
                    $response_arr['error'] = 'No registered '.str_replace('Ingot', 'INGOT', $device_model).' for this account.';
                }
                // Requirements passed, prepare all request data
                else {
                    $response_arr['success'] = 'Configuration request accepted. Waiting for the device\'s response.';
                    $response_arr['dev_ipaddress'] = esc_url($form_data_arr['dev_ipaddress']);
                    $response_arr['activation_code'] = $activation_code;
                    $ip_arr = array('eth_ipaddress', 'smartscope1_ipaddress', 'smartscope2_ipaddress', 'smartscope3_ipaddress', 'smartscope4_ipaddress');
                    foreach($ip_arr as $ip) {
                        if(is_numeric($form_data_arr[$ip.'1']) && is_numeric($form_data_arr[$ip.'2']) && 
                           is_numeric($form_data_arr[$ip.'3']) && is_numeric($form_data_arr[$ip.'4'])) {
                            $response_arr[$ip] = intval($form_data_arr[$ip.'1']).'.'.intval($form_data_arr[$ip.'2']).'.';
                            $response_arr[$ip] .= intval($form_data_arr[$ip.'3']).'.'.intval($form_data_arr[$ip.'4']);
                        }
                    }
                }
            }
        }
        else {
            $response_arr['error'] = 'Sorry, you must first <a href="'.esc_url(site_url('/login-logout/')).'">log in</a> to view this page. You can <a href="'.esc_url(site_url('/register/')).'">register free here</a>.';
        }
        
        echo json_encode($response_arr);
        wp_die();
    }
    
    /*
     * Convert javascript serialize array to php associative array
     * 
     * @param array (javascript serialize array)
     * 
     * @return array (associative array)
     */
    private function __ConvertJSSerializeToAssociativeArray($serialize_arr=array())
    {
        $associative_arr = array();
        
        // Create an associative array out of the serialize js array
        foreach($serialize_arr as $ser_arr)
        {
            // Get the array keys from 'key0[key1]' to array(key0, key1)
            $keys_arr = explode(',', str_replace(array('[', ']'), array(',', ''), $ser_arr['name']));
            
            // 2-dimensional array
            if(count($keys_arr) == 2) {
                $associative_arr[$keys_arr[0]][$keys_arr[1]] = sanitize_text_field($ser_arr['value']);
            }
            // Single array
            else {
                $associative_arr[$keys_arr[0]] = sanitize_text_field($ser_arr['value']);
            }
        }
        
        return $associative_arr;
    }
}

$jiwp_devicepanel = JIWP_DevicePanel::GetInstance();