<?php
/**
 * Plugin Name: PC Component Elementor Widget
 * Description: Adds a custom widget for displaying PC components.
 * Version: 1.0
 * Author: Totto / Keyder C14002
 */

defined('ABSPATH') || exit;

//Loads and register widgets with Elementor
function register_pc_component_elementor() {
    require_once(__DIR__ . '/widget-pc-component.php');
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \PC_Component_Widget());
}

add_action('elementor/widgets/register', 'register_pc_component_elementor');