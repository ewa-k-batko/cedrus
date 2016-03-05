/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


!function (a, b, c) {
    function d() {
        var a, b, d, e = 0;
        j.each(function (f) {
            b = c(this), a = 0 === b.position().top, a ? b.removeClass("nav-submenu-item") : f > 0 && (e++, b.addClass("nav-submenu-item"), b.removeClass("is-first-submenu-item"), l || p.append(l = c('<li class="nav-item ' + n + '-item-more"><a class="nav-item-link" href="#">Więcej</a></li>'))), a && (d = b), 0 === e && l && (l.remove(), l = null)
        }), d && d.addClass("nav-submenu-item is-first-submenu-item").before(l)
    }
    function e(a) {
        a ? o.addClass("nav-submenu-expanded") : o.removeClass("nav-submenu-expanded"), r = a
    }
    function f() {
        k && g(k, !1)
    }
    function g(a, d) {
        a && ("undefined" == typeof d && (d = !a.hasClass("expanded"), f()), d ? (k = a, a.addClass("expanded"), a.hasClass(n + "-item-more") && o.addClass("nav-more-expanded"), a.hasClass(n + "-item-more") && o.addClass("nav-more-expanded"), m.isGreaterThan("sm") && c(b).one(q, h)) : (o.find(".expanded").removeClass("expanded"), k = null, a.hasClass(n + "-item-more") && o.removeClass("nav-more-expanded")), e(d))
    }
    function h(a) {
        k && 0 === c(a.target).closest("." + n).length && (a.stopPropagation(), a.preventDefault(), f())
    }
    function i(a) {
        a.stopPropagation(), a.preventDefault();
        var b = c(this);
        b.hasClass("nav-submenu-item") ? b[b.hasClass("expanded") ? "removeClass" : "addClass"]("expanded") : g(b)
    }
    var j, k, l, m = (a.Inpl || {}).Grid, n = "nav-top", o = c("." + n), p = c("." + n + " > ." + n + "-list"), q = "click", r = !1;
    c(function () {
        j = c("." + n + " > ." + n + "-list > .nav-item"), o.on(q, "." + n + "-item-more, .nav-submenu-item.has-submenu", i), o.on(q, "li > .nav-top-list li", function (a) {
            a.stopImmediatePropagation()
        }), o.on(q, ".nav-item.nav-submenu-item", function (a) {
            c(a.currentTarget).hasClass("has-submenu") || f()
        }), o.on("mousemove", ".d1 > .has-submenu", function () {
            c(this).hasClass("nav-submenu-item") || f()
        }), c(a).lazyresize(d, 1), c(a).load(d), d()
    })
}(window, document, jQuery);




function(a,b){"use strict";function c(a,b,c){return"undefined"==typeof b?c>=a:"undefined"==typeof c?a>=b:a>=b&&c>=a}function d(a){b("body").removeClass("size-xs size-rs size-sm size-md size-lg").addClass("size-"+a.name)}a.Inpl=a.Inpl||{};var e=a.Inpl.Grid=a.Inpl.Grid||{},f=e.RANGE_XS="xs",g=e.RANGE_RS="rs",h=e.RANGE_SM="sm",i=e.RANGE_MD="md",j=e.RANGE_LG="lg",k=e.ranges=[{name:f,widthmax:479},{name:g,widthmin:480,widthmax:767},{name:h,widthmin:768,widthmax:999},{name:i,widthmin:1e3,widthmax:1297},{name:j,widthmin:1280,widthmax:9999}];b.fn.rangechange=function(c){if("function"==typeof c){var d,f,g=b(this),h=g.get(0),i=h.__ranges||k;"undefined"==typeof h.__rangechange&&(h.__rangechange=[],h.__rangechange.ranges=i,h.__rangechange.lastrange=e.getRangeName(g,i),b(a).lazyresize(function(){if(d=e.getRange(g,i),d&&d.name!==h.__rangechange.lastrange)for(h.__rangechange.lastrange=d.name,f=0;f<h.__rangechange.length;f++)h.__rangechange[f](d)})),h.__rangechange.push(c)}},e.getRange=function(d,e){e=e||k,d=d||b(a);var f,g,h=d.width(),i=e.length;for(g=0;i>g;g++)if(f=e[g],c(h,f.widthmin,f.widthmax))return f},e.getRangeName=function(a,b){var c=e.getRange(a,b);return c&&c.name?c.name:""},e.isGreaterThan=function(a,b){var c=e.getRangeByName(b)||e.getRange();return e.getRangeByName(a).widthmax<c.widthmax},e.isLessThan=function(a,b){var c=e.getRangeByName(b)||e.getRange();return e.getRangeByName(a).widthmax>c.widthmax},e.inRanges=function(a,b){for(var c=0;c<b.length;c++)if(a===b[c])return!0;return!1},e.getRangeByName=function(a){switch(a){case f:return k[0];case g:return k[1];case h:return k[2];case i:return k[3];case j:return k[4]}},d(e.getRange(b(a))),b(a).rangechange(d)}(window,jQuery);






var utils = utils || {};

utils.fluidTwitterEmbed = function () {
    var a, b = jQuery, c = 0, d = [], e = b(".embed-twitter");
    c = e.length, 0 >= c || (a = setInterval(function () {
        return e.each(function (a) {
            if (!(b.inArray(a, d) >= 0)) {
                var c, e = b(this).find(".twitter-tweet");
                e.length && e.hasClass("twitter-tweet-rendered") && (c = "" + e.attr("height")
                        , c.match(/[^\d]/) || (e.css({width: "100%"}).parent().css({width: "100%"}), d.push(a)))
            }
        }),
                d.length == c ? void clearInterval(a) : void 0
    }, 2e3))
};