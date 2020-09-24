<?php
/**
 * Plugin Name: Bongos Books Lessons
 * Plugin URI: http://www.bongosbooks.com
 * Description: A plugin for managing lessons and characters.
 * Version: 1.0.0
 * Author: Trademark Productions
 * Author URI: http://www.tmprod.com
 * License: Commercial
 */
use BongosBooks\Lessons\Core;

/**
 * If this file is called directly, abort.
 */
if (!defined('WPINC')) {
    die;
}

/**
 * Use an autoloader to load all classes.
 */
require_once __DIR__ . '/autoloader.php';

/**
 * Run the plugin
 *
 * @since 1.0.0
 */
// Instantiate the core and initialize.
$plugin = new Core();
register_activation_hook(__FILE__, array($plugin, 'activate'));
register_deactivation_hook(__FILE__, array($plugin, 'deactivate'));
$plugin->init();