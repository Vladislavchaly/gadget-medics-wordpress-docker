<?php
	/**
	 * Plugin Name: Webcraftic Hide login page
	 * Plugin URI: https://wordpress.org/plugins/hide-login-page/
	 * Description: Hide wp-login.php login page and close wp-admin access to avoid hacker attacks and brute force.
	 * Author: Webcraftic <wordpress.webraftic@gmail.com>
	 * Version: 1.0.8
	 * Text Domain: hide-login-page
	 * Domain Path: /languages/
	 * Author URI: http://clearfy.pro
	 */
	
	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	define('WHLP_PLUGIN_VERSION', '1.0.8');
	
	define('WHLP_PLUGIN_DIR', dirname(__FILE__));
	define('WHLP_PLUGIN_BASE', plugin_basename(__FILE__));
	define('WHLP_PLUGIN_URL', plugins_url(null, __FILE__));

	// Fix for ithemes sync. When the ithemes sync plugin accepts the request, set the WP_ADMIN constant,
	// after which the plugin Clearfy begins to create errors, and how the logic of its work is broken.
	// Solution to simply terminate the plugin if there is a request from ithemes sync
	// --------------------------------------
	if( defined('DOING_AJAX') && DOING_AJAX && isset($_REQUEST['action']) && $_REQUEST['action'] == 'ithemes_sync_request' ) {
		return;
	}

	if( isset($_GET['ithemes-sync-request']) && !empty($_GET['ithemes-sync-request']) ) {
		return;
	}
	// ----------------------------------------
	
	
	
	if( !defined('LOADING_HIDE_LOGIN_PAGE_AS_ADDON') ) {
		require_once(WHLP_PLUGIN_DIR . '/libs/factory/core/includes/check-compatibility.php');
		require_once(WHLP_PLUGIN_DIR . '/libs/factory/clearfy/includes/check-clearfy-compatibility.php');
	}
	
	$plugin_info = array(
		'prefix' => 'wbcr_hlp_',
		'plugin_name' => 'wbcr_hide_login_page',
		'plugin_title' => __('Webcraftic Hide login page', 'hide-login-page'),
		'plugin_version' => WHLP_PLUGIN_VERSION,
		'plugin_build' => 'free',
		//'updates' => WHLP_PLUGIN_DIR . '/updates/'
	);
	
	/**
	 * Проверяет совместимость с Wordpress, php и другими плагинами.
	 */
	$compatibility = new Wbcr_FactoryClearfy_Compatibility(array_merge($plugin_info, array(
		'plugin_already_activate' => defined('WHLP_PLUGIN_ACTIVE'),
		'plugin_as_component' => defined('LOADING_HIDE_LOGIN_PAGE_AS_ADDON'),
		'plugin_dir' => WHLP_PLUGIN_DIR,
		'plugin_base' => WHLP_PLUGIN_BASE,
		'plugin_url' => WHLP_PLUGIN_URL,
		'required_php_version' => '5.3',
		'required_wp_version' => '4.2.0'
	)));
	
	/**
	 * Если плагин совместим, то он продолжит свою работу, иначе будет остановлен,
	 * а пользователь получит предупреждение.
	 */
	if( !$compatibility->check() ) {
		return;
	}
	
	define('WHLP_PLUGIN_ACTIVE', true);
	
	if( !defined('LOADING_HIDE_LOGIN_PAGE_AS_ADDON') ) {
		require_once(WHLP_PLUGIN_DIR . '/libs/factory/core/boot.php');
	}
	
	require_once(WHLP_PLUGIN_DIR . '/includes/class.plugin.php');
	
	if( !defined('LOADING_HIDE_LOGIN_PAGE_AS_ADDON') ) {
		
		new WHLP_Plugin(__FILE__, $plugin_info);
	}
