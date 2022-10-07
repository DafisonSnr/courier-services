// Resizing Class 0.1.0 Copyright 2018 JP Larson, Fiserv.  All rights reserved.
// Code dependencies: resize css class;
// This adds a class while the window is resizing then removes it. Using a css class transitions can be removed temporarily. body.resize * { transition: none !important; }
(function (jQuery) {
    jQuery.fn.resizeClass = function (options) {
        var settings = jQuery.extend({
            obj: jQuery(this),
            resizeClass: "resize",
            debounceDuration: 500
        }, options),
            timer;
        try {

            jQuery(window).resize(function () {
                clearTimeout(timer);
                timer = setTimeout(function () {
                    settings.obj.removeClass(settings.resizeClass);
                }, settings.debounceDuration);
                settings.obj.addClass(settings.resizeClass);
            });
        } catch (err) {
            console.log(err);
        }
        return this;
    }
}(jQuery));
//scrollTrigger
var initscrolltrigger = function () {
    //when scroll class is added to body
    jQuery('body').scrollTrigger({
        triggerClass: "scroll",
        scrollMin: 1
    });
    //back to top
    jQuery('body').scrollTrigger({
        triggerClass: "showtop",
        scrollMin: 350
    });
    //content animations for image sections
    jQuery('.subsection[style*=url] td.show').scrollTrigger({
        resetOnScrollUp: false,
        elementOffset: 0.70
    });
}


// Replace with checkmarks v1.0.0 Copyright 2017 Jesse Fowler, Fiserv.  All rights reserved.
jQuery.fn.replaceWithCheckmarks = function (options) {
    var settings = jQuery.extend({
        findThis: 'x',
        htmlReplacement: '<span class="checkmark"><span class="visuallyhidden">x</span></span>'
    }, options);
    this.each(function () {
        if (jQuery(this).html() == settings.findThis) {
            jQuery(this).html(settings.htmlReplacement);
        }
    });
    return this;
};

// Responsive Nav
jQuery("#menuopen").click(function () {
    jQuery("body").toggleClass("opennav");
    jQuery("body").removeClass("openob"); //Hide login
    jQuery("nav ul li").each(function () {
        jQuery(this).removeClass('active');
    });
});
jQuery("nav ul li").click(function () {
    jQuery(this).toggleClass("active");
    //jQuery(this).siblings().removeClass("active"); //closes other tabs
});
jQuery("#loginopen").click(function () { // Login Show/Hide
    // jQuery("body").toggleClass("openob");
    if (jQuery("body").hasClass("openob")) {
        jQuery("body").removeClass("openob");
    } else {
        jQuery("body").addClass("openob");
        //loginMobileAdjustReset()
        //setTimeout(loginMobileAdjust, 300)
    }
    jQuery("body").removeClass("opennav"); //Hide Responsive Nav      
});



jQuery(document).ready(function () {

    jQuery('body').resizeClass();


    // Replaces Subsection Table with a Div Wrapper 
    jQuery("table.Subsection-Table").tableWrapper();
    jQuery("table.Subsection-Table-Solid").tableWrapper({
        wrapperClass: "subsection-solid"
    });

    //Secondary page - top section animation
    //Adds Animated Class
    (function (jQuery) {
        jQuery.fn.addAnimate = function () {
            var $this = jQuery(this);

            $this.each(function () {
                if (jQuery(this).html().length) {
                    jQuery(this).addClass('animated fadeInUp');
                }
            });
            return this;
        };
    }(jQuery));
    jQuery('.subsection[style*=url]:first-of-type h1').addAnimate(
        jQuery('.subsection[style*=url]:first-of-type h1').addClass('d6')
    );
    jQuery('.subsection[style*=url]:first-of-type h1 ~ *').addAnimate(
        jQuery('.subsection[style*=url]:first-of-type h1 ~ *').addClass('d10')
    );
    jQuery('.subsection[style*=url] td.show').scrollTrigger({
        resetOnScrollUp: false,
        elementOffset: 0.50
    });

    //Add "Custom" ScrollTo Downarrow - NOT required for scrollTo
    jQuery('[class*="subsection"][style*="url"]:first-of-type').append('<a href="javascript:void(0)" class="down-arrow scroll-trigger animated bounceDelay infinite"><i class="fa fa-angle-double-down"></i><span class="visuallyhidden">Scroll to Next Section</span></a>');

    // Call .scrollTo on the containers you want to rotate through
    jQuery('[class*="subsection"]').scrollTo({
        skipInitial: 1,
        baseOffsetTopObject: jQuery('nav#primary')
    });


    //Remove Spaces 2.0.0
    jQuery('p').each(function () {
        var $this = jQuery(this);
        if ($this.html().replace(/\s|&nbsp;/g, '').length == 0)
            $this.remove();
    });

	//reorganize table based on screen size
    //tableDataTitle();

    // Responsive Zoom 2.2.1 Copyright (c) 2014 Fiserv.  All rights reserved.
    // Requires Modernizr, jQuery			
    var windowWidth = jQuery(window).width();
    var onWinResizer = debounce(function () {
        if (jQuery(window).width() != windowWidth) {
            onWinResize();
            windowWidth = jQuery(window).width();
        }
    }, 500);

    jQuery(window).on('resize', onWinResizer);

    function onWinResize() {
        var windowSize = jQuery(window).width();
        // Set page width maximums and minimums
        pageWidth = parseFloat(windowSize);
        if (pageWidth < 990) {
            try {
                jQuery("body").addClass("mobile");
                jQuery("body").removeClass("desktop");
            } catch (err) { }
        } else {
            try {
                jQuery("body").removeClass("mobile");
                jQuery("body").addClass("desktop");
            } catch (err) { }
        }
        jQuery(".responsivezoom").responsiveZoom();
        jQuery(".Table-Style").responsiveZoom();
        jQuery(".Table-Product").responsiveZoom();
        onWinResizeInitalized = true;
    }

    onWinResize();

    jQuery(".scroll-trigger").scrollPage({
        //autoScroll: true
    });

    //when scroll class is added to body
    jQuery('body').scrollTrigger({
        triggerClass: "scroll",
        scrollMin: 1
    });
    //content animations for image sections
    jQuery('.subsection[style*=url] td.show').scrollTrigger({
        resetOnScrollUp: false,
        elementOffset: 0.70
    });

    // Replace with checkmarks v1.0.0 Copyright 2017 Fiserv.  All rights reserved.
    jQuery(".Table-Product tbody>tr>td>p").replaceWithCheckmarks({
        findThis: 'X',
        htmlReplacement: '<span class="checkmark"><span class="visuallyhidden">Check</span></span>'
    });

    jQuery(".Table-Product tbody>tr>td").replaceWithCheckmarks({
        findThis: 'X',
        htmlReplacement: '<span class="checkmark"><span class="visuallyhidden">Check</span></span>'
    });
    jQuery(".Table-Style tbody>tr>td>p").replaceWithCheckmarks({
        findThis: 'X',
        htmlReplacement: '<span class="checkmark"><span class="visuallyhidden">Check</span></span>'
    });

    jQuery(".Table-Style tbody>tr>td").replaceWithCheckmarks({
        findThis: 'X',
        htmlReplacement: '<span class="checkmark"><span class="visuallyhidden">Check</span></span>'
    });

    // Detect TD has Content
    jQuery("[class*=subsection] .inner-content > table:not('[class*=Table]') td, .Subsection-Table > tbody > tr > td:first-of-type > table:not('[class*=Table]') td").each(function () {
        var $this = jQuery(this);

        if (($this.html().length > 25) || ($this.find('h1,h2,h3,h4,h5').length)) {
            $this.addClass("show");
        }
    });

    // Add overlay (fade) based on content location
    // Detect TD has Content required
    jQuery(".subsection[style*='url'] .inner-content > table:not('[class*=Table]') > tbody > tr, .Subsection-Table[style*='url'] > tbody > tr > td:first-of-type > table:not('[class*=Table]') > tbody > tr").each(function () {
        var $this = jQuery(this);

        if (jQuery(this).find("td:first-child").hasClass("show") && jQuery(this).find("td:last-child").hasClass("show")) {
        } else if (jQuery(this).find("td:first-child").hasClass("show")) {
            $this.parents(".subsection, .Subsection-Table").addClass("fade-left");
        } else if (jQuery(this).find("td:last-child").hasClass("show")) {
            $this.parents(".subsection, .Subsection-Table").addClass("fade-right");
        }
    });

    // Smooth Scroll 
    // Remove if Smooth scroll is already being called somewhere else
    jQuery(function () {
        jQuery('a[href*=#]:not([href=#])').click(function () {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = jQuery(this.hash);
                target = target.length ? target : jQuery('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    jQuery('html,body').animate({
                        scrollTop: target.offset().top
                    }, 850, 'swing');
                    return false;
                }
            }
        });
    });

    //Site Notice
    if (jQuery("body").hasClass("home")) {
        jQuery(".notice").responsiveSiteNotice({
            fixedPosition: true
        });
    }
   
});

jQuery(window).load(function () {
    //calls scrollTrigger
    initscrolltrigger();
});
jQuery(window).scroll(function () {
    //calls scrollTrigger
    initscrolltrigger();
});
//add rel to speedbump links
var links = document.getElementsByTagName("a");
for (var i = 0; i < links.length; i++) {
    if (links[i].href.match(/speedbump/i) && links[i].href.match(/\?link\=/i) && !links[i].target) {
        links[i].target = '_blank';
        //console.log('Found speedbump, added target to link ' +i);
    }
}