<?php
/*
Plugin Name: Style Studio
Plugin URI: https://github.com/mojtabafallah/style-studio
Description: برای ارتباط بین برنامه حسابداری آرتیسا و وردپرس
Version: 1.0.0
Author: Mojtaba Fallah
Author URI: https://github.com/mojtabafallah
Text Domain: stylestudio
*/

if (!defined('ABSPATH')) {
    die;
}
/**
 *Load files required
 */
require_once ("constants.php");

if (file_exists(MJT_PLUGIN_DIR . '/vendor/autoload.php')) {
    require_once MJT_PLUGIN_DIR . '/vendor/autoload.php';
}

require_once ("init.php");

/**
 * load all file rou=te apis
 */
require MJT_PLUGIN_DIR . "route/User.php";
require MJT_PLUGIN_DIR . "route/Customer.php";
require MJT_PLUGIN_DIR . "route/Init.php";


add_filter("jwt_auth_expire", function ($expire) {
    $expire = time() + 31622400;
    return $expire;
});