// // JavaScript to modify
// //ENTER THE APP IDS FROM APPLE STORE AND ANDROID PACKAGE IDS FROM GOOGLE PLAY STORE HERE
// var SABTitle = 'American Community Bank';
// var SABAuthor = 'Fiserv Solutions, Inc.';
// var iPhoneID = '1115873321';
// var iPadID = '';
// var AndroidPhoneID = 'com.americancb.mobile';
// var AndroidTabletID = '';

// //THIS SECTION YOU EDIT TO BUILD THE ANDROID SMART APP BANNER INFORMATION
// $(function () {

//   //THIS SECTION SETS THE IOS AND ANDROID SMART APP BANNERS **DO NOT MODIFY**
//   var mobile = (/iphone|ipad|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));
//   if (mobile) {
//     var userAgent = navigator.userAgent.toLowerCase();
//     if ((userAgent.search("android") > -1) && (userAgent.search("mobile") > -1)) $('head').append("<meta name='google-play-app' content='app-id=" + AndroidPhoneID + "'>");
//     else if ((userAgent.search("android") > -1) && !(userAgent.search("mobile") > -1)) $('head').append("<meta name='google-play-app' content='app-id=" + AndroidTabletID + "'>");
//     else if (userAgent.search("ipad") > -1) $('head').append("<meta name='apple-itunes-app' content='app-id=" + iPadID + "'>");
//     else if ((userAgent.search("iphone") > -1) || (userAgent.search("ipod") > -1)) $('head').append("<meta name='apple-itunes-app' content='app-id=" + iPhoneID + "'>");
//   }

//   //THIS SECTION ADDS THE REQUIRE FILE REFERENCES FOR THE SMART BANNERS TO WORK. ONLY MODIFY THE FILE LOCATION IF NECESSARY
//   $('head').append("<meta name='viewport' content='width=device-width, initial-scale=1.0'>");
//   $('head').append("<link rel='apple-touch-icon' href='sab/icon.png'>");
//   $('head').append("<link rel='android-touch-icon' href='sab/icon.png' />");
//   $.smartbanner({
//     title: SABTitle,
//     author: SABAuthor
//   })
// })
// // Main JavaScript
// /*!
//  * jQuery Smart Banner
//  * Copyright (c) 2014 Nicolas KOKLA
//  * Forked from the Copyrighted project 'jquery.smartbanner' [Copyright (c) 2012 Arnold Daniels <arnold@jasny.net>]
//  * Based on 'jQuery Smart Web App Banner' by Kurt Zenisek @ kzeni.com
//  */
// ! function ($) {
//   var SmartBanner = function (options) {
//     this.options = $.extend({}, $.smartbanner.defaults, options);
//     var standalone = navigator.standalone; // Check if it's already a standalone web app or running within a webui view of an app (not mobile safari)
//     // Detect banner type (iOS, Android, Windows Phone or Windows RT)
//     if (this.options.force) {
//       this.type = this.options.force
//     }
//     else if (navigator.userAgent.match(/iPad|iPhone|iPod/i) != null && navigator.userAgent.match(/Safari/i) != null) {
//       if (
//         (window.Number(navigator.userAgent.substr(navigator.userAgent.indexOf('OS ') + 3, 3).replace('_', '.')) < 6) || navigator.userAgent.match(/Version/i) == null) this.type = 'ios'; // Check webview and native smart banner support (iOS 6+)
//     }
//     else if (navigator.userAgent.match(/Android/i) != null) {
//       this.type = 'android'
//     }
//     else if (navigator.userAgent.match(/Windows NT 6.2/i) != null) {
//       this.type = 'windows'
//     }
//     else if (navigator.userAgent.match(/Windows Phone/i) != null) {
//       this.type = 'windows-phone'
//     }
//     // Don't show banner if device isn't iOS or Android, website is loaded in app or user dismissed banner
//     if (!this.type || standalone || this.getCookie('sb-closed') || this.getCookie('sb-installed')) {
//       return
//     }
//     // Calculate scale
//     this.scale = this.options.scale == 'auto' ? $(window).width() / window.screen.width : this.options.scale;
//     if (this.scale < 1) this.scale = 1;
//     // Get info from meta data
//     var metaString, metaTrackingString, specificDeviceOption;
//     switch (this.type) {
//       case 'windows':
//         metaString = 'meta[name="msApplication-ID"]';
//         metaTrackingString = 'meta[name="ms-store-rt-tracking"]';
//         specificDeviceOption = this.options.windowsRtConfig || null;
//         break;
//       case 'windows-phone':
//         metaString = 'meta[name="msApplication-WinPhonePackageUrl"]';
//         metaTrackingString = 'meta[name="ms-store-phone-tracking"]';
//         specificDeviceOption = this.options.windowsPhoneConfig || null;
//         break;
//       case 'android':
//         metaString = 'meta[name="google-play-app"]';
//         metaTrackingString = 'meta[name="google-play-app-tracking"]';
//         specificDeviceOption = this.options.androidConfig || null;
//         break;
//       case 'ios':
//         metaString = 'meta[name="apple-itunes-app"]';
//         metaTrackingString = 'meta[name="apple-itunes-app-tracking"]';
//         specificDeviceOption = this.options.iphoneConfig || null;
//         break;
//     }
//     var meta = $(metaString);
//     var metaTracking = $(metaTrackingString);
//     if (meta.length == 0) return;
//     if (metaTracking.length == 0) metaTracking = $('<meta name="" content="" />');
//     // For Windows Store apps, get the PackageFamilyName for protocol launch
//     if (this.type == 'windows') {
//       this.pfn = $('meta[name="msApplication-PackageFamilyName"]').attr('content');
//       this.appId = meta.attr('content')[1];
//     }
//     else if (this.type == 'windows-phone') {
//       this.appId = meta.attr('content')
//     }
//     else {
//       this.appId = /app-id=([^\s,]+)/.exec(meta.attr('content'))[1]
//     }
//     // Get Tracking URL :
//     this.appTracking = metaTracking.attr('content');
//     // Get Device Configuration Specific :
//     if (specificDeviceOption) $.extend(this.options, specificDeviceOption);
//     // Get default Title and Author :
//     this.title = this.options.title ? this.options.title : $('title').text().replace(/\s*[|\-·].*$/, '');
//     this.author = this.options.author ? this.options.author : ($('meta[name="author"]').length ? $('meta[name="author"]').attr('content') : window.location.hostname);
//     // Create banner
//     this.create();
//     this.show();
//     this.listen();
//   }
//   SmartBanner.prototype = {
//     constructor: SmartBanner,
//     create: function () {
//       var iconURL, link, inStore = this.options.price ? '<span class="sb-price">' + this.options.price + '</span> ' + (this.type == 'android' ? this.options.inGooglePlay : this.type == 'ios' ? this.options.inAppStore : this.options.inWindowsStore) : '',
//         gloss = this.options.iconGloss;
//       if (this.appTracking == "") {
//         switch (this.type) {
//           case ('windows'):
//             link = 'ms-windows-store:PDP?PFN=' + this.pfn;
//             break;
//           case ('windows-phone'):
//             link = 'http://windowsphone.com/s?appId=' + this.appId;
//             break;
//           case ('android'):
//             link = 'https://play.google.com/store/apps/details?id=' + this.appId;
//             break;
//           case ('ios'):
//             link = 'https://itunes.apple.com/' + this.options.appStoreLanguage + '/app/id' + this.appId;
//             break;
//         }
//       }
//       else {
//         link = this.appTracking;
//       }
//       var container = this.options.container;
//       if ($(container).length < 1) return;
//       $(container).append('<div id="smartbanner" class="' + this.type + '">' + '<div class="sb-container">' + '<a href="#" class="sb-close">&times;</a><span class="sb-icon"></span>' + '<div class="sb-info"><strong>' + this.title + '</strong><span>' + this.author + '</span><span>' + inStore + '</span></div>' + '<a href="' + link + '" target="_blank" class="sb-button"><span>' + this.options.button + '</span></a>' + '</div>' + '</div>');
//       var ejqSmartBanner = $('#smartbanner');
//       if (this.options.icon) {
//         iconURL = this.options.icon
//       }
//       else if ($('link[rel="apple-touch-icon-precomposed"]').length > 0) {
//         iconURL = $('link[rel="apple-touch-icon-precomposed"]').attr('href');
//       }
//       else if ($('link[rel="apple-touch-icon"]').length > 0) {
//         iconURL = $('link[rel="apple-touch-icon"]').attr('href');
//       }
//       else if ($('meta[name="msApplication-TileImage"]').length > 0) {
//         iconURL = $('meta[name="msApplication-TileImage"]').attr('content');
//       }
//       else if ($('meta[name="msapplication-TileImage"]').length > 0) { /* redundant because ms docs show two case usages */
//         iconURL = $('meta[name="msapplication-TileImage"]').attr('content');
//       }
//       if (iconURL) {
//         var eSbIcon = $('#smartbanner .sb-icon');
//         eSbIcon.css('background-image', 'url(' + iconURL + ')');
//         if (gloss) eSbIcon.addClass('gloss');
//       }
//       else {
//         ejqSmartBanner.addClass('no-icon');
//       }
//       if (this.scale > 1) {
//         ejqSmartBanner.css('top', parseFloat(ejqSmartBanner.css('top')) * this.scale).css('height', parseFloat(ejqSmartBanner.css('height')) * this.scale);
//         $('#smartbanner .sb-container').css('-webkit-transform', 'scale(' + this.scale + ')').css('-msie-transform', 'scale(' + this.scale + ')').css('-moz-transform', 'scale(' + this.scale + ')').css('width', $(window).width() / this.scale)
//       }
//     },
//     listen: function () {
//       $('#smartbanner .sb-close').on('click', $.proxy(this.close, this))
//       $('#smartbanner .sb-button').on('click', $.proxy(this.install, this))
//     },
//     show: function (callback) {
//       var ejqHtml = $('html');
//       ejqHtml.get(0).className = ejqHtml.get(0).className + ' smartBanner ';
//       if (callback) callback();
//     },
//     hide: function (callback) {
//       $('html').removeClass('smartBanner');
//       $("#smartbanner").hide();
//       if (callback) callback();
//     },
//     close: function (e) {
//       debugger;
//       e.preventDefault();
//       this.hide();
//       this.setCookie('sb-closed', 'true', this.options.daysHidden);
//     },
//     install: function (e) {
//       this.hide();
//       this.setCookie('sb-installed', 'true', this.options.daysReminder);
//     },
//     setCookie: function (name, value, exdays) {
//       var exdate = new Date();
//       exdate.setDate(exdate.getDate() + exdays);
//       value = encodeURIComponent(value) + ((exdays == null) ? '' : '; expires=' + exdate.toUTCString());
//       document.cookie = name + '=' + value + '; path=/;';
//     },
//     getCookie: function (name) {
//       var i, x, y, ARRcookies = document.cookie.split(";");
//       for (i = 0; i < ARRcookies.length; i++) {
//         x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
//         y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
//         x = x.replace(/^\s+|\s+$/g, "");
//         if (x == name) {
//           return decodeURIComponent(y);
//         }
//       }
//       return null
//     }
//     // For demo only
//     ,
//     switchType: function () {
//       // Array.indexOf polyfill from mozilla :
//       // >> https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/indexOf
//       if (!Array.prototype.indexOf) {
//         Array.prototype.indexOf = function (searchElement, fromIndex) {
//           if (this === undefined || this === null) throw new TypeError('"this" is null or not defined');
//           var length = this.length >>> 0; // Hack to convert object.length to a UInt32
//           fromIndex = +fromIndex || 0;
//           if (Math.abs(fromIndex) === Infinity) fromIndex = 0;
//           if (fromIndex < 0) {
//             fromIndex += length;
//             if (fromIndex < 0) fromIndex = 0;
//           }
//           for (; fromIndex < length; fromIndex++)
//             if (this[fromIndex] === searchElement) return fromIndex;
//           return -1;
//         };
//       }
//       var that = this;
//       that.hide(function () {
//         var a_format = ['ios', 'android', 'windows', 'windows-phone'];
//         var newIndex = a_format.indexOf(that.type) + 1;
//         that.type = (!a_format[newIndex]) ? a_format[0] : a_format[newIndex];
//         var meta = $(that.type == 'android' ? 'meta[name="google-play-app"]' : 'meta[name="apple-itunes-app"]').attr('content');
//         that.appId = /app-id=([^\s,]+)/.exec(meta)[1];
//         $('#smartbanner').detach();
//         that.create();
//         that.show();
//         if (window.console && console.log) console.log(that.type);
//       })
//     }
//   };
//   $.smartbanner = function (option) {
//     var $window = $(window),
//       data = $window.data('typeahead'),
//       options = typeof option == 'object' && option;
//     if (!data) $window.data('typeahead', (data = new SmartBanner(options)));
//     if (typeof option == 'string') data[option]();
//   };
//   // override these globally if you like (they are all optional)
//   $.smartbanner.defaults = {
//     //Smart Banner default config :
//     title: null, // What the title of the app should be in the banner (defaults to <title>)
//     author: null, // What the author of the app should be in the banner (defaults to <meta name="author"> or hostname)
//     price: 'FREE', // Price of the app
//     priceText: 'On the store', // Text of price for store
//     icon: null, // The URL of the icon (defaults to <meta name="apple-touch-icon">)
//     button: 'View', // Text for the install button
//     appStoreLanguage: 'us', // Language code for iOS App Store
//     // Deprecated - replaced by 'priceText' and 'Device Configuration Specific' section :
//     inAppStore: 'On the App Store', // Text of price for iOS - iPhone
//     inGooglePlay: 'In Google Play', // Text of price for Android Phone
//     inWindowsStore: 'In the Windows Store', //Text of price for Windows Phone
//     iconGloss: null, // Force gloss CSS effect for iOS even for precomposed
//     // Technical config :
//     daysHidden: 15, // Duration to hide the banner after being closed (0 = always show banner)
//     daysReminder: 90, // Duration to hide the banner after "VIEW" is clicked *separate from when the close button is clicked* (0 = always show banner)
//     scale: 'auto', // Scale based on viewport size (set to 1 to disable)
//     container: 'body', // Container where the banner will be injected
//     force: null, // Choose 'ios', 'android' or 'windows'. Don't do a browser check, just always show this banner
//     // Device Configuration Specific - Use JSON similar to the 'defaultDeviceConfig' variable :
//     iphoneConfig: null,
//     ipadConfig: null,
//     androidConfig: null,
//     androidTabsConfig: null,
//     windowsPhoneConfig: null,
//     windowsRtConfig: null
//   };
//   var defaultDeviceConfig = {
//     title: null, // What the title of the app should be in the banner (defaults to <title>)
//     author: null, // What the author of the app should be in the banner (defaults to <meta name="author"> or hostname)
//     price: 'FREE', // Price of the app
//     icon: null, // The URL of the icon (defaults to <meta name="apple-touch-icon">)
//     button: 'View', // Text for the install button
//     storeLanguage: 'us' // iOS Only : Language code for App Store
//   };
//   $.smartbanner.Constructor = SmartBanner;
// }(window.jQuery);
// $(function () {
//   // CSS
//   $("#smartbanner").css({
//     "position": "absolute",
//     "left": "0",
//     "top": "0",
//     "border-bottom": "2px solid #e8e8e8",
//     "width": "100%",
//     "height": "95px",
//     "font-family": "'Helvetica Neue',sans-serif",
//     "background": "#fff",
//     "z-index": "9998",
//     "-webkit-font-smoothing": "antialiased",
//     "overflow": "hidden",
//     "-webkit-text-size-adjust": "none",
//     "box-sizing": "border-box"
//   });
//   $("#smartbanner .sb-container").css({
//     "margin": "0 auto"
//   });
//   $("#smartbanner .sb-close").css({
//     "position": "absolute",
//     "left": "0",
//     "top": "0",
//     "display": "block",
//     "text-align": "center",
//     "text-decoration": "none",
//     "-webkit-font-smoothing": "subpixel-antialiased",
//     "border": "0",
//     "width": "17px",
//     "height": "100%",
//     "line-height": "25px",
//     "color": "#999 !important",
//     "border-radius": "0",
//     "background": "none",
//     "box-shadow": "none",
//     "text-shadow": "none",
//     "font-size": "25px",
//     "padding": "2px 5px"
//   });
//   $("#smartbanner .sb-close:active").css({
//     "color": "#aaa"
//   });
//   $("#smartbanner .sb-icon").css({
//     "position": "absolute",
//     "left": "30px",
//     "top": "10px",
//     "display": "block",
//     "width": "55px",
//     "height": "55px",
//     "background-size": "cover"
//   });
//   $("#smartbanner.no-icon .sb-icon").css({
//     "display": "none"
//   });
//   $("#smartbanner .sb-info").css({
//     "position": "absolute",
//     "left": "98px",
//     "top": "18px",
//     "width": "44%",
//     "font-size": "12px",
//     "line-height": "1.2em",
//     "color": "#6a6a6a",
//     "text-shadow": "0 1px 0 rgba(255,255,255,0.8)"
//   });
//   $("#smartbanner #smartbanner.no-icon .sb-info").css({
//     "left": "34px"
//   });
//   $("#smartbanner .sb-info strong").css({
//     "display": "block",
//     "font-size": "13px",
//     "color": "#000",
//     "line-height": "18px",
//     "font-weight": "bold"
//   });
//   $("#smartbanner .sb-info > span").css({
//     "display": "block"
//   });
//   $("#smartbanner .sb-info .sb-price").css({});
//   $("#smartbanner .sb-info em").css({
//     "font-style": "normal",
//     "text-transform": "uppercase"
//   });
//   $("#smartbanner .sb-button").css({
//     "position": "absolute",
//     "right": "20px",
//     "top": "24px",
//     "border": "1px solid #bfbfbf",
//     "padding": "0 10px",
//     "min-width": "10%",
//     "height": "24px",
//     "font-size": "14px",
//     "line-height": "24px",
//     "text-align": "center",
//     "font-weight": "bold",
//     "color": "#6a6a6a !important",
//     "background": "#fff",
//     "text-transform": "uppercase",
//     "text-decoration": "none",
//     "text-shadow": "0 1px 0 rgba(255,255,255,0.8)",
//     "border-radius": "3px",
//     "box-shadow": "0 1px 0 rgba(255,255,255,0.6),0 1px 0 rgba(255,255,255,0.7) inset"
//   });
//   $("#smartbanner .sb-icon.gloss:after").css({
//     "content": "''",
//     "position": "absolute",
//     "left": "0",
//     "top": "-1px",
//     "border-top": "1px solid rgba(255,255,255,0.8)",
//     "width": "100%",
//     "height": "50%",
//     "background": "-webkit-linear-gradient(top, rgba(255,255,255,0.7) 0%,rgba(255,255,255,0.2) 100%)",
//     "border-radius": "10px 10px 12px 12px"
//   });
//   /* iOS*/
//   $("#smartbanner.ios .sb-icon").css({
//     "border-radius": "9px"
//   });
//   $("#smartbanner.ios .sb-close").css({
//     "color": "#999 !important",
//     "padding": "7px"
//   });
//   $("#smartbanner.ios .sb-button").css({
//     "background-color": "#fff",
//     "color": "#007AFF !important",
//     "border": "1px solid #007AFF"
//   });
//   /* Android */
//   $("#smartbanner.android").css({
//     "border-color": "#ccc",
//     "border-top": "5px solid rgb(179, 200, 51)",
//     "border-bottom": "2px solid #d6d6d6",
//     "background": "#f5f5f5",
//     "box-shadow": "none",
//     "font-family": "Roboto,Arial,sans-serif",
//     "font-size": "13px",
//     "font-weight": "normal",
//     "color": "#8d8d8d"
//   });
//   $("#smartbanner.android .sb-close").css({
//     "color": "#999 !important",
//     "padding": "5px"
//   });
//   $("#smartbanner.android .sb-close:active").css({
//     "color": "#eee"
//   });
//   $("#smartbanner.android .sb-info").css({
//     "text-shadow": "none",
//     "font-weight": "normal"
//   });
//   $("#smartbanner.android .sb-info strong").css({
//     "color": "#333"
//   });
//   $("#smartbanner.android .sb-info .sb-price").css({
//     "color": "#b3c833"
//   });
//   $("#smartbanner.android .sb-button").css({
//     "min-width": "12%",
//     "border": "2px solid transparent",
//     "padding": "0",
//     "color": "#fff !important",
//     "border-radius": "2px",
//     "box-shadow": "0 1px 0 rgba(0,0,0,.2)",
//     "background": "#b3c833"
//   });
//   $("#smartbanner.android .sb-button span").css({
//     "display": "block",
//     "padding": "0 10px",
//     "text-transform": "none",
//     "text-shadow": "none"
//   });
//   $("#smartbanner.android .sb-button:active, #smartbanner.android .sb-button:hover").css({
//     "box-shadow": "0 1px 0 rgba(0,0,0,.4)"
//   });
//   $("#smartbanner.android .sb-button:active span, #smartbanner.android .sb-button:hover span").css({
//     "box-shadow": "0 1px 2px rgba(0,0,0,0.05)"
//   });
//   /* Windows RT */
//   $("#smartbanner.windows").css({
//     "background": "#464646",
//     "border-bottom": "8px solid #2a2a2a",
//     "font-family": "wf_SegoeUI,Segoe UI,Segoe,Segoe WP,Tahoma,Verdana,Arial,sans-serif",
//     "font-size": "14px",
//     "-webkit-font-smoothing": "antialiased"
//   });
//   $("#smartbanner.windows .sb-container").css({
//     "height": "100%",
//     "box-sizing": "border-box",
//     "border-bottom": "1px solid #00bcf2"
//   });
//   $("#smartbanner.windows .sb-icon").css({
//     "border-radius": "0px"
//   });
//   $("#smartbanner.windows .sb-info").css({
//     "color": "#fff",
//     "text-shadow": "none",
//     "font-weight": "normal"
//   });
//   $("#smartbanner.windows .sb-info strong").css({
//     "color": "#00bcf2",
//     "text-shadow": "0 0 2px #222"
//   });
//   $("#smartbanner.windows .sb-info .sb-price").css({
//     "color": "#00bcf2"
//   });
//   $("smartbanner.windows .sb-button").css({
//     "border-radius": "0",
//     "background": "#00bcf2",
//     "color": "#fff !important",
//     "border": "2px solid #00bcf2",
//     "box-shadow": "none",
//     "text-shadow": "none"
//   });
//   $("#smartbanner.windows .sb-button:hover").css({
//     "border": "2px solid rgba(0,0,0,0.2)"
//   });
//   $("#smartbanner.windows .sb-close").css({
//     "color": "#999 !important"
//   });
//   /* Windows Phone */
//   $("#smartbanner.windows-phone").css({
//     "background": "#464646",
//     "border-bottom": "8px solid #2a2a2a",
//     "font-family": "wf_SegoeUI,Segoe UI,Segoe,Segoe WP,Tahoma,Verdana,Arial,sans-serif",
//     "font-size": "14px",
//     "-webkit-font-smoothing": "antialiased"
//   });
//   $("#smartbanner.windows-phone .sb-container").css({
//     "height": "100%",
//     "box-sizing": "border-box",
//     "border-bottom": "1px solid #9B4F96"
//   });
//   $("#smartbanner.windows-phone .sb-icon").css({
//     "border-radius": "0px"
//   });
//   $("#smartbanner.windows-phone .sb-info").css({
//     "color": "#fff",
//     "text-shadow": "none",
//     "font-weight": "normal"
//   });
//   $("#smartbanner.windows-phone .sb-info strong").css({
//     "color": "#9B4F96",
//     "text-shadow": "0 0 2px #222"
//   });
//   $("#smartbanner.windows-phone .sb-info .sb-price").css({
//     "color": "#9B4F96"
//   });
//   $("#smartbanner.windows-phone .sb-button").css({
//     "border-radius": "0",
//     "background": "#9B4F96",
//     "color": "#fff !important",
//     "border": "2px solid #9B4F96",
//     "box-shadow": "none",
//     "text-shadow": "none"
//   });
//   $("#smartbanner.windows-phone .sb-button:hover").css({
//     "border": "2px solid rgba(0,0,0,0.2)"
//   });
//   $("#smartbanner.windows-phone .sb-close").css({
//     "color": "#999 !important"
//   });
// });
