<?php
    /* Template: Single Post Page
      Displayed for blog posts
    */
    get_header();
    $thumbnail_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
?>
  <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

    <?php
      $color = get_field('post_color');
      $title_color = get_field('title_color');
      $header_image = get_field('head_image');

      function background($prefix) {
        global $color;  // refer to color variable we already created
        $color1 = adjustBrightness($color, -50);
        $color2 = $color;
        $color3 = adjustBrightness($color, -20);
        $color4 = adjustBrightness($color, 50);

        return "background: " . $prefix . "linear-gradient(to bottom, " . $color1 . " 0%, " . $color2 . " 77%," . $color3 . ' 77%,' . $color4 . " 100%); ";
      }
    ?>

    <header class="hero" style="<?php echo background('-webkit-'); echo background('-o-'); echo background('-ms-'); echo background(''); ?>">
        <div class="container">
            <h1 class="page-title light"<?php if($title_color) { echo ' style="color: '. $title_color . '"'; } ?>><?php the_title(); ?></h1>
            <p class="page-description light"<?php if($title_color) { echo ' style="color: '. $title_color . '"'; } ?>><?php echo get_the_excerpt(); ?></p>
            <p class="page-readtime"<?php if($title_color) { echo ' style="color: '. adjustBrightness($title_color, -70) . '"'; } ?>><?php echo st_estimated_reading_time(); ?></p>
            <img class="page-thumbnail" src="<?php if ($header_image) { echo $header_image; } else { echo $thumbnail_url; } ?>">
        </div>
    </header>

      <div id="post-container">

          <?php the_content(); ?>

      </div><!-- end post container -->

      <div class="post-footer">
        <div class="container">
          <hr>

          <?php
            $author = get_the_author_meta('user_email');
            echo get_avatar( $author, 250);
          ?>

          <h4>By</h4>
          <span class="author"><?php the_author(); ?></span><br>
          <span class="date"><?php the_date(); ?></span>


          <?php
            if (get_the_tag_list()) {
              echo '<hr><div class="post-tags">';
              echo '<h4>Sections</h4>';
              echo get_the_tag_list( null, '<span>, </span>' );
              echo '</div>';
            }
          ?>

        </div>
        <div class="next-article">
          <div class="container">

            <h4 class="next-article__header">Next article</h3>

            <?php

              $next = false;
              if ($next_post = get_previous_post()) {
                $next = true;
              } else {
                $next_post = get_next_post();
              }

              echo '<h3 class="next-article__title">'. $next_post->post_title . '</h3>';
              echo '<p class="next-article__description">'. $next_post->post_excerpt. '</p>';

              if (!$next) {
                next_post_link('%link', 'READ STORY');
              } else {
                previous_post_link('%link', 'READ STORY');
              }
            ?>

          </div>
        </div>
      </div>

      <?php endwhile; endif; wp_reset_postdata(); ?>
      <?php st_portfolio_carousel(); ?>

<?php get_footer(); ?>
