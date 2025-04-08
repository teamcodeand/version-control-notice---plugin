<?php
/**
 * Register WordPress hooks for Version Control Notice.
 *
 * @package Codeand\VersionControlNotice
 */

namespace Codeand\VersionControlNotice;

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/screens/plugins-install.php';

/**
 * Hook into WordPress actions.
 */
add_action( 'admin_menu', __NAMESPACE__ . '\\Screens\\register_fake_plugins_page' );
add_action( 'current_screen', __NAMESPACE__ . '\\Screens\\enqueue_admin_assets' );
add_action( 'admin_page_access_denied', __NAMESPACE__ . '\\Screens\\block_plugin_access' );
