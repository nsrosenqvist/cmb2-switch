<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*
Plugin Name: CMB2 Switch
Description: A switch field type for CMB2
Version: 1.0.0
Author: Niklas Rosenqvist
Author URI: https://www.nsrosenqvist.com/
*/

if (! class_exists('CMB2_Switch')) {
    class CMB2_Switch
    {
        static function init()
        {
            if (! class_exists('CMB2')) {
                return;
            }

            // Include files
            require_once __DIR__.'/src/helpers.php';
            require_once __DIR__ .'/src/Integration.php';

            // Initalize plugin
            \NSRosenqvist\CMB2\SwitchField\Integration::init();
        }
    }
}
add_action('init', [CMB2_Switch::class, 'init']);
