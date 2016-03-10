<?php

if(!defined('ABSPATH')) exit; // Exit if accessed directly

class JIWP_DevicePanelForms
{
    public static function DeviceActivationForm()
    {
        ob_start();
        
        if(is_user_logged_in()):
            ?>
            <!--<h3 class="jiwp-heading jiwp-aligncenter">Register Device</h3>-->
            <form id="formDeviceActivation" method="POST" action="">
                <p>
                    <label class="jiwp-bold jiwp-onecolumn">Device current IP Address<br/><i>Ex: 192.xxx.xxx.xxx Or http://yourdomain.com</i></label>
                    <input type="text" class="jiwp-onecolumn" value="" id="txtDevIPAddress" name="dev_ipaddress" />
                </p>
                <hr/>
                <p>
                    <label class="jiwp-bold jiwp-onecolumn">Device Type :</label><br/>
                    <select class="jiwp-twocolumns" id="selDevType" name="dev_type">
                        <option>INGOT Model 11</option>
                        <option>INGOT Model 12</option>
                        <option>INGOT Model 13</option>
                        <option>INGOT Model 14</option>
                    </select>
                </p>
                <hr/>
                <p>
                    <label class="jiwp-bold jiwp-onecolumn">Activation Code :</label><br/>
                    <input type="text" class="jiwp-onecolumn" maxlength="16" value="" id="txtDevActivationCode" name="dev_activationcode" />
                </p>
                <hr/>
                <p class="jiwp-aligncenter">
                    <input type="submit" value="Submit" id="btnActivateDevice" name="activatedevice" />
                </p>
            </form>
            <?php
        else:
            echo '<h5 class="jiwp-heading">Sorry, you must first <a href="'.esc_url(site_url('/login-logout/')).'">log in</a> to view this page. You can <a href="'.esc_url(site_url('/register/')).'">register free here</a>.</h5>';
        endif;
        
        return ob_get_clean();
    }
    
    public static function INGOTModel11Form()
    {
        ob_start();
        
        if(is_user_logged_in()):
            ?>
            <h3 class="jiwp-heading jiwp-aligncenter">SmartScope Configuration - Web Interface</h3>
            <form id="jiwp_devicepanel_configform" method="POST" action="">
                <p>
                    <label class="jiwp-bold jiwp-onecolumn">Device current IP Address<br/><i>Ex: 192.xxx.xxx.xxx Or http://yourdomain.com</i></label>
                    <input type="text" class="jiwp-onecolumn" value="" id="txtDevIPAddress" name="dev_ipaddress" />
                </p>
                <hr/>
                <p>
                    <label class="jiwp-bold jiwp-onecolumn">Device new IP Address<br/><i>Ex: 192.xxx.xxx.xxx</i></label><br/>
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtEthIPAddress1" name="eth_ipaddress1" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtEthIPAddress2" name="eth_ipaddress2" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtEthIPAddress3" name="eth_ipaddress3" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtEthIPAddress4" name="eth_ipaddress4" />
                </p>
                <hr/>
                <p>
                    <label class="jiwp-bold jiwp-onecolumn">SmartScope 1 IP Address<br/><i>Ex: 192.xxx.xxx.xxx</i></label><br/>
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtSmartScope1IPAddress1" name="smartscope1_ipaddress1" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtSmartScope1IPAddress2" name="smartscope1_ipaddress2" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtSmartScope1IPAddress3" name="smartscope1_ipaddress3" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtSmartScope1IPAddress4" name="smartscope1_ipaddress4" />
                </p>
                <hr/>
                <p>
                    <label class="jiwp-bold jiwp-onecolumn">SmartScope 2 IP Address<br/><i>Ex: 192.xxx.xxx.xxx</i></label><br/>
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtSmartScope2IPAddress1" name="smartscope2_ipaddress1" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtSmartScope2IPAddress2" name="smartscope2_ipaddress2" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtSmartScope2IPAddress3" name="smartscope2_ipaddress3" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtSmartScope2IPAddress4" name="smartscope2_ipaddress4" />
                </p>
                <hr/>
                <p>
                    <label class="jiwp-bold jiwp-onecolumn">SmartScope 3 IP Address<br/><i>Ex: 192.xxx.xxx.xxx</i></label><br/>
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtSmartScope3IPAddress1" name="smartscope3_ipaddress1" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtSmartScope3IPAddress2" name="smartscope3_ipaddress2" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtSmartScope3IPAddress3" name="smartscope3_ipaddress3" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtSmartScope3IPAddress4" name="smartscope3_ipaddress4" />
                </p>
                <hr/>
                <p>
                    <label class="jiwp-bold jiwp-onecolumn">SmartScope 4 IP Address<br/><i>Ex: 192.xxx.xxx.xxx</i></label><br/>
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtSmartScope4IPAddress1" name="smartscope4_ipaddress1" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtSmartScope4IPAddress2" name="smartscope4_ipaddress2" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtSmartScope4IPAddress3" name="smartscope4_ipaddress3" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtSmartScope4IPAddress4" name="smartscope4_ipaddress4" />
                </p>
                <hr/>
                <p class="jiwp-aligncenter">
                    <input type="submit" value="Submit" id="btnConfigSmartScope" name="configsmartscope" />
                </p>
            </form>
            <?php
        else:
            echo '<h5 class="jiwp-heading">Sorry, you must first <a href="'.esc_url(site_url('/login-logout/')).'">log in</a> to view this page. You can <a href="'.esc_url(site_url('/register/')).'">register free here</a>.</h5>';
        endif;
        
        return ob_get_clean();
    }
    
    public static function INGOTModel12Form()
    {
        ob_start();
        
        if(is_user_logged_in()):
            ?>
            <h3 class="jiwp-heading jiwp-aligncenter">VideoHub Configuration - Web Interface</h3>
            <form id="jiwp_devicepanel_configform" method="POST" action="">
                <p>
                    <label class="jiwp-bold jiwp-onecolumn">Device current IP Address<br/><i>Ex: 192.xxx.xxx.xxx Or http://yourdomain.com</i></label>
                    <input type="text" class="jiwp-onecolumn" value="" id="txtDevIPAddress" name="dev_ipaddress" />
                </p>
                <hr/>
                <p>
                    <label class="jiwp-bold jiwp-onecolumn">Device new IP Address<br/><i>Ex: 192.xxx.xxx.xxx</i></label><br/>
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtEthIPAddress1" name="eth_ipaddress1" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtEthIPAddress2" name="eth_ipaddress2" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtEthIPAddress3" name="eth_ipaddress3" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtEthIPAddress4" name="eth_ipaddress4" />
                </p>
                <hr/>
                <p class="jiwp-aligncenter">
                    <input type="submit" value="Submit" id="btnConfigVideoHub" name="submit" />
                </p>
            </form>
            <?php
        else:
            echo '<h5 class="jiwp-heading">Sorry, you must first <a href="'.esc_url(site_url('/login-logout/')).'">log in</a> to view this page. You can <a href="'.esc_url(site_url('/register/')).'">register free here</a>.</h5>';
        endif;
        
        return ob_get_clean();
    }
    
    public static function INGOTModel13Form()
    {
        ob_start();
        
        if(is_user_logged_in()):
            ?>
            <h3 class="jiwp-heading jiwp-aligncenter">Tally Configuration - Web Interface</h3>
            <form id="jiwp_devicepanel_configform" method="POST" action="">
                <p>
                    <label class="jiwp-bold jiwp-onecolumn">Device current IP Address<br/><i>Ex: 192.xxx.xxx.xxx Or http://yourdomain.com</i></label>
                    <input type="text" class="jiwp-onecolumn" value="" id="txtDevIPAddress" name="dev_ip_address" />
                </p>
                <hr/>
                <p>
                    <label class="jiwp-bold jiwp-onecolumn">Device new IP Address<br/><i>Ex: 192.xxx.xxx.xxx</i></label><br/>
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtEthIPAddress1" name="eth_ip_address1" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtEthIPAddress2" name="eth_ip_address2" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtEthIPAddress3" name="eth_ip_address3" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtEthIPAddress4" name="eth_ip_address4" />
                </p>
                <hr/>
                <p>
                    <label class="jiwp-bold jiwp-onecolumn">ATEM Switcher IP Address<br/><i>Ex: 192.xxx.xxx.xxx</i></label><br/>
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtATEMIPAddress1" name="atem_ip_address1" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtATEMIPAddress2" name="atem_ip_address2" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtATEMIPAddress3" name="atem_ip_address3" /> . 
                    <input type="text" class="jiwp-aligncenter jiwp-fivecolumns" maxlength="3" size="2" value="" id="txtATEMIPAddress4" name="atem_ip_address4" />
                </p>
                <hr/>
                <p class="jiwp-aligncenter">
                    <input type="submit" value="Submit" id="btn4CHTally" name="submit" />
                </p>
            </form>
            <?php
        else:
            echo '<h5 class="jiwp-heading">Sorry, you must first <a href="'.esc_url(site_url('/login-logout/')).'">log in</a> to view this page. You can <a href="'.esc_url(site_url('/register/')).'">register free here</a>.</h5>';
        endif;
        
        return ob_get_clean();
    }
}