<?php
    /* Template: Search Results Posts Page */
    get_header();

    $post_num = $wp_query->found_posts;
    $args = array(
          's'=> $s,
          'posts_per_page' => -1
        );
    $query = new WP_Query($args);

    if ($post_num == 1) {
      $result = "result";
    } else {
      $result = "results";
    }
?>
    <header class="hero">
        <div class="container">
            <h1 class="page-title">Search Results</h1>
            <p class="page-description">
              We found <?= $post_num . " " . $result; ?> for...<br>
              <em>"<strong><?php echo get_search_query(); ?></strong>"</em>
            </p>
            <hr>
        </div>
    </header>

      <div id="post-container" class="container">

        <?php if( $query->have_posts() ) : while( $query->have_posts() ) : $query->the_post(); ?>

          <?php get_template_part('content', 'search'); ?>

        <?php endwhile; else: ?>

          <p class="no-results"><em><?php _e('Sorry, no posts matched your Search criteria.'); ?></em></p>

        <?php endif; wp_reset_postdata(); ?>


      </div><!-- end post container -->


<?php get_footer(); ?>
