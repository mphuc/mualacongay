<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * reCaptcha File Config
 *
 * File     : recaptcha.php
 * Created  : May 14, 2013 | 4:22:40 PM
 * 
 * Author   : Andi Irwandi Langgara <irwandi@ourbluecode.com>
 */

$config['public_key']   = '6Le-egYTAAAAAAPQ_-xT15bjEv3R81-UKfXmduOP';
$config['private_key']  = '6Le-egYTAAAAAOz-c5z0BIqonzKYElnQ_LaZK7qP';

// Set Recaptcha options
// Reference at https://developers.google.com/recaptcha/docs/customization
$config['recaptcha_options']  = array(
    'theme'=>'white', // red/white/blackglass/clean
    'lang' => 'vi' // en/nl/fl/de/pt/ru/es/tr
    //  'custom_translations' - Use this to specify custom translations of reCAPTCHA strings.
    //  'custom_theme_widget' - When using custom theming, this is a div element which contains the widget. See the custom theming section for how to use this.
    //  'tabindex' - Sets a tabindex for the reCAPTCHA text box. If other elements in the form use a tabindex, this should be set so that navigation is easier for the user
);

?>
