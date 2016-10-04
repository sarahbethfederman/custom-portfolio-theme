<?php
    /* Template for portfolio posts (case studies) */
    get_header();
?>


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php
  $thumbnail_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
  $color = get_field('post_color');
  $title_color = get_field('title_color');

  function background($prefix) {
    global $color;  // refer to color variable we already created
    return "background: " . $prefix . "linear-gradient(to bottom, " . adjustBrightness($color, -90) . " 0%, " . $color . " 100%); ";
  }
?>

<header class="hero" style="<?php echo background('-webkit-'); echo background('-o-'); echo background('-ms-'); echo background(''); ?>">
    <div class="container">
        <h1 class="page-title <?php the_field('dark_or_light'); ?>"<?php if($title_color) { echo ' style="color: '. $title_color . '"'; } ?>>
          <?php the_title(); ?>
        </h1>
        <p class="page-description <?php the_field('dark_or_light'); ?>"<?php if($title_color) { echo ' style="color: '. $title_color . '"'; } ?>><?php the_field('description'); ?></p>
        <?php
          if ( !post_password_required() ) {
            echo '<img class="page-thumbnail" alt="header image" src="' . get_field('head_image') . '">';
          }
        ?>
    </div>
</header>


<?php the_content(); ?>

<?php endwhile; endif; ?>

<?php st_portfolio_carousel(); ?>

<?php get_footer(); ?>
