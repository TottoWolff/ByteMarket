<?php
get_header();
?>

<div id="primary" class="content-area">
  <main id="main" class="site-main" role="main">

    <section class="hero-banner" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/Landing.png');">
      <div class="hero-text">
        <h1>Bienvenido a<br>ByteMarket</h1>
        <p>Explora nuestro catálogo y saca lo mejor de<br>tus computadoras con la última tecnología</p>
      </div>
    </section>

<section class="features-bar">
  <div class="feature">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/Security.png" alt="Transacciones seguras" />
    <p>Transacciones seguras</p>
  </div>
  <div class="feature">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/Truck.png" alt="Envío rápido" />
    <p>Envío rápido</p>
  </div>
  <div class="feature">
    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/Support.png" alt="Soporte técnico real" />
    <p>Soporte técnico real</p>
  </div>
</section>

<section class="catalog-section">
  <h2>Catálogo</h2>
  <p>¿Listo para potenciar tu setup?</p>
  <a href="/catalogo" class="catalog-button">Ir al catálogo</a>
</section>
  </main>
</div>

<?php get_footer(); ?>