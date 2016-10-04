<?php
  // Archive results content template

  $date = mysql2date('M j', $post->post_date); // format the date
?>
<article class="list">
  <h3 class="list__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
  <div class="list__info">
    <span class="list__info__left"><?php echo $date; ?></span>
    <span class="list__info__right"><?php echo st_estimated_reading_time(); ?></span>
  </div>
</article>
