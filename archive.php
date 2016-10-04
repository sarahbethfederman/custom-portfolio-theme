<?php
    /* Template Name: Archive Page Custom */
    // For tags

    get_header();
    $post_num = $wp_query->found_posts;

    if ($post_num == 1) {
      $result = "result";
    } else {
      $result = "results";
    }
?>

    <header class="hero">
      <?php if ( have_posts() ) : ?>

        <div class="container">
            <?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
            <p class="page-description">
              We found <?php echo $post_num . " " . $result; ?>...
            </p>
            <hr>
        </div>
    </header>

      <div id="post-container" class="container">

        <?php	while ( have_posts() ) : the_post(); ?>

          <?php get_template_part('content', 'archive'); ?>

        <?php endwhile; endif; wp_reset_postdata(); ?>

      </div><!-- end post container -->

<?php get_footer(); ?>
