<?php
/**
 * Created by PhpStorm.
 * User: hizbul
 * Date: 2/14/15
 * Time: 6:26 PM
 */



class LNM {
	public function __construct() {
		add_action('wp_enqueue_scripts', array($this, 'lnm_register_script_style'));
	}

	public function init() {
		require_once LNM_PLUGIN_PATH.'/view/lnm-front.php';
		if(is_admin()) {
			require_once LNM_PLUGIN_PATH.'/admin/lnm-admin.php';
		}
	}


	public function lnm_register_script_style() {
		wp_enqueue_script('jquery');
		wp_enqueue_script('lnm-js', LNM_PLUGIN_URL.'assets/js/lnm-js.js', array('jquery'));
		wp_enqueue_script('lnm-news-ticker', LNM_PLUGIN_URL.'assets/js/jquery.newsTicker.min.js', array('jquery'));
		wp_enqueue_style('lnm-style', LNM_PLUGIN_URL.'assets/css/lnm-style.css');
	}

	public static function lnm_plugin_install() {

	}

	public static function lnm_plugin_uninstall() {

	}
}

//$obj_lnm = new LNM();
