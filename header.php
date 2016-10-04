<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <aside class="overlay"></aside>
    <div class="page-wrap">
      <aside class="header-wrap">
        <header class="header-bar">
            <div class="container">
              <div class="search-wrapper">
              <h2 class="main-title"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h2>
              <a class="nav-trigger" href="#"><img src="<?php echo get_template_directory_uri() . '/img/icons/hamburger.png'; ?>" alt="hamburger icon"></a>
              <?php get_template_part('nav');  ?>
              </div>
            </div>
        </header>
    </aside>
