<?php
    /**
     *   Functions.php for Portfolio Custom theme
     *   Custom functions are prefixed with 'st_'
    */

    // For debugging:
    //ini_set('display_errors',1);  error_reporting(E_ALL);

    /* THEME SUPPORTS --------------------------------------------------------------------------------------------- */

    /**
     * Add theme supports
     */
    add_theme_support('menus');
    add_theme_support('post-thumbnails');
    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
    add_theme_support( 'infinite-scroll', array(
        'type'           => 'click',
        'footer'         => false,
        'container'      => 'post-container',
        'wrapper'        => false,
        'render'         => false,
        'footer-widgets' => false )
    );
    add_post_type_support( 'page', 'excerpt' ); // add excerpt functionality to pages

    /**
     * Remove autop
     */
    remove_filter('the_content', 'wpautop');


    /**
     * Remove infinite scroll from Search & Archive pages
     */
    function st_infinite_scroll_support() {
    	$supported = current_theme_supports( 'infinite-scroll' ) && !( is_archive() || is_search() );
    	return $supported;
    }
    add_filter( 'infinite_scroll_archive_supported', 'st_infinite_scroll_support' );


    /**
     * Enable Wordpress's handling of the <title> tag
     */
    function st_show_title_tag() {
       add_theme_support('title-tag');
    }
    add_action('after_setup_theme', 'st_show_title_tag');


    /**
     * Register custom menus
     * This makes it so you can edit them in WP Admin Appearence > Menus
     */
    function st_register_menus() {
      $menus = array(
        'header_menu' => 'Header Menu',
        'footer_menu' => 'Footer Menu'
      );
      register_nav_menus($menus);
    }
    add_action('init', 'st_register_menus');


    /**
     * Filter infinite scroll button text
     * customize/change the text on the infinite scroll button
     */
    function st_filter_jetpack_infinite_scroll_text( $settings ) {
      $settings['text'] = __( 'MORE', 'l18n' );

      return $settings;
    }
    add_filter( 'infinite_scroll_js_settings', 'st_filter_jetpack_infinite_scroll_text' );


    /**
     * Filter wordpress main menu
     * adds the search box to the end of the main navigation
     */
    function st_add_search_box( $items, $args ) {
      // if we are getting the main header menu, add the search box
      if ($args->theme_location == 'header_menu') {
        $items .= '<li class="search-container"><img class="search-icon" alt="search" src="' . get_template_directory_uri() . '/img/icons/search.svg"><div class="search-form-container">' . get_search_form( false ) . '</div></li>';
      }

      return $items;
    }
    add_filter( 'wp_nav_menu_items','st_add_search_box', 10, 2 );

    /**
     * Filter protected/private titles
     * removes "protected: " from the title
     */
    function st_remove_private_title($text){
    	$text='%s';
    	return $text;
    }
    add_filter('private_title_format','st_remove_private_title');
    add_filter('protected_title_format','st_remove_private_title');

    /**
     * Function manually makes sure that portfolio items are shown as under "Work" in nav bar
     * i.e. "Work" has active state styles (100% opacity white) applied when viewing "Abercrombie" portfolio item
     */
    function st_add_class_to_menu($classes)
    {
    	// portfolio is my custom post type
    	if (is_singular('portfolio'))
    	{
    		// we're viewing a custom post type, so remove the 'current-page' from all menu items.
    		$classes = array_filter($classes, "remove_parent");

    		// add the current page class to a specific menu item. (local & live versions)
    		if (in_array('menu-item-33', $classes)) $classes[] = 'current_page_ancestor';
        if (in_array('menu-item-104', $classes)) $classes[] = 'current_page_ancestor';
    	}
      if (is_search()) {
        // we're viewing a custom post type, so remove the 'current-page' from all menu items.
    		$classes = array_filter($classes, "remove_parent");
        // on searches, active state is styled via body class
      }
    	return $classes;
    }

    function remove_parent($var)
    {
      // check for current page values, return false if they exist.
      if ($var == 'current_page_parent' || $var == 'current-menu-item' || $var == 'current-page-ancestor') { return false; }

      return true;
    }

    if (!is_admin()) { add_filter('nav_menu_css_class', 'st_add_class_to_menu'); }

    /**
     * Custom password protected post form
     * @return [type] [description]
     */
    function st_password_form() {
      global $post;
      $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
      $o = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post" class="post-password-form"><p>' . __( "To view this protected post, enter the password below:" ) . '</p><input name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" /><input type="submit" name="Submit" value="' . esc_attr__( "Submit" ) . '" />
      </form>';
      $o .= '<div style="text-align:center; margin-bottom: 80px;"><p><strong>Need Access?</strong></p>';
      $o .= '<p>Tweet - @johnsmith';
      $o .= '<br>Email - hello@johnsmith.com</p></div>';
      return $o;
    }
    add_filter( 'the_password_form', 'st_password_form' );

    /* LOAD SCRIPTS/STYLES ---------------------------------------------------------------------------------------- */

    /**
     * Load main stylesheet (for browsers only, not admin)
     * We are loading our main styles in site.css instead of style.css so we can minimize the file
     * Style.css contains the theme meta data and will only be loaded on admin screens
     */
    function st_load_styles() {
        if (!is_admin()) {
          wp_register_style('carousel-styles', get_template_directory_uri() . '/js/owl.carousel.css', false, '1.0');
          wp_enqueue_style('carousel-styles');

          wp_register_style('carousel-theme', get_template_directory_uri() . '/js/owl.theme.css', false, '1.0');
          wp_enqueue_style('carousel-theme');

          wp_register_style('carousel-theme-custom', get_template_directory_uri() . '/js/owl.theme.custom.css', false, '1.0');
          wp_enqueue_style('carousel-theme-custom');

          wp_register_style('main-styles', get_template_directory_uri() . '/site.css', false, '1.0');
          wp_enqueue_style('main-styles');
        }
    }
    add_action('wp_enqueue_scripts', 'st_load_styles');

    /**
     * Load Google Analytics into footer
     */
    function add_google_analytics() { ?>
       <script>
         (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
         (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
         m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
         })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

         ga('create', 'UA-30013461-1', 'auto');
         ga('send', 'pageview');

       </script>
    <?php } ?><?php
    add_action('wp_footer', 'add_google_analytics');

    /**
     * Deregister WordPress default jQuery
     * Register and Enqueue Google CDN jQuery
     */
    function st_jquery_enqueue() {
      wp_deregister_script( 'jquery' );
      wp_register_script( 'jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js", false, null, true );
      wp_enqueue_script( 'jquery' );
    }
    if ( !is_admin() ) {
      add_action( 'wp_enqueue_scripts', 'st_jquery_enqueue', 11 );
    }


    /**
     * Load main custom js in the footer
     */
    function st_load_scripts() {
      // Load owl carousel script
      wp_register_script('owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array("jquery"), '1.0', true);
      wp_enqueue_script('owl-carousel');

      // Load headroom.js
      wp_register_script('headroom', get_template_directory_uri() . '/js/headroom.min.js', array("jquery"), '1.0', true);
      wp_enqueue_script('headroom');

      // Load headroom's jquery plugin
      wp_register_script('jquery-headroom', get_template_directory_uri() . '/js/jQuery.headroom.js', array("jquery"), '1.0', true);
      wp_enqueue_script('jquery-headroom');

      // Load the main script
      wp_register_script('main-script', get_template_directory_uri() . '/js/script-min.js', array("jquery"), '1.0', true);
      wp_enqueue_script('main-script');
    }
    add_action('wp_enqueue_scripts', 'st_load_scripts');



    /* CUSTOM POST TYPE (PORTFOLIO) ------------------------------------------------------------------------------ */

    /**
     * Register the 'Portfolio Item' Post Type
     */
    function st_portfolio_post_type() {
      $labels = array(
        'name'               => _x( 'Portfolio Items', 'post type general name' ),
        'singular_name'      => _x( 'Portfolio Item', 'post type singular name' ),
        'add_new'            => _x( 'Add New', 'Portfolio Item' ),
        'add_new_item'       => __( 'Add New Portfolio Item' ),
        'edit_item'          => __( 'Edit Portfolio Item' ),
        'new_item'           => __( 'New Portfolio Item' ),
        'all_items'          => __( 'All Portfolio Items' ),
        'view_item'          => __( 'View Portfolio Item' ),
        'search_items'       => __( 'Search Portfolio Items' ),
        'not_found'          => __( 'No portfolio items found' ),
        'not_found_in_trash' => __( 'No portfolio items found in the Trash' ),
        'parent_item_colon'  => '',
        'menu_name'          => 'Portfolio'
      );

      $args = array(
        'labels'        => $labels,
        'description'   => 'Holds our portfolio items and portfolio-specific data',
        'public'        => true,
        'menu_position' => 5,
        'menu_icon'     => 'dashicons-art',
        'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
        'has_archive'   => true
      );

      register_post_type('portfolio', $args);
    }
    add_action('init', 'st_portfolio_post_type');


    /* SHORTCODES ------------------------------------------------------------------------------ */

    /**
     * Content slide shortcode
     * @param  [array] $atts     these are the attributes in the shortcode i.e. background in [slide background=""]
     * @param  [string] $content the content included inside the shortcode ie. [slide] ... [/slide]
     * @return [markup]          the HTML markup the shortcode translates to
     */
    function st_content_slide($atts, $content = "") {

      $atts = shortcode_atts(array(       // default background color to white
          "background" => '#FFF',
          "text" => 'dark',
      ), $atts, 'st_content_slide');

      return '<div class="slide '. $atts['text'] . '" style="background-color: ' . $atts['background'] . ';">' . do_shortcode($content) . '</div>';
    }
    add_shortcode('slide', 'st_content_slide');


    /**
     * Device Video shortcode
     * @param  [type] $atts    [description]
     * @param  string $content [description]
     * @return [type]          [description]
     */
    function st_video($atts, $content = "") {

      $atts = shortcode_atts(array(       // default is iphone
          "type" => 'phone',
          "orientation" => 'portrait',
      ), $atts, 'st_video');

      $markup = '<div class="video-holder '. $atts['type'] . ' ' . $atts['orientation'] . '">';

      // add the phone image
      switch($atts['type']) {
        case "phone":
          if ($atts['orientation'] == "landscape") {
            $markup .= '<img class="device" src="'. get_template_directory_uri() . '/img/video/iphone-landscape.png">';
          } else {
            $markup .= '<img class="device" src="'. get_template_directory_uri() . '/img/video/iphone-portrait.png">';
          }
          break;
        case "tablet":
          if ($atts['orientation'] == "landscape") {
            $markup .= '<img class="device" src="'. get_template_directory_uri() . '/img/video/ipad-landscape.png">';
          } else {
            $markup .= '<img class="device" src="'. get_template_directory_uri() . '/img/video/ipad-portrait.png">';
          }
          break;
        case "laptop":
          $markup .= '<img class="device" src="'. get_template_directory_uri() . '/img/video/laptop.png">';
          break;
        case "desktop":
          $markup .= '<img class="device" src="'. get_template_directory_uri() . '/img/video/desktop.png">';
          break;
        default:
          $markup .= '<img class="device" src="'. get_template_directory_uri() . '/img/video/iphone.png">';
      }
      $markup .= do_shortcode($content) . '</div>';

      return $markup;
    }
    add_shortcode('device', 'st_video');

    /**
     * Spacer shortcode
     */
     function st_spacer($atts) {
       return '<hr class="spacer">';
     }
     add_shortcode('spacer', 'st_spacer');

    /**
     * Carousel shortcode
     * @param  [type] $atts    [description]
     * @param  string $content [description]
     * @return [type]          [description]
     */
    function st_carousel($atts, $content = "") {
      return '<section class="owl-carousel content-carousel">' . do_shortcode($content) . '</section>';
    }
    add_shortcode('carousel', 'st_carousel');

    function st_carousel_item($atts, $content = "") {
      return '<div>' . do_shortcode($content) . '</div>';
    }
    add_shortcode('item', 'st_carousel_item');

    /**
     * Shortcode creates a <figure> around content
     * @param  [array]  $atts    these are the attributes in the shortcode i.e. [slide background=""]
     * @param  [string] $content the content included inside the shortcode ie. [slide] ... [/slide]
     * @return [markup]          the markup the shortcode translates to
     */
    function st_figure($atts, $content = null ) {
      return '<figure>' . do_shortcode($content) . '</figure>';
    }
    add_shortcode('figure', 'st_figure');

    function st_caption($atts, $content = null) {
      return '<figcaption>' . do_shortcode($content) . '</figcaption>';
    }
    add_shortcode('figcaption', 'st_caption');


    // UTILITIES ------------------------------------------------------------------------------ //

    /**
     * Adjust brightness of a color
     * @param [string] $hex  hex code of color you want to adjust
     * @param [int] $steps how much lighter or darker you want it
     *
     * @return [string] the adjusted color
     */
    function adjustBrightness($hex, $steps) {
      // Steps should be between -255 and 255. Negative = darker, positive = lighter
      $steps = max(-255, min(255, $steps));

      // Normalize into a six character long hex string
      $hex = str_replace('#', '', $hex);
      if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
      }

      // Split into three parts: R, G and B
      $color_parts = str_split($hex, 2);
      $return = '#';

      foreach ($color_parts as $color) {
        $color   = hexdec($color); // Convert to decimal
        $color   = max(0,min(255,$color + $steps)); // Adjust color
        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
      }

      return $return;
    }

    /**
     * Returns estimated reading time of an article
     * @return [string] time in min or sec
     */
    function st_estimated_reading_time() {
    	$post = get_post();

    	$words = str_word_count( strip_tags( $post->post_content ) );
    	$minutes = floor( $words / 120 );
    	$seconds = floor( $words % 120 / ( 120 / 60 ) );

    	if ( 1 <= $minutes ) {
    		$estimated_time = $minutes . ' Min.';
    	} else {
    		$estimated_time = $seconds . ' Sec.';
    	}

    	return $estimated_time . ' Read';
    }

    /**
     * Creates & Prints a carousel of last 3 portfolio items
     */
    function st_portfolio_carousel() {
      $args = array(
          'posts_per_page'   => 5,                // Get 5 most recent portfolio items
          'orderby'          => 'post_date',
          'order'            => 'DESC',
          'post_type'        => 'portfolio'
        );

      $posts_array = get_posts( $args );

      echo '<section class="carousel owl-carousel portfolio-carousel">';
      foreach ($posts_array as $post_item) {
        $gradient = get_field("carousel_background_gradient", $post_item->ID);

        echo '<div class="owl-item-wrapper" style="';
        if ($gradient) {
          echo 'background-image: '. $gradient . ';';
        }
        echo 'background-color: ' . get_field('slide_background_color', $post_item->ID) . '">';
        echo '<a href="' . get_permalink($post_item->ID) . '">';
        echo '<div class="text-items"><h4 class="item-title">' . $post_item->post_title . '</h4>';
        echo '<p class="item-description">' . get_field('description', $post_item->ID) . '</p>';
        echo '<img class="arrow-right" alt="go to post" src="'. get_template_directory_uri() . '/img/icons/arrow-light.png"></div>';
        echo '<img alt="featured image" src="'. get_field('carousel_image', $post_item->ID) .'">';
        echo '</a></div>';
      }
      echo '</section>';

    }

?>
