!function (e) {
    "use strict";

    function t() {
        eltdf.scroll = e(window).scrollTop(), function () {
            var e = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor),
                t = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor),
                a = -1 < navigator.userAgent.toLowerCase().indexOf("firefox"),
                l = window.navigator.userAgent.indexOf("MSIE ");
            e && eltdf.body.addClass("eltdf-chrome");
            t && eltdf.body.addClass("eltdf-safari");
            a && eltdf.body.addClass("eltdf-firefox");
            (0 < l || navigator.userAgent.match(/Trident.*rv\:11\./)) && eltdf.body.addClass("eltdf-ms-explorer");
            /Edge\/\d./i.test(navigator.userAgent) && eltdf.body.addClass("eltdf-edge")
        }(), eltdf.body.hasClass("eltdf-dark-header") && (eltdf.defaultHeaderStyle = "eltdf-dark-header"), eltdf.body.hasClass("eltdf-light-header") && (eltdf.defaultHeaderStyle = "eltdf-light-header")
    }

    function a() {
    }

    function l() {
        eltdf.windowWidth = e(window).width(), eltdf.windowHeight = e(window).height()
    }

    function n() {
        eltdf.scroll = e(window).scrollTop()
    }

    switch (window.eltdf = {}, eltdf.modules = {}, eltdf.scroll = 0, eltdf.window = e(window), eltdf.document = e(document), eltdf.windowWidth = e(window).width(), eltdf.windowHeight = e(window).height(), eltdf.body = e("body"), eltdf.html = e("html, body"), eltdf.htmlEl = e("html"), eltdf.menuDropdownHeightSet = !1, eltdf.defaultHeaderStyle = "", eltdf.minVideoWidth = 1500, eltdf.videoWidthOriginal = 1280, eltdf.videoHeightOriginal = 720, eltdf.videoRatio = 1.61, eltdf.eltdfOnDocumentReady = t, eltdf.eltdfOnWindowLoad = a, eltdf.eltdfOnWindowResize = l, eltdf.eltdfOnWindowScroll = n, e(document).ready(t), e(window).load(a), e(window).resize(l), e(window).scroll(n), !0) {
        case eltdf.body.hasClass("eltdf-grid-1300"):
            eltdf.boxedLayoutWidth = 1350;
            break;
        case eltdf.body.hasClass("eltdf-grid-1200"):
            eltdf.boxedLayoutWidth = 1250;
            break;
        case eltdf.body.hasClass("eltdf-grid-1000"):
            eltdf.boxedLayoutWidth = 1050;
            break;
        case eltdf.body.hasClass("eltdf-grid-800"):
            eltdf.boxedLayoutWidth = 850;
            break;
        default:
            eltdf.boxedLayoutWidth = 1150
    }
    eltdf.gridWidth = function () {
        var e = 1100;
        switch (!0) {
            case eltdf.body.hasClass("eltdf-grid-1300") && 1400 < eltdf.windowWidth:
                e = 1300;
                break;
            case eltdf.body.hasClass("eltdf-grid-1200") && 1300 < eltdf.windowWidth:
            case eltdf.body.hasClass("eltdf-grid-1000") && 1200 < eltdf.windowWidth:
                e = 1200;
                break;
            case eltdf.body.hasClass("eltdf-grid-800") && 1024 < eltdf.windowWidth:
                e = 800
        }
        return e
    }, eltdf.transitionEnd = function () {
        var e = document.createElement("transitionDetector"),
            t = {WebkitTransition: "webkitTransitionEnd", MozTransition: "transitionend", transition: "transitionend"};
        for (var a in t) if (void 0 !== e.style[a]) return t[a]
    }(), eltdf.animationEnd = function () {
        var e = document.createElement("animationDetector"), t = {
            animation: "animationend",
            OAnimation: "oAnimationEnd",
            MozAnimation: "animationend",
            WebkitAnimation: "webkitAnimationEnd"
        };
        for (var a in t) if (void 0 !== e.style[a]) return t[a]
    }()
}(jQuery), function (T) {
    "use strict";
    var e = {};

    function t() {
        m().init(), -1 < navigator.appVersion.toLowerCase().indexOf("mac") && eltdf.body.hasClass("eltdf-smooth-scroll") && eltdf.body.removeClass("eltdf-smooth-scroll"), o().init(), T("#eltdf-back-to-top").on("click", function (e) {
            e.preventDefault(), eltdf.html.animate({scrollTop: 0}, eltdf.window.scrollTop() / 3, "linear")
        }), eltdf.window.scroll(function () {
            var e = T(this).scrollTop(), t = T(this).height();
            s((0 < e ? e + t / 2 : 1) < 1e3 ? "off" : "on")
        }), r(), P(), A(), p(), function () {
            var e = T(".eltdf-preload-background");
            e.length && e.each(function () {
                var e = T(this);
                if ("" !== e.css("background-image") && "none" !== e.css("background-image")) {
                    var t = e.attr("style");
                    if (t = (t = t.match(/url\(["']?([^'")]+)['"]?\)/)) ? t[1] : "") {
                        var a = new Image;
                        a.src = t, T(a).load(function () {
                            e.removeClass("eltdf-preload-background")
                        })
                    }
                } else T(window).load(function () {
                    e.removeClass("eltdf-preload-background")
                })
            })
        }(), f(), function () {
            var e = T(".eltdf-search-post-type");
            e.length && e.each(function () {
                var e = T(this), t = e.find(".eltdf-post-type-search-field"),
                    l = e.siblings(".eltdf-post-type-search-results"), n = e.find(".eltdf-search-loading"),
                    d = e.find(".eltdf-search-icon");
                n.addClass("eltdf-hidden");
                var i, o = e.data("post-type");
                t.on("keyup paste", function () {
                    var a = T(this);
                    a.attr("autocomplete", "off"), n.removeClass("eltdf-hidden"), d.addClass("eltdf-hidden"), clearTimeout(i), i = setTimeout(function () {
                        var e = a.val();
                        if (e.length < 3) l.html(""), l.fadeOut(), n.addClass("eltdf-hidden"), d.removeClass("eltdf-hidden"); else {
                            var t = {
                                action: "solene_elated_search_post_types",
                                term: e,
                                postType: o,
                                search_post_types_nonce: T('input[name="eltdf_search_post_types_nonce"]').val()
                            };
                            T.ajax({
                                type: "POST",
                                data: t,
                                url: eltdfGlobalVars.vars.eltdfAjaxUrl,
                                success: function (e) {
                                    var t = JSON.parse(e);
                                    "success" === t.status && (n.addClass("eltdf-hidden"), d.removeClass("eltdf-hidden"), l.html(t.data.html), l.fadeIn())
                                },
                                error: function (e, t, a) {
                                    console.log("Status: " + t), console.log("Error: " + a), n.addClass("eltdf-hidden"), d.removeClass("eltdf-hidden"), l.fadeOut()
                                }
                            })
                        }
                    }, 500)
                }), t.on("focusout", function () {
                    n.addClass("eltdf-hidden"), d.removeClass("eltdf-hidden"), l.fadeOut()
                })
            })
        }(), function () {
            var e = T(".eltdf-dashboard-form");
            e.length && e.each(function () {
                var e = T(this), n = e.find("button.eltdf-dashboard-form-button"), d = n.data("updating-text"),
                    i = n.data("updated-text"), o = e.data("action");
                e.on("submit", function (e) {
                    e.preventDefault();
                    var a = n.html(), t = T(this).find(".eltdf-dashboard-gallery-upload-hidden"), r = [];
                    n.html(d);
                    var f = new FormData;
                    t.each(function () {
                        var e, t = T(this), a = t.attr("name"), l = t.attr("id"), n = t[0].files;
                        if (-1 < a.indexOf("[")) {
                            e = a.substring(0, a.indexOf("[")) + "_eltdf_regarray_";
                            var d = l.indexOf("["), i = l.indexOf("]"), o = l.substring(d + 1, i);
                            r.push(e), e = e + o + "_"
                        } else e = a + "_eltdf_reg_";
                        0 === n.length && f.append(e, new File([""], "eltdf-dummy-file.txt", {type: "text/plain"}));
                        for (var s = 0; s < n.length; s++) {
                            1 === n[s].name.match(/\./g).length && -1 !== T.inArray(n[s].type, ["image/png", "image/jpg", "image/jpeg", "application/pdf"]) && f.append(e + s, n[s])
                        }
                    }), f.append("action", o);
                    var l = T(this).serialize();
                    return f.append("data", l), T.ajax({
                        type: "POST",
                        data: f,
                        contentType: !1,
                        processData: !1,
                        url: eltdfGlobalVars.vars.eltdfAjaxUrl,
                        success: function (e) {
                            var t;
                            t = JSON.parse(e), eltdf.modules.socialLogin.eltdfRenderAjaxResponseMessage(t), "success" === t.status ? (n.html(i), window.location = t.redirect) : n.html(a)
                        }
                    }), !1
                })
            })
        }(), c(), function () {
            if (eltdf.body.hasClass("eltdf-smooth-page-transitions")) {
                if (eltdf.body.hasClass("eltdf-smooth-page-transitions-preloader")) {
                    var l = T("body > .eltdf-smooth-transition-loader.eltdf-mimic-ajax"),
                        e = T("#eltdf-main-rev-holder"), t = function (t, e, a) {
                            t = t || 600, e = e || 0, a = a || "easeOutSine", l.delay(e).fadeOut(t, a), T(window).on("bind", "pageshow", function (e) {
                                e.originalEvent.persisted && l.fadeOut(t, a)
                            })
                        };
                    e.length ? 0 !== l.find(".eltdf-solene-spinner").length ? (setTimeout(function () {
                        l.css("z-index", 999)
                    }, 1e3), setTimeout(function () {
                        e.find("rs-module").revstart()
                    }, 1e3), T(window).on("scroll", function () {
                        1300 < eltdf.window.scrollTop() ? T(".eltdf-content").find(".eltdf-uncover-row").css({position: "fixed"}) : T(".eltdf-content").find(".eltdf-uncover-row").css({position: "static"})
                    })) : t(1e3, 1e3, "easeOutSine") : T(window).on("load", function () {
                        t()
                    })
                }
                if (window.addEventListener("pageshow", function (e) {
                    (e.persisted || void 0 !== window.performance && 2 === window.performance.navigation.type) && window.location.reload()
                }), eltdf.body.hasClass("eltdf-smooth-page-transitions-fadeout")) T("a").on("click", function (e) {
                    var t = T(this);
                    (t.parents(".eltdf-shopping-cart-dropdown").length || t.parent(".product-remove").length) && t.hasClass("remove") || t.parents(".woocommerce-product-gallery__image").length || 1 === e.which && 0 <= t.attr("href").indexOf(window.location.host) && void 0 === t.data("rel") && void 0 === t.attr("rel") && !t.hasClass("lightbox-active") && (void 0 === t.attr("target") || "_self" === t.attr("target")) && t.attr("href").split("#")[0] !== window.location.href.split("#")[0] && (e.preventDefault(), T(".eltdf-wrapper-inner").fadeOut(600, "easeOutSine", function () {
                        window.location = t.attr("href")
                    }))
                })
            }
        }(), function () {
            var e = T(".eltdf-has-appear-animation");
            e.length && e.each(function () {
                T(this).appear(function () {
                    T(this).addClass("eltdf-item-appear")
                }, {accX: 0, accY: 50})
            })
        }()
    }

    function a() {
        H(), function () {
            var e = T(".eltdf-owl-slider");
            e.length && e.each(function () {
                var e = T(this).find(".owl-dot");
                e.length && e.each(function () {
                    T(this).append('<svg class="eltdf-svg-circle"><circle cx="50%" cy="50%" r="45%"></circle></svg>')
                })
            })
        }(), h().init()
    }

    function l() {
        c(), P(), function () {
            var e = T(".eltdf-right-side-text");
            if (e.length) {
                var t = parseInt(e.css("bottom"), 10), a = e.width();
                e.css({bottom: a + t + "px", opacity: 1})
            }
        }()
    }

    function n(e) {
        i(e)
    }

    function d(e) {
        for (var t = [37, 38, 39, 40], a = t.length; a--;) if (e.keyCode === t[a]) return void i(e)
    }

    function i(e) {
        (e = e || window.event).preventDefault && e.preventDefault(), e.returnValue = !1
    }

    (eltdf.modules.common = e).eltdfFluidVideo = A, e.eltdfEnableScroll = function () {
        window.removeEventListener && window.removeEventListener("wheel", n, {passive: !1});
        window.onmousewheel = document.onmousewheel = document.onkeydown = null
    }, e.eltdfDisableScroll = function () {
        window.addEventListener && window.addEventListener("wheel", n, {passive: !1});
        document.onkeydown = d
    }, e.eltdfOwlSlider = p, e.eltdfInitParallax = H, e.eltdfInitSelfHostedVideoPlayer = r, e.eltdfSelfHostedVideoSize = P, e.eltdfPrettyPhoto = f, e.eltdfStickySidebarWidget = h, e.getLoadMoreData = function (e) {
        var t = e.data(), a = {};
        for (var l in t) t.hasOwnProperty(l) && void 0 !== t[l] && !1 !== t[l] && (a[l] = t[l]);
        return a
    }, e.setLoadMoreAjaxData = function (e, t) {
        var a = {action: t};
        for (var l in e) e.hasOwnProperty(l) && void 0 !== e[l] && !1 !== e[l] && (a[l] = e[l]);
        return a
    }, e.setFixedImageProportionSize = u, e.eltdfInitPerfectScrollbar = function () {
        var a = {wheelSpeed: .6, suppressScrollX: !0};
        return {
            init: function (e) {
                e.length && function (e) {
                    var t = new PerfectScrollbar(e.selector, a);
                    T(window).resize(function () {
                        t.update()
                    })
                }(e)
            }
        }
    }, e.eltdfBlurImage = function (e, d, i, o) {
        var s = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || window.msRequestAnimationFrame,
            r = window.cancelAnimationFrame || window.mozCancelAnimationFrame;
        i = i || 5, o = o || .03, T(e).on("mouseenter", function () {
            var a, l = T(this), n = 0;
            s(function e() {
                var t = i * (Math.sin(n += o) + 1 / i);
                if (0 != Math.round(a)) {
                    if (l.find(d).css({filter: "blur(" + t + "px)"}), a = t, !(Math.round(a) <= i + 1 / i)) return r(e), !1;
                    s(e)
                }
            }), T(e).on("mouseleave", function () {
                s(function e() {
                    var t = i * (Math.sin(n -= 1.5 * o) + 1 / i);
                    if (0 != Math.round(a)) {
                        if (l.find(d).css({filter: "blur(" + t + "px)"}), a = t, !(0 < Math.round(a))) return l.find(d).css({filter: "blur(0px)"}), r(e), !1;
                        s(e)
                    }
                })
            })
        })
    }, e.eltdfOnDocumentReady = t, e.eltdfOnWindowLoad = a, e.eltdfOnWindowResize = l, T(document).ready(t), T(window).load(a), T(window).resize(l);
    var o = function () {
        function i(t) {
            T(".eltdf-main-menu, .eltdf-mobile-nav, .eltdf-fullscreen-menu, .eltdf-vertical-menu").each(function () {
                var e = T(this);
                t.parents(e).length && (e.find(".eltdf-active-item").removeClass("eltdf-active-item"), t.parent().addClass("eltdf-active-item"), e.find("a").removeClass("current"), t.addClass("current"))
            })
        }

        var t = function (e) {
            var t, a = T(".eltdf-main-menu a, .eltdf-mobile-nav a, .eltdf-fullscreen-menu a, .eltdf-vertical-menu a"),
                l = e, n = "" !== l ? T('[data-eltdf-anchor="' + l + '"]') : "";
            if ("" !== l && 0 < n.length) {
                var d = n.offset().top;
                return t = d - o(d) - eltdfGlobalVars.vars.eltdfAddForAdminBar, a.length && a.each(function () {
                    var e = T(this);
                    -1 < e.attr("href").indexOf(l) && i(e)
                }), eltdf.html.stop().animate({scrollTop: Math.round(t)}, 1e3, function () {
                    history.pushState && history.pushState(null, "", "#" + l)
                }), !1
            }
        }, o = function (e) {
            "eltdf-sticky-header-on-scroll-down-up" === eltdf.modules.stickyHeader.behaviour && (eltdf.modules.stickyHeader.isStickyVisible = e > eltdf.modules.header.stickyAppearAmount), "eltdf-sticky-header-on-scroll-up" === eltdf.modules.stickyHeader.behaviour && e > eltdf.scroll && (eltdf.modules.stickyHeader.isStickyVisible = !1);
            var t = eltdf.modules.stickyHeader.isStickyVisible ? eltdfGlobalVars.vars.eltdfStickyHeaderTransparencyHeight : eltdfPerPageVars.vars.eltdfHeaderTransparencyHeight;
            return eltdf.windowWidth < 1025 && (t = 0), t
        };
        return {
            init: function () {
                T("[data-eltdf-anchor]").length && (eltdf.document.on("click", ".eltdf-main-menu a, .eltdf-fullscreen-menu a, a.eltdf-btn, .eltdf-anchor, .eltdf-mobile-nav a, .eltdf-vertical-menu a", function () {
                    var e, t = T(this), a = t.prop("hash").split("#")[1],
                        l = "" !== a ? T('[data-eltdf-anchor="' + a + '"]') : "";
                    if ("" !== a && 0 < l.length) {
                        var n = l.offset().top;
                        return e = n - o(n) - eltdfGlobalVars.vars.eltdfAddForAdminBar, i(t), eltdf.html.stop().animate({scrollTop: Math.round(e)}, 1e3, function () {
                            history.pushState && history.pushState(null, "", "#" + a)
                        }), !1
                    }
                }), function () {
                    var t, e = T("[data-eltdf-anchor]"), a = window.location.href.split("#")[0];
                    "/" !== a.substr(-1) && (a += "/"), e.waypoint(function (e) {
                        "down" === e && (t = 0 < T(this.element).length ? T(this.element).data("eltdf-anchor") : T(this).data("eltdf-anchor"), i(T("a[href='" + a + "#" + t + "']")))
                    }, {offset: "50%"}), e.waypoint(function (e) {
                        "up" === e && (t = 0 < T(this.element).length ? T(this.element).data("eltdf-anchor") : T(this).data("eltdf-anchor"), i(T("a[href='" + a + "#" + t + "']")))
                    }, {
                        offset: function () {
                            return -(T(this.element).outerHeight() - 150)
                        }
                    })
                }(), T(window).load(function () {
                    !function () {
                        var e = window.location.hash.split("#")[1];
                        "" !== e && 0 < T('[data-eltdf-anchor="' + e + '"]').length && t(e)
                    }()
                }))
            }
        }
    };

    function s(e) {
        var t = T("#eltdf-back-to-top");
        t.removeClass("off on"), "on" === e ? t.addClass("on") : t.addClass("off")
    }

    function r() {
        var e = T(".eltdf-self-hosted-video");
        e.length && e.mediaelementplayer({audioWidth: "100%"})
    }

    function P() {
        var e = T(".eltdf-self-hosted-video-holder .eltdf-video-wrap");
        e.length && e.each(function () {
            var e = T(this), t = e.closest(".eltdf-self-hosted-video-holder").outerWidth(), a = t / eltdf.videoRatio;
            navigator.userAgent.match(/(Android|iPod|iPhone|iPad|IEMobile|Opera Mini)/) && (e.parent().width(t), e.parent().height(a)), e.width(t), e.height(a), e.find("video, .mejs-overlay, .mejs-poster").width(t), e.find("video, .mejs-overlay, .mejs-poster").height(a)
        })
    }

    function A() {
        fluidvids.init({selector: ["iframe"], players: ["www.youtube.com", "player.vimeo.com"]})
    }

    function f() {
        var e = '<div class="pp_pic_holder">                         <div class="ppt">&nbsp;</div>                         <div class="pp_top">                             <div class="pp_left"></div>                             <div class="pp_middle"></div>                             <div class="pp_right"></div>                         </div>                         <div class="pp_content_container">                             <div class="pp_left">                             <div class="pp_right">                                 <div class="pp_content">                                     <div class="pp_loaderIcon"></div>                                     <div class="pp_fade">                                         <a href="#" class="pp_expand" title="' + eltdfGlobalVars.vars.ppExpand + '">' + eltdfGlobalVars.vars.ppExpand + '</a>                                         <div class="pp_hoverContainer">                                             <a class="pp_next" href="#"><span class="fa fa-angle-right"></span></a>                                             <a class="pp_previous" href="#"><span class="fa fa-angle-left"></span></a>                                         </div>                                         <div id="pp_full_res"></div>                                         <div class="pp_details">                                             <div class="pp_nav">                                                 <a href="#" class="pp_arrow_previous">' + eltdfGlobalVars.vars.ppPrev + '</a>                                                 <p class="currentTextHolder">0/0</p>                                                 <a href="#" class="pp_arrow_next">' + eltdfGlobalVars.vars.ppNext + '</a>                                             </div>                                             <p class="pp_description"></p>                                             {pp_social}                                             <a class="pp_close" href="#">' + eltdfGlobalVars.vars.ppClose + '</a>                                         </div>                                     </div>                                 </div>                             </div>                             </div>                         </div>                         <div class="pp_bottom">                             <div class="pp_left"></div>                             <div class="pp_middle"></div>                             <div class="pp_right"></div>                         </div>                     </div>                     <div class="pp_overlay"></div>';
        T("a[data-rel^='prettyPhoto']").prettyPhoto({
            hook: "data-rel",
            animation_speed: "normal",
            slideshow: !1,
            autoplay_slideshow: !1,
            opacity: 1,
            show_title: !0,
            allow_resize: !0,
            horizontal_padding: 0,
            default_width: 960,
            default_height: 540,
            counter_separator_label: "/",
            theme: "pp_default",
            hideflash: !1,
            wmode: "opaque",
            autoplay: !0,
            modal: !1,
            overlay_gallery: !1,
            keyboard_shortcuts: !0,
            deeplinking: !1,
            custom_markup: "",
            social_tools: !1,
            markup: e
        })
    }

    function c() {
        var e = T(".eltdf-grid-masonry-list");
        e.length && e.each(function () {
            var e = T(this), t = e.find(".eltdf-masonry-list-wrapper"), a = e.find(".eltdf-masonry-grid-sizer").width();
            t.waitForImages(function () {
                t.isotope({
                    layoutMode: "packery",
                    itemSelector: ".eltdf-item-space",
                    percentPosition: !0,
                    masonry: {columnWidth: ".eltdf-masonry-grid-sizer", gutter: ".eltdf-masonry-grid-gutter"}
                }), (e.find(".eltdf-fixed-masonry-item").length || e.hasClass("eltdf-fixed-masonry-items")) && u(t, t.find(".eltdf-item-space"), a, !0), setTimeout(function () {
                    H()
                }, 600), t.isotope("layout").css("opacity", 1)
            })
        })
    }

    function u(e, t, a, l) {
        if (e.hasClass("eltdf-masonry-images-fixed") || !0 === l) {
            var n = parseInt(t.css("paddingLeft"), 10), d = a - 2 * n, i = e.find(".eltdf-masonry-size-small"),
                o = e.find(".eltdf-masonry-size-large-width"), s = e.find(".eltdf-masonry-size-large-height"),
                r = e.find(".eltdf-masonry-size-large-width-height");
            i.css("height", d), s.css("height", Math.round(2 * (d + n))), 680 < eltdf.windowWidth ? (o.css("height", d), r.css("height", Math.round(2 * (d + n)))) : (o.css("height", Math.round(d / 2)), r.css("height", d))
        }
    }

    var m = function () {
        var e = T(".eltdf-icon-has-hover");
        return {
            init: function () {
                e.length && e.each(function () {
                    !function (e) {
                        if (void 0 !== e.data("hover-color")) {
                            var t = function (e) {
                                e.data.icon.css("color", e.data.color)
                            }, a = e.data("hover-color"), l = e.css("color");
                            "" !== a && (e.on("mouseenter", {icon: e, color: a}, t), e.on("mouseleave", {
                                icon: e,
                                color: l
                            }, t))
                        }
                    }(T(this))
                })
            }
        }
    };

    function H() {
        var e = T(".eltdf-parallax-row-holder");
        e.length && e.each(function () {
            var e = T(this), t = e.data("parallax-bg-image"), a = .4 * e.data("parallax-bg-speed"), l = 0;
            void 0 !== e.data("parallax-bg-height") && !1 !== e.data("parallax-bg-height") && (l = parseInt(e.data("parallax-bg-height"))), e.css({"background-image": "url(" + t + ")"}), 0 < l && e.css({
                "min-height": l + "px",
                height: l + "px"
            }), e.parallax("50%", a)
        })
    }

    function h() {
        var e = T(".eltdf-widget-sticky-sidebar"), t = T(".eltdf-page-header"), u = t.length ? t.outerHeight() : 0,
            i = 0, o = 0, s = 0, r = 0, m = [];

        function a() {
            m.length && T.each(m, function (e) {
                m[e].object;
                var t = m[e].offset, a = m[e].position, l = m[e].height, n = m[e].width, d = m[e].sidebarHolder,
                    i = m[e].sidebarHolderHeight;
                if (eltdf.body.hasClass("eltdf-fixed-on-scroll")) {
                    var o = T(".eltdf-fixed-wrapper.fixed");
                    o.length && (u = o.outerHeight() + eltdfGlobalVars.vars.eltdfAddForAdminBar)
                } else eltdf.body.hasClass("eltdf-no-behavior") && (u = eltdfGlobalVars.vars.eltdfAddForAdminBar);
                if (1024 < eltdf.windowWidth && d.length) {
                    var s = -(a - u), r = l - a - 40, f = i + t - u - a - eltdfGlobalVars.vars.eltdfTopBarHeight;
                    if (eltdf.scroll >= t - u && l < i) if (d.hasClass("eltdf-sticky-sidebar-appeared") ? d.css({top: s + "px"}) : d.addClass("eltdf-sticky-sidebar-appeared").css({
                        position: "fixed",
                        top: s + "px",
                        width: n,
                        "margin-top": "-10px"
                    }).animate({"margin-top": "0"}, 200), eltdf.scroll + r >= f) {
                        var c = i - r + s - u;
                        d.css({position: "absolute", top: c + "px"})
                    } else d.hasClass("eltdf-sticky-sidebar-appeared") && d.css({
                        position: "fixed",
                        top: s + "px"
                    }); else d.removeClass("eltdf-sticky-sidebar-appeared").css({
                        position: "relative",
                        top: "0",
                        width: "auto"
                    })
                } else d.removeClass("eltdf-sticky-sidebar-appeared").css({
                    position: "relative",
                    top: "0",
                    width: "auto"
                })
            })
        }

        return {
            init: function () {
                e.length && e.each(function () {
                    var e = T(this), t = e.parents("aside.eltdf-sidebar"), a = e.parents(".wpb_widgetised_column"),
                        l = "", n = 0;
                    if (i = e.offset().top, o = e.position().top, r = s = 0, t.length) {
                        s = t.outerHeight(), r = t.outerWidth(), n = (l = t).parent().parent().outerHeight();
                        var d = t.parent().parent().find(".eltdf-blog-holder");
                        d.length && (n -= parseInt(d.css("marginBottom")))
                    } else a.length && (s = a.outerHeight(), r = a.outerWidth(), n = (l = a).parents(".vc_row").outerHeight());
                    m.push({
                        object: e,
                        offset: i,
                        position: o,
                        height: s,
                        width: r,
                        sidebarHolder: l,
                        sidebarHolderHeight: n
                    })
                }), a(), T(window).scroll(function () {
                    a()
                })
            }, reInit: a
        }
    }

    function p() {
        var e = T(".eltdf-owl-slider");
        e.length && e.each(function () {
            var a, t = T(this), e = T(this), l = t.children().length, n = 1, d = !0, i = !0, o = !0, s = 5e3, r = 600,
                f = 0, c = 0, u = 0, m = 0, h = !1, p = !1, g = !1, v = !1, y = !1, w = !0, b = !1, C = !1,
                x = !!t.hasClass("eltdf-list-is-slider"), k = x ? t.parent() : t;
            if (void 0 === t.data("number-of-items") || !1 === t.data("number-of-items") || x || (n = t.data("number-of-items")), void 0 !== k.data("number-of-columns") && !1 !== k.data("number-of-columns") && x) switch (k.data("number-of-columns")) {
                case"one":
                    n = 1;
                    break;
                case"two":
                    n = 2;
                    break;
                case"three":
                    n = 3;
                    break;
                case"four":
                    n = 4;
                    break;
                case"five":
                    n = 5;
                    break;
                case"six":
                    n = 6;
                    break;
                default:
                    n = 4
            }
            "no" === k.data("enable-loop") && (d = !1), "no" === k.data("enable-autoplay") && (i = !1), "no" === k.data("enable-autoplay-hover-pause") && (o = !1), void 0 !== k.data("slider-speed") && !1 !== k.data("slider-speed") && (s = k.data("slider-speed")), void 0 !== k.data("slider-speed-animation") && !1 !== k.data("slider-speed-animation") && (r = k.data("slider-speed-animation")), void 0 !== k.data("slider-margin") && !1 !== k.data("slider-margin") ? f = "no" === k.data("slider-margin") ? 0 : k.data("slider-margin") : t.parent().hasClass("eltdf-huge-space") ? f = 54 : t.parent().hasClass("eltdf-large-space") ? f = 25 : t.parent().hasClass("eltdf-medium-space") ? f = 20 : t.parent().hasClass("eltdf-normal-space") ? f = 15 : t.parent().hasClass("eltdf-small-space") ? f = 10 : t.parent().hasClass("eltdf-tiny-space") && (f = 5), "yes" === k.data("slider-padding") && (h = !0, m = parseInt(.28 * t.outerWidth()), f = 50), "yes" === k.data("enable-center") && (p = !0), "yes" === k.data("enable-auto-width") && (g = !0), void 0 !== k.data("slider-animate-in") && !1 !== k.data("slider-animate-in") && (v = k.data("slider-animate-in")), void 0 !== k.data("slider-animate-out") && !1 !== k.data("slider-animate-out") && (y = k.data("slider-animate-out")), "no" === k.data("enable-navigation") && (w = !1), "yes" === k.data("enable-pagination") && (b = !0), "yes" === k.data("enable-thumbnail") && (C = !0), C && !b && (b = !0, e.addClass("eltdf-slider-hide-pagination")), w && b && t.addClass("eltdf-slider-has-both-nav"), l <= 1 && (b = w = i = d = !1);
            var I = 2, S = 3, _ = n, O = n;
            if (n < 3 && (S = I = n), 4 < n && (_ = 4), 5 < n && (O = 5), (h || 30 < f) && (c = 20, u = 30), 0 < f && f <= 30 && (u = c = f), t.waitForImages(function () {
                e = t.owlCarousel({
                    items: n,
                    loop: d,
                    autoplay: i,
                    autoplayHoverPause: o,
                    autoplayTimeout: s,
                    smartSpeed: r,
                    margin: f,
                    stagePadding: m,
                    center: p,
                    autoWidth: g,
                    animateIn: v,
                    animateOut: y,
                    dots: b,
                    nav: w,
                    navText: ['<span class="eltdf-prev-icon">' + eltdfGlobalVars.vars.sliderNavPrevArrow + "</span>", '<span class="eltdf-next-icon">' + eltdfGlobalVars.vars.sliderNavNextArrow + "</span>"],
                    responsive: {
                        0: {items: 1, margin: c, stagePadding: 0, center: !1, autoWidth: !1},
                        681: {items: I, margin: u},
                        769: {items: S, margin: u},
                        1025: {items: _},
                        1281: {items: O},
                        1367: {items: n}
                    },
                    onInitialize: function () {
                        t.css("visibility", "visible"), H(), (t.find("iframe").length || t.find("video").length) && setTimeout(function () {
                            P(), A()
                        }, 500), C && a.find(".eltdf-slider-thumbnail-item:first-child").addClass("active")
                    },
                    onRefreshed: function () {
                        if (!0 === g) {
                            var e = parseInt(t.find(".owl-stage").css("width"));
                            t.find(".owl-stage").css("width", e + 1 + "px")
                        }
                    },
                    onTranslate: function (e) {
                        if (C) {
                            var t = e.page.index + 1;
                            a.find(".eltdf-slider-thumbnail-item.active").removeClass("active"), a.find(".eltdf-slider-thumbnail-item:nth-child(" + t + ")").addClass("active")
                        }
                    },
                    onDrag: function (e) {
                        eltdf.body.hasClass("eltdf-smooth-page-transitions-fadeout") && 0 < e.isTrigger && t.addClass("eltdf-slider-is-moving")
                    },
                    onDragged: function () {
                        eltdf.body.hasClass("eltdf-smooth-page-transitions-fadeout") && t.hasClass("eltdf-slider-is-moving") && setTimeout(function () {
                            t.removeClass("eltdf-slider-is-moving")
                        }, 500)
                    }
                })
            }), C) {
                a = t.parent().find(".eltdf-slider-thumbnail");
                var D = "";
                switch (parseInt(a.data("thumbnail-count")) % 6) {
                    case 2:
                        D = "two";
                        break;
                    case 3:
                        D = "three";
                        break;
                    case 4:
                        D = "four";
                        break;
                    case 5:
                        D = "five";
                        break;
                    case 0:
                    default:
                        D = "six"
                }
                "" !== D && a.addClass("eltdf-slider-columns-" + D), a.find(".eltdf-slider-thumbnail-item").on("click", function () {
                    T(this).siblings(".active").removeClass("active"), T(this).addClass("active"), e.trigger("to.owl.carousel", [T(this).index(), r])
                })
            }
        })
    }
}(jQuery), function (f) {
    "use strict";
    var e = {};

    function t() {
        c()
    }

    function a() {
        n().init()
    }

    function l() {
        n().scroll()
    }

    function c() {
        var e = f("audio.eltdf-blog-audio");
        e.length && e.mediaelementplayer({audioWidth: "100%"})
    }

    function n() {
        function t(e) {
            var t = e.outerHeight() + e.offset().top - eltdfGlobalVars.vars.eltdfAddForAdminBar;
            !e.hasClass("eltdf-blog-pagination-infinite-scroll-started") && eltdf.scroll + eltdf.windowHeight > t && a(e)
        }

        var e = f(".eltdf-blog-holder"), a = function (a) {
            var l, e, n = a.children(".eltdf-blog-holder-inner");
            void 0 !== a.data("max-num-pages") && !1 !== a.data("max-num-pages") && (e = a.data("max-num-pages")), a.hasClass("eltdf-blog-pagination-infinite-scroll") && a.addClass("eltdf-blog-pagination-infinite-scroll-started");
            var t = eltdf.modules.common.getLoadMoreData(a), d = a.find(".eltdf-blog-pag-loading");
            l = t.nextPage;
            var i = a.find('input[name*="eltdf_blog_load_more_nonce_"]');
            if (t.blog_load_more_id = i.attr("name").substring(i.attr("name").length - 4, i.attr("name").length), t.blog_load_more_nonce = i.val(), l <= e) {
                d.addClass("eltdf-showing");
                var o = eltdf.modules.common.setLoadMoreAjaxData(t, "solene_elated_blog_load_more");
                f.ajax({
                    type: "POST", data: o, url: eltdfGlobalVars.vars.eltdfAjaxUrl, success: function (e) {
                        l++, a.data("next-page", l);
                        var t = f.parseJSON(e).html;
                        a.waitForImages(function () {
                            a.hasClass("eltdf-grid-masonry-list") ? (s(n, d, t), eltdf.modules.common.setFixedImageProportionSize(a, a.find("article"), n.find(".eltdf-masonry-grid-sizer").width())) : r(n, d, t), setTimeout(function () {
                                c(), eltdf.modules.common.eltdfOwlSlider(), eltdf.modules.common.eltdfFluidVideo(), eltdf.modules.common.eltdfInitSelfHostedVideoPlayer(), eltdf.modules.common.eltdfSelfHostedVideoSize(), "function" == typeof eltdf.modules.common.eltdfStickySidebarWidget && eltdf.modules.common.eltdfStickySidebarWidget().reInit(), f(document.body).trigger("blog_list_load_more_trigger")
                            }, 400)
                        }), a.hasClass("eltdf-blog-pagination-infinite-scroll-started") && a.removeClass("eltdf-blog-pagination-infinite-scroll-started")
                    }
                })
            }
            l === e && a.find(".eltdf-blog-pag-load-more").hide()
        }, s = function (e, t, a) {
            e.append(a).isotope("reloadItems").isotope({sortBy: "original-order"}), t.removeClass("eltdf-showing"), setTimeout(function () {
                e.isotope("layout")
            }, 600)
        }, r = function (e, t, a) {
            t.removeClass("eltdf-showing"), e.append(a)
        };
        return {
            init: function () {
                e.length && e.each(function () {
                    var e = f(this);
                    e.hasClass("eltdf-blog-pagination-load-more") && function (t) {
                        t.find(".eltdf-blog-pag-load-more a").on("click", function (e) {
                            e.preventDefault(), e.stopPropagation(), a(t)
                        })
                    }(e), e.hasClass("eltdf-blog-pagination-infinite-scroll") && t(e)
                })
            }, scroll: function () {
                e.length && e.each(function () {
                    var e = f(this);
                    e.hasClass("eltdf-blog-pagination-infinite-scroll") && t(e)
                })
            }
        }
    }

    (eltdf.modules.blog = e).eltdfOnDocumentReady = t, e.eltdfOnWindowLoad = a, e.eltdfOnWindowScroll = l, f(document).ready(t), f(window).load(a), f(window).scroll(l)
}(jQuery), function (n) {
    "use strict";
    var e = {};

    function t() {
        !function () {
            if (n("body:not(.error404) .eltdf-footer-uncover").length && !eltdf.htmlEl.hasClass("touch")) {
                var e = n("footer"), t = e.outerHeight(), a = n(".eltdf-content"), l = function () {
                    a.css("margin-bottom", t), e.css("height", t)
                };
                l(), n(window).resize(function () {
                    t = e.find(".eltdf-footer-inner").outerHeight(), l()
                })
            }
        }()
    }

    (eltdf.modules.footer = e).eltdfOnWindowLoad = t, n(window).load(t)
}(jQuery), function (s) {
    "use strict";
    var e = {};

    function t() {
        l(), setTimeout(function () {
            s(".eltdf-drop-down > ul > li").each(function () {
                var i = s(this);
                i.find(".second").length && i.waitForImages(function () {
                    var e = i.find(".second"), t = eltdf.menuDropdownHeightSet ? 0 : e.outerHeight();
                    if (i.hasClass("wide")) {
                        var a = 0, l = e.find("> .inner > ul > li");
                        l.each(function () {
                            var e = s(this).outerHeight();
                            a < e && (a = e)
                        }), l.css("height", "").height(a), eltdf.menuDropdownHeightSet || (t = e.outerHeight())
                    }
                    if (eltdf.menuDropdownHeightSet || e.height(0), navigator.userAgent.match(/(iPod|iPhone|iPad)/)) i.on("touchstart mouseenter", function () {
                        e.css({height: t, overflow: "visible", visibility: "visible", opacity: "1"})
                    }).on("mouseleave", function () {
                        e.css({height: "0px", overflow: "hidden", visibility: "hidden", opacity: "0"})
                    }); else if (eltdf.body.hasClass("eltdf-dropdown-animate-height")) {
                        var n = {
                            interval: 0, over: function () {
                                setTimeout(function () {
                                    e.addClass("eltdf-drop-down-start").css({
                                        visibility: "visible",
                                        height: "0",
                                        opacity: "1"
                                    }), e.stop().animate({height: t}, 400, "easeInOutQuint", function () {
                                        e.css("overflow", "visible")
                                    })
                                }, 100)
                            }, timeout: 100, out: function () {
                                e.stop().animate({height: "0", opacity: 0}, 100, function () {
                                    e.css({overflow: "hidden", visibility: "hidden"})
                                }), e.removeClass("eltdf-drop-down-start")
                            }
                        };
                        i.hoverIntent(n)
                    } else {
                        var d = {
                            interval: 0, over: function () {
                                setTimeout(function () {
                                    e.addClass("eltdf-drop-down-start").stop().css({height: t})
                                }, 150)
                            }, timeout: 150, out: function () {
                                e.stop().css({height: "0"}).removeClass("eltdf-drop-down-start")
                            }
                        };
                        i.hoverIntent(d)
                    }
                })
            }), s(".eltdf-drop-down ul li.wide ul li a").on("click", function (e) {
                if (1 === e.which) {
                    var t = s(this);
                    setTimeout(function () {
                        t.mouseleave()
                    }, 500)
                }
            }), eltdf.menuDropdownHeightSet = !0
        }, 100)
    }

    function a() {
        n()
    }

    function l() {
        var e = s(".eltdf-drop-down > ul > li.narrow.menu-item-has-children");
        e.length && e.each(function (e) {
            var t, a = s(this), l = a.offset().left, n = a.find(".second"), d = n.find(".inner ul"), i = d.outerWidth(),
                o = eltdf.windowWidth - l;
            eltdf.body.hasClass("eltdf-boxed") && (o = eltdf.boxedLayoutWidth - (l - (eltdf.windowWidth - eltdf.boxedLayoutWidth) / 2)), 0 < a.find("li.sub").length && (t = o - i), n.removeClass("right"), d.removeClass("right"), (o < i || t < i) && (n.addClass("right"), d.addClass("right"))
        })
    }

    function n() {
        var e = s(".eltdf-drop-down > ul > li.wide");
        e.length && e.each(function (e) {
            var t = s(this).find(".second");
            if (t.length && !t.hasClass("left_position") && !t.hasClass("right_position")) {
                t.css("left", 0);
                var a = t.offset().left;
                if (eltdf.body.hasClass("eltdf-boxed")) {
                    var l = s(".eltdf-boxed .eltdf-wrapper .eltdf-wrapper-inner").outerWidth();
                    a -= (eltdf.windowWidth - l) / 2, t.css({left: -a, width: l})
                } else eltdf.body.hasClass("eltdf-wide-dropdown-menu-in-grid") ? t.css({
                    left: -a + (eltdf.windowWidth - eltdf.gridWidth()) / 2,
                    width: eltdf.gridWidth()
                }) : t.css({left: -a, width: eltdf.windowWidth})
            }
        })
    }

    (eltdf.modules.header = e).eltdfSetDropDownMenuPosition = l, e.eltdfSetDropDownWideMenuPosition = n, e.eltdfOnDocumentReady = t, e.eltdfOnWindowLoad = a, s(document).ready(t), s(window).load(a)
}(jQuery), function (f) {
    "use strict";
    var e = {};

    function t() {
        !function () {
            var l, n = f(".eltdf-wrapper"), d = f(".eltdf-side-menu"), i = f("a.eltdf-side-menu-button-opener"), o = !1,
                s = !1, r = !1;
            eltdf.body.hasClass("eltdf-side-menu-slide-from-right") ? (f(".eltdf-cover").remove(), l = "eltdf-right-side-menu-opened", n.prepend('<div class="eltdf-cover"/>'), o = !0) : eltdf.body.hasClass("eltdf-side-menu-slide-with-content") ? (l = "eltdf-side-menu-open", s = !0) : eltdf.body.hasClass("eltdf-side-area-uncovered-from-content") && (l = "eltdf-right-side-menu-opened", r = !0);
            f("a.eltdf-side-menu-button-opener, a.eltdf-close-side-menu").on("click", function (e) {
                if (e.preventDefault(), n.one("wheel", function () {
                    i.hasClass("opened") && (eltdf.modules.common.eltdfEnableScroll(), i.removeClass("opened"), eltdf.body.removeClass("eltdf-side-menu-open"))
                }), i.hasClass("opened")) {
                    if (eltdf.modules.common.eltdfEnableScroll(), i.removeClass("opened"), eltdf.body.removeClass(l), r) var t = setTimeout(function () {
                        d.css({visibility: "hidden"}), clearTimeout(t)
                    }, 400)
                } else {
                    eltdf.modules.common.eltdfDisableScroll(), i.addClass("opened"), eltdf.body.addClass(l), o && f(".eltdf-wrapper .eltdf-cover").on("click", function () {
                        eltdf.modules.common.eltdfEnableScroll(), eltdf.body.removeClass("eltdf-right-side-menu-opened"), i.removeClass("opened")
                    }), r && d.css({visibility: "visible"});
                    var a = f(window).scrollTop();
                    f(window).scroll(function () {
                        if (400 < Math.abs(eltdf.scroll - a) && (eltdf.modules.common.eltdfEnableScroll(), eltdf.body.removeClass(l), i.removeClass("opened"), r)) var e = setTimeout(function () {
                            d.css({visibility: "hidden"}), clearTimeout(e)
                        }, 400)
                    })
                }
                s && (e.stopPropagation(), n.on("click", function () {
                    e.preventDefault(), eltdf.modules.common.eltdfEnableScroll(), i.removeClass("opened"), eltdf.body.removeClass("eltdf-side-menu-open")
                }))
            }), d.length && eltdf.modules.common.eltdfInitPerfectScrollbar().init(d)
        }()
    }

    (eltdf.modules.sidearea = e).eltdfOnDocumentReady = t, f(document).ready(t)
}(jQuery), function (o) {
    "use strict";
    var e = {};

    function t() {
        !function () {
            var e = o(".eltdf-subscribe-popup-holder"), t = o(".eltdf-sp-close");
            if (e.length) {
                var a = e.find(".eltdf-sp-prevent"), l = "no";
                if (a.length) {
                    var n = e.hasClass("eltdf-sp-prevent-cookies"), d = a.find(".eltdf-sp-prevent-input"),
                        i = d.data("value");
                    n ? (l = localStorage.getItem("disabledPopup"), sessionStorage.removeItem("disabledPopup")) : (l = sessionStorage.getItem("disabledPopup"), localStorage.removeItem("disabledPopup")), a.children().on("click", function (e) {
                        "yes" !== i ? (i = "yes", d.addClass("eltdf-sp-prevent-clicked").data("value", "yes")) : (i = "no", d.removeClass("eltdf-sp-prevent-clicked").data("value", "no")), "yes" === i ? n ? localStorage.setItem("disabledPopup", "yes") : sessionStorage.setItem("disabledPopup", "yes") : n ? localStorage.setItem("disabledPopup", "no") : sessionStorage.setItem("disabledPopup", "no")
                    })
                }
                "yes" !== l && (eltdf.body.hasClass("eltdf-sp-opened") ? (eltdf.body.removeClass("eltdf-sp-opened"), eltdf.modules.common.eltdfEnableScroll()) : (eltdf.body.addClass("eltdf-sp-opened"), eltdf.modules.common.eltdfDisableScroll()), t.on("click", function (e) {
                    e.preventDefault(), eltdf.body.removeClass("eltdf-sp-opened"), eltdf.modules.common.eltdfEnableScroll()
                }), o(document).keyup(function (e) {
                    27 === e.keyCode && (eltdf.body.removeClass("eltdf-sp-opened"), eltdf.modules.common.eltdfEnableScroll())
                }))
            }
        }()
    }

    (eltdf.modules.subscribePopup = e).eltdfOnWindowLoad = t, o(window).load(t)
}(jQuery), function (o) {
    "use strict";
    var e = {};

    function t() {
        !function () {
            var e = o(".eltdf-title-holder.eltdf-bg-parallax");
            if (0 < e.length && 1024 < eltdf.windowWidth) {
                var t = e.hasClass("eltdf-bg-parallax-zoom-out"), a = parseInt(e.data("height")),
                    l = parseInt(e.data("background-width")), n = a / 1e4 * 7, d = -eltdf.scroll * n,
                    i = eltdfGlobalVars.vars.eltdfAddForAdminBar;
                e.css({"background-position": "center " + (d + i) + "px"}), t && e.css({"background-size": l - eltdf.scroll + "px auto"}), o(window).scroll(function () {
                    d = -eltdf.scroll * n, e.css({"background-position": "center " + (d + i) + "px"}), t && e.css({"background-size": l - eltdf.scroll + "px auto"})
                })
            }
        }()
    }

    (eltdf.modules.title = e).eltdfOnDocumentReady = t, o(document).ready(t)
}(jQuery), function (s) {
    "use strict";
    var e = {};

    function t() {
        s(document).on("click", ".eltdf-quantity-minus, .eltdf-quantity-plus", function (e) {
            e.stopPropagation();
            var t, a = s(this), l = a.siblings(".eltdf-quantity-input"), n = parseFloat(l.data("step")),
                d = parseFloat(l.data("max")), i = !1, o = parseFloat(l.val());
            a.hasClass("eltdf-quantity-minus") && (i = !0), i ? 1 <= (t = o - n) ? l.val(t) : l.val(0) : (t = o + n, void 0 === d ? l.val(t) : d <= t ? l.val(d) : l.val(t)), l.trigger("change")
        }), function () {
            var e = s(".woocommerce-ordering .orderby");
            e.length && e.select2({minimumResultsForSearch: 1 / 0});
            var t = s(".eltdf-woocommerce-page .eltdf-content .variations td.value select");
            t.length && t.select2();
            var a = s("#calc_shipping_country");
            a.length && a.select2();
            var l = s(".cart-collaterals .shipping select#calc_shipping_state");
            l.length && l.select2();
            var n = s(".widget.widget_archive select, .widget.widget_categories select, .widget.widget_text select");
            n.length && "function" == typeof n.select2 && n.select2()
        }(), function () {
            var e = s(".eltdf-woo-single-page.eltdf-woo-single-has-pretty-photo .images .woocommerce-product-gallery__image");
            e.length && (e.children("a").attr("data-rel", "prettyPhoto[woo_single_pretty_photo]"), "function" == typeof eltdf.modules.common.eltdfPrettyPhoto && eltdf.modules.common.eltdfPrettyPhoto())
        }()
    }

    (eltdf.modules.woocommerce = e).eltdfOnDocumentReady = t, s(document).ready(t)
}(jQuery), function (h) {
    "use strict";
    var e = {};

    function t() {
        l().init()
    }

    function a() {
        l().scroll()
    }

    function l() {
        function t(e) {
            var t = e.outerHeight() + e.offset().top - eltdfGlobalVars.vars.eltdfAddForAdminBar;
            !e.hasClass("eltdf-bl-pag-infinite-scroll-started") && eltdf.scroll + eltdf.windowHeight > t && n(e)
        }

        var e = h(".eltdf-blog-list-holder"), n = function (a, e) {
            var l, n, d = a.find(".eltdf-blog-list");
            void 0 !== a.data("max-num-pages") && !1 !== a.data("max-num-pages") && (n = a.data("max-num-pages")), a.hasClass("eltdf-bl-pag-standard-shortcodes") && a.data("next-page", e), a.hasClass("eltdf-bl-pag-infinite-scroll") && a.addClass("eltdf-bl-pag-infinite-scroll-started");
            var t = eltdf.modules.common.getLoadMoreData(a), i = a.find(".eltdf-blog-pag-loading");
            l = t.nextPage;
            var o = a.find('input[name*="eltdf_blog_load_more_nonce_"]');
            if (t.blog_load_more_id = o.attr("name").substring(o.attr("name").length - 4, o.attr("name").length), t.blog_load_more_nonce = o.val(), l <= n) {
                a.hasClass("eltdf-bl-pag-standard-shortcodes") ? (i.addClass("eltdf-showing eltdf-standard-pag-trigger"), a.addClass("eltdf-bl-pag-standard-shortcodes-animate")) : i.addClass("eltdf-showing");
                var s = eltdf.modules.common.setLoadMoreAjaxData(t, "solene_elated_blog_shortcode_load_more");
                h.ajax({
                    type: "POST", data: s, url: eltdfGlobalVars.vars.eltdfAjaxUrl, success: function (e) {
                        a.hasClass("eltdf-bl-pag-standard-shortcodes") || l++, a.data("next-page", l);
                        var t = h.parseJSON(e).html;
                        a.hasClass("eltdf-bl-pag-standard-shortcodes") ? (r(a, n, l), a.waitForImages(function () {
                            a.hasClass("eltdf-bl-masonry") ? f(a, d, i, t) : (c(a, d, i, t), "function" == typeof eltdf.modules.common.eltdfStickySidebarWidget && eltdf.modules.common.eltdfStickySidebarWidget().reInit())
                        })) : a.waitForImages(function () {
                            a.hasClass("eltdf-bl-masonry") ? u(d, i, t) : (m(d, i, t), "function" == typeof eltdf.modules.common.eltdfStickySidebarWidget && eltdf.modules.common.eltdfStickySidebarWidget().reInit())
                        }), a.hasClass("eltdf-bl-pag-infinite-scroll-started") && a.removeClass("eltdf-bl-pag-infinite-scroll-started")
                    }
                })
            }
            l === n && a.find(".eltdf-blog-pag-load-more").hide()
        }, r = function (e, t, a) {
            var l = e.find(".eltdf-bl-standard-pagination"), n = l.find("li.eltdf-pag-number"),
                d = l.find("li.eltdf-pag-prev a"), i = l.find("li.eltdf-pag-next a");
            n.removeClass("eltdf-pag-active"), n.eq(a - 1).addClass("eltdf-pag-active"), d.data("paged", a - 1), i.data("paged", a + 1), 1 < a ? d.css({opacity: "1"}) : d.css({opacity: "0"}), a === t ? i.css({opacity: "0"}) : i.css({opacity: "1"})
        }, f = function (e, t, a, l) {
            var n = "";
            t.children('[class*="-grid-sizer"]').length && (n += t.children('[class*="-grid-sizer"]')[0].outerHTML), t.children('[class*="-grid-gutter"]').length && (n += t.children('[class*="-grid-gutter"]')[0].outerHTML), t.html(n + l).isotope("reloadItems").isotope({sortBy: "original-order"}), a.removeClass("eltdf-showing eltdf-standard-pag-trigger"), e.removeClass("eltdf-bl-pag-standard-shortcodes-animate"), setTimeout(function () {
                t.isotope("layout"), "function" == typeof eltdf.modules.common.eltdfStickySidebarWidget && eltdf.modules.common.eltdfStickySidebarWidget().reInit()
            }, 600)
        }, c = function (e, t, a, l) {
            a.removeClass("eltdf-showing eltdf-standard-pag-trigger"), e.removeClass("eltdf-bl-pag-standard-shortcodes-animate"), t.html(l)
        }, u = function (e, t, a) {
            e.append(a).isotope("reloadItems").isotope({sortBy: "original-order"}), t.removeClass("eltdf-showing"), setTimeout(function () {
                e.isotope("layout"), "function" == typeof eltdf.modules.common.eltdfStickySidebarWidget && eltdf.modules.common.eltdfStickySidebarWidget().reInit()
            }, 600)
        }, m = function (e, t, a) {
            t.removeClass("eltdf-showing"), e.append(a)
        };
        return {
            init: function () {
                e.length && e.each(function () {
                    var e = h(this);
                    e.hasClass("eltdf-bl-pag-standard-shortcodes") && function (l) {
                        var e = l.find(".eltdf-bl-standard-pagination li");
                        e.length && e.each(function () {
                            var t = h(this).children("a"), a = 1;
                            t.on("click", function (e) {
                                e.preventDefault(), e.stopPropagation(), void 0 !== t.data("paged") && !1 !== t.data("paged") && (a = t.data("paged")), n(l, a)
                            })
                        })
                    }(e), e.hasClass("eltdf-bl-pag-load-more") && function (t) {
                        t.find(".eltdf-blog-pag-load-more a").on("click", function (e) {
                            e.preventDefault(), e.stopPropagation(), n(t)
                        })
                    }(e), e.hasClass("eltdf-bl-pag-infinite-scroll") && t(e)
                })
            }, scroll: function () {
                e.length && e.each(function () {
                    var e = h(this);
                    e.hasClass("eltdf-bl-pag-infinite-scroll") && t(e)
                })
            }
        }
    }

    (eltdf.modules.blogListSC = e).eltdfOnWindowLoad = t, e.eltdfOnWindowScroll = a, h(window).load(t), h(window).scroll(a)
}(jQuery), function (e) {
    "use strict";
    var t = {};

    function a() {
        n()
    }

    function l() {
        n()
    }

    function n() {
        if (eltdf.body.hasClass("eltdf-header-divided")) {
            var t = e(".eltdf-menu-area, .eltdf-sticky-header"), a = t.width(),
                l = parseInt(t.find(".eltdf-vertical-align-containers").css("paddingLeft"), 10),
                n = e(".eltdf-main-menu > ul > li > a"), d = 0, i = t.find(".eltdf-logo-wrapper .eltdf-normal-logo"),
                o = 0;
            t.waitForImages(function () {
                t.find(".eltdf-grid").length && (a = t.find(".eltdf-grid").outerWidth()), n.length && (d = parseInt(n.css("paddingLeft"), 10)), i.length && (o = i.width() / 2);
                var e = Math.round(a / 2 - d - o - l);
                t.find(".eltdf-position-left").width(e), t.find(".eltdf-position-right").width(e), t.css("opacity", 1), "function" == typeof eltdf.modules.header.eltdfSetDropDownMenuPosition && eltdf.modules.header.eltdfSetDropDownMenuPosition(), "function" == typeof eltdf.modules.header.eltdfSetDropDownWideMenuPosition && eltdf.modules.header.eltdfSetDropDownWideMenuPosition()
            })
        }
    }

    (eltdf.modules.headerDivided = t).eltdfOnDocumentReady = a, t.eltdfOnWindowResize = l, e(document).ready(a), e(window).resize(l)
}(jQuery), function (f) {
    "use strict";
    var e = {};

    function t() {
        !function () {
            var t = f("a.eltdf-fullscreen-menu-opener");
            if (t.length) {
                var a, e = f(".eltdf-fullscreen-menu-holder-outer"), l = !1, n = !1,
                    d = f(".eltdf-fullscreen-above-menu-widget-holder"),
                    i = f(".eltdf-fullscreen-below-menu-widget-holder"),
                    o = f(".eltdf-fullscreen-menu-holder-outer nav > ul > li > a"),
                    s = f(".eltdf-fullscreen-menu > ul li.has_sub > a"),
                    r = f(".eltdf-fullscreen-menu ul li:not(.has_sub) a");
                eltdf.modules.common.eltdfInitPerfectScrollbar().init(e), f(window).resize(function () {
                    e.height(eltdf.windowHeight)
                }), eltdf.body.hasClass("eltdf-fade-push-text-right") ? (a = "eltdf-push-nav-right", l = !0) : eltdf.body.hasClass("eltdf-fade-push-text-top") && (a = "eltdf-push-text-top", n = !0), (l || n) && (d.length && d.children().css({
                    "-webkit-animation-delay": "0ms",
                    "-moz-animation-delay": "0ms",
                    "animation-delay": "0ms"
                }), o.each(function (e) {
                    f(this).css({
                        "-webkit-animation-delay": 70 * (e + 1) + "ms",
                        "-moz-animation-delay": 70 * (e + 1) + "ms",
                        "animation-delay": 70 * (e + 1) + "ms"
                    })
                }), i.length && i.children().css({
                    "-webkit-animation-delay": 70 * (o.length + 1) + "ms",
                    "-moz-animation-delay": 70 * (o.length + 1) + "ms",
                    "animation-delay": 70 * (o.length + 1) + "ms"
                })), t.on("click", function (e) {
                    e.preventDefault(), t.hasClass("eltdf-fm-opened") ? (t.removeClass("eltdf-fm-opened"), eltdf.body.removeClass("eltdf-fullscreen-menu-opened eltdf-fullscreen-fade-in").addClass("eltdf-fullscreen-fade-out"), eltdf.body.addClass(a), eltdf.modules.common.eltdfEnableScroll(), f("nav.eltdf-fullscreen-menu ul.sub_menu").slideUp(200)) : (t.addClass("eltdf-fm-opened"), eltdf.body.removeClass("eltdf-fullscreen-fade-out").addClass("eltdf-fullscreen-menu-opened eltdf-fullscreen-fade-in"), eltdf.body.removeClass(a), eltdf.modules.common.eltdfDisableScroll(), f(document).keyup(function (e) {
                        27 === e.keyCode && (t.removeClass("eltdf-fm-opened"), eltdf.body.removeClass("eltdf-fullscreen-menu-opened eltdf-fullscreen-fade-in").addClass("eltdf-fullscreen-fade-out"), eltdf.body.addClass(a), eltdf.modules.common.eltdfEnableScroll(), f("nav.eltdf-fullscreen-menu ul.sub_menu").slideUp(200))
                    }))
                }), s.on("tap click", function (e) {
                    e.preventDefault();
                    var t = f(this).parent(), a = t.siblings(".menu-item-has-children");
                    if (t.hasClass("has_sub")) {
                        var l = t.find("> ul.sub_menu");
                        l.is(":visible") ? (l.slideUp(450, "easeInOutQuint"), t.removeClass("open_sub")) : (t.addClass("open_sub"), 0 === a.length ? l.slideDown(400, "easeInOutQuint") : (t.closest("li.menu-item").siblings().find(".menu-item").removeClass("open_sub"), t.siblings().removeClass("open_sub").find(".sub_menu").slideUp(400, "easeInOutQuint", function () {
                            l.slideDown(400, "easeInOutQuint")
                        })))
                    }
                    return !1
                }), r.on("click", function (e) {
                    if ("http://#" === f(this).attr("href") || "#" === f(this).attr("href")) return !1;
                    1 === e.which && (t.removeClass("eltdf-fm-opened"), eltdf.body.removeClass("eltdf-fullscreen-menu-opened"), eltdf.body.removeClass("eltdf-fullscreen-fade-in").addClass("eltdf-fullscreen-fade-out"), eltdf.body.addClass(a), f("nav.eltdf-fullscreen-menu ul.sub_menu").slideUp(200), eltdf.modules.common.eltdfEnableScroll())
                })
            }
        }()
    }

    (eltdf.modules.headerMinimal = e).eltdfOnDocumentReady = t, f(document).ready(t)
}(jQuery), function (i) {
    "use strict";
    var e = {};

    function t() {
        a().init()
    }

    (eltdf.modules.headerVertical = e).eltdfOnDocumentReady = t, i(document).ready(t);
    var a = function () {
        function e() {
            t.hasClass("eltdf-with-scroll") && eltdf.modules.common.eltdfInitPerfectScrollbar().init(t)
        }

        var t = i(".eltdf-vertical-menu-area");
        return {
            init: function () {
                t.length && (function () {
                    var l, n, d, e = t.find(".eltdf-vertical-menu");
                    e.hasClass("eltdf-vertical-dropdown-below") ? (d = e.find("ul li.menu-item-has-children")).each(function () {
                        var t = i(this).find(" > .second, > ul"), a = this, l = i(this).find("> a"), n = "fast";
                        l.on("click tap", function (e) {
                            e.preventDefault(), e.stopPropagation(), t.is(":visible") ? (i(a).removeClass("open"), t.slideUp(n)) : (l.parent().parent().children().hasClass("open") && l.parent().parent().parent().hasClass("eltdf-vertical-menu") ? (i(this).parent().parent().children().removeClass("open"), i(this).parent().parent().children().find(" > .second").slideUp(n)) : (i(this).parents("li").hasClass("open") || (d.removeClass("open"), d.find(" > .second, > ul").slideUp(n)), i(this).parent().parent().children().hasClass("open") && (i(this).parent().parent().children().removeClass("open"), i(this).parent().parent().children().find(" > .second, > ul").slideUp(n))), i(a).addClass("open"), t.slideDown("slow"))
                        })
                    }) : e.hasClass("eltdf-vertical-dropdown-side") && (l = e.find("ul li.menu-item-has-children"), n = l.find(" > .second > .inner > ul, > ul"), l.each(function () {
                        var t = i(this).find(" > .second > .inner > ul, > ul"), a = this;
                        Modernizr.touch ? i(this).find("> a").on("click tap", function (e) {
                            e.preventDefault(), e.stopPropagation(), t.hasClass("eltdf-float-open") ? (t.removeClass("eltdf-float-open"), i(a).removeClass("open")) : (i(this).parents("li").hasClass("open") || (l.removeClass("open"), n.removeClass("eltdf-float-open")), t.addClass("eltdf-float-open"), i(a).addClass("open"))
                        }) : i(this).hoverIntent({
                            over: function () {
                                t.addClass("eltdf-float-open"), i(a).addClass("open")
                            }, out: function () {
                                t.removeClass("eltdf-float-open"), i(a).removeClass("open")
                            }, timeout: 300
                        })
                    }))
                }(), e())
            }
        }
    }
}(jQuery), function (o) {
    "use strict";
    var e = {};

    function t() {
        !function () {
            var t = o(".eltdf-mobile-header .eltdf-mobile-menu-opener"),
                i = o(".eltdf-mobile-header .eltdf-mobile-nav"),
                e = o(".eltdf-mobile-nav .mobile_arrow, .eltdf-mobile-nav h6, .eltdf-mobile-nav a.eltdf-mobile-no-link");
            t.length && i.length && t.on("tap click", function (e) {
                e.stopPropagation(), e.preventDefault(), i.is(":visible") ? (i.slideUp(450, "easeInOutQuint"), t.removeClass("eltdf-mobile-menu-opened")) : (i.slideDown(450, "easeInOutQuint"), t.addClass("eltdf-mobile-menu-opened"))
            });
            e.length && e.each(function () {
                var n = o(this), d = i.outerHeight();
                n.on("tap click", function (e) {
                    var t = n.parent("li"), a = t.siblings(".menu-item-has-children");
                    if (t.hasClass("has_sub")) {
                        var l = t.find("> ul.sub_menu");
                        l.is(":visible") ? (l.slideUp(450, "easeInOutQuint"), t.removeClass("eltdf-opened"), i.stop().animate({height: d}, 300)) : (t.addClass("eltdf-opened"), 0 === a.length ? t.find(".sub_menu").slideUp(400, "easeInOutQuint", function () {
                            l.slideDown(400, "easeInOutQuint"), i.stop().animate({height: d + 50}, 300)
                        }) : t.siblings().removeClass("eltdf-opened").find(".sub_menu").slideUp(400, "easeInOutQuint", function () {
                            l.slideDown(400, "easeInOutQuint"), i.stop().animate({height: d + 50}, 300)
                        }))
                    }
                })
            });
            o(".eltdf-mobile-nav a, .eltdf-mobile-logo-wrapper a").on("click tap", function (e) {
                "http://#" !== o(this).attr("href") && "#" !== o(this).attr("href") && (i.slideUp(450, "easeInOutQuint"), t.removeClass("eltdf-mobile-menu-opened"))
            })
        }(), l(), function () {
            var t = o(".eltdf-mobile-header"), a = t.find(".eltdf-mobile-menu-opener"),
                e = t.length ? t.outerHeight() : 0;
            eltdf.body.hasClass("eltdf-content-is-behind-header") && 0 < e && eltdf.windowWidth <= 1024 && o(".eltdf-content").css("marginTop", -e);
            if (eltdf.body.hasClass("eltdf-sticky-up-mobile-header")) {
                var l, n = o("#wpadminbar"), d = o(document).scrollTop();
                l = e + eltdfGlobalVars.vars.eltdfAddForAdminBar, o(window).scroll(function () {
                    var e = o(document).scrollTop();
                    l < e ? t.addClass("eltdf-animate-mobile-header") : t.removeClass("eltdf-animate-mobile-header"), d < e && l < e && !a.hasClass("eltdf-mobile-menu-opened") || e < l ? (t.removeClass("mobile-header-appear"), t.css("margin-bottom", 0), n.length && t.find(".eltdf-mobile-header-inner").css("top", 0)) : (t.addClass("mobile-header-appear"), t.css("margin-bottom", l)), d = o(document).scrollTop()
                })
            }
        }()
    }

    function a() {
        l()
    }

    function l() {
        if (eltdf.windowWidth <= 1024) {
            var e = o(".eltdf-mobile-header"), t = e.length ? e.height() : 0, a = e.find(".eltdf-mobile-nav"),
                l = a.outerHeight(), n = eltdf.windowHeight - 100, d = n < t + l ? n - t : l;
            a.length && (a.height(d), eltdf.modules.common.eltdfInitPerfectScrollbar().init(a))
        }
    }

    (eltdf.modules.mobileHeader = e).eltdfOnDocumentReady = t, e.eltdfOnWindowResize = a, o(document).ready(t), o(window).resize(a)
}(jQuery), function (c) {
    "use strict";
    var e = {};

    function t() {
        1024 < eltdf.windowWidth && function () {
            var t, e, a = c(".eltdf-page-header"), l = c(".eltdf-sticky-header"), n = c(".eltdf-fixed-wrapper"),
                d = n.children(".eltdf-menu-area").outerHeight(), i = c(".eltdf-slider"),
                o = i.length ? i.outerHeight() : 0,
                s = n.length ? n.offset().top - eltdfGlobalVars.vars.eltdfAddForAdminBar : 0;
            switch (!0) {
                case eltdf.body.hasClass("eltdf-sticky-header-on-scroll-up"):
                    eltdf.modules.stickyHeader.behaviour = "eltdf-sticky-header-on-scroll-up";
                    var r = c(document).scrollTop();
                    t = parseInt(eltdfGlobalVars.vars.eltdfTopBarHeight) + parseInt(eltdfGlobalVars.vars.eltdfLogoAreaHeight) + parseInt(eltdfGlobalVars.vars.eltdfMenuAreaHeight) + parseInt(eltdfGlobalVars.vars.eltdfStickyHeaderHeight), (e = function () {
                        var e = c(document).scrollTop();
                        r < e && t < e || e < t ? (eltdf.modules.stickyHeader.isStickyVisible = !1, l.removeClass("header-appear").find(".eltdf-main-menu .second").removeClass("eltdf-drop-down-start"), eltdf.body.removeClass("eltdf-sticky-header-appear")) : (eltdf.modules.stickyHeader.isStickyVisible = !0, l.addClass("header-appear"), eltdf.body.addClass("eltdf-sticky-header-appear")), r = c(document).scrollTop()
                    })(), c(window).scroll(function () {
                        e()
                    });
                    break;
                case eltdf.body.hasClass("eltdf-sticky-header-on-scroll-down-up"):
                    eltdf.modules.stickyHeader.behaviour = "eltdf-sticky-header-on-scroll-down-up", 0 !== eltdfPerPageVars.vars.eltdfStickyScrollAmount ? eltdf.modules.stickyHeader.stickyAppearAmount = parseInt(eltdfPerPageVars.vars.eltdfStickyScrollAmount) : eltdf.modules.stickyHeader.stickyAppearAmount = parseInt(eltdfGlobalVars.vars.eltdfTopBarHeight) + parseInt(eltdfGlobalVars.vars.eltdfLogoAreaHeight) + parseInt(eltdfGlobalVars.vars.eltdfMenuAreaHeight) + parseInt(o), (e = function () {
                        eltdf.scroll < eltdf.modules.stickyHeader.stickyAppearAmount ? (eltdf.modules.stickyHeader.isStickyVisible = !1, l.removeClass("header-appear").find(".eltdf-main-menu .second").removeClass("eltdf-drop-down-start"), eltdf.body.removeClass("eltdf-sticky-header-appear")) : (eltdf.modules.stickyHeader.isStickyVisible = !0, l.addClass("header-appear"), eltdf.body.addClass("eltdf-sticky-header-appear"))
                    })(), c(window).scroll(function () {
                        e()
                    });
                    break;
                case eltdf.body.hasClass("eltdf-fixed-on-scroll"):
                    eltdf.modules.stickyHeader.behaviour = "eltdf-fixed-on-scroll";
                    var f = function () {
                        eltdf.scroll <= s ? (n.removeClass("fixed"), eltdf.body.removeClass("eltdf-fixed-header-appear"), a.css("margin-bottom", "0")) : (n.addClass("fixed"), eltdf.body.addClass("eltdf-fixed-header-appear"), a.css("margin-bottom", d + "px"))
                    };
                    f(), c(window).scroll(function () {
                        f()
                    })
            }
        }()
    }

    (eltdf.modules.stickyHeader = e).isStickyVisible = !1, e.stickyAppearAmount = 0, e.behaviour = "", e.eltdfOnDocumentReady = t, c(document).ready(t)
}(jQuery), function (u) {
    "use strict";
    var e = {};

    function t() {
        !function () {
            if (eltdf.body.hasClass("eltdf-search-covers-header")) {
                var e = u("a.eltdf-search-opener");
                0 < e.length && e.each(function () {
                    u(this).on("click", function (e) {
                        e.preventDefault();
                        var t, a = u(this), l = u(".eltdf-page-header"), n = u(".eltdf-top-bar"),
                            d = l.find(".eltdf-fixed-wrapper.fixed"), i = u(".eltdf-mobile-header"),
                            o = u(".eltdf-search-cover"), s = !!a.parents(".eltdf-top-bar").length,
                            r = !!a.parents(".eltdf-fixed-wrapper.fixed").length,
                            f = !!a.parents(".eltdf-sticky-header").length,
                            c = !!a.parents(".eltdf-mobile-header").length;
                        o.removeClass("eltdf-is-active"), s ? (t = n.outerHeight(), l.children(".eltdf-search-cover").addClass("eltdf-is-active eltdf-opener-in-top-header")) : r ? (t = d.outerHeight(), l.children(".eltdf-search-cover").addClass("eltdf-is-active")) : f ? (t = l.find(".eltdf-sticky-header").outerHeight(), l.children(".eltdf-search-cover").addClass("eltdf-is-active")) : c ? (t = i.hasClass("mobile-header-appear") ? i.children(".eltdf-mobile-header-inner").outerHeight() : i.outerHeight(), i.find(".eltdf-search-cover").addClass("eltdf-is-active")) : (t = l.outerHeight(), l.children(".eltdf-search-cover").addClass("eltdf-is-active")), o.hasClass("eltdf-is-active") && o.height(t).stop(!0).fadeIn(600).find('input[type="text"]').focus(), o.find(".eltdf-search-close").on("click", function (e) {
                            e.preventDefault(), o.stop(!0).fadeOut(450, function () {
                                o.hasClass("eltdf-opener-in-top-header") && o.removeClass("eltdf-opener-in-top-header")
                            }), o.removeClass("eltdf-is-active")
                        }), o.blur(function () {
                            o.stop(!0).fadeOut(450, function () {
                                o.hasClass("eltdf-opener-in-top-header") && o.removeClass("eltdf-opener-in-top-header")
                            }), o.removeClass("eltdf-is-active")
                        }), u(window).scroll(function () {
                            o.stop(!0).fadeOut(450, function () {
                                o.hasClass("eltdf-opener-in-top-header") && o.removeClass("eltdf-opener-in-top-header")
                            }), o.removeClass("eltdf-is-active")
                        })
                    })
                })
            }
        }()
    }

    (eltdf.modules.searchCoversHeader = e).eltdfOnDocumentReady = t, u(document).ready(t)
}(jQuery), function (d) {
    "use strict";
    var e = {};

    function t() {
        !function () {
            if (eltdf.body.hasClass("eltdf-fullscreen-search")) {
                var e = d("a.eltdf-search-opener");
                if (0 < e.length) {
                    var a = d(".eltdf-fullscreen-search-holder"), t = d(".eltdf-search-close");
                    e.on("click", function (e) {
                        e.preventDefault(), a.hasClass("eltdf-animate") ? (eltdf.body.removeClass("eltdf-fullscreen-search-opened eltdf-search-fade-out"), eltdf.body.removeClass("eltdf-search-fade-in"), a.removeClass("eltdf-animate"), setTimeout(function () {
                            a.find(".eltdf-search-field").val(""), a.find(".eltdf-search-field").blur()
                        }, 300), eltdf.modules.common.eltdfEnableScroll()) : (eltdf.body.addClass("eltdf-fullscreen-search-opened eltdf-search-fade-in"), eltdf.body.removeClass("eltdf-search-fade-out"), a.addClass("eltdf-animate"), setTimeout(function () {
                            a.find(".eltdf-search-field").focus()
                        }, 900), eltdf.modules.common.eltdfDisableScroll()), t.on("click", function (e) {
                            e.preventDefault(), eltdf.body.removeClass("eltdf-fullscreen-search-opened eltdf-search-fade-in"), eltdf.body.addClass("eltdf-search-fade-out"), a.removeClass("eltdf-animate"), setTimeout(function () {
                                a.find(".eltdf-search-field").val(""), a.find(".eltdf-search-field").blur()
                            }, 300), eltdf.modules.common.eltdfEnableScroll()
                        }), d(document).mouseup(function (e) {
                            var t = d(".eltdf-form-holder-inner");
                            t.is(e.target) || 0 !== t.has(e.target).length || (e.preventDefault(), eltdf.body.removeClass("eltdf-fullscreen-search-opened eltdf-search-fade-in"), eltdf.body.addClass("eltdf-search-fade-out"), a.removeClass("eltdf-animate"), setTimeout(function () {
                                a.find(".eltdf-search-field").val(""), a.find(".eltdf-search-field").blur()
                            }, 300), eltdf.modules.common.eltdfEnableScroll())
                        }), d(document).keyup(function (e) {
                            27 === e.keyCode && (eltdf.body.removeClass("eltdf-fullscreen-search-opened eltdf-search-fade-in"), eltdf.body.addClass("eltdf-search-fade-out"), a.removeClass("eltdf-animate"), setTimeout(function () {
                                a.find(".eltdf-search-field").val(""), a.find(".eltdf-search-field").blur()
                            }, 300), eltdf.modules.common.eltdfEnableScroll())
                        })
                    });
                    var l = d(".eltdf-fullscreen-search-holder .eltdf-search-field"),
                        n = d(".eltdf-fullscreen-search-holder .eltdf-field-holder .eltdf-line");
                    l.focus(function () {
                        n.css("width", "100%")
                    }), l.blur(function () {
                        n.css("width", "0")
                    })
                }
            }
        }()
    }

    (eltdf.modules.searchFullscreen = e).eltdfOnDocumentReady = t, d(document).ready(t)
}(jQuery), function (l) {
    "use strict";
    var e = {};

    function t() {
        !function () {
            if (eltdf.body.hasClass("eltdf-fullscreen-search-with-sidebar")) {
                var e = l("a.eltdf-search-opener");
                if (0 < e.length) {
                    var t = l(".eltdf-fullscreen-with-sidebar-search-holder"), a = l(".eltdf-search-close");
                    eltdf.modules.common.eltdfInitPerfectScrollbar().init(t), e.on("click", function (e) {
                        e.preventDefault(), t.hasClass("eltdf-animate") ? (eltdf.body.removeClass("eltdf-fullscreen-search-opened eltdf-search-fade-out"), eltdf.body.removeClass("eltdf-search-fade-in"), t.removeClass("eltdf-animate"), setTimeout(function () {
                            t.find(".eltdf-search-field").val(""), t.find(".eltdf-search-field").blur()
                        }, 300), eltdf.modules.common.eltdfEnableScroll()) : (eltdf.body.addClass("eltdf-fullscreen-search-opened eltdf-search-fade-in"), eltdf.body.removeClass("eltdf-search-fade-out"), t.addClass("eltdf-animate"), setTimeout(function () {
                            t.find(".eltdf-search-field").focus()
                        }, 900), eltdf.modules.common.eltdfDisableScroll()), a.on("click", function (e) {
                            e.preventDefault(), eltdf.body.removeClass("eltdf-fullscreen-search-opened eltdf-search-fade-in"), eltdf.body.addClass("eltdf-search-fade-out"), t.removeClass("eltdf-animate"), setTimeout(function () {
                                t.find(".eltdf-search-field").val(""), t.find(".eltdf-search-field").blur()
                            }, 300), eltdf.modules.common.eltdfEnableScroll()
                        }), l(document).keyup(function (e) {
                            27 === e.keyCode && (eltdf.body.removeClass("eltdf-fullscreen-search-opened eltdf-search-fade-in"), eltdf.body.addClass("eltdf-search-fade-out"), t.removeClass("eltdf-animate"), setTimeout(function () {
                                t.find(".eltdf-search-field").val(""), t.find(".eltdf-search-field").blur()
                            }, 300), eltdf.modules.common.eltdfEnableScroll())
                        })
                    })
                }
            }
        }()
    }

    (eltdf.modules.searchFullscreenWithSidebar = e).eltdfOnDocumentReady = t, l(document).ready(t)
}(jQuery), function (m) {
    "use strict";
    var e = {};

    function t() {
        !function () {
            if (eltdf.body.hasClass("eltdf-slide-from-header-bottom")) {
                var e = m("a.eltdf-search-opener");
                e.length && e.each(function () {
                    m(this).on("click", function (e) {
                        e.preventDefault();
                        var t = m(this), a = parseInt(eltdf.windowWidth - t.offset().left - t.outerWidth());
                        eltdf.body.hasClass("eltdf-boxed") && 1024 < eltdf.windowWidth && (a -= parseInt((eltdf.windowWidth - m(".eltdf-boxed .eltdf-wrapper .eltdf-wrapper-inner").outerWidth()) / 2));
                        var l = m(".eltdf-page-header"), n = "100%", d = m(".eltdf-top-bar"),
                            i = l.find(".eltdf-fixed-wrapper.fixed"), o = m(".eltdf-mobile-header"),
                            s = l.children(".eltdf-slide-from-header-bottom-holder"),
                            r = !!t.parents(".eltdf-top-bar").length,
                            f = !!t.parents(".eltdf-fixed-wrapper.fixed").length,
                            c = !!t.parents(".eltdf-sticky-header").length,
                            u = !!t.parents(".eltdf-mobile-header").length;
                        s.removeClass("eltdf-is-active"), r ? (s = d.find(".eltdf-slide-from-header-bottom-holder")).addClass("eltdf-is-active") : f ? (n = i.outerHeight() + eltdfGlobalVars.vars.eltdfAddForAdminBar, s.addClass("eltdf-is-active")) : c ? (n = eltdfGlobalVars.vars.eltdfStickyHeaderHeight + eltdfGlobalVars.vars.eltdfAddForAdminBar, s.addClass("eltdf-is-active")) : u ? (o.hasClass("mobile-header-appear") && (n = o.children(".eltdf-mobile-header-inner").outerHeight() + eltdfGlobalVars.vars.eltdfAddForAdminBar), (s = o.find(".eltdf-slide-from-header-bottom-holder")).addClass("eltdf-is-active")) : s.addClass("eltdf-is-active"), s.hasClass("eltdf-is-active") && s.css({
                            right: a,
                            top: n
                        }).stop(!0).slideToggle(300, "easeOutBack"), m(document).keyup(function (e) {
                            27 === e.keyCode && s.stop(!0).fadeOut(0)
                        }), m(window).scroll(function () {
                            s.stop(!0).fadeOut(0)
                        })
                    })
                })
            }
        }()
    }

    (eltdf.modules.searchSlideFromHB = e).eltdfOnDocumentReady = t, m(document).ready(t)
}(jQuery), function (l) {
    "use strict";
    var e = {};

    function t() {
        !function () {
            if (eltdf.body.hasClass("eltdf-search-slides-from-window-top")) {
                var e = l("a.eltdf-search-opener");
                if (0 < e.length) {
                    var t = l(".eltdf-search-slide-window-top"), a = l(".eltdf-search-close");
                    e.on("click", function (e) {
                        e.preventDefault(), 0 === t.height() ? (l('.eltdf-search-slide-window-top input[type="text"]').focus(), eltdf.body.addClass("eltdf-search-open")) : eltdf.body.removeClass("eltdf-search-open"), l(window).scroll(function () {
                            "0" !== t.height() && 50 < eltdf.scroll && eltdf.body.removeClass("eltdf-search-open")
                        }), a.on("click", function (e) {
                            e.preventDefault(), eltdf.body.removeClass("eltdf-search-open")
                        })
                    })
                }
            }
        }()
    }

    (eltdf.modules.searchSlideFromWT = e).eltdfOnDocumentReady = t, l(document).ready(t)
}(jQuery), function (d) {
    "use strict";

    function e() {
        d(document).on("click", ".eltdf-like", function () {
            var t = d(this), e = t.attr("id"), a = t.data("post-id"), l = "";
            if (t.hasClass("liked")) return !1;
            void 0 !== t.data("type") && (l = t.data("type"));
            var n = {
                action: "solene_core_action_like",
                likes_id: e,
                type: l,
                like_nonce: d("#eltdf_like_nonce_" + a).val()
            };
            d.post(eltdfGlobalVars.vars.eltdfAjaxUrl, n, function (e) {
                t.html(e).addClass("liked").attr("title", "You already like this!")
            });
            return !1
        })
    }

    d(document).ready(e)
}(jQuery), function (d) {
    "use strict";
    var e = {};

    function t() {
        !function () {
            function n(e, t) {
                for (var a = 0; a < e.length; a++) {
                    var l = e[a];
                    a < t ? d(l).addClass("active") : d(l).removeClass("active")
                }
            }

            var e = d(".eltdf-comment-form-rating");
            e.each(function () {
                var e = d(this), t = e.find(".eltdf-rating"), a = t.val(), l = e.find(".eltdf-star-rating");
                n(l, a), l.on("click", function () {
                    t.val(d(this).data("value")).trigger("change")
                }), t.change(function () {
                    a = t.val(), n(l, a)
                })
            })
        }()
    }

    (eltdf.modules.rating = e).eltdfOnDocumentReady = t, d(document).ready(t)
}(jQuery), function (r) {
    "use strict";
    var e = {};

    function t() {
        a().init()
    }

    (eltdf.modules.portfolio = e).eltdfOnWindowLoad = t, r(window).load(t);
    var a = function () {
        var a = r(".eltdf-follow-portfolio-info .eltdf-portfolio-single-holder .eltdf-ps-info-sticky-holder");
        if (a.length) var l = a.parent().height(), e = r(".eltdf-ps-image-holder"), n = e.height(), d = e.offset().top,
            i = parseInt(e.find(".eltdf-ps-image:last-of-type").css("marginBottom"), 10),
            o = r(".header-appear, .eltdf-fixed-wrapper"), s = o.length ? o.height() : 0, t = function () {
                if (l <= n) {
                    var e = eltdf.scroll;
                    0 < e && o.length && (s = o.height());
                    var t = s + eltdfGlobalVars.vars.eltdfAddForAdminBar;
                    d - t <= e ? n + d - i - t <= e + l ? (a.stop().animate({marginTop: n - i - l}), s = 0) : a.stop().animate({marginTop: e - d + t}) : a.stop().animate({marginTop: 0})
                }
            };
        return {
            init: function () {
                a.length && (t(), r(window).scroll(function () {
                    t()
                }))
            }
        }
    }
}(jQuery), function (n) {
    "use strict";
    var e = {};

    function t() {
        !function () {
            var e = n(".eltdf-proofing-gallery-single-holder .eltdf-pgs-gallery-filter-holder");
            e.length && e.each(function () {
                var a = n(this);
                a.find(".eltdf-pgs-gallery-filter:first").addClass("eltdf-pgs-filter-current"), a.find(".eltdf-pgs-gallery-filter").on("click", function () {
                    var e = n(this), t = e.attr("data-filter");
                    e.parent().children(".eltdf-pgs-gallery-filter").removeClass("eltdf-pgs-filter-current"), e.addClass("eltdf-pgs-filter-current"), a.parent().children(".eltdf-pgs-gallery-inner").isotope({filter: t})
                })
            })
        }(), a().init(), function () {
            var e = n(".eltdf-password-protected-holder");
            if (e.hasClass("eltdf-password-protected-full-height")) {
                var t = eltdf.body.hasClass("eltdf-paspartu-enabled") ? parseInt(n(".eltdf-wrapper").css("paddingBottom"), 10) : 0;
                e.css({height: eltdf.windowHeight - e.offset().top - t + "px"}), eltdf.body.hasClass("eltdf-pg-password-protected-full-height") || eltdf.body.addClass("eltdf-pg-password-protected-full-height")
            }
        }()
    }

    (eltdf.modules.proofingGallery = e).eltdfOnDocumentReady = t, n(document).ready(t);
    var a = eltdf.modules.proofingGallery.eltdfProofingGalleryApproving = function () {
        var e = n(".eltdf-pgs-gallery-holder");
        return {
            init: function () {
                e.length && e.each(function () {
                    !function (e) {
                        e.find(".eltdf-pgs-gallery-image").each(function () {
                            var a = n(this), l = a.find(".eltdf-pgs-image-action-icon");
                            l.on("click", function () {
                                l.addClass("eltdf-blink");
                                var e = {
                                    action: "solene_core_proofing_gallery_approving",
                                    gallery_id: a.data("gallery-id"),
                                    image_id: a.data("image-id")
                                };
                                n.ajax({
                                    type: "POST",
                                    data: e,
                                    url: eltdfGlobalVars.vars.eltdfAjaxUrl,
                                    success: function (e) {
                                        l.removeClass("eltdf-blink");
                                        var t = JSON.parse(e);
                                        "success" === t.status && ("approved" === t.data.image_status ? (a.removeClass("proofing-gallery-image-rejected"), a.addClass("proofing-gallery-image-approved")) : (a.removeClass("proofing-gallery-image-approved"), a.addClass("proofing-gallery-image-rejected")))
                                    }
                                })
                            })
                        })
                    }(n(this))
                })
            }
        }
    }
}(jQuery), function (n) {
    "use strict";
    var e = {};

    function t() {
        a()
    }

    function a() {
        var e = n(".eltdf-accordion-holder");
        e.length && e.each(function () {
            var e = n(this);
            if (e.hasClass("eltdf-accordion") && e.accordion({
                animate: "swing",
                collapsible: !0,
                active: 0,
                icons: "",
                heightStyle: "content"
            }), e.hasClass("eltdf-toggle")) {
                var t = n(this), a = t.find(".eltdf-accordion-title"), l = a.next();
                t.addClass("accordion ui-accordion ui-accordion-icons ui-widget ui-helper-reset"), a.addClass("ui-accordion-header ui-state-default ui-corner-top ui-corner-bottom"), l.addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom").hide(), a.each(function () {
                    var e = n(this);
                    e.on("hover", function () {
                        e.toggleClass("ui-state-hover")
                    }), e.on("click", function () {
                        e.toggleClass("ui-accordion-header-active ui-state-active ui-state-default ui-corner-bottom"), e.next().toggleClass("ui-accordion-content-active").slideToggle(400)
                    })
                })
            }
        })
    }

    (eltdf.modules.accordions = e).eltdfInitAccordions = a, e.eltdfOnDocumentReady = t, n(document).ready(t)
}(jQuery), function (o) {
    "use strict";
    var e = {};

    function t() {
        a()
    }

    function a() {
        var e = o(".eltdf-anchor-menu");
        if (e.length && 1024 < eltdf.windowWidth) {
            e.remove(), o(".eltdf-content-inner").append(e.addClass("eltdf-init"));
            var t = o("div[data-eltdf-anchor]"), i = e.find(".eltdf-anchor");
            t.length && i.length && (i.first().addClass("eltdf-active"), o(window).scroll(function () {
                t.each(function (e) {
                    var t = o(this), a = t.offset().top, l = t.outerHeight(), n = eltdf.windowHeight / 5, d = 0;
                    0 === eltdf.scroll ? i.removeClass("eltdf-active").first().addClass("eltdf-active") : a <= eltdf.scroll + n && a + l >= eltdf.scroll + n ? d !== e && (d = e, i.removeClass("eltdf-active").eq(e).addClass("eltdf-active")) : eltdf.scroll + eltdf.windowHeight == eltdf.document.height() && i.removeClass("eltdf-active").last().addClass("eltdf-active")
                })
            }))
        }
    }

    (eltdf.modules.anchorMenu = e).eltdfAnchorMenu = a, e.eltdfOnDocumentReady = t, o(document).ready(t)
}(jQuery), function (n) {
    "use strict";
    var e = {};

    function t() {
        a()
    }

    function a() {
        var a, l,
            e = n(".eltdf-grow-in, .eltdf-fade-in-down, .eltdf-element-from-fade, .eltdf-element-from-left, .eltdf-element-from-right, .eltdf-element-from-top, .eltdf-element-from-bottom, .eltdf-flip-in, .eltdf-x-rotate, .eltdf-z-rotate, .eltdf-y-translate, .eltdf-fade-in, .eltdf-fade-in-left-x-rotate");
        e.length && e.each(function () {
            var t = n(this);
            t.appear(function () {
                if (a = t.data("animation"), l = parseInt(t.data("animation-delay")), void 0 !== a && "" !== a) {
                    var e = a + "-on";
                    setTimeout(function () {
                        t.addClass(e)
                    }, l)
                }
            }, {accX: 0, accY: eltdfGlobalVars.vars.eltdfElementAppearAmount})
        })
    }

    (eltdf.modules.animationHolder = e).eltdfInitAnimationHolder = a, e.eltdfOnDocumentReady = t, n(document).ready(t)
}(jQuery), function (t) {
    "use strict";
    var e = {};

    function a() {
        l().init()
    }

    (eltdf.modules.button = e).eltdfButton = l, e.eltdfOnDocumentReady = a, t(document).ready(a);
    var l = function () {
        var e = t(".eltdf-btn");
        return {
            init: function () {
                e.length && e.each(function () {
                    !function (e) {
                        if (void 0 !== e.data("hover-color")) {
                            var t = function (e) {
                                e.data.button.css("color", e.data.color)
                            }, a = e.css("color"), l = e.data("hover-color");
                            e.on("mouseenter", {button: e, color: l}, t), e.on("mouseleave", {button: e, color: a}, t)
                        }
                    }(t(this)), function (e) {
                        if (void 0 !== e.data("hover-bg-color")) {
                            var t = function (e) {
                                e.data.button.css("background-color", e.data.color)
                            }, a = e.css("background-color"), l = e.data("hover-bg-color");
                            e.on("mouseenter", {button: e, color: l}, t), e.on("mouseleave", {button: e, color: a}, t)
                        }
                    }(t(this)), function (e) {
                        if (void 0 !== e.data("hover-border-color")) {
                            var t = function (e) {
                                e.data.button.css("border-color", e.data.color)
                            }, a = e.css("borderTopColor"), l = e.data("hover-border-color");
                            e.on("mouseenter", {button: e, color: l}, t), e.on("mouseleave", {button: e, color: a}, t)
                        }
                    }(t(this))
                })
            }
        }
    }
}(jQuery), function (l) {
    "use strict";
    var e = {};

    function t() {
        !function () {
            var e = l(".eltdf-cards-gallery");
            e.length && e.each(function () {
                var t = l(this), a = t.find(".eltdf-cg-card");
                a.each(function () {
                    var e = l(this);
                    e.on("click", function () {
                        if (!a.last().is(e)) return e.addClass("eltdf-out eltdf-animating").siblings().addClass("eltdf-animating-siblings"), e.detach(), e.insertAfter(a.last()), setTimeout(function () {
                            e.removeClass("eltdf-out")
                        }, 200), setTimeout(function () {
                            e.removeClass("eltdf-animating").siblings().removeClass("eltdf-animating-siblings")
                        }, 1200), a = t.find(".eltdf-cg-card"), !1
                    })
                }), t.hasClass("eltdf-bundle-animation") && !eltdf.htmlEl.hasClass("touch") && t.appear(function () {
                    t.addClass("eltdf-appeared"), t.find("img").one("animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd", function () {
                        l(this).addClass("eltdf-animation-done")
                    })
                }, {accX: 0, accY: eltdfGlobalVars.vars.eltdfElementAppearAmount})
            })
        }()
    }

    (eltdf.modules.cardsGallery = e).eltdfOnWindowLoad = t, l(window).load(t)
}(jQuery), function (g) {
    "use strict";
    var e = {};

    function t() {
        a()
    }

    function a() {
        var n, d, i, o, s, r, f, c, u, m, h, e = g(".eltdf-countdown"), p = (new Date).getMonth();
        e.length && e.each(function () {
            var e, t, a = g(this).attr("id"), l = g("#" + a);
            n = l.data("year"), d = l.data("month"), i = l.data("day"), o = l.data("hour"), s = l.data("minute"), r = l.data("timezone"), f = l.data("month-label"), c = l.data("day-label"), u = l.data("hour-label"), m = l.data("minute-label"), h = l.data("second-label"), e = l.data("digit-size"), t = l.data("label-size"), p !== d && (d -= 1), l.countdown({
                until: new Date(n, d, i, o, s, 44),
                labels: ["", f, "", c, u, m, h],
                format: "ODHMS",
                timezone: r,
                padZeroes: !0,
                onTick: function () {
                    l.find(".countdown-amount").css({
                        "font-size": e + "px",
                        "line-height": e + "px"
                    }), l.find(".countdown-period").css({"font-size": t + "px"})
                }
            })
        })
    }

    (eltdf.modules.countdown = e).eltdfInitCountdown = a, e.eltdfOnDocumentReady = t, g(document).ready(t)
}(jQuery), function (l) {
    "use strict";
    var e = {};

    function t() {
        a()
    }

    function a() {
        var e = l(".eltdf-counter-holder");
        e.length && e.each(function () {
            var t = l(this), a = t.find(".eltdf-counter");
            t.appear(function () {
                if (t.css("opacity", "1"), a.hasClass("eltdf-zero-counter")) {
                    var e = parseFloat(a.text());
                    a.countTo({from: 0, to: e, speed: 1500, refreshInterval: 100})
                } else a.absoluteCounter({speed: 2e3, fadeInDelay: 1e3})
            }, {accX: 0, accY: eltdfGlobalVars.vars.eltdfElementAppearAmount})
        })
    }

    (eltdf.modules.counter = e).eltdfInitCounter = a, e.eltdfOnDocumentReady = t, l(document).ready(t)
}(jQuery), function (s) {
    "use strict";
    var e = {};

    function t() {
        l()
    }

    function a() {
        n(), function () {
            var e = s(".eltdf-cf-has-appear");
            e.length && e.each(function () {
                var e = s(this);
                e.appear(function () {
                    e.addClass("eltdf-cf-appeared")
                }, {accX: 0, accY: 100})
            })
        }()
    }

    function l() {
        var e = s(".eltdf-custom-font-holder");
        e.length && e.each(function () {
            var e = s(this), t = "", a = "", l = "", n = "", d = "", i = "", o = "";
            void 0 !== e.data("item-class") && !1 !== e.data("item-class") && (t = e.data("item-class")), void 0 !== e.data("font-size-1366") && !1 !== e.data("font-size-1366") && (a += "font-size: " + e.data("font-size-1366") + " !important;"), void 0 !== e.data("font-size-1024") && !1 !== e.data("font-size-1024") && (l += "font-size: " + e.data("font-size-1024") + " !important;"), void 0 !== e.data("font-size-768") && !1 !== e.data("font-size-768") && (n += "font-size: " + e.data("font-size-768") + " !important;"), void 0 !== e.data("font-size-680") && !1 !== e.data("font-size-680") && (d += "font-size: " + e.data("font-size-680") + " !important;"), void 0 !== e.data("line-height-1366") && !1 !== e.data("line-height-1366") && (a += "line-height: " + e.data("line-height-1366") + " !important;"), void 0 !== e.data("line-height-1024") && !1 !== e.data("line-height-1024") && (l += "line-height: " + e.data("line-height-1024") + " !important;"), void 0 !== e.data("line-height-768") && !1 !== e.data("line-height-768") && (n += "line-height: " + e.data("line-height-768") + " !important;"), void 0 !== e.data("line-height-680") && !1 !== e.data("line-height-680") && (d += "line-height: " + e.data("line-height-680") + " !important;"), (a.length || l.length || n.length || d.length) && (a.length && (o += "@media only screen and (max-width: 1366px) {.eltdf-custom-font-holder." + t + " { " + a + " } }"), l.length && (o += "@media only screen and (max-width: 1024px) {.eltdf-custom-font-holder." + t + " { " + l + " } }"), n.length && (o += "@media only screen and (max-width: 768px) {.eltdf-custom-font-holder." + t + " { " + n + " } }"), d.length && (o += "@media only screen and (max-width: 680px) {.eltdf-custom-font-holder." + t + " { " + d + " } }")), o.length && (i = '<style type="text/css">' + o + "</style>"), i.length && s("head").append(i)
        })
    }

    function n() {
        var e = s(".eltdf-cf-typed");
        e.length && e.each(function () {
            var e = s(this), t = e.parent(".eltdf-cf-typed-wrap").parent(".eltdf-custom-font-holder"), a = [],
                l = e.find(".eltdf-cf-typed-1").text(), n = e.find(".eltdf-cf-typed-2").text(),
                d = e.find(".eltdf-cf-typed-3").text(), i = e.find(".eltdf-cf-typed-4").text();
            l.length && a.push(l), n.length && a.push(n), d.length && a.push(d), i.length && a.push(i), t.appear(function () {
                e.typed({
                    strings: a,
                    typeSpeed: 90,
                    backDelay: 700,
                    loop: !0,
                    contentType: "text",
                    loopCount: !1,
                    cursorChar: "_"
                })
            }, {accX: 0, accY: eltdfGlobalVars.vars.eltdfElementAppearAmount})
        })
    }

    (eltdf.modules.customFont = e).eltdfCustomFontResize = l, e.eltdfCustomFontTypeOut = n, e.eltdfOnDocumentReady = t, e.eltdfOnWindowLoad = a, s(document).ready(t), s(window).load(a)
}(jQuery), function (r) {
    "use strict";
    var e = {};

    function t() {
        a()
    }

    function a() {
        var e = r(".eltdf-elements-holder");
        e.length && e.each(function () {
            var e = r(this).children(".eltdf-eh-item"), t = "", s = "";
            e.each(function () {
                var e = r(this), t = "", a = "", l = "", n = "", d = "", i = "";
                if (void 0 !== e.data("item-class") && !1 !== e.data("item-class") && (t = e.data("item-class")), void 0 !== e.data("1400-1600") && !1 !== e.data("1400-1600") && (a = e.data("1400-1600")), void 0 !== e.data("1025-1399") && !1 !== e.data("1025-1399") && (l = e.data("1025-1399")), void 0 !== e.data("769-1024") && !1 !== e.data("769-1024") && (n = e.data("769-1024")), void 0 !== e.data("681-768") && !1 !== e.data("681-768") && (d = e.data("681-768")), void 0 !== e.data("680") && !1 !== e.data("680") && (i = e.data("680")), (a.length || l.length || n.length || d.length || i.length || "".length) && (a.length && (s += "@media only screen and (min-width: 1400px) and (max-width: 1600px) {.eltdf-eh-item-content." + t + " { padding: " + a + " !important; } }"), l.length && (s += "@media only screen and (min-width: 1025px) and (max-width: 1399px) {.eltdf-eh-item-content." + t + " { padding: " + l + " !important; } }"), n.length && (s += "@media only screen and (min-width: 769px) and (max-width: 1024px) {.eltdf-eh-item-content." + t + " { padding: " + n + " !important; } }"), d.length && (s += "@media only screen and (min-width: 681px) and (max-width: 768px) {.eltdf-eh-item-content." + t + " { padding: " + d + " !important; } }"), i.length && (s += "@media only screen and (max-width: 680px) {.eltdf-eh-item-content." + t + " { padding: " + i + " !important; } }")), "function" == typeof eltdf.modules.common.eltdfOwlSlider) {
                    var o = e.find(".eltdf-owl-slider");
                    o.length && setTimeout(function () {
                        o.trigger("refresh.owl.carousel")
                    }, 100)
                }
            }), s.length && (t = '<style type="text/css">' + s + "</style>"), t.length && r("head").append(t)
        })
    }

    (eltdf.modules.elementsHolder = e).eltdfInitElementsHolderResponsiveStyle = a, e.eltdfOnDocumentReady = t, r(document).ready(t)
}(jQuery), function (o) {
    "use strict";
    var e = {};

    function t() {
        !function () {
            var e = o(".eltdf-fsis-slider");
            e.length && e.each(function () {
                var t = o(this), e = t.parent(), a = e.children(".eltdf-fsis-prev-nav"),
                    l = e.children(".eltdf-fsis-next-nav"), n = e.children(".eltdf-fsis-slider-mask");
                e.addClass("eltdf-fsis-is-init"), d(t), i(t, a, l, -1), t.on("drag.owl.carousel", function () {
                    setTimeout(function () {
                        n.hasClass("eltdf-drag") || e.hasClass("eltdf-fsis-active") || n.addClass("eltdf-drag")
                    }, 200)
                }), t.on("dragged.owl.carousel", function () {
                    setTimeout(function () {
                        n.hasClass("eltdf-drag") && n.removeClass("eltdf-drag")
                    }, 300)
                }), t.on("translate.owl.carousel", function (e) {
                    i(t, a, l, e.item.index)
                }), t.on("translated.owl.carousel", function () {
                    d(t), setTimeout(function () {
                        n.removeClass("eltdf-drag")
                    }, 300)
                })
            })
        }()
    }

    function d(t) {
        var e = t.find(".owl-item.active");
        if (t.find(".eltdf-fsis-item").removeClass("eltdf-fsis-content-image-init"), function (e) {
            var t = e.find(".eltdf-fsis-item");
            t.length && t.removeClass("eltdf-fsis-active-image")
        }(t), e.length) {
            var a = e.find(".eltdf-fsis-item"), l = a.children(".eltdf-fsis-image");
            setTimeout(function () {
                a.addClass("eltdf-fsis-content-image-init")
            }, 100), l.off().on("mouseenter", function () {
                a.addClass("eltdf-fsis-image-hover")
            }).on("mouseleave", function () {
                a.removeClass("eltdf-fsis-image-hover")
            }).on("click", function () {
                a.hasClass("eltdf-fsis-active-image") ? (t.trigger("play.owl.autoplay"), t.parent().removeClass("eltdf-fsis-active"), a.removeClass("eltdf-fsis-active-image")) : (t.trigger("stop.owl.autoplay"), t.parent().addClass("eltdf-fsis-active"), a.addClass("eltdf-fsis-active-image"))
            }), o(document).keyup(function (e) {
                27 === e.keyCode && (t.trigger("play.owl.autoplay"), t.parent().removeClass("eltdf-fsis-active"), a.removeClass("eltdf-fsis-active-image"))
            })
        }
    }

    function i(e, t, a, l) {
        var n = -1 === l ? e.find(".owl-item.active") : o(e.find(".owl-item")[l]),
            d = n.prev().find(".eltdf-fsis-image").css("background-image"),
            i = n.next().find(".eltdf-fsis-image").css("background-image");
        d.length && t.css({"background-image": d}), i.length && a.css({"background-image": i})
    }

    (eltdf.modules.fullScreenImageSlider = e).eltdfOnWindowLoad = t, o(window).load(t)
}(jQuery), function (c) {
    "use strict";
    var e = {};

    function t() {
        a(), function () {
            var e = c("#fp-nav ul");
            e.length && e.each(function () {
                var e = c(this).find("li");
                e.length && e.each(function () {
                    c(this).append('<svg class="eltdf-svg-circle"><circle cx="50%" cy="50%" r="45%"></circle></svg>')
                })
            })
        }()
    }

    function a() {
        var e = c(".eltdf-full-screen-sections");
        e.length && e.each(function () {
            var l = c(this), e = l.children(".eltdf-fss-wrapper"), n = e.children(".eltdf-fss-item"), d = n.length,
                i = n.hasClass("eltdf-fss-item-has-style"), t = !1, a = "", o = "", s = "";
            eltdf.body.hasClass("eltdf-light-header") ? s = "light" : eltdf.body.hasClass("eltdf-dark-header") && (s = "dark"), void 0 !== l.data("enable-continuous-vertical") && !1 !== l.data("enable-continuous-vertical") && "yes" === l.data("enable-continuous-vertical") && (t = !0), void 0 !== l.data("enable-navigation") && !1 !== l.data("enable-navigation") && (a = l.data("enable-navigation")), void 0 !== l.data("enable-pagination") && !1 !== l.data("enable-pagination") && (o = l.data("enable-pagination"));
            var r = "no" !== a, f = "no" !== o;
            e.fullpage({
                sectionSelector: ".eltdf-fss-item",
                scrollingSpeed: 1200,
                verticalCentered: !1,
                continuousVertical: t,
                loopBottom: t,
                loopTop: t,
                navigation: f,
                onLeave: function (e, t, a) {
                    i && u(c(n[t - 1]).data("header-style"), s), r && m(l, d, t)
                },
                afterRender: function () {
                    i && u(n.first().data("header-style"), s), r && (m(l, d, 1), l.children(".eltdf-fss-nav-holder").css("visibility", "visible")), e.css("visibility", "visible")
                }
            }), function (e) {
                var t = e.find(".eltdf-fss-item"), i = "", a = "";
                t.each(function () {
                    var e = c(this), t = "", a = "", l = "", n = "", d = "";
                    void 0 !== e.data("item-class") && !1 !== e.data("item-class") && (t = e.data("item-class")), void 0 !== e.data("laptop-image") && !1 !== e.data("laptop-image") && (a = e.data("laptop-image")), void 0 !== e.data("tablet-image") && !1 !== e.data("tablet-image") && (l = e.data("tablet-image")), void 0 !== e.data("tablet-portrait-image") && !1 !== e.data("tablet-portrait-image") && (n = e.data("tablet-portrait-image")), void 0 !== e.data("mobile-image") && !1 !== e.data("mobile-image") && (d = e.data("mobile-image")), (a.length || l.length || n.length || d.length) && (a.length && (i += "@media only screen and (max-width: 1366px) {.eltdf-fss-item." + t + " { background-image: url(" + a + ") !important; } }"), l.length && (i += "@media only screen and (max-width: 1024px) {.eltdf-fss-item." + t + " { background-image: url( " + l + ") !important; } }"), n.length && (i += "@media only screen and (max-width: 800px) {.eltdf-fss-item." + t + " { background-image: url( " + n + ") !important; } }"), d.length && (i += "@media only screen and (max-width: 680px) {.eltdf-fss-item." + t + " { background-image: url( " + d + ") !important; } }"))
                }), i.length && (a = '<style type="text/css">' + i + "</style>");
                a.length && c("head").append(a)
            }(l), r && (l.find("#eltdf-fss-nav-up").on("click", function () {
                return c.fn.fullpage.moveSectionUp(), !1
            }), l.find("#eltdf-fss-nav-down").on("click", function () {
                return c.fn.fullpage.moveSectionDown(), !1
            }))
        })
    }

    function u(e, t) {
        void 0 !== e && "" !== e ? eltdf.body.removeClass("eltdf-light-header eltdf-dark-header").addClass("eltdf-" + e + "-header") : "" !== t ? eltdf.body.removeClass("eltdf-light-header eltdf-dark-header").addClass("eltdf-" + t + "-header") : eltdf.body.removeClass("eltdf-light-header eltdf-dark-header")
    }

    function m(e, t, a) {
        var l = e, n = l.find("#eltdf-fss-nav-up"), d = l.find("#eltdf-fss-nav-down"), i = !1;
        void 0 !== e.data("enable-continuous-vertical") && !1 !== e.data("enable-continuous-vertical") && "yes" === e.data("enable-continuous-vertical") && (i = !0), 1 !== a || i ? a !== t || i ? (n.css({
            opacity: "1",
            height: "auto",
            visibility: "visible"
        }), d.css({opacity: "1", height: "auto", visibility: "visible"})) : (d.css({
            opacity: "0",
            height: "0",
            visibility: "hidden"
        }), 2 === t && n.css({opacity: "1", height: "auto", visibility: "visible"})) : (n.css({
            opacity: "0",
            height: "0",
            visibility: "hidden"
        }), d.css({opacity: "0", height: "0", visibility: "hidden"}), a !== t && d.css({
            opacity: "1",
            height: "auto",
            visibility: "visible"
        }))
    }

    (eltdf.modules.fullScreenSections = e).eltdfInitFullScreenSections = a, e.eltdfOnDocumentReady = t, c(document).ready(t)
}(jQuery), function (p) {
    "use strict";
    var e = {};

    function t() {
        a()
    }

    function a() {
        var e = p(".eltdf-google-map");
        e.length && e.each(function () {
            var e, t, a, l, n, d, i, o, s, r, f = p(this), c = !1, u = "";
            if (void 0 !== f.data("snazzy-map-style") && "yes" === f.data("snazzy-map-style")) {
                c = !0;
                var m = f.parent().find(".eltdf-snazzy-map"), h = m.val();
                m.length && h.length && (u = JSON.parse(h.replace(/`{`/g, "[").replace(/`}`/g, "]").replace(/``/g, '"').replace(/`/g, "")))
            }
            void 0 !== f.data("custom-map-style") && (e = f.data("custom-map-style")), void 0 !== f.data("color-overlay") && !1 !== f.data("color-overlay") && (t = f.data("color-overlay")), void 0 !== f.data("saturation") && !1 !== f.data("saturation") && (a = f.data("saturation")), void 0 !== f.data("lightness") && !1 !== f.data("lightness") && (l = f.data("lightness")), void 0 !== f.data("zoom") && !1 !== f.data("zoom") && (n = f.data("zoom")), void 0 !== f.data("pin") && !1 !== f.data("pin") && (d = f.data("pin")), void 0 !== f.data("height") && !1 !== f.data("height") && (i = f.data("height")), void 0 !== f.data("unique-id") && !1 !== f.data("unique-id") && (o = f.data("unique-id")), void 0 !== f.data("scroll-wheel") && (s = f.data("scroll-wheel")), void 0 !== f.data("addresses") && !1 !== f.data("addresses") && (r = f.data("addresses")), function (e, t, a, l, n, d, i, o, s, r, f, c, u, m) {
                if ("object" != typeof google) return;
                var h, p = [];
                p = e && t.length ? t : [{stylers: [{hue: l}, {saturation: n}, {lightness: d}, {gamma: 1}]}];
                h = e || "yes" === a ? "eltdf-style" : google.maps.MapTypeId.ROADMAP;
                i = "yes" === i;
                var g = new google.maps.StyledMapType(p, {name: "Google Map"});
                u = new google.maps.Geocoder;
                var v = new google.maps.LatLng(-34.397, 150.644);
                isNaN(r) || (r += "px");
                var y, w = {
                    zoom: o,
                    scrollwheel: i,
                    center: v,
                    zoomControl: !0,
                    zoomControlOptions: {
                        style: google.maps.ZoomControlStyle.SMALL,
                        position: google.maps.ControlPosition.RIGHT_CENTER
                    },
                    scaleControl: !1,
                    scaleControlOptions: {position: google.maps.ControlPosition.LEFT_CENTER},
                    streetViewControl: !1,
                    streetViewControlOptions: {position: google.maps.ControlPosition.LEFT_CENTER},
                    panControl: !1,
                    panControlOptions: {position: google.maps.ControlPosition.LEFT_CENTER},
                    mapTypeControl: !1,
                    mapTypeControlOptions: {
                        mapTypeIds: [google.maps.MapTypeId.ROADMAP, "eltdf-style"],
                        style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                        position: google.maps.ControlPosition.LEFT_CENTER
                    },
                    mapTypeId: h
                };
                for ((c = new google.maps.Map(document.getElementById(s), w)).mapTypes.set("eltdf-style", g), y = 0; y < m.length; ++y) b(m[y], f, c, u);
                document.getElementById(s).style.height = r
            }(c, u, e, t, a, l, s, n, "eltdf-map-" + o, i, d, "map_" + o, "geocoder_" + o, r)
        })
    }

    function b(l, n, d, e) {
        if ("" !== l) {
            var t = '<div id="content"><div id="siteNotice"></div><div id="bodyContent"><p>' + l + "</p></div></div>",
                i = new google.maps.InfoWindow({content: t});
            e.geocode({address: l}, function (e, t) {
                if (t === google.maps.GeocoderStatus.OK) {
                    d.setCenter(e[0].geometry.location);
                    var a = new google.maps.Marker({
                        map: d,
                        position: e[0].geometry.location,
                        icon: n,
                        title: l.store_title
                    });
                    google.maps.event.addListener(a, "click", function () {
                        i.open(d, a)
                    }), google.maps.event.addDomListener(window, "resize", function () {
                        d.setCenter(e[0].geometry.location)
                    })
                }
            })
        }
    }

    (eltdf.modules.googleMap = e).eltdfShowGoogleMap = a, e.eltdfOnDocumentReady = t, p(document).ready(t)
}(jQuery), function (g) {
    "use strict";
    var e = {};

    function t() {
        a().init()
    }

    function a() {
        var d, e = g(".eltdf-horizontal-timeline");

        function t(e) {
            e.each(function () {
                var t = g(this), a = {};
                d = t.data("distance"), a.timelineNavWrapper = t.find(".eltdf-ht-nav-wrapper"), a.timelineNavWrapperWidth = a.timelineNavWrapper.width(), a.timelineNavInner = a.timelineNavWrapper.find(".eltdf-ht-nav-inner"), a.fillingLine = a.timelineNavInner.find(".eltdf-ht-nav-filling-line"), a.timelineEvents = a.timelineNavInner.find("a"), a.timelineDates = function (e) {
                    var i = [];
                    return e.each(function () {
                        var e = g(this), t = new String(e.data("date")), a = ["2000", "0", "0"], l = ["0", "0"];
                        if (4 === t.length) a = [t, "0", "0"]; else {
                            var n = t.split("T");
                            a = n[0].split("/"), 1 < n.length ? (a = n[0].split("/"), l = n[1].split(":")) : 0 <= n[0].indexOf(":") && (l = n[0].split(":"))
                        }
                        var d = new Date(a[2], a[1] - 1, a[0], l[0], l[1]);
                        i.push(d)
                    }), i
                }(a.timelineEvents), a.eventsMinLapse = function (e) {
                    for (var t = [], a = 1; a < e.length; a++) {
                        var l = h(e[a - 1], e[a]);
                        t.push(l)
                    }
                    return Math.min.apply(null, t)
                }(a.timelineDates), a.timelineNavigation = t.find(".eltdf-ht-nav-navigation"), a.timelineEventContent = t.find(".eltdf-ht-content"), a.timelineEvents.first().addClass("eltdf-selected"), a.timelineEventContent.find("li").first().addClass("eltdf-selected"), function (e, t) {
                    for (var a = 0; a < e.timelineDates.length; a++) {
                        var l = h(e.timelineDates[0], e.timelineDates[a]), n = Math.round(l / e.eventsMinLapse) + 2;
                        e.timelineEvents.eq(a).css("left", n * t + "px")
                    }
                }(a, d);
                var l = function (e, t) {
                    var a = h(e.timelineDates[0], e.timelineDates[e.timelineDates.length - 1]),
                        l = (Math.round(a / e.eventsMinLapse) + 4) * t;
                    l < e.timelineNavWrapperWidth && (l = e.timelineNavWrapperWidth);
                    return e.timelineNavInner.css("width", l + "px"), r(e.timelineNavInner.find("a.eltdf-selected"), e.fillingLine, l), o("next", e.timelineNavInner.find("a.eltdf-selected"), e), l
                }(a, d);
                t.addClass("eltdf-loaded"), a.timelineNavigation.on("click", ".eltdf-next", function (e) {
                    e.preventDefault(), n(a, l, "next")
                }), a.timelineNavigation.on("click", ".eltdf-prev", function (e) {
                    e.preventDefault(), n(a, l, "prev")
                }), a.timelineNavInner.on("click", "a", function (e) {
                    e.preventDefault();
                    var t = g(this);
                    a.timelineEvents.removeClass("eltdf-selected"), t.addClass("eltdf-selected"), c(t), r(t, a.fillingLine, l), f(t, a.timelineEventContent)
                });
                var e = window.getComputedStyle(document.querySelector(".eltdf-horizontal-timeline"), "::before").getPropertyValue("content").replace(/'/g, "").replace(/"/g, "");
                a.timelineEventContent.on("swipeleft", function () {
                    "mobile" === e && i(a, l, "next")
                }), a.timelineEventContent.on("swiperight", function () {
                    "mobile" === e && i(a, l, "prev")
                }), g(document).keyup(function (e) {
                    "37" === e.which && p(t.get(0)) ? i(a, l, "prev") : "39" === e.which && p(t.get(0)) && i(a, l, "next")
                })
            })
        }

        function n(e, t, a) {
            var l = u(e.timelineNavInner), n = Number(e.timelineNavWrapper.css("width").replace("px", ""));
            "next" === a ? s(e, l - n + d, n - t) : s(e, l + n - d)
        }

        function i(e, t, a) {
            var l = e.timelineEventContent.find(".eltdf-selected");
            if (0 < ("next" === a ? l.next() : l.prev()).length) {
                var n = e.timelineNavInner.find(".eltdf-selected"),
                    d = "next" === a ? n.parent("li").next("li").children("a") : n.parent("li").prev("li").children("a");
                r(d, e.fillingLine, t), f(d, e.timelineEventContent), d.addClass("eltdf-selected"), n.removeClass("eltdf-selected"), c(d), o(a, d, e)
            }
        }

        function o(e, t, a) {
            var l = window.getComputedStyle(t.get(0), null), n = Number(l.getPropertyValue("left").replace("px", "")),
                d = Number(a.timelineNavWrapper.css("width").replace("px", "")),
                i = Number(a.timelineNavInner.css("width").replace("px", "")), o = u(a.timelineNavInner);
            ("next" === e && d - o < n || "prev" === e && n < -o) && s(a, d / 2 - n, d - i)
        }

        function s(e, t, a) {
            t = 0 < t ? 0 : t, m(e.timelineNavInner.get(0), "translateX", (t = void 0 !== a && t < a ? a : t) + "px"), 0 === t ? e.timelineNavigation.find(".eltdf-prev").addClass("eltdf-inactive") : e.timelineNavigation.find(".eltdf-prev").removeClass("eltdf-inactive"), t === a ? e.timelineNavigation.find(".eltdf-next").addClass("eltdf-inactive") : e.timelineNavigation.find(".eltdf-next").removeClass("eltdf-inactive")
        }

        function r(e, t, a) {
            var l = window.getComputedStyle(e.get(0), null), n = l.getPropertyValue("left"),
                d = l.getPropertyValue("width"),
                i = (n = Number(n.replace("px", "")) + Number(d.replace("px", "")) / 2) / a;
            m(t.get(0), "scaleX", i)
        }

        function f(e, t) {
            var a = e.data("date"), l = t.find(".eltdf-selected"), n = t.find('[data-date="' + a + '"]'),
                d = n.height(), i = "eltdf-selected eltdf-enter-left", o = "eltdf-leave-right";
            n.index() > l.index() && (i = "eltdf-selected eltdf-enter-right", o = "eltdf-leave-left"), n.attr("class", i), l.attr("class", o).one("webkitAnimationEnd oanimationend msAnimationEnd animationend", function () {
                l.removeClass("eltdf-leave-right eltdf-leave-left"), n.removeClass("eltdf-enter-left eltdf-enter-right")
            }), t.css("height", d + "px")
        }

        function c(e) {
            e.parent("li").prevAll("li").children("a").addClass("eltdf-older-event").end().end().nextAll("li").children("a").removeClass("eltdf-older-event")
        }

        function u(e) {
            var t = window.getComputedStyle(e.get(0), null),
                a = t.getPropertyValue("-webkit-transform") || t.getPropertyValue("-moz-transform") || t.getPropertyValue("-ms-transform") || t.getPropertyValue("-o-transform") || t.getPropertyValue("transform"),
                l = 0;
            return 0 <= a.indexOf("(") && (l = (a = (a = (a = a.split("(")[1]).split(")")[0]).split(","))[4]), Number(l)
        }

        function m(e, t, a) {
            e.style["-webkit-transform"] = t + "(" + a + ")", e.style["-moz-transform"] = t + "(" + a + ")", e.style["-ms-transform"] = t + "(" + a + ")", e.style["-o-transform"] = t + "(" + a + ")", e.style.transform = t + "(" + a + ")"
        }

        function h(e, t) {
            return Math.round(t - e)
        }

        function p(e) {
            for (var t = e.offsetTop, a = e.offsetLeft, l = e.offsetWidth, n = e.offsetHeight; e.offsetParent;) t += (e = e.offsetParent).offsetTop, a += e.offsetLeft;
            return t < window.pageYOffset + window.innerHeight && a < window.pageXOffset + window.innerWidth && t + n > window.pageYOffset && a + l > window.pageXOffset
        }

        return {
            init: function () {
                0 < e.length && t(e)
            }
        }
    }

    (eltdf.modules.timeline = e).eltdfInitHorizontalTimeline = a, e.eltdfOnDocumentReady = t, g(document).ready(t)
}(jQuery), function (t) {
    "use strict";
    var e = {};

    function a() {
        l().init()
    }

    (eltdf.modules.icon = e).eltdfIcon = l, e.eltdfOnDocumentReady = a, t(document).ready(a);
    var l = function () {
        var e = t(".eltdf-icon-shortcode");
        return {
            init: function () {
                e.length && e.each(function () {
                    !function (e) {
                        e.hasClass("eltdf-icon-animation") && e.appear(function () {
                            e.parent(".eltdf-icon-animation-holder").addClass("eltdf-icon-animation-show")
                        }, {accX: 0, accY: eltdfGlobalVars.vars.eltdfElementAppearAmount})
                    }(t(this)), function (e) {
                        if (void 0 !== e.data("hover-color")) {
                            var t = function (e) {
                                e.data.icon.css("color", e.data.color)
                            }, a = e.find(".eltdf-icon-element"), l = e.data("hover-color"), n = a.css("color");
                            "" !== l && (e.on("mouseenter", {icon: a, color: l}, t), e.on("mouseleave", {
                                icon: a,
                                color: n
                            }, t))
                        }
                    }(t(this)), function (e) {
                        if (void 0 !== e.data("hover-background-color")) {
                            var t = function (e) {
                                e.data.icon.css("background-color", e.data.color)
                            }, a = e.data("hover-background-color"), l = e.css("background-color");
                            "" !== a && (e.on("mouseenter", {icon: e, color: a}, t), e.on("mouseleave", {
                                icon: e,
                                color: l
                            }, t))
                        }
                    }(t(this)), function (e) {
                        if (void 0 !== e.data("hover-border-color")) {
                            var t = function (e) {
                                e.data.icon.css("border-color", e.data.color)
                            }, a = e.data("hover-border-color"), l = e.css("borderTopColor");
                            "" !== a && (e.on("mouseenter", {icon: e, color: a}, t), e.on("mouseleave", {
                                icon: e,
                                color: l
                            }, t))
                        }
                    }(t(this))
                })
            }
        }
    }
}(jQuery), function (t) {
    "use strict";
    var e = {};

    function a() {
        l().init()
    }

    (eltdf.modules.iconListItem = e).eltdfInitIconList = l, e.eltdfOnDocumentReady = a, t(document).ready(a);
    var l = function () {
        var e = t(".eltdf-animate-list");
        return {
            init: function () {
                e.length && e.each(function () {
                    !function (e) {
                        setTimeout(function () {
                            e.appear(function () {
                                e.addClass("eltdf-appeared")
                            }, {accX: 0, accY: eltdfGlobalVars.vars.eltdfElementAppearAmount})
                        }, 30)
                    }(t(this))
                })
            }
        }
    }
}(jQuery), function (d) {
    "use strict";
    var e = {};

    function t() {
        a()
    }

    function a() {
        var e = d(".eltdf-image-gallery.eltdf-ig-carousel-type");
        e.length && e.each(function () {
            var e = d(this).children(".eltdf-ig-slider"), t = "", n = "";
            e.each(function () {
                var e = d(this), t = "", a = "";
                if (void 0 !== e.data("768-1024") && !1 !== e.data("768-1024") && (t = e.data("768-1024")), void 0 !== e.data("767") && !1 !== e.data("767") && (a = e.data("767")), (t.length || a.length) && (t.length && (n += "@media only screen and (min-width: 768px) and (max-width: 1024px) {.owl-stage-outer { height: " + t + " !important; } }"), a.length && (n += "@media only screen and (max-width: 767px) {.owl-stage-outer { height: " + a + " !important; } }")), "function" == typeof eltdf.modules.common.eltdfOwlSlider) {
                    var l = e.find(".eltdf-owl-slider");
                    l.length && setTimeout(function () {
                        l.trigger("refresh.owl.carousel")
                    }, 100)
                }
            }), n.length && (t = '<style type="text/css">' + n + "</style>"), t.length && d("head").append(t)
        })
    }

    (eltdf.modules.imageGallery = e).eltdfInitImageGalleryCarouselResponsiveStyle = a, e.eltdfOnDocumentReady = t, d(document).ready(t)
}(jQuery), function (m) {
    "use strict";
    var e = {};

    function t() {
        a()
    }

    function a() {
        var e = m(".eltdf-image-with-text-holder.eltdf-image-behavior-scrolling-image");
        e.length && e.each(function () {
            function e() {
                if (a = r.height(), n = f.height(), l = r.width(), d = f.width(), u) {
                    var e = a, t = d * a / n;
                    f.css("height", e), i = Math.round(t - l), o = 2.4 * Math.round(d / l)
                } else i = Math.round(n - a), o = 2.4 * Math.round(n / a);
                u ? l < d && (c = !0) : a < n && (c = !0)
            }

            var a, l, n, d, i, o, t = m(this), s = t.find(".eltdf-iwt-image"), r = t.find(".eltdf-iwt-frame"),
                f = t.find(".main-image"), c = !1, u = t.hasClass("eltdf-scrolling-horizontal");
            t.waitForImages(function () {
                t.css("visibility", "visible"), e(), s.mouseenter(function () {
                    f.css("transition-duration", .59 * o + "s"), u ? f.css("transform", "translate3d(-" + i + "px, 0px, 0px)") : f.css("transform", "translate3d(0px, -" + i + "px, 0px)")
                }), s.mouseleave(function () {
                    c && (f.css("transition-duration", Math.min(o / 1.8, 3.5) + "s"), f.css("transform", "translate3d(0px, 0px, 0px)"))
                })
            }), m(window).resize(function () {
                e()
            })
        })
    }

    (eltdf.modules.scrollingImage = e).eltdfScrollingImage = a, e.eltdfOnDocumentReady = t, m(document).ready(t)
}(jQuery), function (b) {
    "use strict";
    var e = {};

    function t() {
        a()
    }

    function a() {
        var e = b(".eltdf-ils-holder");
        e.length && e.each(function () {
            var a = b(this), l = a.find(".eltdf-ils-item-link");
            if (a.hasClass("eltdf-ils-standard")) {
                var g = 0, v = 0, y = 0, w = 0;
                l.length && l.on("mouseenter", function () {
                    l.removeClass("eltdf-active"), b(this).addClass("eltdf-active")
                }).on("mousemove", function (e) {
                    var t = b(this), a = t.find(".eltdf-ils-follow-content"), l = a.find(".eltdf-ils-follow-image"),
                        n = l.find("img"), d = n.width(), i = parseInt(l.data("images-count"), 10),
                        o = l.data("images"), s = a.find(".eltdf-ils-follow-title"), r = t.outerWidth(),
                        f = t.outerHeight(), c = t.offset().top - eltdf.scroll, u = t.offset().left;
                    if (g = e.clientX - u >> 0, v = e.clientY - c >> 0, y = r < g ? r : g < 0 ? 0 : g, w = f < v ? f : v < 0 ? 0 : v, 1 < i) {
                        var m = o.split("|"), h = r / i;
                        n.removeAttr("srcset"), y < h && n.attr("src", m[0]);
                        for (var p = 1; p <= i - 2; p++) h * p <= y && y < h * (p + 1) && n.attr("src", m[p]);
                        r - h <= y && n.attr("src", m[i - 1])
                    }
                    l.css({top: f / 2}), s.css({
                        transform: "translateY(" + -(parseInt(f, 10) / 2 + w) + "px)",
                        left: -(y - d / 2)
                    }), a.css({top: w, left: y})
                }).on("mouseleave", function () {
                    l.removeClass("eltdf-active")
                })
            } else {
                var n = a.find(".eltdf-ils-item-image");
                l = a.find(".eltdf-ils-item-link");
                n.eq(0).addClass("eltdf-active"), a.find('.eltdf-ils-item-link[data-index="0"]').addClass("eltdf-active"), l.children().on("touchstart mouseenter", function () {
                    var e = b(this).parent(), t = parseInt(e.data("index"), 10);
                    n.removeClass("eltdf-prev"), n.filter(".eltdf-active").addClass("eltdf-prev"), n.removeClass("eltdf-active").eq(t).addClass("eltdf-active"), l.removeClass("eltdf-active"), a.find('.eltdf-ils-item-link[data-index="' + t + '"]').addClass("eltdf-active")
                })
            }
        })
    }

    (eltdf.modules.interactiveLinkShowcase = e).eltdfInitInteractiveLinkShowcase = a, e.eltdfOnDocumentReady = t, b(document).ready(t)
}(jQuery), function (d) {
    "use strict";
    var e = {};

    function t() {
        a()
    }

    function a() {
        var e = d(".eltdf-item-showcase-holder");
        e.length && e.each(function () {
            var t = d(this), e = t.find(".eltdf-is-left"), a = t.find(".eltdf-is-right"), l = t.find(".eltdf-is-image");

            function n(e) {
                t.find(e).each(function (e) {
                    var t = d(this);
                    setTimeout(function () {
                        t.addClass("eltdf-appeared")
                    }, 150 * e)
                })
            }

            e.wrapAll("<div class='eltdf-is-item-holder eltdf-is-left-holder' />"), a.wrapAll("<div class='eltdf-is-item-holder eltdf-is-right-holder' />"), t.animate({opacity: 1}, 200), setTimeout(function () {
                t.appear(function () {
                    l.addClass("eltdf-appeared"), t.on("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function (e) {
                        1200 < eltdf.windowWidth ? (n(".eltdf-is-left-holder .eltdf-is-item"), n(".eltdf-is-right-holder .eltdf-is-item")) : n(".eltdf-is-item")
                    })
                }, {accX: 0, accY: eltdfGlobalVars.vars.eltdfElementAppearAmount})
            }, 100)
        })
    }

    (eltdf.modules.itemShowcase = e).eltdfInitItemShowcase = a, e.eltdfOnDocumentReady = t, d(document).ready(t)
}(jQuery), function (d) {
    "use strict";
    var e = {};

    function t() {
        a()
    }

    function a() {
        var e = d(".eltdf-pie-chart-holder");
        e.length && e.each(function () {
            var e = d(this), t = e.children(".eltdf-pc-percentage"), a = "#afafa5", l = "#f7f7f7", n = 176;
            void 0 !== t.data("size") && "" !== t.data("size") && (n = t.data("size")), void 0 !== t.data("bar-color") && "" !== t.data("bar-color") && (a = t.data("bar-color")), void 0 !== t.data("track-color") && "" !== t.data("track-color") && (l = t.data("track-color")), t.appear(function () {
                !function (e) {
                    var t = e.find(".eltdf-pc-percent"), a = parseFloat(t.text());
                    t.countTo({from: 0, to: a, speed: 1500, refreshInterval: 50})
                }(t), e.css("opacity", "1"), t.easyPieChart({
                    barColor: a,
                    trackColor: l,
                    scaleColor: !1,
                    lineCap: "butt",
                    lineWidth: 3,
                    animate: 1500,
                    size: n
                })
            }, {accX: 0, accY: eltdfGlobalVars.vars.eltdfElementAppearAmount})
        })
    }

    (eltdf.modules.pieChart = e).eltdfInitPieChart = a, e.eltdfOnDocumentReady = t, d(document).ready(t)
}(jQuery), function (t) {
    "use strict";
    var e = {};

    function a() {
        l()
    }

    function l() {
        var e = t(".eltdf-process-holder");
        e.length && e.each(function () {
            var e = t(this);
            e.appear(function () {
                e.addClass("eltdf-process-appeared")
            }, {accX: 0, accY: eltdfGlobalVars.vars.eltdfElementAppearAmount})
        })
    }

    (eltdf.modules.process = e).eltdfInitProcess = l, e.eltdfOnDocumentReady = a, t(document).ready(a)
}(jQuery), function (n) {
    "use strict";
    var e = {};

    function t() {
        a()
    }

    function a() {
        var e = n(".eltdf-progress-bar");
        e.length && e.each(function () {
            var e = n(this), t = e.find(".eltdf-pb-content"), a = e.find(".eltdf-pb-percent"), l = t.data("percentage");
            e.appear(function () {
                !function (e, t) {
                    var a = parseFloat(t);
                    e.length && e.each(function () {
                        var e = n(this);
                        e.css("opacity", "1"), e.countTo({from: 0, to: a, speed: 2e3, refreshInterval: 50})
                    })
                }(a, l), t.css("width", "0%").animate({width: l + "%"}, 2e3), e.hasClass("eltdf-pb-percent-floating") && a.css("left", "0%").animate({left: l + "%"}, 2e3)
            })
        })
    }

    (eltdf.modules.progressBar = e).eltdfInitProgressBars = a, e.eltdfOnDocumentReady = t, n(document).ready(t)
}(jQuery), function (t) {
    "use strict";
    var e = {};

    function a() {
        l()
    }

    function l() {
        var e = t(".eltdf-section-title-holder");
        e.length && e.each(function () {
            var e = t(this);
            e.appear(function () {
                e.addClass("eltdf-section-title-appeared")
            }, {accX: 0, accY: eltdfGlobalVars.vars.eltdfElementAppearAmount})
        })
    }

    (eltdf.modules.sectionTitle = e).eltdfInitSectionTitle = l, e.eltdfOnDocumentReady = a, t(document).ready(a)
}(jQuery), function (a) {
    "use strict";
    var e = {};

    function t() {
        l()
    }

    function l() {
        var e = a(".eltdf-stacked-images-holder");
        e.length && e.each(function () {
            var e = a(this), t = e.find(".eltdf-si-images");
            e.animate({opacity: 1}, 200), setTimeout(function () {
                e.appear(function () {
                    t.addClass("eltdf-appeared")
                }, {accX: 0, accY: eltdfGlobalVars.vars.eltdfElementAppearAmount})
            }, 100)
        })
    }

    (eltdf.modules.stackedImages = e).eltdfInitItemShowcase = l, e.eltdfOnDocumentReady = t, a(document).ready(t)
}(jQuery), function (n) {
    "use strict";
    var e = {};

    function t() {
        a()
    }

    function a() {
        var e = n(".eltdf-stamp-holder");
        e.length && e.each(function () {
            var e = n(this), t = e.data("appearing-delay"), a = e.children(".eltdf-s-text"),
                l = parseInt(a.data("count"), 10);
            a.children().each(function (e) {
                var t = 360 * e / l - 90, a = 60 * e / l * 10;
                n(this).css({transform: "rotate(" + t + "deg) translateZ(0)", "transition-delay": a + "ms"})
            });
            e.appear(function () {
                setTimeout(function () {
                    e.addClass("eltdf-stamp-appeared"), e.addClass("eltdf-appear"), setTimeout(function () {
                        e.addClass("eltdf-init")
                    }, 300), setTimeout(function () {
                        e.addClass("eltdf-animate-stamp")
                    }, 1e3)
                }, t)
            }, {accX: 0, accY: eltdfGlobalVars.vars.eltdfElementAppearAmount})
        })
    }

    (eltdf.modules.stamp = e).eltdfInitProcess = a, e.eltdfOnDocumentReady = t, n(document).ready(t)
}(jQuery), function (d) {
    "use strict";
    var e = {};

    function t() {
        !function () {
            var e = d(".eltdf-sig-image-holder");
            e.length && e.each(function () {
                var t = d(this), e = !1, a = !1, l = t;
                void 0 !== l.data("slider-animate-in") && !1 !== l.data("slider-animate-in") && (e = l.data("slider-animate-in")), void 0 !== l.data("slider-animate-out") && !1 !== l.data("slider-animate-out") && (a = l.data("slider-animate-out"));
                var n = d(".eltdf-sig-thumbnails-holder");
                n.find(".eltdf-sig-thumbnail").on("click", function () {
                    var e = d(this).index();
                    t.trigger("to.owl.carousel", e)
                }), t.waitForImages(function () {
                    d(this).owlCarousel({
                        items: 1,
                        loop: !0,
                        autoplay: !1,
                        autoplayHoverPause: !1,
                        autoplayTimeout: 3500,
                        smartSpeed: 700,
                        margin: 0,
                        stagePadding: 0,
                        center: !1,
                        autoWidth: !1,
                        animateIn: e,
                        animateOut: a,
                        dots: !0,
                        dotsContainer: n,
                        nav: !1,
                        drag: !0,
                        callbacks: !0,
                        navText: ['<span class="eltdf-prev-icon fa fa-chevron-left"></span>', '<span class="eltdf-next-icon fa fa-chevron-right"></span>'],
                        onInitialize: function () {
                            t.css("visibility", "visible")
                        },
                        onDrag: function (e) {
                            eltdf.body.hasClass("eltdf-smooth-page-transitions-fadeout") && 0 < e.isTrigger && t.addClass("eltdf-slider-is-moving")
                        },
                        onDragged: function () {
                            eltdf.body.hasClass("eltdf-smooth-page-transitions-fadeout") && t.hasClass("eltdf-slider-is-moving") && setTimeout(function () {
                                t.removeClass("eltdf-slider-is-moving")
                            }, 500)
                        }
                    })
                })
            })
        }()
    }

    (eltdf.modules.swappingImageGallery = e).eltdfOnWindowLoad = t, d(window).load(t)
}(jQuery), function (d) {
    "use strict";
    var e = {};

    function t() {
        a()
    }

    function a() {
        var e = d(".eltdf-tabs");
        e.length && e.each(function () {
            var e = d(this);
            e.children(".eltdf-tab-container").each(function (e) {
                e += 1;
                var t = d(this), a = t.attr("id"), l = t.parent().find(".eltdf-tabs-nav li:nth-child(" + e + ") a"),
                    n = l.attr("href");
                -1 < (a = "#" + a).indexOf(n) && l.attr("href", a)
            }), e.tabs(), d(".eltdf-tabs a.eltdf-external-link").unbind("click")
        })
    }

    (eltdf.modules.tabs = e).eltdfInitTabs = a, e.eltdfOnDocumentReady = t, d(document).ready(t)
}(jQuery), function (e) {
    "use strict";
    var t = {};

    function a() {
        l()
    }

    function l() {
        eltdf.modules.common.eltdfBlurImage(".eltdf-team-holder .eltdf-team-image", ".main-image")
    }

    (eltdf.modules.team = t).eltdfBlurImage = l, t.eltdfOnDocumentReady = a, e(document).ready(a)
}(jQuery), function (s) {
    "use strict";
    var e = {};

    function t() {
        a()
    }

    function a() {
        var i = s(".eltdf-uncovering-sections");
        i.length && i.each(function () {
            var e = s(this), t = i.find(".curtains"), a = t.find(".eltdf-uss-item"), l = i.find(".eltdf-fss-shadow"),
                n = eltdf.body, d = "";
            n.hasClass("eltdf-light-header") ? d = "light" : n.hasClass("eltdf-dark-header") && (d = "dark"), n.addClass("eltdf-uncovering-section-on-page"), 0 < eltdfPerPageVars.vars.eltdfHeaderVerticalWidth && 1024 < eltdf.windowWidth && (a.css({
                left: eltdfPerPageVars.vars.eltdfHeaderVerticalWidth,
                width: "calc(100% - " + eltdfPerPageVars.vars.eltdfHeaderVerticalWidth + "px)"
            }), l.css({
                left: eltdfPerPageVars.vars.eltdfHeaderVerticalWidth,
                width: "calc(100% - " + eltdfPerPageVars.vars.eltdfHeaderVerticalWidth + "px)"
            })), t.curtain({
                scrollSpeed: 400, nextSlide: function () {
                    o(t, d)
                }, prevSlide: function () {
                    o(t, d)
                }
            }), o(t, d), function (e) {
                var t = e.find(".eltdf-uss-item"), o = "", a = "";
                t.each(function () {
                    var e = s(this), t = e.find(".eltdf-uss-image-holder"), a = "", l = "", n = "", d = "", i = "";
                    void 0 !== e.data("item-class") && !1 !== e.data("item-class") && (a = e.data("item-class")), void 0 !== t.data("laptop-image") && !1 !== t.data("laptop-image") && (l = t.data("laptop-image")), void 0 !== t.data("tablet-image") && !1 !== t.data("tablet-image") && (n = t.data("tablet-image")), void 0 !== t.data("tablet-portrait-image") && !1 !== t.data("tablet-portrait-image") && (d = t.data("tablet-portrait-image")), void 0 !== t.data("mobile-image") && !1 !== t.data("mobile-image") && (i = t.data("mobile-image")), (l.length || n.length || d.length || i.length) && (l.length && (o += "@media only screen and (max-width: 1366px) {.eltdf-uss-item." + a + " .eltdf-uss-image-holder { background-image: url(" + l + ") !important; } }"), n.length && (o += "@media only screen and (max-width: 1024px) {.eltdf-uss-item." + a + " .eltdf-uss-image-holder { background-image: url( " + n + ") !important; } }"), d.length && (o += "@media only screen and (max-width: 800px) {.eltdf-uss-item." + a + " .eltdf-uss-image-holder { background-image: url( " + d + ") !important; } }"), i.length && (o += "@media only screen and (max-width: 680px) {.eltdf-uss-item." + a + " .eltdf-uss-image-holder { background-image: url( " + i + ") !important; } }"))
                }), o.length && (a = '<style type="text/css">' + o + "</style>");
                a.length && s("head").append(a)
            }(t), e.addClass("eltdf-loaded")
        })
    }

    function o(e, t) {
        var a = e.find(".current").data("header-style");
        void 0 !== a && "" !== a ? eltdf.body.removeClass("eltdf-light-header eltdf-dark-header").addClass("eltdf-" + a + "-header") : "" !== t ? eltdf.body.removeClass("eltdf-light-header eltdf-dark-header").addClass("eltdf-" + t + "-header") : eltdf.body.removeClass("eltdf-light-header eltdf-dark-header")
    }

    (eltdf.modules.uncoveringSections = e).eltdfInitUncoveringSections = a, e.eltdfOnDocumentReady = t, s(document).ready(t)
}(jQuery), function (r) {
    "use strict";
    var e = {};

    function t() {
        a(), function () {
            var e = r("#multiscroll-nav ul");
            e.length && e.each(function () {
                var e = r(this).find("li");
                e.length && e.each(function () {
                    r(this).append('<svg class="eltdf-svg-circle"><circle cx="50%" cy="50%" r="45%"></circle></svg>')
                })
            });
            setTimeout(function () {
                r("#multiscroll-nav").css({opacity: 1})
            }, 500)
        }()
    }

    function a() {
        var i = r(".eltdf-vertical-split-slider"), o = !0;
        if (i.length) {
            eltdf.body.hasClass("eltdf-vss-initialized") && (eltdf.body.removeClass("eltdf-vss-initialized"), r.fn.multiscroll.destroy()), setTimeout(function () {
                i.height(eltdf.windowHeight).animate({opacity: 1}, 800)
            }, 500);
            var s = "";
            eltdf.body.hasClass("eltdf-light-header") ? s = "light" : eltdf.body.hasClass("eltdf-dark-header") && (s = "dark"), i.multiscroll({
                scrollingSpeed: 700,
                easing: "easeInOutQuart",
                navigation: !0,
                useAnchorsOnLoad: !1,
                sectionSelector: ".eltdf-vss-ms-section",
                leftSelector: ".eltdf-vss-ms-left",
                rightSelector: ".eltdf-vss-ms-right",
                loopTop: !0,
                loopBottom: !0,
                css3: !0,
                afterRender: function () {
                    f(r(".eltdf-vss-ms-left .eltdf-vss-ms-section:first-child").data("header-style"), s), eltdf.body.addClass("eltdf-vss-initialized");
                    var e = r("div.wpcf7 > form");
                    e.length && e.each(function () {
                        var t = r(this);
                        t.find(".wpcf7-submit").off().on("click", function (e) {
                            e.preventDefault(), wpcf7.submit(t)
                        })
                    });
                    var t = r('<div class="eltdf-vss-responsive"></div>'), a = i.find(".eltdf-vss-ms-left > div"),
                        l = i.find(".eltdf-vss-ms-right > div");
                    i.after(t);
                    for (var n = 0; n < a.length; n++) t.append(r(a[n]).clone(!0)), t.append(r(l[a.length - 1 - n]).clone(!0));
                    var d = r(".eltdf-vss-responsive .eltdf-google-map");
                    d.length && d.each(function () {
                        var e = r(this);
                        e.empty();
                        var t = Math.floor(1e5 * Math.random() + 1);
                        e.attr("id", "eltdf-map-" + t), e.data("unique-id", t)
                    }), "function" == typeof eltdf.modules.animationHolder.eltdfInitAnimationHolder && eltdf.modules.animationHolder.eltdfInitAnimationHolder(), "function" == typeof eltdf.modules.common.eltdfPrettyPhoto && eltdf.modules.common.eltdfPrettyPhoto(), "function" == typeof eltdf.modules.button.eltdfButton && eltdf.modules.button.eltdfButton().init(), "function" == typeof eltdf.modules.elementsHolder.eltdfInitElementsHolderResponsiveStyle && eltdf.modules.elementsHolder.eltdfInitElementsHolderResponsiveStyle(), "function" == typeof eltdf.modules.googleMap.eltdfShowGoogleMap && eltdf.modules.googleMap.eltdfShowGoogleMap(), "function" == typeof eltdf.modules.icon.eltdfIcon && eltdf.modules.icon.eltdfIcon().init(), o && "function" == typeof eltdf.modules.progressBar.eltdfInitProgressBars && (r(".eltdf-vss-ms-left .eltdf-vss-ms-section.active").find(".eltdf-progress-bar").length || r(".eltdf-vss-ms-right .eltdf-vss-ms-section.active").find(".eltdf-progress-bar").length) && (eltdf.modules.progressBar.eltdfInitProgressBars(), o = !1)
                },
                onLeave: function (e, t) {
                    o && "function" == typeof eltdf.modules.progressBar.eltdfInitProgressBars && (r(".eltdf-vss-ms-left .eltdf-vss-ms-section.active").find(".eltdf-progress-bar").length || r(".eltdf-vss-ms-right .eltdf-vss-ms-section.active").find(".eltdf-progress-bar").length) && (setTimeout(function () {
                        eltdf.modules.progressBar.eltdfInitProgressBars()
                    }, 700), o = !1), function (e, t) {
                        e.hasClass("eltdf-vss-scrolling-animation") && (1 < t && !e.hasClass("eltdf-vss-scrolled") ? e.addClass("eltdf-vss-scrolled") : 1 === t && e.hasClass("eltdf-vss-scrolled") && e.removeClass("eltdf-vss-scrolled"))
                    }(i, t), f(r(r(".eltdf-vss-ms-left .eltdf-vss-ms-section")[t - 1]).data("header-style"), s)
                }
            }), eltdf.windowWidth <= 1024 ? r.fn.multiscroll.destroy() : r.fn.multiscroll.build(), r(window).resize(function () {
                eltdf.windowWidth <= 1024 ? r.fn.multiscroll.destroy() : r.fn.multiscroll.build()
            })
        }
    }

    function f(e, t) {
        void 0 !== e && "" !== e ? eltdf.body.removeClass("eltdf-light-header eltdf-dark-header").addClass("eltdf-" + e + "-header") : "" !== t ? eltdf.body.removeClass("eltdf-light-header eltdf-dark-header").addClass("eltdf-" + t + "-header") : eltdf.body.removeClass("eltdf-light-header eltdf-dark-header")
    }

    (eltdf.modules.verticalSplitSlider = e).eltdfInitVerticalSplitSlider = a, e.eltdfOnDocumentReady = t, r(document).ready(t)
}(jQuery), function (a) {
    "use strict";
    var e = {};

    function t() {
        l()
    }

    function l() {
        var e = a(".eltdf-workflow");
        e.length && e.each(function () {
            var e = a(this);
            if (e.hasClass("eltdf-workflow-animate")) {
                var t = e.find(".eltdf-workflow-item");
                e.appear(function () {
                    e.addClass("eltdf-appeared"), setTimeout(function () {
                        t.each(function (e) {
                            var t = a(this);
                            setTimeout(function () {
                                t.addClass("eltdf-appeared")
                            }, 350 * e)
                        })
                    }, 350)
                }, {accX: 0, accY: eltdfGlobalVars.vars.eltdfElementAppearAmount})
            }
        })
    }

    (eltdf.modules.workflow = e).eltdfWorkflow = l, e.eltdfOnDocumentReady = t, a(document).ready(t)
}(jQuery), function (a) {
    "use strict";
    var e = {};

    function t() {
        l().init()
    }

    function l() {
        var e = a(".eltdf-masonry-gallery-holder");
        return {
            init: function () {
                e.length && e.each(function () {
                    var e = a(this), t = e.find(".eltdf-mg-grid-sizer").outerWidth();
                    !function (t, a) {
                        t.waitForImages(function () {
                            var e = t.children();
                            e.isotope({
                                layoutMode: "packery",
                                itemSelector: ".eltdf-mg-item",
                                percentPosition: !0,
                                packery: {gutter: ".eltdf-mg-grid-gutter", columnWidth: ".eltdf-mg-grid-sizer"}
                            }), eltdf.modules.common.setFixedImageProportionSize(t, t.find(".eltdf-mg-item"), a, !0), setTimeout(function () {
                                eltdf.modules.common.eltdfInitParallax()
                            }, 600), e.isotope("layout").css("opacity", "1")
                        })
                    }(e, t), a(window).resize(function () {
                        !function (e, t) {
                            eltdf.modules.common.setFixedImageProportionSize(e, e.find(".eltdf-mg-item"), t, !0), e.children().isotope("reloadItems")
                        }(e, t)
                    })
                })
            }
        }
    }

    (eltdf.modules.masonryGalleryList = e).eltdfInitMasonryGallery = l, e.eltdfOnDocumentReady = t, a(document).ready(t)
}(jQuery), function (m) {
    "use strict";
    var e = {};

    function t() {
        a.init(), eltdf.modules.common.eltdfBlurImage(".eltdf-horizontal-scrolling-portfolio-holder .eltdf-hspl-item-inner", ".eltdf-hspli-image img"), function () {
            var e = m(".eltdf-horizontal-scrolling-portfolio-holder");
            eltdf.windowWidth < 1025 && e.length && e.each(function () {
                m(this).find("article").each(function () {
                    var e = m(this);
                    e.appear(function () {
                        setTimeout(function () {
                            e.addClass("eltdf-item-show")
                        }, 150)
                    })
                })
            })
        }()
    }

    (eltdf.modules.horizontalScrollingPortfolioList = e).eltdfOnDocumentReady = t, m(document).ready(t);
    var a = {
        init: function () {
            if (this.holder = m(".eltdf-horizontal-scrolling-portfolio-holder"), this.holder.length && 1024 < eltdf.windowWidth) {
                var t = this;
                t.holder.each(function () {
                    var e = m(this);
                    eltdf.body.addClass("eltdf-hspl-active"), a.load(t, e), m(window).resize(function () {
                        a.load(t, e)
                    })
                })
            }
        }, load: function (e, t) {
            768 < eltdf.windowWidth && (e.setMainVariables(e, t), eltdf.htmlEl.hasClass("touch") ? e.touchDevicesInit(e) : e.devicesInit(e))
        }, setMainVariables: function (e, t) {
            e.currentHolder = t, e.holderOffset = t.offset().top, e.listInner = t.find(".eltdf-hspl-inner"), e.section = document.querySelector(".eltdf-hspl-inner"), e.items = t.find(".eltdf-hspl-item"), e.featureItem = t.find(".eltdf-hspl-item.eltdf-hspl-featured"), e.calcHolderHeight(e), e.spaceBetweenItems = 2 * parseInt(t.find(".eltdf-hspl-item:not(.eltdf-hspl-featured)").css("paddingRight"), 10), e.rowsNumber = 2, e.widthValFeatured = 0, e.setFeaturedItemWidth(e), e.setItemWidth(e)
        }, calcHolderHeight: function (e) {
            var t = eltdf.windowHeight, a = e.currentHolder.data("header-decrease"), l = m(".eltdf-content-bottom"),
                n = l.length ? e.currentHolder.data("content-bottom-decrease") : "no";
            "yes" === a && (t -= e.holderOffset), "yes" === n && l.length && (t -= l.outerHeight()), e.listInner.css({height: t})
        }, setFeaturedItemWidth: function (e) {
            e.featureItem.length && (eltdf.windowWidth <= 1680 ? e.widthValFeatured = Math.round(.3 * parseInt(eltdf.windowWidth, 10)) : e.widthValFeatured = Math.round(.34 * parseInt(eltdf.windowWidth, 10)), e.listInner.css("left", e.widthValFeatured), e.featureItem.width(e.widthValFeatured))
        }, setItemWidth: function (s) {
            var r = 0, f = s.featureItem.length ? s.items.length - 1 : s.items.length, c = 0, u = s.listInner.height();
            s.items.each(function () {
                var e = m(this), t = 0, a = 0, l = e.find(".eltdf-hspl-item-content"),
                    n = l.outerHeight() + parseInt(l.css("marginTop"), 10);
                if (!e.hasClass("eltdf-hspl-featured")) {
                    c <= f / 2 ? c % 2 == 0 ? (t = 238, a = 356) : (t = 284, a = 230, eltdf.windowWidth < 1401 && (t = 234, a = 190)) : c % 2 != 0 ? (t = 284, a = 230, eltdf.windowWidth < 1401 && (t = 234, a = 190)) : (t = 238, a = 356);
                    var d = t + s.spaceBetweenItems, i = a + n, o = 0;
                    u / 2 < i && (o = Math.round(i - u / 2), d = Math.round(d * (i - o) / i)), e.css({
                        width: d,
                        height: i - o
                    }), r += d
                }
                c++
            }), eltdf.windowWidth <= 1680 ? s.listInner.width((r + 2 * s.spaceBetweenItems) / s.rowsNumber) : s.listInner.width((r + s.spaceBetweenItems / 2) / s.rowsNumber)
        }, getHolderWidth: function (e) {
            return e.listInner.outerWidth() + e.widthValFeatured + e.spaceBetweenItems - eltdf.windowWidth
        }, touchDevicesInit: function (t) {
            var e = new Hammer(t.section), a = 0;
            t.listInner.addClass("eltdf-ready"), e.on("swipe", function (e) {
                !function (e) {
                    t.listInner.css("transform", "translate3d(" + e + "px, 0, 0)")
                }(a = 0 < e.deltaX ? (a += e.distance, Math.min(0, a)) : (a -= e.distance, -Math.min(t.getHolderWidth(t), Math.abs(a))))
            })
        }, devicesInit: function (a) {
            var l = 0, n = 0;
            eltdf.htmlEl.add(eltdf.body).addClass("eltdf-overflow-hidden"), eltdf.modules.common.eltdfDisableScroll(), a.listInner.addClass("eltdf-ready"), VirtualScroll.on(function (e) {
                l += e.deltaY, l = Math.min(0, Math.max(-1 * a.getHolderWidth(a), l))
            });
            var d = function () {
                requestAnimationFrame(d);
                var e = "translate3d(" + (n += .08 * (l - n)) + "px, 0px, 0px)", t = a.section.style;
                t.transform = e, t.webkitTransform = e, t.mozTransform = e, t.msTransform = e, function (e) {
                    e.not(".eltdf-show").length && e.not(".eltdf-show").each(function () {
                        var e = m(this);
                        e.offset().left - eltdf.windowWidth < 0 && e.addClass("eltdf-show")
                    })
                }(a.items)
            };
            d()
        }
    }
}(jQuery), function (m) {
    "use strict";
    var e = {};

    function t() {
        !function () {
            var e = m(".eltdf-portfolio-list-holder .eltdf-pl-filter-holder");
            e.length && e.each(function () {
                var n = m(this), d = n.closest(".eltdf-portfolio-list-holder"), i = d.find(".eltdf-pl-inner"),
                    o = d.hasClass("eltdf-pl-pag-load-more");
                n.find(".eltdf-pl-filter:first").addClass("eltdf-pl-current"), d.hasClass("eltdf-pl-gallery") && i.isotope(), n.find(".eltdf-pl-filter").on("click", function () {
                    var e = m(this), t = e.attr("data-filter"), a = t.length ? t.substring(1) : "",
                        l = i.children().hasClass(a);
                    e.parent().children(".eltdf-pl-filter").removeClass("eltdf-pl-current"), e.addClass("eltdf-pl-current"), o && !l && t.length ? function l(e, t, a) {
                        var n = e, d = n.find(".eltdf-pl-inner"), i = t, o = a, s = 0;
                        void 0 !== n.data("max-num-pages") && !1 !== n.data("max-num-pages") && (s = n.data("max-num-pages"));
                        var r = eltdf.modules.common.getLoadMoreData(n), f = r.nextPage,
                            c = eltdf.modules.common.setLoadMoreAjaxData(r, "solene_core_portfolio_ajax_load_more"),
                            u = n.find(".eltdf-pl-loading");
                        f <= s && (u.addClass("eltdf-showing eltdf-filter-trigger"), d.css("opacity", "0"), m.ajax({
                            type: "POST",
                            data: c,
                            url: eltdfGlobalVars.vars.eltdfAjaxUrl,
                            success: function (e) {
                                f++, n.data("next-page", f);
                                var t = m.parseJSON(e), a = t.html;
                                n.waitForImages(function () {
                                    d.append(a).isotope("reloadItems").isotope({sortBy: "original-order"});
                                    var e = !!d.children().hasClass(o);
                                    e ? setTimeout(function () {
                                        eltdf.modules.common.setFixedImageProportionSize(n, d.find("article"), d.find(".eltdf-masonry-grid-sizer").width(), !0), d.isotope("layout").isotope({filter: i}), u.removeClass("eltdf-showing eltdf-filter-trigger"), setTimeout(function () {
                                            d.css("opacity", "1"), h(), eltdf.modules.common.eltdfInitParallax()
                                        }, 150)
                                    }, 400) : (u.removeClass("eltdf-showing eltdf-filter-trigger"), l(n, i, o))
                                })
                            }
                        }))
                    }(d, t, a) : (t = 0 === t.length ? "*" : t, n.parent().children(".eltdf-pl-inner").isotope({filter: t}), eltdf.modules.common.eltdfInitParallax())
                })
            })
        }(), h(), l().init()
    }

    function a() {
        l().scroll()
    }

    function h() {
        var e = m(".eltdf-portfolio-list-holder.eltdf-pl-has-animation");
        e.length && e.each(function () {
            m(this).children(".eltdf-pl-inner").children("article").each(function (e) {
                var t = m(this);
                t.appear(function () {
                    setTimeout(function () {
                        t.addClass("eltdf-item-show")
                    }, 150 * e), setTimeout(function () {
                        t.addClass("eltdf-item-shown")
                    }, 150 * e + 1e3)
                }, {accX: 0, accY: 0})
            })
        })
    }

    function l() {
        function t(e) {
            var t = e.outerHeight() + e.offset().top - eltdfGlobalVars.vars.eltdfAddForAdminBar;
            !e.hasClass("eltdf-pl-infinite-scroll-started") && eltdf.scroll + eltdf.windowHeight > t && n(e)
        }

        var e = m(".eltdf-portfolio-list-holder"), n = function (a, l) {
            var n, d, i = a.find(".eltdf-pl-inner");
            void 0 !== a.data("max-num-pages") && !1 !== a.data("max-num-pages") && (d = a.data("max-num-pages")), a.hasClass("eltdf-pl-pag-standard") && a.data("next-page", l), a.hasClass("eltdf-pl-pag-infinite-scroll") && a.addClass("eltdf-pl-infinite-scroll-started");
            var e = eltdf.modules.common.getLoadMoreData(a), o = a.find(".eltdf-pl-loading");
            if ((n = e.nextPage) <= d || 0 === d) {
                a.hasClass("eltdf-pl-pag-standard") ? (o.addClass("eltdf-showing eltdf-standard-pag-trigger"), a.addClass("eltdf-pl-pag-standard-animate")) : o.addClass("eltdf-showing");
                var t = eltdf.modules.common.setLoadMoreAjaxData(e, "solene_core_portfolio_ajax_load_more");
                m.ajax({
                    type: "POST", data: t, url: eltdfGlobalVars.vars.eltdfAjaxUrl, success: function (e) {
                        a.hasClass("eltdf-pl-pag-standard") || n++, a.data("next-page", n);
                        var t = m.parseJSON(e).html;
                        a.hasClass("eltdf-pl-pag-standard") ? (s(a, d, n), a.waitForImages(function () {
                            a.hasClass("eltdf-pl-masonry") ? r(a, i, o, t) : a.hasClass("eltdf-pl-gallery") && a.hasClass("eltdf-pl-has-filter") ? r(a, i, o, t) : f(a, i, o, t)
                        })) : a.waitForImages(function () {
                            a.hasClass("eltdf-pl-masonry") ? 1 === l ? r(a, i, o, t) : c(a, i, o, t) : a.hasClass("eltdf-pl-gallery") && a.hasClass("eltdf-pl-has-filter") && 1 !== l ? c(a, i, o, t) : 1 === l ? f(a, i, o, t) : u(i, o, t)
                        }), a.hasClass("eltdf-pl-infinite-scroll-started") && a.removeClass("eltdf-pl-infinite-scroll-started")
                    }
                })
            }
            n === d && a.find(".eltdf-pl-load-more-holder").hide()
        }, s = function (e, t, a) {
            var l = e.find(".eltdf-pl-standard-pagination"), n = l.find("li.eltdf-pag-number"),
                d = l.find("li.eltdf-pag-prev a"), i = l.find("li.eltdf-pag-next a");
            n.removeClass("eltdf-pag-active"), n.eq(a - 1).addClass("eltdf-pag-active"), d.data("paged", a - 1), i.data("paged", a + 1), 1 < a ? d.css({opacity: "1"}) : d.css({opacity: "0"}), a === t ? i.css({opacity: "0"}) : i.css({opacity: "1"})
        }, r = function (e, t, a, l) {
            t.find("article").remove(), t.append(l), eltdf.modules.common.setFixedImageProportionSize(e, t.find("article"), t.find(".eltdf-masonry-grid-sizer").width(), !0), t.isotope("reloadItems").isotope({sortBy: "original-order"}), a.removeClass("eltdf-showing eltdf-standard-pag-trigger"), e.removeClass("eltdf-pl-pag-standard-animate"), setTimeout(function () {
                t.isotope("layout"), h(), eltdf.modules.common.eltdfInitParallax(), eltdf.modules.common.eltdfPrettyPhoto()
            }, 600)
        }, f = function (e, t, a, l) {
            a.removeClass("eltdf-showing eltdf-standard-pag-trigger"), e.removeClass("eltdf-pl-pag-standard-animate"), t.html(l), h(), eltdf.modules.common.eltdfInitParallax(), eltdf.modules.common.eltdfPrettyPhoto()
        }, c = function (e, t, a, l) {
            t.append(l), eltdf.modules.common.setFixedImageProportionSize(e, t.find("article"), t.find(".eltdf-masonry-grid-sizer").width(), !0), t.isotope("reloadItems").isotope({sortBy: "original-order"}), a.removeClass("eltdf-showing"), setTimeout(function () {
                t.isotope("layout"), h(), eltdf.modules.common.eltdfInitParallax(), eltdf.modules.common.eltdfPrettyPhoto()
            }, 600)
        }, u = function (e, t, a) {
            t.removeClass("eltdf-showing"), e.append(a), h(), eltdf.modules.common.eltdfInitParallax(), eltdf.modules.common.eltdfPrettyPhoto()
        };
        return {
            init: function () {
                e.length && e.each(function () {
                    var e = m(this);
                    e.hasClass("eltdf-pl-pag-standard") && function (l) {
                        var e = l.find(".eltdf-pl-standard-pagination li");
                        e.length && e.each(function () {
                            var t = m(this).children("a"), a = 1;
                            t.on("click", function (e) {
                                e.preventDefault(), e.stopPropagation(), void 0 !== t.data("paged") && !1 !== t.data("paged") && (a = t.data("paged")), n(l, a)
                            })
                        })
                    }(e), e.hasClass("eltdf-pl-pag-load-more") && function (t) {
                        t.find(".eltdf-pl-load-more a").on("click", function (e) {
                            e.preventDefault(), e.stopPropagation(), n(t)
                        })
                    }(e), e.hasClass("eltdf-pl-pag-infinite-scroll") && t(e)
                })
            }, scroll: function () {
                e.length && e.each(function () {
                    var e = m(this);
                    e.hasClass("eltdf-pl-pag-infinite-scroll") && t(e)
                })
            }, getMainPagFunction: function (e, t) {
                n(e, t)
            }
        }
    }

    (eltdf.modules.portfolioList = e).eltdfOnWindowLoad = t, e.eltdfOnWindowScroll = a, m(window).load(t), m(window).scroll(a)
}(jQuery), function (n) {
    "use strict";
    var e = {};

    function t() {
        l(), eltdf.modules.common.eltdfBlurImage(".eltdf-portfolio-slider-full-screen .owl-item", ".eltdf-psfsi-image-holder")
    }

    function a() {
        !function () {
            var e = n(".eltdf-portfolio-slider-full-screen.eltdf-pl-mousewheel-enabled");
            e.length && e.each(function () {
                var t = n(this).find(".eltdf-owl-slider"), a = !0;
                t.on("translate.owl.carousel", function () {
                    a = !1
                }), t.on("translated.owl.carousel", function () {
                    a = !0
                }), t.on("mousewheel", ".owl-stage", function (e) {
                    a && (0 < e.deltaY ? t.trigger("prev.owl") : t.trigger("next.owl"), e.preventDefault())
                })
            })
        }()
    }

    function l() {
        var e = n(".eltdf-portfolio-slider-full-screen .owl-item"), t = n(".eltdf-page-header").height(),
            a = n(".eltdf-page-footer").height(), l = n(".eltdf-content-bottom").height();
        e.length && e.each(function () {
            n(this).css({height: "calc(100vh - " + (t + a + l) + "px)"})
        })
    }

    eltdf.modules.eltdfPortfolioFullScreenSlider = l, e.eltdfOnDocumentReady = t, e.eltdfOnWindowLoad = a, n(document).ready(t), n(window).load(a)
}(jQuery), function (m) {
    "use strict";
    var e = {};

    function t() {
        !function () {
            var e = m(".eltdf-portfolio-vertical-loop-holder");
            e.length && e.each(function () {
                var i, o, s = m(this), e = m(".eltdf-page-header"), r = m(".eltdf-mobile-header"), t = e.outerHeight(),
                    f = eltdf.body.hasClass("eltdf-paspartu-enabled") ? parseInt(m(".eltdf-paspartu-enabled .eltdf-wrapper").css("padding-left")) : 0;
                o = eltdf.body.hasClass("eltdf-content-is-behind-header") ? 0 : t;
                var c = !0, u = m(".eltdf-pvl-inner");
                m(eltdf.body).on("click", ".eltdf-pvli-content-holder .eltdf-pvli-content-link", function (e) {
                    if (e.preventDefault(), !c) return !1;
                    c = !1;
                    var t = m(this);
                    i = eltdf.windowWidth < 1e3 ? r.outerHeight() : o;
                    var a = eltdf.window.scrollTop(), l = t.closest("article").offset().top - a - i - f;
                    u.find("article:eq(0)").addClass("fade-out"), t.closest("article").addClass("move-up").removeClass("next-item").css("transform", "translateY(-" + l + "px)"), setTimeout(function () {
                        eltdf.window.scrollTop(0), u.find("article:eq(0)").remove(), t.closest("article").removeAttr("style").removeClass("move-up")
                    }, 450);
                    var n = eltdf.modules.common.getLoadMoreData(s),
                        d = eltdf.modules.common.setLoadMoreAjaxData(n, "solene_core_portfolio_vertical_loop_ajax_load_more");
                    m.ajax({
                        type: "POST", data: d, url: eltdfGlobalVars.vars.eltdfAjaxUrl, success: function (e) {
                            var t = m.parseJSON(e), a = t.html, l = t.next_item_id;
                            s.data("next-item-id", l);
                            var n = m(a).find(".eltdf-pvl-item-inner").parent().addClass("next-item").fadeIn(400);
                            u.append(n), c = !0
                        }
                    }), function (e) {
                        var n = e.find(".eltdf-pvl-navigation-holder"),
                            t = (n.find(".eltdf-pvl-navigation"), eltdf.modules.common.getLoadMoreData(n)),
                            a = eltdf.modules.common.setLoadMoreAjaxData(t, "solene_core_portfolio_vertical_loop_ajax_load_more_navigation");
                        m.ajax({
                            type: "POST", data: a, url: eltdfGlobalVars.vars.eltdfAjaxUrl, success: function (e) {
                                var t = m.parseJSON(e), a = t.html, l = t.next_item_id;
                                n.data("next-item-id", l), n.html(a)
                            }
                        })
                    }(s)
                }), function (d, i) {
                    var e = d.find(".eltdf-pvl-navigation-holder");
                    e.find(".eltdf-pvl-navigation");
                    if (void 0 !== e.data("id") && !1 !== e.data("id")) var t = e.data("id");
                    if (void 0 !== e.data("next-item-id") && !1 !== e.data("next-item-id")) var a = e.data("next-item-id");
                    void 0 !== d.data("id") && !1 === d.data("id") || d.data("id", t);
                    void 0 !== d.data("next-item-id") && !1 !== d.data("next-item-id") || d.data("next-item-id", a);
                    var l = eltdf.modules.common.getLoadMoreData(d),
                        n = eltdf.modules.common.setLoadMoreAjaxData(l, "solene_core_portfolio_vertical_loop_ajax_load_more");
                    m.ajax({
                        type: "POST", data: n, url: eltdfGlobalVars.vars.eltdfAjaxUrl, success: function (e) {
                            var t = m.parseJSON(e), a = t.html, l = t.next_item_id;
                            d.data("next-item-id", l);
                            var n = m(a).find(".eltdf-pvl-item-inner").parent().addClass("next-item").fadeIn(400);
                            i.append(n)
                        }
                    })
                }(s, u)
            })
        }()
    }

    (eltdf.modules.portfolioVerticalLoop = e).eltdfOnDocumentReady = t, m(document).ready(t)
}(jQuery), function (m) {
    "use strict";
    var e = {};

    function t() {
        d(), l().init()
    }

    function a() {
        l().scroll()
    }

    function d() {
        var e = m(".eltdf-proofing-gallery-list-holder.eltdf-pgl-has-animation");
        e.length && e.each(function () {
            m(this).children(".eltdf-pgl-inner").children("article").each(function (e) {
                var t = m(this);
                t.appear(function () {
                    t.addClass("eltdf-item-show"), setTimeout(function () {
                        t.addClass("eltdf-item-shown")
                    }, 1e3)
                }, {accX: 0, accY: 0})
            })
        })
    }

    function l() {
        function t(e) {
            var t = e.outerHeight() + e.offset().top - eltdfGlobalVars.vars.eltdfAddForAdminBar;
            !e.hasClass("eltdf-pgl-infinite-scroll-started") && eltdf.scroll + eltdf.windowHeight > t && n(e)
        }

        var e = m(".eltdf-proofing-gallery-list-holder"), n = function (a, e) {
            var l, n, d = a.find(".eltdf-pgl-inner");
            void 0 !== a.data("max-num-pages") && !1 !== a.data("max-num-pages") && (n = a.data("max-num-pages")), a.hasClass("eltdf-pgl-pag-standard") && a.data("next-page", e), a.hasClass("eltdf-pgl-pag-infinite-scroll") && a.addClass("eltdf-pgl-infinite-scroll-started");
            var t = eltdf.modules.common.getLoadMoreData(a), i = a.find(".eltdf-pgl-loading");
            if ((l = t.nextPage) <= n) {
                a.hasClass("eltdf-pgl-pag-standard") ? (i.addClass("eltdf-showing eltdf-standard-pag-trigger"), a.addClass("eltdf-pgl-pag-standard-animate")) : i.addClass("eltdf-showing");
                var o = eltdf.modules.common.setLoadMoreAjaxData(t, "solene_core_proofing_gallery_ajax_load_more");
                m.ajax({
                    type: "POST", data: o, url: eltdfGlobalVars.vars.eltdfAjaxUrl, success: function (e) {
                        a.hasClass("eltdf-pgl-pag-standard") || l++, a.data("next-page", l);
                        var t = m.parseJSON(e).html;
                        a.hasClass("eltdf-pgl-pag-standard") ? (s(a, n, l), a.waitForImages(function () {
                            a.hasClass("eltdf-pgl-masonry") ? r(a, d, i, t) : a.hasClass("eltdf-pgl-gallery") && a.hasClass("eltdf-pgl-has-filter") ? r(a, d, i, t) : f(a, d, i, t)
                        })) : a.waitForImages(function () {
                            a.hasClass("eltdf-pgl-masonry") ? c(d, i, t) : a.hasClass("eltdf-pgl-gallery") && a.hasClass("eltdf-pgl-has-filter") ? c(d, i, t) : u(d, i, t)
                        }), a.hasClass("eltdf-pgl-infinite-scroll-started") && a.removeClass("eltdf-pgl-infinite-scroll-started")
                    }
                })
            }
            l === n && a.find(".eltdf-pgl-load-more-holder").hide()
        }, s = function (e, t, a) {
            var l = e.find(".eltdf-pgl-standard-pagination"), n = l.find("li.eltdf-pag-number"),
                d = l.find("li.eltdf-pag-prev a"), i = l.find("li.eltdf-pag-next a");
            n.removeClass("eltdf-pag-active"), n.eq(a - 1).addClass("eltdf-pag-active"), d.data("paged", a - 1), i.data("paged", a + 1), 1 < a ? d.css({opacity: "1"}) : d.css({opacity: "0"}), a === t ? i.css({opacity: "0"}) : i.css({opacity: "1"})
        }, r = function (e, t, a, l) {
            t.html(l).isotope("reloadItems").isotope({sortBy: "original-order"}), a.removeClass("eltdf-showing eltdf-standard-pag-trigger"), e.removeClass("eltdf-pgl-pag-standard-animate"), setTimeout(function () {
                t.isotope("layout"), d()
            }, 400)
        }, f = function (e, t, a, l) {
            a.removeClass("eltdf-showing eltdf-standard-pag-trigger"), e.removeClass("eltdf-pgl-pag-standard-animate"), t.html(l), d()
        }, c = function (e, t, a) {
            e.append(a).isotope("reloadItems").isotope({sortBy: "original-order"}), t.removeClass("eltdf-showing"), setTimeout(function () {
                e.isotope("layout"), d()
            }, 400)
        }, u = function (e, t, a) {
            t.removeClass("eltdf-showing"), e.append(a), d()
        };
        return {
            init: function () {
                e.length && e.each(function () {
                    var e = m(this);
                    e.hasClass("eltdf-pgl-pag-standard") && function (l) {
                        var e = l.find(".eltdf-pgl-standard-pagination li");
                        e.length && e.each(function () {
                            var t = m(this).children("a"), a = 1;
                            t.on("click", function (e) {
                                e.preventDefault(), e.stopPropagation(), void 0 !== t.data("paged") && !1 !== t.data("paged") && (a = t.data("paged")), n(l, a)
                            })
                        })
                    }(e), e.hasClass("eltdf-pgl-pag-load-more") && function (t) {
                        t.find(".eltdf-pgl-load-more a").on("click", function (e) {
                            e.preventDefault(), e.stopPropagation(), n(t)
                        })
                    }(e), e.hasClass("eltdf-pgl-pag-infinite-scroll") && t(e)
                })
            }, scroll: function () {
                e.length && e.each(function () {
                    var e = m(this);
                    e.hasClass("eltdf-pgl-pag-infinite-scroll") && t(e)
                })
            }
        }
    }

    (eltdf.modules.proofingGalleryList = e).eltdfOnWindowLoad = t, e.eltdfOnWindowScroll = a, m(window).load(t), m(window).scroll(a)
}(jQuery), function (f) {
    "use strict";
    var e = {};

    function t() {
        a()
    }

    function a() {
        var e = f(".eltdf-testimonials-holder.eltdf-testimonials-carousel");
        e.length && e.each(function () {
            var e = f(this), t = e.find(".eltdf-testimonials-main"), n = e.children(".eltdf-testimonial-image-nav"),
                a = !0, l = !0, d = 500, i = 600, o = !1;
            if ("no" === t.data("enable-loop") && (a = !1), "no" === t.data("enable-autoplay") && (l = !1), void 0 !== t.data("slider-speed") && !1 !== t.data("slider-speed") && (d = t.data("slider-speed")), void 0 !== t.data("slider-speed-animation") && !1 !== t.data("slider-speed-animation") && (i = t.data("slider-speed-animation")), eltdf.windowWidth < 680 && (o = !0), t.length && n.length) {
                var s = t.owlCarousel({
                    items: 1,
                    loop: a,
                    autoplay: l,
                    autoplayTimeout: d,
                    smartSpeed: i,
                    autoplayHoverPause: !1,
                    dots: !1,
                    nav: !1,
                    mouseDrag: !1,
                    touchDrag: o,
                    onInitialize: function () {
                        t.css("visibility", "visible")
                    }
                }), r = n.owlCarousel({
                    loop: a,
                    autoplay: l,
                    autoplayTimeout: d,
                    smartSpeed: i,
                    autoplayHoverPause: !1,
                    center: !0,
                    dots: !1,
                    nav: !1,
                    mouseDrag: !1,
                    touchDrag: !1,
                    responsive: {1025: {items: 5}, 0: {items: 3}},
                    onInitialize: function () {
                        n.css("visibility", "visible"), e.css("opacity", "1")
                    }
                });
                n.find(".owl-item").on("click touchpress", function (e) {
                    e.preventDefault();
                    var t = f(this).index(), a = n.find(".owl-item.cloned").length, l = 0 <= t - a / 2 ? t - a / 2 : t;
                    r.trigger("to.owl.carousel", l), s.trigger("to.owl.carousel", l)
                })
            }
        })
    }

    (eltdf.modules.testimonialsCarousel = e).eltdfInitTestimonials = a, e.eltdfOnWindowLoad = t, f(window).load(t)
}(jQuery), function (m) {
    "use strict";
    var e = {};

    function t() {
        !function () {
            var e = m(".eltdf-testimonials-image-pagination-inner");
            e.length && e.each(function () {
                var t = m(this), e = t.children().length, a = !0, l = !0, n = 3500, d = 500, i = !1, o = !1, s = !1,
                    r = !0, f = !1, c = t;
                if ("no" === c.data("enable-loop") && (a = !1), void 0 !== c.data("slider-speed") && !1 !== c.data("slider-speed") && (n = c.data("slider-speed")), void 0 !== c.data("slider-speed-animation") && !1 !== c.data("slider-speed-animation") && (d = c.data("slider-speed-animation")), "yes" === c.data("enable-auto-width") && (i = !0), void 0 !== c.data("slider-animate-in") && !1 !== c.data("slider-animate-in") && (o = c.data("slider-animate-in")), void 0 !== c.data("slider-animate-out") && !1 !== c.data("slider-animate-out") && (s = c.data("slider-animate-out")), "no" === c.data("enable-navigation") && (r = !1), "yes" === c.data("enable-pagination") && (f = !0), r && f && t.addClass("eltdf-slider-has-both-nav"), f) {
                    var u = "#eltdf-testimonial-pagination";
                    m(".eltdf-tsp-item").on("click", function () {
                        t.trigger("to.owl.carousel", [m(this).index(), 300])
                    })
                }
                e <= 1 && (f = r = l = a = !1), t.waitForImages(function () {
                    m(this).owlCarousel({
                        items: 1,
                        loop: a,
                        autoplay: l,
                        autoplayHoverPause: !1,
                        autoplayTimeout: n,
                        smartSpeed: d,
                        margin: 0,
                        stagePadding: 0,
                        center: !1,
                        autoWidth: i,
                        animateIn: o,
                        animateOut: s,
                        dots: f,
                        dotsContainer: u,
                        nav: r,
                        drag: !0,
                        callbacks: !0,
                        navText: ['<span class="eltdf-prev-icon ion-chevron-left"></span>', '<span class="eltdf-next-icon ion-chevron-right"></span>'],
                        onInitialize: function () {
                            t.css("visibility", "visible")
                        },
                        onDrag: function (e) {
                            eltdf.body.hasClass("eltdf-smooth-page-transitions-fadeout") && 0 < e.isTrigger && t.addClass("eltdf-slider-is-moving")
                        },
                        onDragged: function () {
                            eltdf.body.hasClass("eltdf-smooth-page-transitions-fadeout") && t.hasClass("eltdf-slider-is-moving") && setTimeout(function () {
                                t.removeClass("eltdf-slider-is-moving")
                            }, 500)
                        }
                    })
                })
            })
        }()
    }

    (eltdf.modules.testimonialsImagePagination = e).eltdfOnDocumentReady = t, m(document).ready(t)
}(jQuery), function (l) {
    "use strict";
    l(document).ready(function () {
        !function () {
            var e = l(".eltdf-testimonials-vertical");
            e.length && e.each(function () {
                var e = l(this), t = e.find(".swiper-container"), a = new Swiper(t, {
                    autoplay: !1,
                    loop: !0,
                    centeredSlides: !0,
                    slidesPerView: "auto",
                    freeMode: !1,
                    direction: "vertical",
                    speed: 500,
                    navigation: {prevEl: e.find(".eltdf-prev-icon"), nextEl: e.find(".eltdf-next-icon")},
                    pagination: {
                        el: ".swiper-pagination", type: "fraction", renderCustom: function (e, t, a) {
                            return t + " of " + a
                        }
                    },
                    breakpoints: {680: {direction: "horizontal"}},
                    parallax: !0,
                    init: !1,
                    autoHeight: !0
                });
                l(window).load(function () {
                    e.addClass("eltdf-initialized"), a.init()
                })
            })
        }()
    })
}(jQuery);
;!function (d, l) {
    "use strict";
    var e = !1, o = !1;
    if (l.querySelector) if (d.addEventListener) e = !0;
    if (d.wp = d.wp || {}, !d.wp.receiveEmbedMessage) if (d.wp.receiveEmbedMessage = function (e) {
        var t = e.data;
        if (t) if (t.secret || t.message || t.value) if (!/[^a-zA-Z0-9]/.test(t.secret)) {
            var r, a, i, s, n, o = l.querySelectorAll('iframe[data-secret="' + t.secret + '"]'),
                c = l.querySelectorAll('blockquote[data-secret="' + t.secret + '"]');
            for (r = 0; r < c.length; r++) c[r].style.display = "none";
            for (r = 0; r < o.length; r++) if (a = o[r], e.source === a.contentWindow) {
                if (a.removeAttribute("style"), "height" === t.message) {
                    if (1e3 < (i = parseInt(t.value, 10))) i = 1e3; else if (~~i < 200) i = 200;
                    a.height = i
                }
                if ("link" === t.message) if (s = l.createElement("a"), n = l.createElement("a"), s.href = a.getAttribute("src"), n.href = t.value, n.host === s.host) if (l.activeElement === a) d.top.location.href = t.value
            }
        }
    }, e) d.addEventListener("message", d.wp.receiveEmbedMessage, !1), l.addEventListener("DOMContentLoaded", t, !1), d.addEventListener("load", t, !1);

    function t() {
        if (!o) {
            o = !0;
            var e, t, r, a, i = -1 !== navigator.appVersion.indexOf("MSIE 10"),
                s = !!navigator.userAgent.match(/Trident.*rv:11\./),
                n = l.querySelectorAll("iframe.wp-embedded-content");
            for (t = 0; t < n.length; t++) {
                if (!(r = n[t]).getAttribute("data-secret")) a = Math.random().toString(36).substr(2, 10), r.src += "#?secret=" + a, r.setAttribute("data-secret", a);
                if (i || s) (e = r.cloneNode(!0)).removeAttribute("security"), r.parentNode.replaceChild(e, r)
            }
        }
    }
}(window, document);
;
/*!
 * WPBakery Page Builder v6.0.0 (https://wpbakery.com)
 * Copyright 2011-2019 Michael M, WPBakery
 * License: Commercial. More details: http://go.wpbakery.com/licensing
 */

// jscs:disable
// jshint ignore: start

document.documentElement.className += " js_active ", document.documentElement.className += "ontouchstart" in document.documentElement ? " vc_mobile " : " vc_desktop ", function () {
    for (var prefix = ["-webkit-", "-moz-", "-ms-", "-o-", ""], i = 0; i < prefix.length; i++) prefix[i] + "transform" in document.documentElement.style && (document.documentElement.className += " vc_transform ")
}(), function ($) {
    "function" != typeof window.vc_js && (window.vc_js = function () {
        "use strict";
        vc_toggleBehaviour(), vc_tabsBehaviour(), vc_accordionBehaviour(), vc_teaserGrid(), vc_carouselBehaviour(), vc_slidersBehaviour(), vc_prettyPhoto(), vc_pinterest(), vc_progress_bar(), vc_plugin_flexslider(), vc_gridBehaviour(), vc_rowBehaviour(), vc_prepareHoverBox(), vc_googleMapsPointer(), vc_ttaActivation(), jQuery(document).trigger("vc_js"), window.setTimeout(vc_waypoints, 500)
    }), "function" != typeof window.vc_plugin_flexslider && (window.vc_plugin_flexslider = function ($parent) {
        ($parent ? $parent.find(".wpb_flexslider") : jQuery(".wpb_flexslider")).each(function () {
            var this_element = jQuery(this), sliderTimeout = 1e3 * parseInt(this_element.attr("data-interval"), 10),
                sliderFx = this_element.attr("data-flex_fx"), slideshow = !0;
            0 === sliderTimeout && (slideshow = !1), this_element.is(":visible") && this_element.flexslider({
                animation: sliderFx,
                slideshow: slideshow,
                slideshowSpeed: sliderTimeout,
                sliderSpeed: 800,
                smoothHeight: !0
            })
        })
    }), "function" != typeof window.vc_googleplus && (window.vc_googleplus = function () {
        0 < jQuery(".wpb_googleplus").length && function () {
            var po = document.createElement("script");
            po.type = "text/javascript", po.async = !0, po.src = "https://apis.google.com/js/plusone.js";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(po, s)
        }()
    }), "function" != typeof window.vc_pinterest && (window.vc_pinterest = function () {
        0 < jQuery(".wpb_pinterest").length && function () {
            var po = document.createElement("script");
            po.type = "text/javascript", po.async = !0, po.src = "https://assets.pinterest.com/js/pinit.js";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(po, s)
        }()
    }), "function" != typeof window.vc_progress_bar && (window.vc_progress_bar = function () {
        void 0 !== jQuery.fn.vcwaypoint && jQuery(".vc_progress_bar").each(function () {
            var $el = jQuery(this);
            $el.vcwaypoint(function () {
                $el.find(".vc_single_bar").each(function (index) {
                    var bar = jQuery(this).find(".vc_bar"), val = bar.data("percentage-value");
                    setTimeout(function () {
                        bar.css({width: val + "%"})
                    }, 200 * index)
                })
            }, {offset: "85%"})
        })
    }), "function" != typeof window.vc_waypoints && (window.vc_waypoints = function () {
        void 0 !== jQuery.fn.vcwaypoint && jQuery(".wpb_animate_when_almost_visible:not(.wpb_start_animation)").each(function () {
            var $el = jQuery(this);
            $el.vcwaypoint(function () {
                $el.addClass("wpb_start_animation animated")
            }, {offset: "85%"})
        })
    }), "function" != typeof window.vc_toggleBehaviour && (window.vc_toggleBehaviour = function ($el) {
        function event(e) {
            e && e.preventDefault && e.preventDefault();
            var element = jQuery(this).closest(".vc_toggle"), content = element.find(".vc_toggle_content");
            element.hasClass("vc_toggle_active") ? content.slideUp({
                duration: 300, complete: function () {
                    element.removeClass("vc_toggle_active")
                }
            }) : content.slideDown({
                duration: 300, complete: function () {
                    element.addClass("vc_toggle_active")
                }
            })
        }

        $el ? $el.hasClass("vc_toggle_title") ? $el.unbind("click").on("click", event) : $el.find(".vc_toggle_title").off("click").on("click", event) : jQuery(".vc_toggle_title").off("click").on("click", event)
    }), "function" != typeof window.vc_tabsBehaviour && (window.vc_tabsBehaviour = function ($tab) {
        if (jQuery.ui) {
            var $call = $tab || jQuery(".wpb_tabs, .wpb_tour"),
                ver = jQuery.ui && jQuery.ui.version ? jQuery.ui.version.split(".") : "1.10",
                old_version = 1 === parseInt(ver[0], 10) && parseInt(ver[1], 10) < 9;
            $call.each(function (index) {
                var $tabs, interval = jQuery(this).attr("data-interval"), tabs_array = [];
                if ($tabs = jQuery(this).find(".wpb_tour_tabs_wrapper").tabs({
                    show: function (event, ui) {
                        wpb_prepare_tab_content(event, ui)
                    }, activate: function (event, ui) {
                        wpb_prepare_tab_content(event, ui)
                    }
                }), interval && 0 < interval) try {
                    $tabs.tabs("rotate", 1e3 * interval)
                } catch (err) {
                    window.console && window.console.warn && console.warn("tabs behaviours error", err)
                }
                jQuery(this).find(".wpb_tab").each(function () {
                    tabs_array.push(this.id)
                }), jQuery(this).find(".wpb_tabs_nav li").on("click", function (e) {
                    return e && e.preventDefault && e.preventDefault(), old_version ? $tabs.tabs("select", jQuery("a", this).attr("href")) : $tabs.tabs("option", "active", jQuery(this).index()), !1
                }), jQuery(this).find(".wpb_prev_slide a, .wpb_next_slide a").on("click", function (e) {
                    var index, length;
                    e && e.preventDefault && e.preventDefault(), old_version ? (index = $tabs.tabs("option", "selected"), jQuery(this).parent().hasClass("wpb_next_slide") ? index++ : index--, index < 0 ? index = $tabs.tabs("length") - 1 : index >= $tabs.tabs("length") && (index = 0), $tabs.tabs("select", index)) : (index = $tabs.tabs("option", "active"), length = $tabs.find(".wpb_tab").length, index = jQuery(this).parent().hasClass("wpb_next_slide") ? length <= index + 1 ? 0 : index + 1 : index - 1 < 0 ? length - 1 : index - 1, $tabs.tabs("option", "active", index))
                })
            })
        }
    }), "function" != typeof window.vc_accordionBehaviour && (window.vc_accordionBehaviour = function () {
        jQuery(".wpb_accordion").each(function (index) {
            var $tabs, active_tab, collapsible, $this = jQuery(this);
            $this.attr("data-interval"), collapsible = !1 === (active_tab = !isNaN(jQuery(this).data("active-tab")) && 0 < parseInt($this.data("active-tab"), 10) && parseInt($this.data("active-tab"), 10) - 1) || "yes" === $this.data("collapsible"), $tabs = $this.find(".wpb_accordion_wrapper").accordion({
                header: "> div > h3",
                autoHeight: !1,
                heightStyle: "content",
                active: active_tab,
                collapsible: collapsible,
                navigation: !0,
                activate: vc_accordionActivate,
                change: function (event, ui) {
                    void 0 !== jQuery.fn.isotope && ui.newContent.find(".isotope").isotope("layout"), vc_carouselBehaviour(ui.newPanel)
                }
            }), !0 === $this.data("vcDisableKeydown") && ($tabs.data("uiAccordion")._keydown = function () {
            })
        })
    }), "function" != typeof window.vc_teaserGrid && (window.vc_teaserGrid = function () {
        var layout_modes = {fitrows: "fitRows", masonry: "masonry"};
        jQuery(".wpb_grid .teaser_grid_container:not(.wpb_carousel), .wpb_filtered_grid .teaser_grid_container:not(.wpb_carousel)").each(function () {
            var $container = jQuery(this), $thumbs = $container.find(".wpb_thumbnails"),
                layout_mode = $thumbs.attr("data-layout-mode");
            $thumbs.isotope({
                itemSelector: ".isotope-item",
                layoutMode: void 0 === layout_modes[layout_mode] ? "fitRows" : layout_modes[layout_mode]
            }), $container.find(".categories_filter a").data("isotope", $thumbs).on("click", function (e) {
                e && e.preventDefault && e.preventDefault();
                var $thumbs = jQuery(this).data("isotope");
                jQuery(this).parent().parent().find(".active").removeClass("active"), jQuery(this).parent().addClass("active"), $thumbs.isotope({filter: jQuery(this).attr("data-filter")})
            }), jQuery(window).bind("load resize", function () {
                $thumbs.isotope("layout")
            })
        })
    }), "function" != typeof window.vc_carouselBehaviour && (window.vc_carouselBehaviour = function ($parent) {
        ($parent ? $parent.find(".wpb_carousel") : jQuery(".wpb_carousel")).each(function () {
            var $this = jQuery(this);
            if (!0 !== $this.data("carousel_enabled") && $this.is(":visible")) {
                $this.data("carousel_enabled", !0);
                getColumnsCount(jQuery(this));
                jQuery(this).hasClass("columns_count_1") && 900;
                var carousel_li = jQuery(this).find(".wpb_thumbnails-fluid li");
                carousel_li.css({"margin-right": carousel_li.css("margin-left"), "margin-left": 0});
                var fluid_ul = jQuery(this).find("ul.wpb_thumbnails-fluid");
                fluid_ul.width(fluid_ul.width() + 300), jQuery(window).on("resize", function () {
                    screen_size != (screen_size = getSizeName()) && window.setTimeout(function () {
                        location.reload()
                    }, 20)
                })
            }
        })
    }), "function" != typeof window.vc_slidersBehaviour && (window.vc_slidersBehaviour = function () {
        jQuery(".wpb_gallery_slides").each(function (index) {
            var $imagesGrid, this_element = jQuery(this);
            if (this_element.hasClass("wpb_slider_nivo")) {
                var sliderTimeout = 1e3 * this_element.attr("data-interval");
                0 === sliderTimeout && (sliderTimeout = 9999999999), this_element.find(".nivoSlider").nivoSlider({
                    effect: "boxRainGrow,boxRain,boxRainReverse,boxRainGrowReverse",
                    slices: 15,
                    boxCols: 8,
                    boxRows: 4,
                    animSpeed: 800,
                    pauseTime: sliderTimeout,
                    startSlide: 0,
                    directionNav: !0,
                    directionNavHide: !0,
                    controlNav: !0,
                    keyboardNav: !1,
                    pauseOnHover: !0,
                    manualAdvance: !1,
                    prevText: "Prev",
                    nextText: "Next"
                })
            } else this_element.hasClass("wpb_image_grid") && (jQuery.fn.imagesLoaded ? $imagesGrid = this_element.find(".wpb_image_grid_ul").imagesLoaded(function () {
                $imagesGrid.isotope({itemSelector: ".isotope-item", layoutMode: "fitRows"})
            }) : this_element.find(".wpb_image_grid_ul").isotope({
                itemSelector: ".isotope-item",
                layoutMode: "fitRows"
            }))
        })
    }), "function" != typeof window.vc_prettyPhoto && (window.vc_prettyPhoto = function () {
        try {
            jQuery && jQuery.fn && jQuery.fn.prettyPhoto && jQuery('a.prettyphoto, .gallery-icon a[href*=".jpg"]').prettyPhoto({
                animationSpeed: "normal",
                hook: "data-rel",
                padding: 15,
                opacity: .7,
                showTitle: !0,
                allowresize: !0,
                counter_separator_label: "/",
                hideflash: !1,
                deeplinking: !1,
                modal: !1,
                callback: function () {
                    -1 < location.href.indexOf("#!prettyPhoto") && (location.hash = "")
                },
                social_tools: ""
            })
        } catch (err) {
            window.console && window.console.warn && window.console.warn("vc_prettyPhoto initialize error", err)
        }
    }), "function" != typeof window.vc_google_fonts && (window.vc_google_fonts = function () {
        return window.console && window.console.warn && window.console.warn("function vc_google_fonts is deprecated, no need to use it"), !1
    }), window.vcParallaxSkroll = !1, "function" != typeof window.vc_rowBehaviour && (window.vc_rowBehaviour = function () {
        var vcSkrollrOptions, callSkrollInit, $ = window.jQuery;

        function fullWidthRow() {
            var $elements = $('[data-vc-full-width="true"]');
            $.each($elements, function (key, item) {
                var $el = $(this);
                $el.addClass("vc_hidden");
                var $el_full = $el.next(".vc_row-full-width");
                if ($el_full.length || ($el_full = $el.parent().next(".vc_row-full-width")), $el_full.length) {
                    var padding, paddingRight, el_margin_left = parseInt($el.css("margin-left"), 10),
                        el_margin_right = parseInt($el.css("margin-right"), 10),
                        offset = 0 - $el_full.offset().left - el_margin_left, width = $(window).width();
                    if ("rtl" === $el.css("direction") && (offset -= $el_full.width(), offset += width, offset += el_margin_left, offset += el_margin_right), $el.css({
                        position: "relative",
                        left: offset,
                        "box-sizing": "border-box",
                        width: width
                    }), !$el.data("vcStretchContent")) "rtl" === $el.css("direction") ? ((padding = offset) < 0 && (padding = 0), (paddingRight = offset) < 0 && (paddingRight = 0)) : ((padding = -1 * offset) < 0 && (padding = 0), (paddingRight = width - padding - $el_full.width() + el_margin_left + el_margin_right) < 0 && (paddingRight = 0)), $el.css({
                        "padding-left": padding + "px",
                        "padding-right": paddingRight + "px"
                    });
                    $el.attr("data-vc-full-width-init", "true"), $el.removeClass("vc_hidden"), $(document).trigger("vc-full-width-row-single", {
                        el: $el,
                        offset: offset,
                        marginLeft: el_margin_left,
                        marginRight: el_margin_right,
                        elFull: $el_full,
                        width: width
                    })
                }
            }), $(document).trigger("vc-full-width-row", $elements)
        }

        function fullHeightRow() {
            var windowHeight, offsetTop, fullHeight, $element = $(".vc_row-o-full-height:first");
            $element.length && (windowHeight = $(window).height(), (offsetTop = $element.offset().top) < windowHeight && (fullHeight = 100 - offsetTop / (windowHeight / 100), $element.css("min-height", fullHeight + "vh")));
            $(document).trigger("vc-full-height-row", $element)
        }

        $(window).off("resize.vcRowBehaviour").on("resize.vcRowBehaviour", fullWidthRow).on("resize.vcRowBehaviour", fullHeightRow), fullWidthRow(), fullHeightRow(), (0 < window.navigator.userAgent.indexOf("MSIE ") || navigator.userAgent.match(/Trident.*rv\:11\./)) && $(".vc_row-o-full-height").each(function () {
            "flex" === $(this).css("display") && $(this).wrap('<div class="vc_ie-flexbox-fixer"></div>')
        }), vc_initVideoBackgrounds(), callSkrollInit = !1, window.vcParallaxSkroll && window.vcParallaxSkroll.destroy(), $(".vc_parallax-inner").remove(), $("[data-5p-top-bottom]").removeAttr("data-5p-top-bottom data-30p-top-bottom"), $("[data-vc-parallax]").each(function () {
            var skrollrSize, skrollrStart, $parallaxElement, parallaxImage, youtubeId;
            callSkrollInit = !0, "on" === $(this).data("vcParallaxOFade") && $(this).children().attr("data-5p-top-bottom", "opacity:0;").attr("data-30p-top-bottom", "opacity:1;"), skrollrSize = 100 * $(this).data("vcParallax"), ($parallaxElement = $("<div />").addClass("vc_parallax-inner").appendTo($(this))).height(skrollrSize + "%"), parallaxImage = $(this).data("vcParallaxImage"), (youtubeId = vcExtractYoutubeId(parallaxImage)) ? insertYoutubeVideoAsBackground($parallaxElement, youtubeId) : void 0 !== parallaxImage && $parallaxElement.css("background-image", "url(" + parallaxImage + ")"), skrollrStart = -(skrollrSize - 100), $parallaxElement.attr("data-bottom-top", "top: " + skrollrStart + "%;").attr("data-top-bottom", "top: 0%;")
        }), callSkrollInit && window.skrollr && (vcSkrollrOptions = {
            forceHeight: !1,
            smoothScrolling: !1,
            mobileCheck: function () {
                return !1
            }
        }, window.vcParallaxSkroll = skrollr.init(vcSkrollrOptions), window.vcParallaxSkroll)
    }), "function" != typeof window.vc_gridBehaviour && (window.vc_gridBehaviour = function () {
        jQuery.fn.vcGrid && jQuery("[data-vc-grid]").vcGrid()
    }), "function" != typeof window.getColumnsCount && (window.getColumnsCount = function (el) {
        for (var find = !1, i = 1; !1 === find;) {
            if (el.hasClass("columns_count_" + i)) return find = !0, i;
            i++
        }
    });
    var screen_size = getSizeName();

    function getSizeName() {
        var screen_w = jQuery(window).width();
        return 1170 < screen_w ? "desktop_wide" : 960 < screen_w && screen_w < 1169 ? "desktop" : 768 < screen_w && screen_w < 959 ? "tablet" : 300 < screen_w && screen_w < 767 ? "mobile" : screen_w < 300 ? "mobile_portrait" : ""
    }

    "function" != typeof window.wpb_prepare_tab_content && (window.wpb_prepare_tab_content = function (event, ui) {
        var $ui_panel, $google_maps, panel = ui.panel || ui.newPanel,
            $pie_charts = panel.find(".vc_pie_chart:not(.vc_ready)"), $round_charts = panel.find(".vc_round-chart"),
            $line_charts = panel.find(".vc_line-chart"), $carousel = panel.find('[data-ride="vc_carousel"]');
        if (vc_carouselBehaviour(), vc_plugin_flexslider(panel), ui.newPanel.find(".vc_masonry_media_grid, .vc_masonry_grid").length && ui.newPanel.find(".vc_masonry_media_grid, .vc_masonry_grid").each(function () {
            var grid = jQuery(this).data("vcGrid");
            grid && grid.gridBuilder && grid.gridBuilder.setMasonry && grid.gridBuilder.setMasonry()
        }), panel.find(".vc_masonry_media_grid, .vc_masonry_grid").length && panel.find(".vc_masonry_media_grid, .vc_masonry_grid").each(function () {
            var grid = jQuery(this).data("vcGrid");
            grid && grid.gridBuilder && grid.gridBuilder.setMasonry && grid.gridBuilder.setMasonry()
        }), $pie_charts.length && jQuery.fn.vcChat && $pie_charts.vcChat(), $round_charts.length && jQuery.fn.vcRoundChart && $round_charts.vcRoundChart({reload: !1}), $line_charts.length && jQuery.fn.vcLineChart && $line_charts.vcLineChart({reload: !1}), $carousel.length && jQuery.fn.carousel && $carousel.carousel("resizeAction"), $ui_panel = panel.find(".isotope, .wpb_image_grid_ul"), $google_maps = panel.find(".wpb_gmaps_widget"), 0 < $ui_panel.length && $ui_panel.isotope("layout"), $google_maps.length && !$google_maps.is(".map_ready")) {
            var $frame = $google_maps.find("iframe");
            $frame.attr("src", $frame.attr("src")), $google_maps.addClass("map_ready")
        }
        panel.parents(".isotope").length && panel.parents(".isotope").each(function () {
            jQuery(this).isotope("layout")
        })
    }), "function" != typeof window.vc_ttaActivation && (window.vc_ttaActivation = function () {
        jQuery("[data-vc-accordion]").on("show.vc.accordion", function (e) {
            var $ = window.jQuery, ui = {};
            ui.newPanel = $(this).data("vc.accordion").getTarget(), window.wpb_prepare_tab_content(e, ui)
        })
    }), "function" != typeof window.vc_accordionActivate && (window.vc_accordionActivate = function (event, ui) {
        if (ui.newPanel.length && ui.newHeader.length) {
            var $pie_charts = ui.newPanel.find(".vc_pie_chart:not(.vc_ready)"),
                $round_charts = ui.newPanel.find(".vc_round-chart"), $line_charts = ui.newPanel.find(".vc_line-chart"),
                $carousel = ui.newPanel.find('[data-ride="vc_carousel"]');
            void 0 !== jQuery.fn.isotope && ui.newPanel.find(".isotope, .wpb_image_grid_ul").isotope("layout"), ui.newPanel.find(".vc_masonry_media_grid, .vc_masonry_grid").length && ui.newPanel.find(".vc_masonry_media_grid, .vc_masonry_grid").each(function () {
                var grid = jQuery(this).data("vcGrid");
                grid && grid.gridBuilder && grid.gridBuilder.setMasonry && grid.gridBuilder.setMasonry()
            }), vc_carouselBehaviour(ui.newPanel), vc_plugin_flexslider(ui.newPanel), $pie_charts.length && jQuery.fn.vcChat && $pie_charts.vcChat(), $round_charts.length && jQuery.fn.vcRoundChart && $round_charts.vcRoundChart({reload: !1}), $line_charts.length && jQuery.fn.vcLineChart && $line_charts.vcLineChart({reload: !1}), $carousel.length && jQuery.fn.carousel && $carousel.carousel("resizeAction"), ui.newPanel.parents(".isotope").length && ui.newPanel.parents(".isotope").each(function () {
                jQuery(this).isotope("layout")
            })
        }
    }), "function" != typeof window.initVideoBackgrounds && (window.initVideoBackgrounds = function () {
        return window.console && window.console.warn && window.console.warn("this function is deprecated use vc_initVideoBackgrounds"), vc_initVideoBackgrounds()
    }), "function" != typeof window.vc_initVideoBackgrounds && (window.vc_initVideoBackgrounds = function () {
        jQuery("[data-vc-video-bg]").each(function () {
            var youtubeUrl, youtubeId, $element = jQuery(this);
            $element.data("vcVideoBg") ? (youtubeUrl = $element.data("vcVideoBg"), (youtubeId = vcExtractYoutubeId(youtubeUrl)) && ($element.find(".vc_video-bg").remove(), insertYoutubeVideoAsBackground($element, youtubeId)), jQuery(window).on("grid:items:added", function (event, $grid) {
                $element.has($grid).length && vcResizeVideoBackground($element)
            })) : $element.find(".vc_video-bg").remove()
        })
    }), "function" != typeof window.insertYoutubeVideoAsBackground && (window.insertYoutubeVideoAsBackground = function ($element, youtubeId, counter) {
        if ("undefined" == typeof YT || void 0 === YT.Player) return 100 < (counter = void 0 === counter ? 0 : counter) ? void console.warn("Too many attempts to load YouTube api") : void setTimeout(function () {
            insertYoutubeVideoAsBackground($element, youtubeId, counter++)
        }, 100);
        var $container = $element.prepend('<div class="vc_video-bg vc_hidden-xs"><div class="inner"></div></div>').find(".inner");
        new YT.Player($container[0], {
            width: "100%",
            height: "100%",
            videoId: youtubeId,
            playerVars: {
                playlist: youtubeId,
                iv_load_policy: 3,
                enablejsapi: 1,
                disablekb: 1,
                autoplay: 1,
                controls: 0,
                showinfo: 0,
                rel: 0,
                loop: 1,
                wmode: "transparent"
            },
            events: {
                onReady: function (event) {
                    event.target.mute().setLoop(!0)
                }
            }
        }), vcResizeVideoBackground($element), jQuery(window).bind("resize", function () {
            vcResizeVideoBackground($element)
        })
    }), "function" != typeof window.vcResizeVideoBackground && (window.vcResizeVideoBackground = function ($element) {
        var iframeW, iframeH, marginLeft, marginTop, containerW = $element.innerWidth(),
            containerH = $element.innerHeight();
        containerW / containerH < 16 / 9 ? (iframeW = containerH * (16 / 9), iframeH = containerH, marginLeft = -Math.round((iframeW - containerW) / 2) + "px", marginTop = -Math.round((iframeH - containerH) / 2) + "px") : (iframeH = (iframeW = containerW) * (9 / 16), marginTop = -Math.round((iframeH - containerH) / 2) + "px", marginLeft = -Math.round((iframeW - containerW) / 2) + "px"), iframeW += "px", iframeH += "px", $element.find(".vc_video-bg iframe").css({
            maxWidth: "1000%",
            marginLeft: marginLeft,
            marginTop: marginTop,
            width: iframeW,
            height: iframeH
        })
    }), "function" != typeof window.vcExtractYoutubeId && (window.vcExtractYoutubeId = function (url) {
        if (void 0 === url) return !1;
        var id = url.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
        return null !== id && id[1]
    }), "function" != typeof window.vc_googleMapsPointer && (window.vc_googleMapsPointer = function () {
        var $ = window.jQuery, $wpbGmapsWidget = $(".wpb_gmaps_widget");
        $wpbGmapsWidget.on("click", function () {
            $("iframe", this).css("pointer-events", "auto")
        }), $wpbGmapsWidget.on("mouseleave", function () {
            $("iframe", this).css("pointer-events", "none")
        }), $(".wpb_gmaps_widget iframe").css("pointer-events", "none")
    }), "function" != typeof window.vc_setHoverBoxPerspective && (window.vc_setHoverBoxPerspective = function (hoverBox) {
        hoverBox.each(function () {
            var $this = jQuery(this), perspective = 4 * $this.width() + "px";
            $this.css("perspective", perspective)
        })
    }), "function" != typeof window.vc_setHoverBoxHeight && (window.vc_setHoverBoxHeight = function (hoverBox) {
        hoverBox.each(function () {
            var $this = jQuery(this), hoverBoxInner = $this.find(".vc-hoverbox-inner");
            hoverBoxInner.css("min-height", 0);
            var frontHeight = $this.find(".vc-hoverbox-front-inner").outerHeight(),
                backHeight = $this.find(".vc-hoverbox-back-inner").outerHeight(),
                hoverBoxHeight = backHeight < frontHeight ? frontHeight : backHeight;
            hoverBoxHeight < 250 && (hoverBoxHeight = 250), hoverBoxInner.css("min-height", hoverBoxHeight + "px")
        })
    }), "function" != typeof window.vc_prepareHoverBox && (window.vc_prepareHoverBox = function () {
        var hoverBox = jQuery(".vc-hoverbox");
        vc_setHoverBoxHeight(hoverBox), vc_setHoverBoxPerspective(hoverBox)
    }), jQuery(document).ready(window.vc_prepareHoverBox), jQuery(window).resize(window.vc_prepareHoverBox), jQuery(document).ready(function ($) {
        window.vc_js()
    })
}(window.jQuery);
;(function ($) {
    "use strict";
    $.fn.countTo = function (options) {
        options = $.extend({}, $.fn.countTo.defaults, options || {});
        var loops = Math.ceil(options.speed / options.refreshInterval), increment = (options.to - options.from) / loops;
        return $(this).each(function () {
            var _this = this, loopCount = 0, value = options.from,
                interval = setInterval(updateTimer, options.refreshInterval);

            function updateTimer() {
                value += increment;
                loopCount++;
                $(_this).html(value.toFixed(options.decimals));
                if (typeof(options.onUpdate) === 'function') {
                    options.onUpdate.call(_this, value);
                }
                if (loopCount >= loops) {
                    clearInterval(interval);
                    value = options.to;
                    if (typeof(options.onComplete) === 'function') {
                        options.onComplete.call(_this, value);
                    }
                }
            }
        });
    };
    $.fn.countTo.defaults = {
        from: 0,
        to: 100,
        speed: 1000,
        refreshInterval: 100,
        decimals: 0,
        onUpdate: null,
        onComplete: null
    };
})(jQuery);
;
/* Absolute counter */
(function (a) {
    "use strict";
    a.fn.absoluteCounter = function (b) {
        b = a.extend({}, a.fn.absoluteCounter.defaults, b || {});
        return a(this).each(function () {
            var d = this, g = b.speed, f = b.setStyles, e = b.delayedStart, c = b.fadeInDelay;
            if (f) {
                a(d).css({display: "block", position: "relative", overflow: "hidden"}).addClass('animated')
            }
            a(d).css("opacity", "0");
            a(d).animate({opacity: 0}, e, function () {
                var l = a(d).text();
                a(d).text("");
                for (var k = 0; k < l.length; k++) {
                    var n = l.charAt(k);
                    var m = "";
                    if (parseInt(n, 10) >= 0) {
                        m = '<span class="onedigit p' + (l.length - k) + " d" + n + '">';
                        for (var h = 0; h <= parseInt(n, 10); h++) {
                            m += '<span class="n' + (h % 10) + '">' + (h % 10) + "</span>"
                        }
                        m += "</span>"
                    } else {
                        m = '<span class="onedigit p' + (l.length - k) + ' char"><span class="c">' + n + "</span></span>"
                    }
                    a(d).append(m)
                }
                a(d).animate({opacity: 1}, c);
                a("span.onedigit", d).each(function (i, o) {
                    if (f) {
                        a(o).css({"float": "left", position: "relative"});
                        a("span", a(o)).css({display: "block"})
                    }
                    var p = a("span", a(o)).length, j = a(d).height();
                    a(o).css({height: (p * j) + "px", top: "0"});
                    a("span", a(o)).css({height: j + "px"});
                    a(o).animate({top: -1 * ((p - 1) * j) + "px"}, g, function () {
                        if (typeof(b.onComplete) === "function") {
                            b.onComplete.call(d)
                        }
                    })
                })
            })
        })
    };
    a.fn.absoluteCounter.defaults = {speed: 2000, setStyles: true, onComplete: null, delayedStart: 0, fadeInDelay: 0}
}(jQuery));