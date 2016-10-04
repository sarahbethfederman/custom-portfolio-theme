<?php
    // Show 4 posts on the first page or all of them on archive page
    $num_posts = ( is_front_page() ) ? 7 : -1;

    // Only display portfolio posts
    $args = array(
        'post_type' => 'portfolio',
        'posts_per_page' => $num_posts
    );

    $query = new WP_Query( $args );
    $count = 0; // post counter
?>

<?php if( $query->have_posts() ) : while( $query->have_posts() ) : $query->the_post(); ?>

    <?php // featured image
      $gradient = get_field('background_gradient');
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
      $post_obj = get_post(get_the_ID());
      $post_name = $post_obj->post_name;
      $large = get_field('background_size');

      if ($image) : ?>
        <section data-url="<?php the_permalink(); ?>" class="portfolio-slide <?php the_field('dark_or_light'); ?> <?php the_field('background_offset');  echo " " . $post_name; ?><?php if ($large) echo ' xlarge'; ?>" style="background-image: url('<?php echo $image[0]; ?>')<?php if ($gradient) {
            echo ", ";
            echo $gradient;
          } ?>; background-color: <?php the_field('background_color')?>;">
      <?php endif; ?>


        <div class="portfolio-slide__content">
            <h2 class="portfolio-slide__title"><?php the_title(); ?></h2>
            <p class="portfolio-slide__description"><?php the_field('description'); ?></p>
            <a class="portfolio-slide__link" href="<?php the_permalink(); ?>">
              <?php if (get_field('dark_or_light') == "light") : ?>
                <img class="arrow-right" alt="go to project" src="wp-content/themes/portfolio-theme/img/icons/arrow-light.png">
              <?php else: ?>
                <img class="arrow-right" alt="go to project" src="wp-content/themes/portfolio-theme/img/icons/arrow-dark.png">
              <?php endif; ?>
            </a>
        </div>
    </section>

<?php endwhile; endif; wp_reset_postdata(); ?>
