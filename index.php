<?php
  // Default template
  // This is the most generic template file in a WordPress theme
  // It is used to display a page when nothing more specific matches a query

  get_header();
?>

<header class="hero">
    <div class="container">
        <h1 class="page-title"><?php echo single_post_title(); ?></h1>
        <p class="page-description"><?php echo $page->post_excerpt; ?></p>
        <img class="page-thumbnail" src="<?php echo $thumbnail_url; ?>">
    </div>
</header>

  <div id="post-container" class="container">

    <?php if( $query->have_posts() ) : while( $query->have_posts() ) : $query->the_post(); ?>

      <?php get_template_part('content'); ?>

    <?php endwhile; endif; wp_reset_postdata(); ?>

  </div><!-- end post container -->

<?php
  get_footer();
?>
