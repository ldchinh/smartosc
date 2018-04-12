/* debouncing function from John Hann
 * http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods
 */
/*==================================
 SCROLL DEBOUNCE
 ==================================*/
// (function($, sr){
//     var debounce = function (func, threshold, execAsap) {
//         var timeout;
//         return function debounced () {
//             var obj = this, args = arguments;
//             function delayed () {
//                 if (!execAsap)
//                     func.apply(obj, args);
//                 timeout = null;
//             }
//             if (timeout)
//                 clearTimeout(timeout);
//             else if (execAsap)
//                 func.apply(obj, args);
//             timeout = setTimeout(delayed, threshold || 100);
//         };
//     };
//     // smartscroll2
//     jQuery.fn[sr] = function(fn, threshhold){  return fn ? this.bind('scroll', debounce(fn, threshhold)) : this.trigger(sr); };
// })(jQuery,'smartscroll2');
/*==================================
 RESIZE DEBOUNCE
 ==================================*/
(function($,sr){
    var debounce = function (func, threshold, execAsap) {
        var timeout;
        return function debounced () {
            var obj = this, args = arguments;
            function delayed () {
                if (!execAsap)
                    func.apply(obj, args);
                timeout = null;
            }
            if (timeout)
                clearTimeout(timeout);
            else if (execAsap)
                func.apply(obj, args);
            timeout = setTimeout(delayed, threshold || 400);
        };
    };
// smartresize2
    jQuery.fn[sr] = function(fn){ return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };
})(jQuery,'smartresize2');


(function ($) {
    'use strict';

    var _smartosc = {
        init: function () {

            //JS FROM BASE THEME
            if ($("[data-appear-animation]").length)
                    _smartosc.animations.init($("[data-appear-animation]"));

            // Sticky Header
            if(!$('body').hasClass("not-sticky") && $(".section-header").length)
                    _smartosc.spsticky.init($('.section-header'), $('.section-branding'));

            // Filter Mobile
            if ($(".view-filters").length)
                    _smartosc.filterOnMobile.init();

            // Scroll Banner
            $(".scroll").click(function (event) {
                    event.preventDefault();
                    var menu_height     = $('.not-transparent').height(),
                        anchor_offset   = $(this.hash).offset().top;

                    $('html,body').animate({scrollTop: anchor_offset - menu_height}, 1500);
            });

            // Capbilities banner
            if($('.capbilities-hero-image .img-grid').length)
                    _smartosc.equalHeight.init('.capbilities-hero-image .img-grid', true);
            if($('.client-video-info .client-info').length)
                    _smartosc.equalHeight.init('.client-video-info .client-info');

            // News
            if ($(window).width() >= 768) {
                if ($('.page-insights .news-description .blog-title').length)
                    _smartosc.equalHeight.init('.page-insights .news-description .blog-title');
            }

            // Second Toggle
            if ($(".sidebar").length)
                _smartosc.toggleGroup.init('.sidebar .block .heading-title', '.sidebar .block > .content');

            // Carousel Mobile
            if($('.article-carousel-mobile .view-content').length)
                    _smartosc.mobileCarousel.init('.article-carousel-mobile .view-content', '.blog-title');

            // About
            if($('.about-us-member .grid-masonry-custom .grid-item').length)
                _smartosc.mobileCarousel.init('.about-us-member .grid-masonry-custom .view-content');

            // Case study home
            if($('.home-case-study .work-case-study').length) {
                $(window).resize(function () {
                    var $wrapper = $('.home-case-study .view-content'),
                        $Element = $('.home-case-study .work-case-study'),
                        $ItemImage = $Element.find('img'),
                        $window_height = $(window).height();

                    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
                        _smartosc.mobileCarousel.init('.home-case-study .view-content');
                        $Element.height($window_height);
                        ImageCenter($Element, $ItemImage);
                        $wrapper.addClass("case-study-mobile");
                    }else{
                        $Element.removeAttr('style');
                        $ItemImage.removeAttr("style");
                        $wrapper.removeClass("case-study-mobile");
                    }
                }).trigger('resize');
            }

            // Case study detail
            if($('.elresult-carousel .element-result').length)
                _smartosc.mobileCarousel.init('.elresult-carousel', undefined, 992, 1);

            if($('.funfact-carousel .round-dotted').length)
                _smartosc.mobileCarousel.init('.funfact-carousel');

            if($('.our-solutions .element').length)
                _smartosc.equalHeightItem.initParent($('.our-solutions .element'), '.pic', 992);
            if($('.picture_info').length)
                _smartosc.equalHeightItem.initParent($('.picture_info'), '.pic', 992);
            if($('.info-layout').length)
                _smartosc.equalHeightItem.initParent($('.info-layout'), '.pic', 992);// Carousel Mobile
            if($('.mobile-post-carousel .view-content .case-grid').length)
                _smartosc.mobileCarousel.init('.mobile-post-carousel .view-content');


            // Careers For Student
            if($('.student-carousel .for-student-grid').length)
                _smartosc.mobileCarousel.init('.student-carousel .view-content');

            // FAQ
            if ($(".faqs-accordion").length)
                _smartosc.toggleGroup.init('.faqs-accordion li > h3', '.faqs-accordion li > div', '', 'hidden');

            // Apply Button Popup
            if($('a.apply-btn').length)
                _smartosc.careersPopup.init($('a.apply-btn'));

            // Career Toggle
            if ($(".career-group").length)
                _smartosc.toggleGroup.init('.group-career-title', '.group-career-data');
            if($('.content-carousel').length)
                _smartosc.carouselItem.init('.content-carousel');


            // History
            if ($(".one-page-scroll").length)
                _smartosc.onePage.init('.one-page-scroll', '.scroll-section');
        },
        animations: {
            init: function (content) {
                var $this = content;
                $this.each(function () {
                    var $this = $(this);
                    $this.addClass('appear-animation');
                    if ($(window).width() > 767) {
                        $this.appear(function () {
                            var delay = ($this.attr('data-appear-animation-delay') ? $this.attr("data-appear-animation-delay") : 1);
                            if (delay > 1) $this.css('animation-delay', delay + 'ms');
                            $this.addClass($this.attr('data-appear-animation'));
                            setTimeout(function () {
                                $this.addClass('appear-animation-visible');
                            }, delay);
                        }, {accX: 0, accY: 0, one: false});
                    } else {
                        $this.addClass('appear-animation-visible');
                    }
                });
            }
        },
        spsticky: {
            init: function (selector, height_transition) {
                var $this = selector;
                //$this.data('max-height', $this.outerHeight());

                $(window).scroll(function () {
                    var offsetTop = $(window).scrollTop(),
                        $banner = height_transition,
                        $header = selector;

                    var $start_transition = 2;
                    if ($banner.length) {
                        $start_transition = $banner.offset().top + $banner.height() - $header.height();
                    }
                    if (offsetTop > $start_transition) {
                        setTimeout(function () {
                            $this.addClass('fixed-transition');
                            $('body').addClass('fixed-header');
                        }, 10);
                    } else {
                        setTimeout(function () {
                            $this.removeClass('fixed-transition');
                            $('body').removeClass('fixed-header');
                        }, 10);
                    }
                });
            }
        },
        equalHeightItem: {
            init: function (container, item_get, item_set) {
                $(window).load(function() {
                    container.each(function() {
                        var selector_get_height = $(this).find(item_get).height(),
                            selector_set_height = $(this).find(item_set).height();

                        if(selector_get_height > selector_set_height) {
                            $(this).find(item_set).height(selector_get_height);
                        }
                    })
                })
            },
            initParent: function (container, item_get, responsive) {
                var point_res = responsive || 768;
                $(window).load(function() {
                    $(window).resize(function () {
                        if ($(window).width() >= point_res) {
                            container.each(function () {
                                var selector_get_height = $(this).find(item_get).height(),
                                    selector_set_height = $(this).height();

                                if (selector_get_height > selector_set_height) {
                                    $(this).height(selector_get_height);
                                }
                            })
                        }else{
                            container.css('height','auto');
                        }
                    }).trigger('resize');
                });
            }
        },
        equalHeight: {
            init: function (container, afterLoad) {
                if (typeof afterLoad !== 'undefined') {
                    $(window).load(function () {
                        _smartosc.equalHeight.calc(container);
                    });
                } else {
                    _smartosc.equalHeight.calc(container);
                }
                $(window).resize(function () {
                    $(container).css('height', 'auto');
                });
                $(window).smartresize2(function () {
                    _smartosc.equalHeight.calc(container);
                });
            },
            calc: function(container){
                if ($(window).width() >= 768) {
                    if ($(container).css('height', 'auto')) {
                        var tallest = 0;
                        $(container).each(function () {
                            var thisHeight = $(this).outerHeight();
                            if (thisHeight > tallest) {
                                tallest = thisHeight;
                            }
                        });
                        $(container).outerHeight(tallest);
                    }
                }
            }
        },
        filterOnMobile: {
            init: function(){
                var filterItem = $('.view-filters .form-type-bef-link'),
                    filterTitle = $('.view-filters .filter-title');

                if (filterItem.length && filterTitle.length < 1) {
                    filterItem.parent().parent().addClass('filter-on-mobile');
                    var currentItem = $('.view-filters .form-type-bef-link a.active').text();
                    $("<div class='filter-title'><span>" + currentItem + "</span><i class='fa fa-angle-down'></i></div>").insertBefore(filterItem.parent());
                    $(".filter-on-mobile .filter-title").on('click', function(){
                        var container = $(this).next();
                        container.toggleClass('active');
                    });
                }
            }
        },
        careersPopup: {
            init: function (selector) {
                selector.on('click', function () {
                    if ($('.careers-popup').length) {
                        $('.careers-popup').removeClass('hide-popup').addClass('show-popup').show();
                        $('html').addClass('overlay-open-popup');

                        $('.careers-popup .close-btn').on('click', function () {
                            $('.careers-popup').removeClass('show-popup').addClass('hide-popup').hide();
                            $('html').removeClass('overlay-open-popup');
                        });
                    }
                    return false;
                });
            }
        },
        toggleGroup: {
            init: function (groupTitle, groupContainer, defaultMobile, defaultDesktop) {
                if ($(window).width() < 768) {
                    if (typeof defaultMobile !== 'undefined' && defaultMobile == 'open') {
                        $(groupTitle).addClass('active').append("<span class='status'>-</span>");
                        $(groupContainer).show();
                    } else {
                        $(groupTitle).append("<span class='status'>+</span>");
                        $(groupContainer).hide();
                    }
                } else {
                    if (typeof defaultDesktop !== 'undefined' && defaultDesktop == 'hidden') {
                        $(groupTitle).append("<span class='status'>+</span>");
                        $(groupContainer).hide();
                    } else {
                        $(groupTitle).addClass('active').append("<span class='status'>-</span>");
                        $(groupContainer).show();
                    }
                }

                $(groupTitle).on('click', function () {

                    var title = $(this);
                    var container = $(this).next(groupContainer);

                    if (container.is(':hidden')) {
                        container.slideDown('200', function () {
                            title.addClass('active').find('.status').html("-");
                        });
                    } else {
                        container.slideUp('200', function () {
                            title.removeClass('active').find('.status').html("+");
                        });
                    }

                });
            }
        },
        carouselItem:{
            init: function (container) {
                $(container).addClass('owl-carousel').owlCarousel({
                    loop: true,
                    margin: 20,
                    nav: false,
                    dots: true,
                    autoplay: true,
					autoplaySpeed: 1000,
					autoplayTimeout: 5000,
                    autoplayHoverPause: true,
                    items : 1,
                });
            }
        },
        mobileCarousel: {
            init: function (container, equalHeightEle, responsive, item) {
                var owl = $(container);
                var point_res = responsive || 768;
                var item = item || 2;

                // console.log(container +' '+typeof equalHeightEle);
                if ($(window).width() < point_res) {
                    if (typeof equalHeightEle !== 'undefined') {
                        _smartosc.mobileCarousel.carouselInit(container, equalHeightEle, item);
                    } else {
                        _smartosc.mobileCarousel.carouselInit(container, undefined, item);
                    }
                } else {
                    if (owl.find('.owl-stage-outer').length) {
                        var block = container + ' ' + equalHeightEle;

                        $(block).css('height', 'auto');
                        owl.trigger('destroy.owl.carousel').removeClass('owl-carousel');
                    }
                }

                $(window).resize(function () {
                    if ($(window).width() >= point_res) {
                        if (owl.find('.owl-stage-outer').length) {
                            var block = container + ' ' + equalHeightEle;

                            $(block).css('height', 'auto');
                            owl.trigger('destroy.owl.carousel').removeClass('owl-carousel');
                        }
                    } else {
                        if (typeof equalHeightEle !== 'undefined') {
                            _smartosc.mobileCarousel.carouselInit(container, equalHeightEle, item);
                        } else {
                            _smartosc.mobileCarousel.carouselInit(container, undefined, item);
                        }
                    }
                });
            },
            carouselInit: function (container, equalHeightEle, itemRespon) {
                var itemsresponsive = false;
                if (itemRespon != 1){
                    itemsresponsive = {
                            0: {
                                items: 1
                            },
                            480: {
                                items: 2
                            }
                        };
                }


                $(container).addClass('owl-carousel').owlCarousel({
                    loop: true,
                    margin: 0,
                    nav: false,
                    dots: true,
                    autoHeight: false,
                    responsive: itemsresponsive,
                    items : 1,
                    onInitialized: function () {
                        if (typeof equalHeightEle !== 'undefined') {
                            if ($(container).find(equalHeightEle).length) {
                                var block = container + ' ' + equalHeightEle;
                                _smartosc.mobileCarousel.equalHeightCaro(block);
                            }
                        }
                    },
                    onResized: function () {
                        if (typeof equalHeightEle !== 'undefined') {
                            if ($(container).find(equalHeightEle).length) {
                                var block = container + ' ' + equalHeightEle;
                                _smartosc.mobileCarousel.equalHeightCaro(block);
                            }
                        }
                    }
                })
            },
            equalHeightCaro: function (block) {
                if ($(block).css('height', 'auto')) {
                    var tallest = 0;
                    $(block).each(function () {
                        var thisHeight = $(this).outerHeight();
                        if (thisHeight > tallest) {
                            tallest = thisHeight;
                        }
                    });
                    $(block).outerHeight(tallest);
                }
            }
        },
        onePage: {
            init: function(wrapper, section){
                $('body').addClass('full-one-page');
                if ($(wrapper).length && $(section).length) {
                    $(window).load(function () {
                        $(wrapper).fullpage({
                            sectionSelector: section,
                            navigation: true,
                            loopBottom: true,
                            loopTop: true,
                            responsiveWidth: 600,
                        });
                        $('.btn-start').on('click', function(e){
                            $(wrapper).fullpage.moveSectionDown();
                            return false;
                        });
                    });
                }
            }
        },
    }

    function isTouchDevice() {
        return true == ("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch);
    }

    // Video Banner
    $.fn.fullScreenVideo = function() {
        var _this = $(this),
            _video = _this.find('.okvideo_player');

        if (isTouchDevice() !== true) {
            // var ytID = _this.attr('data-video-id');
            // var ytOptions = {
            //     ratio: 16 / 9, // usually either 4/3 or 16/9
            //     videoId: ytID,
            //     mute: false,
            //     repeat: true,
            //     width: $(window).width(),
            //     wrapperZIndex: 1,
            //     shieldBg: false,
            //     shieldOpacity: 0.3,
            //     playButtonClass: 'tubular-play',
            //     pauseButtonClass: 'tubular-pause',
            //     muteButtonClass: 'tubular-mute',
            //     volumeUpClass: 'tubular-volume-up',
            //     volumeDownClass: 'tubular-volume-down',
            //     increaseVolumeBy: 10,
            //     start: 0,
            //     setBlockHeight: false
            // };
            // _this.empty().tubular(ytOptions);

            var $video_id = String(_video.data('videoid')),
                $video_repeat = _video.data('repeat'),
                $video_volume = _video.data('volume');

            _video.YTPlayer({
                ratio: 16 / 9,
                fitToBackground: true,
                videoId: $video_id,
                mute: $video_volume,
                repeat: $video_repeat,
                playerVars: {
                    autoplay: 1,
                    rel: 0,
                }
            })

            $(window).load(function(){
                var $parent = _this.parent();
                if(_this.find('iframe').length){
                    $parent.find('.banner-shield').addClass('transparent');
                    $(".banner-img,.banner-shield img", $parent).fadeOut(1000);
                }
            });
        }
    }

    // Portfolio
    $.fn.masonryGrid = function() {

        var $this = $(this),
            $loadingIMG = $this.find('.content-loading');

            // Loaded
            $(window).load(function(){
                if($loadingIMG.length && $loadingIMG.hide()){
                    $this.removeClass('loading');
                }
            });

        var $GridContent    = $this.find('.grid-item'),
            $ItemContent    = $this.find('.grid-masory-item'),
            $ItemWrap       = $this.find('.content-effect-wrap');

            // Mobile Hover Image
            if (isTouchDevice() === true) {
                $("html").addClass('is-touch-device');
                $ItemContent.on('touchstart', function(event){
                    if($(this).hasClass('focus')){
                        $(this).remove('focus');
                    } else {
                        if($ItemContent.removeClass('focus')){
                            $(this).addClass('focus');
                        }
                    }
                });
            } else if ($ItemContent.length) {
                $ItemContent.each(function () {
                    $(this).hoverdir({
                        hoverElem: $ItemWrap
                    });
                });
            }

            // Image Center
            $(window).load(function () {
                $GridContent.each(function () {
                    var $Element = $(this).find('.grid-masory-item'),
                        $ItemImage = $(this).find('.grid-masory-item > img');
                    ImageCenter($Element, $ItemImage);
                });
            })
            $(window).smartresize2(function () {
                $GridContent.each(function () {
                    var $Element = $(this).find('.grid-masory-item'),
                        $ItemImage = $(this).find('.grid-masory-item > img');
                    ImageCenter($Element, $ItemImage);
                });
            })
    }

    // Center Image
    function ImageCenter(container, picture) {
        if (container.length && picture.length) {
            var blockW = container.width(),
                blockH = container.height(),
                imgW = picture.width(),
                imgH = picture.height();

            if (imgW <= blockW && imgH >= blockH) {
                picture.css({
                    'position': 'absolute',
                    'max-height': 'inherit',
                    'width': '100%',
                    'height': 'auto',
                    'top': '50%',
                    'left': '0',
                    '-webkit-transform': 'translate(0, -50%)',
                    '-moz-transform': 'translate(0, -50%)',
                    '-ms-transform': 'translate(0, -50%)',
                    '-o-transform': 'translate(0, -50%)',
                    'transform': 'translate(0, -50%)'
                });
            } else if (imgH < blockH) {
                picture.css({
                    'position': 'absolute',
                    'max-width': 'inherit',
                    'width': 'auto',
                    'height': '100%',
                    'top': '0',
                    'left': '50%',
                    '-webkit-transform': 'translate(-50%, 0)',
                    '-moz-transform': 'translate(-50%, 0)',
                    '-ms-transform': 'translate(-50%, 0)',
                    '-o-transform': 'translate(-50%, 0)',
                    'transform': 'translate(-50%, 0)'
                });
            }
        }
    }

    // Header body
    function headerMove(region_menu, section_toggle) {
        if(region_menu.find('.bt-js-close').length < 1)
            region_menu.prepend("<div class='bt-js-close'></div>");

        section_toggle.click(function(){
            if (isTouchDevice() != false)
                $('html').addClass('nav-open-fixed');
            $('body').addClass('nav-sidebar-open');
            $(window).trigger('resize');// Change size Video Slider
        });
        $("body").click(function(e){
            var tag=$(e.target);
            var $regionClose = region_menu.find('.bt-js-close');
            if(tag.is($regionClose) || tag.is(".body-innerwrapper")) {
                if (isTouchDevice() != false)
                    $('html').removeClass('nav-open-fixed');
                $("body").removeClass("nav-sidebar-open");
                $(window).trigger('resize');// Change size Video Slider
            }
        });
    }

    // Scroll Top
    function scrollToTop(){
        $(window).scroll(function(){
            if ($(this).scrollTop() > 100) {
                $('.back-top-wrap').addClass('in');
            } else {
                $('.back-top-wrap').removeClass('in');
            }
        });
        $('.back-to-top').click(function(){
            $('html, body').animate({scrollTop : 0},800);
            return false;
        });
    }


    $(document).ready(function () {

        // Header Menu
        headerMove($(".region-fixed-header"),$(".section-header .nav-toggle"));

        // Footer
        $(window).resize(function () {
            if (!$("body").hasClass("footer-special")) {
                if ($(window).width() >= 992) {
                    var footer_height = $('.section-fixed-bottom').height();
                    $('.main-wrapper-content').css("margin-bottom", footer_height);
                }else{
                    $('.main-wrapper-content').css("margin-bottom", '0');
                }
            }
        });

        // Loader
        $(window).on('load', function(){
            $('body').addClass('loaded');

            if ($('.loader_page').length) {
                setTimeout(function() {
                    $('.loader_page').fadeOut(250);
                }, 1000);
            }

            $(window).trigger('resize');
        });

        // Youtube video
        if (isTouchDevice() != true) {
            if ($(".youtube-video-full-screen").length)
                $(".youtube-video-full-screen").fullScreenVideo();
        }
        // Picture Video
        $(window).resize(function () {
            var $banner_video = $('.home-page-banner-content'),
                $banner_img = $banner_video.find('.banner-img img'),
                $window_width = $(window).width(),
                $window_height = $(window).height();

            $banner_video.width($window_width).height($window_height);
            ImageCenter($banner_video, $banner_img);
        });

        // Smart OSC
        _smartosc.init();

        // Scroll
        scrollToTop();

        //Hover Menu Dropdown Language
        if (isTouchDevice() != true) {
            $(".lang-dropdown").mouseenter(function () {
                $(this).addClass('show-other');
            });
            $(".lang-dropdown").mouseleave(function () {
                $(this).removeClass('show-other');
            });
        } else {
            $(".lang-dropdown").on('touchstart', function () {
                'use strict';
                $(this).toggleClass('show-other');
            });
        }

        // Portfolio
        if ($(".grid-masonry-custom").length)
            $('.grid-masonry-custom').masonryGrid();

        // Popup
        $('[data-popup-open]').on('click', function(e)  {
            var targeted_popup_class = jQuery(this).attr('data-popup-open');
            $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);

            e.preventDefault();
        });
        $('[data-popup-close]').on('click', function(e)  {
            var targeted_popup_class = jQuery(this).attr('data-popup-close');
            $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);

            e.preventDefault();
        });


        //Newsletter Dotmailer
        $(window).scroll(function() {
            var element_affix = $(".fixed-black-bottom"),
                offset_bottom = $(window).scrollTop() + $(window).height();

            var bottom_height = element_affix.outerHeight();
            element_affix.parent().css("padding-bottom", bottom_height);

            //Offset bottom of Content
            var body_offset = $("body").offset().top,
                main_height = $(".main-wrapper-content").outerHeight(),
                main_offset_bottom = Math.round(main_height + body_offset);

            if (offset_bottom <= main_offset_bottom) {
                element_affix.addClass('has_fixed');
            } else {
                element_affix.removeClass('has_fixed');
            }
        }).trigger('scroll');

        // localStorage
        if (typeof(Storage) !== "undefined") {
            $('.fixed-black-bottom').append('<a class="fixed-close">+</a>');

            $('.fixed-black-bottom .fixed-close').click(function() {
                localStorage.form_close = true;
                $('.fixed-black-bottom').parent().hide();
            })
            if(localStorage.form_close){
                $('.fixed-black-bottom').parent().hide();
            }
        }

    });

})(jQuery);