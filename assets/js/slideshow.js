jQuery(document).ready(function () {
    // Slideshow v2.8.1 (c) 2015 Jesse Fowler, Fiserv
    // Requires jQuery, jQuery Mobile, and CSS
    jQuery.fn.slideShow = function (options) {
        var settings = jQuery.extend({
            showDuration: 8000,
            transitionSpeed: 1000,
            container: this,
            currentIndex: 0,
            tocActive: 'toc-active',
            captionActive: 'captionActive',
            thumbOpacity: 1,
            hoverSelect: false,
            autoPlay: true,
            TOC: 2, 							// TOC: 0 - Off, 1 - Numbered, 2 - Image Alt, 3 - Thumbnails
            tocThumbnailed: false,
            randomSelect: true,
            hoverPause: false,
            captionTables: true,
            debug: false,
            loadMobile: false
        }, options);

        var images = settings.container.find('table>tbody>tr>td>p:first-child img, table>tbody>tr>td>p:first-child video'),
            interval,
            toc = [],
            captions = [],
            afterFirstSlide = false,
            hold = false,
            TOCParent = settings.container;	//settings.container.parent().parent().parent().parent()	

        //images.not('video').each(function() {
        //    var imgSrc = jQuery(this).attr('src');
        //    jQuery(this).css('background-image', 'url(' + imgSrc + ')');
        //});

        // Create slideshow objects 
        if (settings.container.find('.slideshow').length > 0) {
            settings.container.find('.slideshow').remove();
        }
        if (settings.container.find('.slideshow-container-controls').length > 0) {
            settings.container.find('.slideshow-container-controls').remove();
        }
        if (settings.container.find('.caption-container').length > 0) {
            settings.container.find('.caption-container').remove();
        }
        var slideshow = jQuery('<div />');
        slideshow.addClass('slideshow');
        // Create duplicates for the slides
        images.each(function () {
            var duplicateElement;
            if (jQuery(this).is('video')) {
                duplicateElement = jQuery(this).clone();
            } else {
                duplicateElement = jQuery('<div />');
                duplicateElement.addClass('slide');
                duplicateElement.css('background-image', 'url(' + jQuery(this).attr('src') + ')');
            }
            slideshow.append(duplicateElement);
        });
        imageClones = slideshow.find('.slide').add(slideshow.find('video'));
        settings.container.append(slideshow);

        var muteAll = function () {
            imageClones.each(function () {
                if (jQuery(this).is('video')) {
                    jQuery(this).get(0).muted = true;
                }
            });
        }
        muteAll();
        var pauseAllVideos = function (e) {
            imageClones.not(e).each(function () {
                if (jQuery(this).is('video') && !jQuery(this).get(0).loop && !images.get(0).paused) {
                    jQuery(this).get(0).pause();
                }
            });
        }
        pauseAllVideos();


        var start = function () {
            if (settings.autoPlay && typeof (interval) === 'undefined') {
                interval = self.setInterval(show, settings.showDuration);
            }
        };

        var stop = function () {
            window.clearInterval(interval);
            interval = undefined;
            //console.log(interval)
        };

        var show = function (to) {

            // Ending animation of the last slide.
            imageClones.removeClass('previous');
            imageClones.eq(settings.currentIndex).removeClass('active');
            imageClones.eq(settings.currentIndex).addClass('previous');
            if (!Modernizr.csstransforms) {
                imageClones.eq(settings.currentIndex).fadeOut(settings.transitionSpeed);
            }
            if (settings.TOC > 0) { TOCParent.find('.slideshow-container-controls').children('div').eq(settings.currentIndex).removeClass(settings.tocActive); }
            if (settings.captionTables) {
                TOCParent.find('.caption-container .caption').eq(settings.currentIndex).removeClass(settings.captionActive);
                // Caption Animation 
                if (!Modernizr.csstransforms) {
                    TOCParent.find('.caption-container .caption').eq(settings.currentIndex).animate({
                        left: -580
                    }, (settings.transitionSpeed / 2), "linear", function () {
                        hold = false;
                    });
                }
            }

            // Beginning of the animation of the new slide.
            imageClones.eq(settings.currentIndex = (typeof to != 'undefined' ? to : (settings.currentIndex < images.length - 1 ? settings.currentIndex + 1 : 0))).addClass('active');
            if (settings.debug) { console.log('Showing slide number: ' + (settings.currentIndex + 1)) }
            if (!Modernizr.csstransforms) {
                imageClones.eq(settings.currentIndex).fadeIn(settings.transitionSpeed);
            }
            muteAll();
            pauseAllVideos();
            if (settings.debug && imageClones.get(settings.currentIndex).buffered) { console.log('Typeof buffered: ' + typeof (imageClones.get(settings.currentIndex).buffered) + '; Buffer length: ' + imageClones.get(settings.currentIndex).buffered.length) }
            if (imageClones.eq(settings.currentIndex).is('video') && typeof (imageClones.get(settings.currentIndex).buffered) !== 'undefined' /*&& imageClones.get(settings.currentIndex).buffered.length > 0*/) {
                imageClones.get(settings.currentIndex).muted = false;
                if (!imageClones.get(settings.currentIndex).loop && (settings.loadMobile == false && onWinResize() == false)) {
                    if (settings.debug) { console.log('Not looping. Paused: ' + imageClones.get(settings.currentIndex).paused) }
                    if (imageClones.get(settings.currentIndex).paused) {
                        imageClones.get(settings.currentIndex).play();
                    }
                    stop();
                    imageClones.eq(settings.currentIndex).unbind('ended');
                    imageClones.eq(settings.currentIndex).bind('ended', function () {
                        if (settings.debug) { console.log('Video slide ended') }
                        //images.get( settings.currentIndex ).currentTime = 0;
                        //imageClones.get(settings.currentIndex).load();
                        //start();
                        show();
                    });
                } else {
                    if (imageClones.get(settings.currentIndex).currentTime == imageClones.get(settings.currentIndex).duration) {
                        imageClones.get(settings.currentIndex).currentTime = 0;
                    }
                }
            } else {
                start();
                if (settings.debug) { console.log(interval) }
            }

            // Class all of the elements in the slideshow with a unique order.
            for (i = 0; i < imageClones.length; i++) {
                imageClones.removeClass("item-" + i);
            }
            for (i = settings.currentIndex; i < imageClones.length; i++) {
                imageClones.eq(i).addClass("item-" + (i - settings.currentIndex));
            }
            for (i = 0; i < settings.currentIndex; i++) {
                imageClones.eq(i).addClass("item-" + (i + imageClones.length - settings.currentIndex));
            }

            if (settings.TOC > 0) { TOCParent.find('.slideshow-container-controls').children('div').eq(settings.currentIndex).addClass(settings.tocActive); }
            if (settings.captionTables) {
                TOCParent.find('.caption-container .caption').eq(settings.currentIndex).addClass(settings.captionActive);
                if (!Modernizr.csstransforms) {
                    hold = true;
                    TOCParent.find('.caption-container .caption').eq(settings.currentIndex).animate({
                        left: 0
                    }, (settings.transitionSpeed / 2), "linear", function () {
                        hold = false;
                    });
                }
            }
        };

        var preview = jQuery("<div/>", {
            'class': 'slideshow-container-controls'
        })
        TOCParent.append(preview);

        var captionsContainer = jQuery("<div/>", {
            'class': 'caption-container'
        })
        settings.container.append(captionsContainer);

        images.each(function (index) {
            /* add caption */
            if (settings.captionTables) {
                if (jQuery(this).parent().prop("tagName") != "A") {
                    var tableContents = '<div class="caption captionInActive">' + jQuery(this).parent('p').parent().html() + '</div>';
                } else {
                    var tableContents = '<div class="caption captionInActive">' + jQuery(this).parent('a').parent('p').parent().html() + '</div>';
                }
                captionsContainer.append(tableContents);
            }
            /* add to table of contents */
            // if(index == 0) { tocPreActive = settings.tocActive }
            if (jQuery(this).prop('alt') != null) { tocAlt = jQuery(this).prop('alt'); } else { tocAlt = "" }
            var imgnum = index + 1;
            if (settings.TOC == 3) {
                var tocImg = '<a href="#"><img src="' + jQuery(this).get('src') + '" alt="' + tocAlt + '" title="' + tocAlt + '"></a>';
            } else if (settings.TOC == 2) {
                var tocImg = '<a href="#"><span class="numeric-index">' + imgnum + '</span>' + tocAlt + '</a>';
            } else {
                var tocImg = '<a href="#">' + imgnum + '</a>';
            };

            var tocDiv = jQuery("<div/>", {
                html: tocImg
            });
            preview.append(tocDiv);
            tocDiv.on({
                click: function (e) {
                    if (e) e.preventDefault();
                    stop();
                    start();
                    show(index);
                }/*, mouseenter: function() {
					jQuery(this).fadeIn(settings.transitionSpeed);
					if (settings.hoverSelect) {
						stop();
						show(index);
					}
				}, mouseleave: function() {
					if(!jQuery(this).hasClass(settings.tocActive)) jQuery(this).fadeTo(settings.transitionSpeed,settings.thumbOpacity);
					if (settings.hoverSelect) {
						start();
					}
				} */
            });

            // captionsContainer.inject('mainimg', 'after'); Not sure if this is a requirement.
            //document.id('content1').grab(preview, 'top');
        });

        if (settings.captionTables) {
            captionsContainer.children('.caption').children('p:first-child').remove();
            captionsContainer.children('.caption').children('*:last-child').addClass('lastchild');
        }

        if (settings.TOC > 0) { preview.css('display', 'block'); } else { preview.css('display', 'none'); }

        jQuery('#previous').on({
            click: function (e) {
                if (e) e.preventDefault();
                stop();
                start();
                if ((settings.currentIndex - 1) < 0) {
                    show(images.length - 1);
                } else {
                    show(settings.currentIndex - 1);
                }
            }
        });

        jQuery('#previous-alternate').on({
            click: function (e) {
                if (e) e.preventDefault();
                stop();
                start();
                if ((settings.currentIndex - 1) < 0) {
                    show(images.length - 1);
                } else {
                    show(settings.currentIndex - 1);
                }
            }
        });

        // Swipe previous
        slideshow.add(captionsContainer).on("swiperight", swiperightHandler);

        function swiperightHandler(event) {
            event.stopImmediatePropagation();
            stop();
            start();
            if ((settings.currentIndex - 1) < 0) {
                show(images.length - 1);
            } else {
                show(settings.currentIndex - 1);
            }
        }

        jQuery('#next').on({
            click: function (e) {
                if (!hold) {
                    if (e) e.preventDefault();
                    stop();
                    start();
                    show();
                }
            }
        });

        jQuery('#next-alternate').on({
            click: function (e) {
                if (!hold) {
                    if (e) e.preventDefault();
                    stop();
                    start();
                    show();
                }
            }
        });
        // Swipe next
        slideshow.add(captionsContainer).on("swipeleft", swipeleftHandler);

        function swipeleftHandler(event) {
            event.stopImmediatePropagation();
            stop();
            start();
            show();
        }

        /* control: start/stop on mouseover/mouseout */
        if (settings.hoverPause) {
            settings.container.on({
                mouseenter: function () { stop(); },
                mouseleave: function () { start(); }
            });
        }
        start();
        if (settings.randomSelect) {
            var randomSlideNumber = Math.floor(Math.random() * (images.length));
            show(randomSlideNumber);
        } else {
            show(0);
        }

        var playVideo = function () {
            // Play videos
            slideshow.find('video').each(function () {
                if (jQuery(this).get(0).loop && jQuery(this).get(0).paused) {
                    jQuery(this).get(0).play();
                }
            });
        };

        var windowWidth = jQuery(window).width();

        function debounce(func, wait, immediate) {
            var timeout;
            return function () {
                var context = this, args = arguments;
                var later = function () {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        };

        if (settings.loadMobile == false) {
            //Play only on desktop
            var onWinResizer = debounce(function () {
                if (jQuery(window).width() != windowWidth) {
                    onWinResize();
                    windowWidth = jQuery(window).width();
                }
            }, 500);
            jQuery(window).on('resize', onWinResizer);
        }

        function onWinResize() {
            var windowSize = jQuery(window).width();
            // Set page width maximums and minimums
            pageWidth = parseFloat(windowSize);
            if (pageWidth < 640) {
                jQuery(settings.container).find('video').each(function () {
                    jQuery(this).get(0).pause();
                });
                return true;
            } else {
                if (imageClones.get(settings.currentIndex) && imageClones.eq(settings.currentIndex).is('video')) {
                    imageClones.get(settings.currentIndex).play();
                }
                return false;
            }
            onWinResizeInitalized = true;
        }
        onWinResize();

        // Linking the TOC between multiple slideshows - only activates if more than one slide show instance exists.
        var enableLinkedTOCs = true,
            numberOfTOCs = jQuery('.slideshow-container-controls').length;
        if (enableLinkedTOCs && numberOfTOCs > 1) {
            //name of primary slideshow that will hold the main clickable toc
            jQuery('#slideshow-container').parent().find('.slideshow-container-controls div').each(function (index) {
                jQuery(this).click(function () {
                    //name of element additional instance of slideshow called on to receive the click actions of the primary slideshow
                    jQuery('#slideshow-secondary-container').parent().find('.slideshow-container-controls div').eq(index).click();
                });
            });
        }
    };
    jQuery('#hero-main').slideShow({
        randomSelect: false
    });

    //jQuery('#hero-main-alternate').slideShow();
});