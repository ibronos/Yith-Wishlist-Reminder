<?php
/**
 * Yith Wishlist Reminder Plugin
 *
 * @package     Isaidi\YithWishlistReminder
 * @author      isaidi
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Yith Wishlist Reminder
 * Plugin URI:  https://github.com/ibronos/
 * Description: WordPress Yith wishlist email reminder extension.
 * Version:     1.0.0
 * Author:      isaidi
 * Author URI:  https://isaidi.vercel.app
 * Text Domain: yith-wishlist-email-reminder-extension
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


namespace Isaidi\YithWishlistReminder;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function autoload_files() {

	// add the list of files to load here.
	$files = array(
		'admin/helper.php',
		'admin/yith.php'		
	);

	foreach ( $files as $file ) {
		require __DIR__ . '/src/' . $file;
	}
}

function launch() {
	autoload_files();
}

launch();