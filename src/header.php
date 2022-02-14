<!DOCTYPE html>
<html class="h-100" <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">

    <?php wp_head(); ?>
  </head>
  <body class="d-flex flex-column h-100" <?php body_class(); ?>>
    <div class="container">
      <header class="header" role="banner">
        <nav class="navigation d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom" role="navigation">
          <div class="logo d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
            <?php the_custom_logo(); ?>
          </div>

          <?php wp_nav_menu(
            array(
              'theme_location' => 'menu-1',
              'menu_class' => 'main-menu',
              'items_wrap' => '<ul class="%2$s">%3$s</ul>'
            )
          ) ?>
        </nav>

      </header>
