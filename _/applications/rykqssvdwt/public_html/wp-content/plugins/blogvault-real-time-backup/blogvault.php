<?php
/*
Plugin Name: WordPress Backup & Security Plugin - BlogVault
Plugin URI: https://blogvault.net
Description: Easiest way to backup & secure your WordPress site
Author: Backup by BlogVault
Author URI: https://blogvault.net
Version: 5.65
Network: True
 */

/*  Copyright 2017  BlogVault  (email : support@blogvault.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Global response array */

if (!defined('ABSPATH')) exit;
##OLDWPR##

require_once dirname( __FILE__ ) . '/wp_settings.php';
require_once dirname( __FILE__ ) . '/wp_site_info.php';
require_once dirname( __FILE__ ) . '/wp_db.php';
require_once dirname( __FILE__ ) . '/wp_api.php';
require_once dirname( __FILE__ ) . '/wp_actions.php';
require_once dirname( __FILE__ ) . '/info.php';
require_once dirname( __FILE__ ) . '/account.php';
require_once dirname( __FILE__ ) . '/helper.php';
##WPCACHEMODULE##


$bvsettings = new BVWPSettings();
$bvsiteinfo = new BVWPSiteInfo();
$bvdb = new BVWPDb();


$bvapi = new BVWPAPI($bvsettings);
$bvinfo = new BVInfo($bvsettings);
$wp_action = new BVWPAction($bvsettings, $bvsiteinfo, $bvapi);

register_uninstall_hook(__FILE__, array('BVWPAction', 'uninstall'));
register_activation_hook(__FILE__, array($wp_action, 'activate'));
register_deactivation_hook(__FILE__, array($wp_action, 'deactivate'));

add_action('wp_footer', array($wp_action, 'footerHandler'), 100);
add_action('clear_bv_services_config', array($wp_action, 'clear_bv_services_config'));
##SOADDUNINSTALLACTION##

##DISABLE_OTHER_OPTIMIZATION_PLUGINS##

##WPCLIMODULE##
if (is_admin()) {
	require_once dirname( __FILE__ ) . '/wp_admin.php';
	$wpadmin = new BVWPAdmin($bvsettings, $bvsiteinfo);
	add_action('admin_init', array($wpadmin, 'initHandler'));
	add_filter('all_plugins', array($wpadmin, 'initWhitelabel'));
	add_filter('plugin_row_meta', array($wpadmin, 'hidePluginDetails'), 10, 2);
	add_filter('debug_information', array($wpadmin, 'handlePluginHealthInfo'), 10, 1);
	if ($bvsiteinfo->isMultisite()) {
		add_action('network_admin_menu', array($wpadmin, 'menu'));
	} else {
		add_action('admin_menu', array($wpadmin, 'menu'));
	}
	add_filter('plugin_action_links', array($wpadmin, 'settingsLink'), 10, 2);
	add_action('admin_head', array($wpadmin, 'removeAdminNotices'), 3);
	add_action('admin_notices', array($wpadmin, 'activateWarning'));
	add_action('admin_enqueue_scripts', array($wpadmin, 'bvsecAdminMenu'));
	##ALPURGECACHEFUNCTION##
	##ALADMINMENU##
}

if ((array_key_exists('bvreqmerge', $_POST)) || (array_key_exists('bvreqmerge', $_GET))) {
	$_REQUEST = array_merge($_GET, $_POST);
}

require_once dirname( __FILE__ ) . '/php_error_monitoring/monitoring.php';
BVWPPHPErrorMonitoring::init();

if ($bvinfo->hasValidDBVersion()) {
	if ($bvinfo->isServiceActive('activity_log')) {
		require_once dirname( __FILE__ ) . '/wp_actlog.php';
		$bvconfig = $bvinfo->config;
		$actlog = new BVWPActLog($bvdb, $bvsettings, $bvinfo, $bvconfig['activity_log']);
		$actlog->init();
	}

	if ($bvinfo->isServiceActive('maintenance_mode')) {
		require_once dirname( __FILE__ ). '/maintenance/wp_maintenance.php';
		$bvconfig = $bvinfo->config;
		$maintenance = new BVWPMaintenance($bvconfig['maintenance_mode']);
		$maintenance->init();
	}

}

if ((array_key_exists('bvplugname', $_REQUEST)) && ($_REQUEST['bvplugname'] == "bvbackup")) {
	require_once dirname( __FILE__ ) . '/callback/base.php';
	require_once dirname( __FILE__ ) . '/callback/response.php';
	require_once dirname( __FILE__ ) . '/callback/request.php';
	require_once dirname( __FILE__ ) . '/recover.php';

	$pubkey = BVAccount::sanitizeKey($_REQUEST['pubkey']);

	if (array_key_exists('rcvracc', $_REQUEST)) {
		$account = BVRecover::find($bvsettings, $pubkey);
	} else {
		$account = BVAccount::find($bvsettings, $pubkey);
	}

	$request = new BVCallbackRequest($account, $_REQUEST, $bvsettings);
	$response = new BVCallbackResponse($request->bvb64cksize);

	if ($request->authenticate() === 1) {
		if (array_key_exists('bv_ignr_frm_cptch', $_REQUEST)) {
			#handling of Contact Forms 7
			add_filter('wpcf7_skip_spam_check', '__return_true', PHP_INT_MAX, 2);

			#handling of Formidable plugin
			add_filter('frm_is_field_hidden', '__return_true', PHP_INT_MAX, 3);

			#handling of WP Forms plugin
			add_filter('wpforms_process_bypass_captcha', '__return_true', PHP_INT_MAX, 3);

			#handling of Forminator plugin
			if (defined('WP_PLUGIN_DIR')) {
				$abstractFrontActionFilePath = WP_PLUGIN_DIR . '/forminator/library/abstracts/abstract-class-front-action.php';
				$frontActionFilePath = WP_PLUGIN_DIR . '/forminator/library/modules/custom-forms/front/front-action.php';

				if (file_exists($abstractFrontActionFilePath) && file_exists($frontActionFilePath)) {
					require_once $abstractFrontActionFilePath;
					require_once $frontActionFilePath;
					if (class_exists('Forminator_CForm_Front_Action')) {
						Forminator_CForm_Front_Action::$hidden_fields[] = "bv-stripe-";
					}
				}
			}

			#handling of CleanTalk Antispam plugin
			add_action('init', function() {
				global $apbct;
				if (isset($apbct) && is_object($apbct)) {
					$apbct->settings['forms__contact_forms_test'] = 0;
				}
			});
		} else {
			define('BVBASEPATH', plugin_dir_path(__FILE__));


			require_once dirname( __FILE__ ) . '/callback/handler.php';

			$params = $request->processParams($_REQUEST);
			if ($params === false) {
				$response->terminate($request->corruptedParamsResp());
			}
			$request->params = $params;
			$callback_handler = new BVCallbackHandler($bvdb, $bvsettings, $bvsiteinfo, $request, $account, $response);
			if ($request->is_afterload) {
				add_action('wp_loaded', array($callback_handler, 'execute'));
			} else if ($request->is_admin_ajax) {
				add_action('wp_ajax_bvadm', array($callback_handler, 'bvAdmExecuteWithUser'));
				add_action('wp_ajax_nopriv_bvadm', array($callback_handler, 'bvAdmExecuteWithoutUser'));
			} else {
				$callback_handler->execute();
			}
		}
	} else {
		$response->terminate($request->authFailedResp());
	}
} else {
	if ($bvinfo->hasValidDBVersion()) {
		if ($bvinfo->isProtectModuleEnabled()) {
			require_once dirname( __FILE__ ) . '/protect/protect.php';
			add_action('clear_pt_config', array('BVProtect_V565', 'uninstall'));
			if ($bvinfo->isActivePlugin()) {
				BVProtect_V565::init(BVProtect_V565::MODE_WP);
			}
		}

		if ($bvinfo->isDynSyncModuleEnabled()) {
		require_once dirname( __FILE__ ) . '/wp_dynsync.php';
		$bvconfig = $bvinfo->config;
		$dynsync = new BVWPDynSync($bvdb, $bvsettings, $bvconfig['dynsync']);
		$dynsync->init();
	}

	}
	$bv_site_settings = $bvsettings->getOption('bv_site_settings');
	if (isset($bv_site_settings)) {
		if (isset($bv_site_settings['wp_auto_updates'])) {
			$wp_auto_updates = $bv_site_settings['wp_auto_updates'];
			if (array_key_exists('block_auto_update_core', $wp_auto_updates)) {
				add_filter('auto_update_core', '__return_false' );
			}
			if (array_key_exists('block_auto_update_theme', $wp_auto_updates)) {
				add_filter('auto_update_theme', '__return_false' );
				add_filter('themes_auto_update_enabled', '__return_false' );
			}
			if (array_key_exists('block_auto_update_plugin', $wp_auto_updates)) {
				add_filter('auto_update_plugin', '__return_false' );
				add_filter('plugins_auto_update_enabled', '__return_false' );
			}
			if (array_key_exists('block_auto_update_translation', $wp_auto_updates)) {
				add_filter('auto_update_translation', '__return_false' );
			}
		}
	}

	if (is_admin()) {
		add_filter('site_transient_update_plugins', array($wpadmin, 'hidePluginUpdate'));
	}

	##THIRDPARTYCACHINGMODULE##
}