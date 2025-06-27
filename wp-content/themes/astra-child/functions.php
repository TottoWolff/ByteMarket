<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'astra-theme-css','woocommerce-layout','woocommerce-smallscreen','woocommerce-general' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

// END ENQUEUE PARENT ACTION

function byte_custom_header() {
  ?>
  <header class="byt-header">
    <div class="byt-header-inner">
<div class="byt-logo">
  <a href="<?php echo home_url(); ?>">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/ByteMarket.png" alt="ByteMarket logo">
  </a>
</div>
      <nav class="byt-nav">
        <?php wp_nav_menu(['theme_location' => 'header']); ?>
      </nav>
      <div class="byt-landing-overlay"></div>
    </div>
  </header>
  <?php
}
add_action( 'astra_header_before', 'byte_custom_header' );

function byte_custom_footer() {
  ?>
<footer class="byt-footer">
  <div class="byt-footer-top">
    <div class="byt-footer-inner">
      <div class="byt-footer-logo">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/ByteMarket.png" alt="ByteMarket logo">
      </div>
      <nav class="footer-menu">
        <?php wp_nav_menu(['theme_location' => 'footer']); ?>
      </nav>
    </div>
  </div>
<div class="byt-footer-bottom">
  <p>Copyright © 2025 ByteMarket.</p>
</div>
</footer>
  <?php
}
add_action( 'astra_footer_content_bottom', 'byte_custom_footer' );

register_nav_menus([
'header'  => 'Menu Principal',
'footer'  => 'Menu Footer'
]);

add_action( 'init', 'byte_disable_astra_header' );
function byte_disable_astra_header() {
  remove_action( 'astra_header', 'astra_header_markup' );
}

add_filter( 'astra_get_content_layout', 'byte_set_layout_for_landing', 20 );
function byte_set_layout_for_landing( $layout ) {
  if ( is_page_template( 'page-landing.php' ) ) {
    return 'full-width';
  }
  return $layout;
}

add_shortcode( 'product_cat_dropdown_ajax', function() {
  ob_start();
  ?>
  <select id="product-cat-dropdown">
    <option value="">Todos los productos</option>
    <?php
$terms = get_terms([
  'taxonomy' => 'product_cat',
  'hide_empty' => false,
  'exclude' => [ get_option( 'default_product_cat' ) ],
]);
    foreach ( $terms as $term ) {
      echo "<option value='{$term->slug}'>{$term->name}</option>";
    }
    ?>
  </select>
  <div id="catalog-results"></div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const dropdown = document.getElementById('product-cat-dropdown');
      const results = document.getElementById('catalog-results');

      dropdown.addEventListener('change', function () {
        const slug = this.value;
        results.innerHTML = '<p>Cargando productos...</p>';

        fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=load_products_by_cat&slug=' + slug)
          .then(res => res.text())
          .then(html => {
            results.innerHTML = html;
          });
      });
    });
  </script>
  <?php
  return ob_get_clean();
});

add_action('wp_ajax_load_products_by_cat', 'bytemarket_load_products_by_cat');
add_action('wp_ajax_nopriv_load_products_by_cat', 'bytemarket_load_products_by_cat');

function bytemarket_load_products_by_cat() {
  $slug = sanitize_text_field($_GET['slug']);
  $args = [
    'post_type' => 'product',
    'posts_per_page' => 12,
    'tax_query' => [[
      'taxonomy' => 'product_cat',
      'field'    => 'slug',
      'terms'    => $slug,
    ]],
  ];
  $query = new WP_Query($args);

  if ( $query->have_posts() ) {
    // ➜ Add default Woo wrapper
    echo '<div class="woocommerce"><ul class="products columns-4">';
    while ( $query->have_posts() ) {
      $query->the_post();
      wc_get_template_part( 'content', 'product' );
    }
    echo '</ul></div>';
  } else {
    echo '<p>No hay productos en esta categoría.</p>';
  }

  wp_die();
}