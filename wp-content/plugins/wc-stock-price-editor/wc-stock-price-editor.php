<?php
/**
 * Plugin Name: WooCommerce Stock & Price Editor
 * Description: Bulk edit stock availability and prices for WooCommerce products.
 * Version: 1.0
 * Author: Totto / Keyder C14002
 */

defined('ABSPATH') || exit;

//Admin menu
function wc_stock_price_editor_menu() {
    add_menu_page(
        'Stock & Price Editor',
        'Stock & Price Editor',
        'manage_woocommerce',
        'wc-stock-price-editor',
        'wc_stock_price_editor_page',
        'dashicons-editor-table',
        25
    );
}
add_action('admin_menu', 'wc_stock_price_editor_menu');

//Shows products
function wc_stock_price_editor_page() {
    echo '<div class="wrap"><h1>WooCommerce Stock & Price Editor</h1>';
    echo '<form method="post" action="">';
    
    echo '<table class="wp-list-table widefat fixed">';
    echo '<thead><tr><th>Product</th><th>Price (₡)</th><th>Stock Status</th><th>Update</th></tr></thead>';
    echo '<tbody>';
    
    $args = ['post_type' => 'product', 'posts_per_page' => -1];
    $products = get_posts($args);
    
    foreach ($products as $product) {
        $id = $product->ID;
        $price = get_post_meta($id, '_price', true);
        $stock = get_post_meta($id, '_stock_status', true);
        
        echo "<tr>
            <td>{$product->post_title}</td>
            <td><input type='text' name='price_{$id}' value='{$price}' /></td>
            <td>
                <select name='stock_{$id}'>
                    <option value='instock' " . selected($stock, 'instock', false) . ">In Stock</option>
                    <option value='outofstock' " . selected($stock, 'outofstock', false) . ">Out of Stock</option>
                </select>
            </td>
            <td><input type='checkbox' name='update_{$id}' value='1' /></td>
        </tr>";
    }
    
    echo '</tbody></table>';
    echo '<input type="submit" name="wc_stock_price_update" class="button button-primary" value="Save Changes">';
    echo '</form></div>';
}

//Makes updates
function wc_stock_price_update() {
    if (isset($_POST['wc_stock_price_update'])) {
        $args = ['post_type' => 'product', 'posts_per_page' => -1];
        $products = get_posts($args);
        
        foreach ($products as $product) {
            $id = $product->ID;
            
            if (isset($_POST["update_{$id}"])) {
                if (isset($_POST["price_{$id}"])) {
                    update_post_meta($id, '_price', sanitize_text_field($_POST["price_{$id}"]));
                }
                if (isset($_POST["stock_{$id}"])) {
                    update_post_meta($id, '_stock_status', sanitize_text_field($_POST["stock_{$id}"]));
                }
            }
        }
        echo '<div class="updated"><p>Product updates saved!</p></div>';
    }
}
add_action('admin_init', 'wc_stock_price_update');