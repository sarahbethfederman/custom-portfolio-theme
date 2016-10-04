<?php 
    // Grab the main navigation menu from Wordpress

    $defaults = array(
        'theme_location'  => 'header_menu',
        'menu'            => '',
        'container'       => 'nav',
        'container_class' => 'nav',
        'container_id'    => '',
        'menu_class'      => 'nav__menu',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul class="nav__menu">%3$s</ul>',
        'depth'           => 0,
        'walker'          => ''
    );

    wp_nav_menu($defaults);
?>
