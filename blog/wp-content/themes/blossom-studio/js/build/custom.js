jQuery(document).ready(function($) {
    var slider_auto, slider_loop, rtl;
    
    if( blossom_studio_data.auto == '1' ){
        slider_auto = true;
    }else{
        slider_auto = false;
    }
    
    if( blossom_studio_data.loop == '1' ){
        slider_loop = true;
    }else{
        slider_loop = false;
    }
    
    if( blossom_studio_data.rtl == '1' ){
        rtl = true;
    }else{
        rtl = false;
    }    

    //header search form toggle 
    $('.header-search .search-toggle').on( 'click', function() {
        $(this).siblings('.header-search-wrap').fadeIn();
    });

    $('.header-search .close').on( 'click', function() {
        $(this).parents('.header-search-wrap').fadeOut();
    });

    $(window).keyup(function(e) {
        if (e.key == 'Escape') {
            $('.header-search .header-search-wrap').fadeOut();
        }
    });

    //add submenu toggle btn
    $('.nav-menu li.menu-item-has-children').find('> a').after('<button class="submenu-toggle"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="5" viewBox="0 0 10 5"><path d="M5,0l5,5H0Z" transform="translate(10 5) rotate(180)" fill="#fff"/></svg></button>');


    $('.menu-item-has-children .submenu-toggle').on('click', function () {
        $(this).toggleClass('active');
        $(this).siblings('.sub-menu').stop(true, false, true).slideToggle();
    });
  
    //toggle main navigation
    $('.main-navigation .toggle-btn').on( 'click', function() {
        $(this).parents('.main-navigation').addClass('menu-toggled');
        $(this).siblings('.main-menu-modal').animate({
            width: 'toggle',
        });
    });

    $('.main-navigation .close').on( 'click', function() {
        $(this).parents('.main-navigation').removeClass('menu-toggled');
        $(this).parents('.main-menu-modal').animate({
            width: 'toggle',
        });
    });

    $(window).keyup(function(event) {
        if(event.key == 'Escape') {
            $('.main-navigation').removeClass('menu-toggled');
        }
    });

  //for accessibility
    $('.nav-menu li a, .nav-menu li button').on( 'focus', function() {
        $(this).parents('li').addClass('hover');
        }).blur(function() {
        $(this).parents('li').removeClass('hover');
    });

    //header one secondary menu toggle
    if ( !$('.site-header').hasClass('style-seven') && !$('.site-header').hasClass('style-three') ) {

        $('.secondary-menu .toggle-btn').on('click', function () {
            $(this).parents('.secondary-menu').addClass('menu-active');
            $(this).siblings('div').animate({
                width: 'toggle',
            });
        });

        $('.secondary-menu .close').on('click', function () {
          
            $(this).parent('div').animate({
                width: 'toggle',
            });
            $(this).parents('.secondary-menu').removeClass('menu-active');
        });

        $(window).keyup( function (e) {
            if( e.key == 'Escape' ) {
                // $('.secondary-menu > div').animate({
                //     width: 'toggle',
                // });
                $('.secondary-menu').removeClass('menu-active');
            }
        });
    }

    //Add site logo in the middle of menu item
    $('.hide-element').removeClass('hide-element');

    //add top spacing on sticky widget
    $(window).on('resize load', function() {
        var stickyHeaderHeight = $('.mobile-header.sticky-enabled').outerHeight();
        var adminbarHeight = $('#wpadminbar').outerHeight();
        var totalTopSize = parseInt(stickyHeaderHeight) + parseInt(adminbarHeight);
        if($('#wpadminbar').length && $('.mobile-header').hasClass('sticky-enabled')) {
            $('.single .site-main .has-sticky-meta .article-meta-inner').css('top', totalTopSize + 20);
        } else if($('#wpadminbar').length === 0 && $('.mobile-header').hasClass('sticky-enabled')) {
            $('.single .site-main .has-sticky-meta .article-meta-inner').css('top', stickyHeaderHeight + 20);
        } else if($('#wpadminbar').length && $('.mobile-header.sticky-enabled').length === 0) {
            $('.single .site-main .has-sticky-meta .article-meta-inner').css('top', adminbarHeight + 20);
        } else {
            $('.single .site-main .has-sticky-meta .article-meta-inner').css('top', 20);
        }
    });

    //add layout class in body
    if ($('.site-banner.static-cta').hasClass('style-one')) {
        $('body').addClass('static-cta-one');
    } else {
        $('body').removeClass('static-cta-one');
    }

    $(window).on('load resize', function() {

        //move secondary menu into main navigation
        if($('.mobile-header .secondary-menu').length && $(window).width() < 1025) {
            $('.mobile-header .secondary-menu .nav-menu > li').insertAfter('.mobile-header .main-navigation .nav-menu > li:last-child').addClass('sec-menu-item');
        } else {
            $('.mobile-header .main-navigation .nav-menu > li.sec-menu-item').appendTo('.mobile-header .secondary-menu .nav-menu').removeClass('sec-menu-item');
        }

    });

    //mobile menu toggle
    $('.mobile-header .toggle-btn').on( 'click', function() {
        $(this).parents('.mobile-header').addClass('menu-toggled');
        $(this).siblings('.mobile-header-popup').animate({
            width: 'toggle',
        });
    });

    $('.mobile-header .mbl-header-inner > .close').on( 'click', function() {
        $(this).parents('.mobile-header').removeClass('menu-toggled');
        $('.mobile-header-popup').animate({
            width: 'toggle',
        });
    });

    if( blossom_studio_data.lightbox == '1' ){  
        //banner cta video popup
        $('[data-fancybox]').fancybox({
            youtube: {
                controls: 0,
                showinfo: 0
            }
        });
    }

    //banner slider
    $('.site-banner .owl-carousel').owlCarousel({
        items: 1,
        nav: true,
        dots: false,
        autoplay: slider_auto,
        loop: slider_loop,
        rewind: true,
        autoplaySpeed: blossom_studio_data.speed,
        animateOut : blossom_studio_data.animation,
        autoplayTimeout: 7000,
        rtl: rtl,
        navText: [
          '<svg xmlns="http://www.w3.org/2000/svg" width="11.277" height="21.054" viewBox="0 0 11.277 21.054"><path d="M174.048,32.845l-9.466,9.466,9.466,9.466" transform="translate(-163.832 -31.784)" fill="none" stroke="#44576b" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>',
          '<svg xmlns="http://www.w3.org/2000/svg" width="11.277" height="21.054" viewBox="0 0 11.277 21.054"><path d="M164.582,32.845l9.466,9.466-9.466,9.466" transform="translate(-163.521 -31.784)" fill="none" stroke="#44576b" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/></svg>'
        ],
    });

    //promo section slider
    $('.widget_bttk_image_text_widget .bttk-itw-holder li').each(function() {
        $(this).wrapInner('<div class="bttk-itw-inner-holder"></div>');
    });

    //get height of testimonial section header
    $(window).on('load resize', function() {
        var testHeaderHeight = $('.testimonial-section .widget_text').outerHeight();
        $('.testimonial-section .test-overlay').css('top', testHeaderHeight);
    });

    //wrap widget title content with span
    $('.widget .widget-title, .widget .section-title').wrapInner('<span></span>');

    //back to top
    $(window).on( 'scroll', function () {
        if ($(this).scrollTop() > 200) {
            $('.back-to-top').addClass('active');
        } else {
            $('.back-to-top').removeClass('active');
        }
    });

    $('.back-to-top').on('click', function () {
        $('body,html').animate({
            scrollTop: 0,
        }, 600);
    });

    //alignfull js
    $(window).on('load resize', function() {
        var metaWidth;
        if($(window).width() > 1024){
            metaWidth = $('.single .site-main .article-meta').outerWidth() + 50;
        } else {
            metaWidth = $('.single .site-main .article-meta').outerWidth() + 30;
        }
        var gbWindowWidth = $(window).width();
        var gbContainerWidth = $('.blossom-studio-pro-has-blocks .site-content > .container').width();
        var gbContentWidth = $('.blossom-studio-pro-has-blocks .site-main .entry-content').width();
        var gbMarginFull = (parseInt(gbContentWidth) - parseInt(gbWindowWidth)) / 2;
        var gbMarginFull2 = (parseInt(gbContentWidth) - parseInt(gbContainerWidth)) / 2;
        var gbMarginCenter = (parseInt(gbContentWidth) - parseInt(gbWindowWidth)) / 2;
        $(".blossom-studio-pro-has-blocks.full-width .site-main .entry-content .alignfull").css({"max-width": gbWindowWidth, "width": gbWindowWidth, "margin-left": gbMarginFull});
        $(".blossom-studio-pro-has-blocks.full-width.centered .site-main .entry-content .alignfull").css({"max-width": gbWindowWidth, "width": gbWindowWidth, "margin-left": gbMarginCenter});
        $(".blossom-studio-pro-has-blocks.full-width.centered .site-main .entry-content .alignwide").css({"max-width": gbContainerWidth, "width": gbContainerWidth, "margin-left": gbMarginFull2});
    });

    //promo section slider
    $('.promo-section .widget .bttk-itw-holder').addClass('owl-carousel');
    $('.widget_bttk_image_text_widget .bttk-itw-holder li').each(function() {
        $(this).wrapInner('<div class="bttk-itw-inner-holder"></div>');
    });
    $('.promo-section .widget .bttk-itw-holder').owlCarousel({
        items: 4,
        margin: 45,
        nav: true,
        dots: false,
        autoplay: false,
        loop: false,
        rewind: true,
        autoplaySpeed: 800,
        autoplayTimeout: 3000,
        navText: [
          '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M152.485 396.284l19.626-19.626c4.753-4.753 4.675-12.484-.173-17.14L91.22 282H436c6.627 0 12-5.373 12-12v-28c0-6.627-5.373-12-12-12H91.22l80.717-77.518c4.849-4.656 4.927-12.387.173-17.14l-19.626-19.626c-4.686-4.686-12.284-4.686-16.971 0L3.716 247.515c-4.686 4.686-4.686 12.284 0 16.971l131.799 131.799c4.686 4.685 12.284 4.685 16.97-.001z"></path></svg>',
          '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M295.515 115.716l-19.626 19.626c-4.753 4.753-4.675 12.484.173 17.14L356.78 230H12c-6.627 0-12 5.373-12 12v28c0 6.627 5.373 12 12 12h344.78l-80.717 77.518c-4.849 4.656-4.927 12.387-.173 17.14l19.626 19.626c4.686 4.686 12.284 4.686 16.971 0l131.799-131.799c4.686-4.686 4.686-12.284 0-16.971L312.485 115.716c-4.686-4.686-12.284-4.686-16.97 0z"></path></svg>'
        ], 
        responsive: {

            0 : {
                items: 1,
                nav: false,
                dots: true,
            }, 
            768 : {
                items: 3,
                nav: false,
                dots: true,
            }, 
            1025 : {
                items : 4,
                nav: true,
                dots: false,
            }

        }
    });

    //Ajax for Add to Cart
    $('.btn-simple').click(function() {        
        $(this).addClass('adding-cart');
        var product_id = $(this).attr('id');
        
        $.ajax ({
            url     : blossom_studio_data.ajax_url,  
            type    : 'POST',
            data    : 'action=blossom_studio_add_cart_single&product_id=' + product_id,    
            success : function(results){
                $('#'+product_id).replaceWith(results);
            }
        }).done(function(){
            var cart = $('#cart-'+product_id).val();
            $('.cart .number').html(cart);         
        });
    });
     
});//document close