<?php
/**
 * Plugin Name: wp-mintfit
 * Plugin URI: https://gitlab.rlp.net/jdillenberger/wp-mintfit
 * Description: MintFIT Integration for WordPress
 * Version:  1.0
 * Author:  Jan Dillenberger
 * License:  GPLv2
*/

defined('ABSPATH') or die();
define('MF_PLUGIN_INDEX', __FILE__);

ini_set('display_errors', '1');
error_reporting(E_ALL);

# HOOKS
include plugin_dir_path(MF_PLUGIN_INDEX) . 'hooks/activation.php';
include plugin_dir_path(MF_PLUGIN_INDEX) . 'hooks/admin-change-options.php';
include plugin_dir_path(MF_PLUGIN_INDEX) . 'hooks/admin-menu.php';
include plugin_dir_path(MF_PLUGIN_INDEX) . 'hooks/api-update.php';
include plugin_dir_path(MF_PLUGIN_INDEX) . 'hooks/rest-delete-entry.php';
include plugin_dir_path(MF_PLUGIN_INDEX) . 'hooks/rest-endpoints.php';
include plugin_dir_path(MF_PLUGIN_INDEX) . 'hooks/rest-get-options.php';
include plugin_dir_path(MF_PLUGIN_INDEX) . 'hooks/rest-get-test.php';
include plugin_dir_path(MF_PLUGIN_INDEX) . 'hooks/rest-post-options.php';
include plugin_dir_path(MF_PLUGIN_INDEX) . 'hooks/rest-put-api-update.php';






# SCHEDULE HOOKS
#include plugin_dir_path(MF_PLUGIN_INDEX) . 'cron.php';


