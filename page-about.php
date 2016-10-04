<?php
/* Template Name: About Page
  Custom Template for About page
*/

  get_header();
  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0];
?>


<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
  <header class="hero" style="background-image: url('<?php echo $image; ?>');">
      <div class="container">
          <h1 class="page-title">John Smith</h1>
          <p class="page-description"><?php echo get_the_excerpt(); ?></p>
          <p class="page-description"><?php the_field('top_description_text'); ?></p>
      </div>
  </header>

  <div id="post-container" >

    <?php the_content(); ?>

    <?php endwhile; endif; wp_reset_postdata(); ?>

  </div><!-- end post container -->

<?php
  st_portfolio_carousel();

  get_footer();
?>
