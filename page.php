<?php
    /* Template: Page
      Displayed for pages
    */

    get_header();
?>
  <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
    <header class="hero">
        <div class="container">
            <h1 class="page-title"><?php the_title(); ?></h1>
            <p class="page-description"><?php the_excerpt(); ?></p>
            <?php
              if ( has_post_thumbnail() ) {
              	the_post_thumbnail();
              } 
            ?>
        </div>
    </header>

    <div id="post-container" class="container">

      <?php the_content(); ?>

      <?php endwhile; endif; wp_reset_postdata(); ?>

    </div><!-- end post container -->

<?php get_footer(); ?>
