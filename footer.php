
  </div><!-- end page wrap -->

    <footer class="footer">
        <div class="container">
            <?php
                $defaults = array(
                    'theme_location'  => 'footer_menu',
                    'menu'            => '',
                    'container'       => 'false',
                    'container_class' => '',
                    'container_id'    => '',
                    'menu_class'      => 'social',
                    'menu_id'         => '',
                    'echo'            => true,
                    'fallback_cb'     => 'wp_page_menu',
                    'before'          => '',
                    'after'           => '',
                    'link_before'     => '',
                    'link_after'      => '',
                    'items_wrap'      => '<ul class="social">%3$s</ul>',
                    'depth'           => 0,
                    'walker'          => ''
                );
                wp_nav_menu($defaults);
            ?>
            <p>&copy; <?php echo date('Y'); ?> JohnSmith.com &nbsp;&nbsp; All rights reserved.</p>
        </div>
    </footer>

<?php wp_footer(); ?>
</body>
</html>
