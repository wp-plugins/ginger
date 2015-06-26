<?php
/*
Plugin Name: Ginger - EU Cookie Law
Plugin URI: http://manafactory.it/
Description: Make your website compliant with EU Cookie Policy.
Version: 1.1.6
Author: Manafactory
Author URI: http://manafactory.it/
License: GPLv2 or later
Text Domain: ginger
*/

if ( !defined('ABSPATH')) exit;

load_plugin_textdomain( 'ginger', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

//Gestione Backend
if(is_admin()){
    require_once("admin/ginger.utils.php");
    require_once("admin/ginger.pointer.php");
}
//Gestione Frontend
if(!is_admin()){
    require_once("front/gingerfront.utils.php");
}

register_activation_hook( __FILE__, 'ginger_plugin_activate' );

