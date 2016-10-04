<?php
    /* Template: Blog (REFLECT) Posts Page
      Home.php refers to blog homepage i.e. a list of blog posts
      Whereas, frontpage is the landing page (just portfolio posts)
    */
    get_header();

    // exlude portfolio posts (just blog posts)
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 4
    );

    $query = new WP_Query( $args );
    $page = get_post('7');
    $thumbnail_url = wp_get_attachment_url( get_post_thumbnail_id($page->ID) );
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

<?php get_footer(); ?>
