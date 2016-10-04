<?php
  // This is how each post is displayed
  // It's called from the loop

  // Grab and format the date
  $date = mysql2date('M j', $post->post_date);
  $chunks = explode(' ', $date);

  $month = $chunks[0];
  $day = $chunks[1];
?>

<article class="card">
    <aside class="card__flag">
      <span class="month"><?php echo $month; ?></span>
        <hr>
      <span class="date"><?php echo $day; ?></span>
    </aside>
    <div class="card__image">
      <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full') ?></a>
    </div>
    <div class="card__content">
      <?php
        $thetitle = $post->post_title; /* or you can use get_the_title() */
        $getlength = strlen($thetitle);
        $thelength = 43;
      ?>
      <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php echo substr($thetitle, 0, $thelength); if ($getlength > $thelength) echo "..."; ?></a></h2>
      <p><?php the_excerpt(); ?></p>
    </div>
</article>
