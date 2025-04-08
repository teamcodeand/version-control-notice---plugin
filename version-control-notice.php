<?php
/**
 * Plugin Name: Version Control Notice
 * Description: Shows a client friendly explainer as to why installing or updating plugins is disabled.
 * Version:     1.2.0
 * Author:      Code&
 * Author URI:  https://codeand.com.au
 * Text Domain: version-control-notice
 * License:     MIT License
 */

defined( 'ABSPATH' ) || exit;

// Load all plugin logic.
require_once __DIR__ . '/includes/hooks.php';
