"use strict";

// Pass in '$' shortcut for jQuery since wordpress uses no-conflict mode
(function($) {

    // make the nav work on click
    function navMenu($trigger, $menu) {
      $trigger.click(function() {
        $menu.toggleClass('open').toggleClass('transparent');   // SAFARI BUG WORKAROUND (TEMPORARY)
        $('.overlay').toggleClass('active');
        $('.header-bar').toggleClass('transparent');

        // switch menu button to close
        if ($menu.hasClass('open')) {
          $(this).find('img').attr('src', 'http://www.johnsmith.com/wp-content/themes/portfolio-theme/img/icons/close.png');
        } else {
          $(this).find('img').attr('src', 'http://www.johnsmith.com/wp-content/themes/portfolio-theme/img/icons/hamburger.png');
        }

        // fade in the menu
        $menu.toggle();

        // toggle open class
        $(this).parent().parent().parent().toggleClass('open');

        return false;  // prevent page jump
      });
    }

    // Search box for desktop
    function searchBox($icon, $menuItems, $searchBox) {
      $icon.on("click", function() {
        $(this).parent().toggleClass('active');
        $menuItems.toggleClass('fade');
        $searchBox.attr('placeholder', 'type and press "enter" to search')

        if ($(this).parent().hasClass('active')) {
          $(this).attr('src', 'http://www.johnsmith.com/wp-content/themes/portfolio-theme/img/icons/close.png');
        } else {
          $(this).attr('src', 'http://www.johnsmith.com/wp-content/themes/portfolio-theme/img/icons/search.svg');
        }
      });
    }

    function adjustAutoParagraphs() {
      // Reduce line height for paragraphs that only contain "em" elements
      $('.slide p em:only-of-type').parent().css("line-height", "1.1");

      $('blockquote p').contents().unwrap();

      // remove <p> around elements that aren't text nodes (kill autoparagraphs)
      $(".slide p").each(function(){
          if (!$(this).text().trim().length) {
            $(this).contents().unwrap();
          }
      })
    }

    $(document).ready(function() {
        // cache nav
        var $nav = $('.nav');
        // init nav menu
        navMenu($('.nav-trigger'), $nav);

        // Init search box
        searchBox($('.search-icon'), $('.nav .menu-item'), $('.search__box'));

        // adjust paragraph issues
        adjustAutoParagraphs();

        // Portfolio clicking on background links portfolio item
        $('.portfolio-slide').on("click", function() {
          window.location = $(this).data("url");
        })

        // init headroom
        var $header = $(".header-bar");
        var $search = $(".search-container");
        $header.headroom();
        // make headroom activate when top area is hovered on
        $(".header-wrap").hover(function() {
          if (!$nav.hasClass('open') && !$search.hasClass('active')) {  // turn off hover on mobile menu
            $header.removeClass('headroom--unpinned').addClass('headroom--pinned');
          }
        }, function() {
          if (!$nav.hasClass('open') && !$search.hasClass('active')) {
            $header.removeClass('headroom--pinned').addClass('headroom--unpinned');
          }
        });

        // init carousels
        var $portfolioCarousel = $('.portfolio-carousel');
        var $contentCarousel = $('.content-carousel');

        if ($portfolioCarousel.length > 0) {
          $portfolioCarousel.owlCarousel({
            'singleItem': true,
            'autoHeight': false,
            'theme': 'owl-theme portfolio-theme'
          });
        }

        if ($contentCarousel.length > 0) {
          $contentCarousel.owlCarousel({
            'singleItem': true,
            'autoHeight': false,
            'theme': 'owl-theme content-theme',
            'afterInit': function(elem){
              var that = this;
              that.owlControls.prependTo(elem);
            }
          });
        }
    });
})(jQuery);
