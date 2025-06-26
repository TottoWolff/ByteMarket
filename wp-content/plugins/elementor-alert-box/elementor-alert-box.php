<?php
/**
 * Plugin Name: Elementor Alert Box
 * Description: Adds a customizable alert box widget to Elementor.
 * Version: 1.0
 * Author: Totto / Keyder C14002
 */

defined('ABSPATH') || exit;

//Registers alert box
function register_alert_box_widget($widgets_manager) {
    require_once(__DIR__ . '/widget-alert-box.php');
    $widgets_manager->register(new \Alert_Box_Widget());
}

add_action('elementor/widgets/register', 'register_alert_box_widget');

//Load styles
function alert_box_enqueue_assets() {
    wp_enqueue_style('alert-box-css', plugin_dir_url(__FILE__) . 'style.css');
}
add_action('wp_enqueue_scripts', 'alert_box_enqueue_assets');