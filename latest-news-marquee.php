<?php
/*
Plugin Name: Latest News Marquee
Plugin URI:  http://hizbul.com/latest-news-marquee/
Description: Plugin for displaying latest news from two famous Bangladeshi news paper Daily Prothom Alo, Daily Star. This plugin is really very easy to use in any blog or website
				for showing latest news. Just using shortcode this feature can be implemented and can be changed look and feel from admin settings.
Version: 1.0
Author: Hizbul Bahar
Author URI: http://hizbul.com/about
License: License: GPLv2 or later
*/


if(!function_exists('add_action')) {
	echo 'Hi there!!, i am just a plugin, not much i can do when you call directly';
	exit;
}

define('LNM_PLUGIN_NAME','Latest News Marquee');
define('LNM_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('LNM_PLUGIN_URL', plugin_dir_url(__FILE__));
define('LNM_SITE_BASE_URL', get_bloginfo('url'));

require_once LNM_PLUGIN_PATH.'/inc/lnm.php';
$lnm = new LNM();
$lnm->init();

register_activation_hook(__FILE__, array('LNM', 'lnm_plugin_install'));
register_deactivation_hook(__FILE__, array('LNM', 'lnm_plugin_uninstall'));