window.Tuan = {},
function(a) {
    if (a("#range-p-tip").length > 0) var b = a("#range-p-tip");
    if (a("#subrange-bg").length > 0) {
        return;
        var c, d
    }
    if (a("#sitemid-subrange-bg").length > 0) {
        var e = a("#sitemid-subrange-bg"),
        d = a("#subrange");
        e.css({
            left: d.position().left + 5,
            top: d.position().top + 7,
            width: d.width(),
            height: d.height()
        }).show()
    }
} (jQuery),
function(a) {
    a.fn.extend({
        showRCitylist: function() {
            a(this).bind("click",
            function() {
                if (a("#wt-city-list-new").css("display") == "block" && a("#wt-city-list-new").css("left") != "-118px") return ! 1;
                if (a("#wt-city-list-new").css("display") != "block") {
                    var b = encodeURI(a("#wt-city-title").html()),
                    c = /do=(.*)&wd=(.*)$/;
                    c.exec(document.URL),
                    RegExp.$1 ? a.ajax({
                        type: "get",
                        url: "/getCityList?type=" + RegExp.$1 + "&word=" + RegExp.$2 + "&city=" + b,
                        success: function(b) {
                            a("#wt-city-list-new").html(b)
                        }
                    }) : a.ajax({
                        type: "get",
                        url: "/getCityList?city=" + b,
                        success: function(b) {
                            a("#wt-city-list-new").html(b)
                        }
                    })
                }
                var d = a(this).parent().offset().top - a("#wt-city-list-new").parent().offset().top + 20,
                e = a("#wt-city-list-new").css({
                    left: -128,
                    top: d
                }),
                f = a("#result-city-tip"),
                g = a("#wt-city-list-new .city-a");
                userCookie.init(),
                g.live("click",
                function() {
                    userCookie.set("TGCITY", a(this).attr("rel"))
                });
                var h = 0;
                a("#city-border-left").hide(),
                a("#city-border-right").hide(),
                a("#city-border-mid").removeClass("city-border-mid"),
                e.show(),
                f.addClass("down-ico"),
                a("body").bind("click",
                function(b) {
                    var c = e.offset().left,
                    d = e.offset().top,
                    g = e.width(),
                    i = e.height();
                    h && (b.pageX < c || b.pageX > c + g || b.pageY < d || b.pageY > d + i) && (e.hide(), f.removeClass("down-ico"), a("body").unbind("click")),
                    h = 1
                })
            })
        },
        showSitelist: function() {
            var b = a("#other-sitelist"),
            c = a("#other-site-tip"),
            d = a(this);
            d.toggle(function() {
                b.show(),
                a(".site-container").css("padding-bottom", "5px"),
                d.attr("mon", d.attr("mon").substring(0, d.attr("mon").length - 4) + "up"),
                a("#othersite-span").addClass("othersite-span-current"),
                c.attr("class", "downtip"),
                d.addClass("othersite-current")
            },
            function() {
                b.hide(),
                a(".site-container").css("padding-bottom", "5px"),
                d.attr("mon", d.attr("mon").substring(0, d.attr("mon").length - 2) + "down"),
                a("#othersite-span").removeClass("othersite-span-current"),
                c.attr("class", "uptip"),
                d.removeClass("othersite-current")
            })
        },
        addFavor: function() {
            a(this).bind("click",
            function() {
                try {
                    window.external.addFavorite("http://tuan.baidu.com/", "\u767e\u5ea6\u56e2\u8d2d\u2014\u2014\u6700\u6743\u5a01\u7684\u56e2\u8d2d\u5bfc\u822a ")
                } catch(a) {
                    try {
                        window.sidebar.addPanel("\u767e\u5ea6\u56e2\u8d2d\u2014\u2014\u6700\u6743\u5a01\u7684\u56e2\u8d2d\u5bfc\u822a ", "http://tuan.baidu.com/", "")
                    } catch(a) {
                        alert("\u60a8\u53ef\u4ee5\u5c1d\u8bd5\u901a\u8fc7\u5feb\u6377\u952e Ctrl+D \u52a0\u5165\u5230\u6536\u85cf\u5939~")
                    }
                }
                return ! 1
            })
        },
        showRange: function() {
            a(this).bind("click",
            function() {
                a(this).blur();
                var b = a("#range-more"),
                c = a("#other-range span"),
                d = a("#other-range-span");
                othis = a(this);
                var e = d.position(),
                f = b.width(),
                g = e.left - f - 2 * parseInt(b.css("padding-right")) + 68 > 0 ? e.left - f - 2 * parseInt(b.css("padding-right")) + 68 - 32 : 0,
                h = 0;
                a("#range-p-tip").hide(),
                b.css({
                    left: g
                }).show(),
                c.attr("class", "downtip"),
                d.addClass("other-range-current"),
                a("body").bind("click",
                function(e) {
                    var f = b.offset().left,
                    g = b.offset().top,
                    i = b.width(),
                    j = b.height(),
                    k = parseInt(b.css("padding-left")) + parseInt(b.css("padding-right")),
                    l = parseInt(b.css("padding-top")) + parseInt(b.css("padding-bottom"));
                    h && (e.pageX < f || e.pageX > f + i + k || e.pageY < g || e.pageY > g + j + l) && (b.hide(), a("#range-p-tip").show(), c.attr("class", "uptip"), d.removeClass("other-range-current"), a("body").unbind("click")),
                    h = 1
                })
            })
        },
        showCity: function() {
            a(this).bind("click",
            function() {
                a(this).blur();
                var b = a("#city-more"),
                c = a("#other-city span"),
                d = a("#other-city-span");
                othis = a(this);
                var e = d.position(),
                f = b.width(),
                g = b.height(),
                h = e.left - f - 2 * parseInt(b.css("padding-right")) + 68 > 0 ? e.left - f - 2 * parseInt(b.css("padding-right")) + 68 : 0,
                i = e.top + d.outerHeight(),
                j = 0;
                a("#range-p-tip").hide(),
                b.css({
                    left: h,
                    top: i
                }).show(),
                c.attr("class", "downtip"),
                d.addClass("other-range-current"),
                a("body").bind("click",
                function(e) {
                    var f = b.offset().left,
                    g = b.offset().top,
                    h = b.width(),
                    i = b.height(),
                    k = parseInt(b.css("padding-left")) + parseInt(b.css("padding-right")),
                    l = parseInt(b.css("padding-top")) + parseInt(b.css("padding-bottom"));
                    j && (e.pageX < f || e.pageX > f + h + k || e.pageY < g || e.pageY > g + i + l) && (b.hide(), a("#range-p-tip").show(), c.attr("class", "uptip"), d.removeClass("other-range-current"), a("body").unbind("click")),
                    j = 1
                })
            })
        },
        showCitybyLetter: function() {
            a(this).live("click",
            function() {
                var b = a(this),
                c = b.index();
                b.addClass("current").siblings().removeClass("current"),
                a("div.city-con .all-city-con").hide().eq(c).show()
            })
        },
        showNewCitylist: function() {
            a(this).bind("click",
            function() {
                if (a("#wt-city-list-new").css("display") == "block" && a("#wt-city-list-new").css("left") != "0px") return ! 1;
                if (a("#wt-city-list-new").css("display") != "block") {
                    var b = encodeURI(a("#wt-city-title").html());
                    function c(a) {
                        var b = new RegExp("//?(?:.+?|&)?" + a + "=(.*?)(?:&.*)?$"),
                        c = window.location.toString().match(b);
                        return c ? c[1] : ""
                    }
                    var d = c("do");
                    if (c("ie")) var e = "/getCityList?type=" + d + "&word=" + c("wd") + "&city=" + b + "&ie=" + c("ie");
                    else var e = "/getCityList?type=" + d + "&word=" + c("wd") + "&city=" + b;
                    d ? a.ajax({
                        type: "get",
                        url: e,
                        success: function(b) {
                            a("#wt-city-list-new").html(b)
                        }
                    }) : a.ajax({
                        type: "get",
                        url: "/getCityList?city=" + b,
                        success: function(b) {
                            a("#wt-city-list-new").html(b)
                        }
                    })
                }
                var f = a("#wt-city-list-new").css({
                    left: 0,
                    top: 38
                }),
                g = a("#wt-city-other"),
                h = a("#wt-city-list-new .city-a");
                userCookie.init(),
                h.live("click",
                function() {
                    userCookie.set("TGCITY", a(this).attr("rel"))
                });
                var i = 0;
                a("#result-city-list") && a("#result-city-list").hide(),
                f.show(),
                a("#city-border-left").show(),
                a("#city-border-right").show(),
                a("#city-border-mid").addClass("city-border-mid"),
                g.attr("class", "uptip"),
                a("body").bind("click",
                function(b) {
                    var c = f.offset().left,
                    d = f.offset().top,
                    e = f.width(),
                    h = f.height();
                    i && (b.pageX < c || b.pageX > c + e || b.pageY < d || b.pageY > d + h) && (f.hide(), a("#city-border-left").hide(), a("#city-border-right").hide(), a("#city-border-mid").removeClass("city-border-mid"), g.attr("class", "downtip"), a("body").unbind("click")),
                    i = 1
                })
            })
        },
        showNewQCitylist: function() {
            a(this).bind("click",
            function() {
                if (a("#wt-city-list-new").css("display") == "block" && a("#wt-city-list-new").css("left") != "360px") return ! 1;
                var b = a("#wt-city-list-new").css({
                    left: 360,
                    top: 132
                }),
                c = a("#wt-city-list-new .city-a");
                userCookie.init(),
                c.live("click",
                function() {
                    userCookie.set("TGCITY", a(this).attr("rel"))
                });
                var d = 0;
                b.show(),
                a("body").bind("click",
                function(c) {
                    var e = b.offset().left,
                    f = b.offset().top,
                    g = b.width(),
                    h = b.height();
                    d && (c.pageX < e || c.pageX > e + g || c.pageY < f || c.pageY > f + h) && (b.hide(), a("body").unbind("click")),
                    d = 1
                })
            })
        }
    }),
    a("#city-border-mid").showNewCitylist(),
    a("#quanguo-city").showNewQCitylist(),
    a("#result-city").showRCitylist(),
    a("#other-site").showSitelist(),
    a("a.favor-btn").addFavor(),
    a("#other-range").showRange(),
    a("div.all-letter .letter").showCitybyLetter(),
    a("#SRCityChange").click(function() {
        userCookie.init(),
        userCookie.set("TGCITY", a(this).attr("rel"))
    })
} (jQuery),
function(a) {
    a("#other-city").live("click",
    function() {
        userCookie.init(),
        userCookie.set("TGCITY", a(this).attr("rel")),
        userCookie.set("OTHERCITY", "1")
    })
} (jQuery),
function(a) {
    var b = a("#ssinput"),
    c = a("#ssbutton");
    b.bind("focus",
    function() {
        a("#placeholder").hide()
    }),
    b.bind("blur",
    function() {
        this.value == "" && a("#placeholder").show()
    }),
    a("#ssinput").attr("value") != "" && a("#placeholder").hide(),
    c.bind("click",
    function() {
        if (a.trim(b.val()) == "") return ! 1
    })
} (jQuery),
Tuan.backtop = function(a) {
    a.fn.extend({
        showBacktop: function() {
            b.css({
                opacity: 1
            }).bind("click",
            function() {
                b.unbind("click").css({
                    opacity: 0
                }),
                b.blur(),
                a(window).scrollTop(0)
            }),
            c = !0
        },
        hideBacktop: function() {
            b.unbind("click").css({
                opacity: 0
            }),
            c = !1
        }
    }),
    a.extend({
        isFixed: function() {
            b.position().top > 2 * g ? (c || b.showBacktop(), a.browser.msie && a.browser.version == "6.0" && !a.support.style ? d ? a(window).scrollTop() + g < f + 10 && (b[0].style.setExpression("top", "eval(document.documentElement.scrollTop+document.documentElement.clientHeight-130)"), d = !1) : a(window).scrollTop() + g > f + 10 && (b[0].style.setExpression("top", f - 70), d = !0) : d ? a(window).scrollTop() + g <= f + 40 && (b.css({
                top: "auto",
                bottom: 30,
                position: "fixed"
            }), d = !1) : a(window).scrollTop() + g > f + 40 && (b.css({
                top: f - 100,
                bottom: "auto",
                position: "absolute"
            }), d = !0)) : c && b.hideBacktop()
        }
    });
    var b = a("#backtop");
    if (b.length == 0) return;
    var c = !1,
    d = !1,
    e = document.documentElement.clientWidth / 2 + 500,
    f = a("#main").position().top + a("#main").height(),
    g = document.documentElement.clientHeight,
    h = document.documentElement.clientWidth,
    i = {};
    return i.refresh = function() {
        e = document.documentElement.clientWidth / 2 + 500,
        f = a("#main").position().top + a("#main").height(),
        g = document.documentElement.clientHeight,
        h = document.documentElement.clientWidth
    },
    b.position().top > 2 * g && b.showBacktop(),
    a(window).bind("scroll",
    function() {
        a.isFixed()
    }),
    a(window).bind("resize",
    function() {
        e = document.documentElement.clientWidth / 2 + 500,
        g = document.documentElement.clientHeight,
        a.isFixed()
    }),
    i
} (jQuery),
Tuan.map = function(a) {
    var b, c, d, e = {
        myMap: {},
        myGeo: {},
        timmer: ""
    };
    return e.setMap = function(a, b) {
        clearTimeout(e.timmer),
        e.myGeo.getPoint(a,
        function(a) {
            a && (e.myMap.clearOverlays(), e.myMap.centerAndZoom(a, 12), e.myMap.addOverlay(new BMap.Marker(a)))
        },
        b)
    },
    e.handle = function(f, g) {
        var f = f || a(".range"),
        g = g || a("#main");
        if (!f || !g) return;
        f.unbind("click").click(function(f) {
            var h = a(this).attr("title"),
            i = g.offset(),
            j = a(this).offset(),
            k = parseInt(this.id),
            l = "";
            a("body").css("zoom", "");
            var m = mapData[k].length;
            if (m == 1) l += "<p class='clearfix single cur_map'><span class='map_dist'><a href='javascript:void(0)' title='" + mapData[k][0].address + "'>" + mapData[k][0].range + "</a></span></p>";
            else for (var n = 0; n < m; n++) l += "<p class='clearfix " + (n == 0 ? "cur_map": "") + "'><span class='map_dist'><a href='javascript:void(0)' title='" + mapData[k][n].address + "'>" + mapData[k][n].range + "</a></span></p>";
            c.html(l),
            b.css({
                left: j.left,
                top: j.top - a("body").offset().top + 20
            }),
            d.css({
                width: b.width(),
                height: b.height()
            }),
            b.show(),
            a(this).addClass("cur_map_show");
            var o = "#" + this.id;
            e.timmer = setTimeout(function() {
                e.setMap(h, TG.city)
            },
            200),
            a("#tgMapClose").click(function(b) {
                return a("#tgMap").hide(),
                a("#tgMapClose").unbind(),
                a(o).removeClass("cur_map_show"),
                !1
            }),
            a("body").css("zoom", "1");
            var p = a("#tgMapInfo p");
            return p.length > 1 && p.click(function(b) {
                var c = this.childNodes[0].childNodes[0];
                return this.className.indexOf("cur_map") == -1 && (_address = c.getAttribute("title"), e.setMap(_address, TG.city), p.removeClass("cur_map"), a(this).addClass("cur_map")),
                !1
            }),
            !1
        })
    },
    e.fullScreen = function() {
        var b = function() {
            this.defaultAnchor = BMAP_ANCHOR_TOP_RIGHT,
            this.defaultOffset = new BMap.Size(10, 10)
        };
        b.prototype = new BMap.Control,
        b.prototype.initialize = function(a) {
            a.fullScreenMode = !1,
            this._map = a;
            var b = a.getContainer(),
            c = this._container = document.createElement("div");
            b.appendChild(c);
            var d = this;
            return c.id = "fullSc_" + this.hashCode,
            c.title = "\u8fdb\u5165\u5168\u5c4f\u72b6\u6001",
            c.style.width = "50px",
            c.style.height = "22px",
            c.style.background = "url(http://www.hao123.com/images/map_full.gif)",
            c.style.backgroundRepeat = "no-repeat",
            c.style.cursor = "pointer",
            c.style.backgroundPosition = "0 0",
            c.style.zIndex = "800",
            c.onmousedown = function(b) {
                b = b || window.event,
                a.fullScreenMode == !1 ? (c.style.backgroundPosition = "0 -22px", c.style.width = "49px", c.style.height = "22px") : (c.style.backgroundPosition = "-50px -22px", c.style.width = "75px"),
                b.returnValue = !1
            },
            c.onmouseout = function(b) {
                b = b || window.event,
                a.fullScreenMode == !1 ? (c.style.backgroundPosition = "0 0", c.style.width = "49px", c.style.height = "22px") : (c.style.backgroundPosition = "-50px 0", c.style.width = "75px"),
                b.returnValue = !1
            },
            c.onclick = function() {
                a.enableDoubleClickZoom(!1),
                a.fullScreenMode == !1 ? d.toFullSrc() : d.returnFullSrc(),
                setTimeout(function() {
                    a.enableDoubleClickZoom(!0)
                },
                300)
            },
            c
        },
        b.prototype.getClientSize = function() {
            return window.innerHeight ? {
                width: window.innerWidth,
                height: window.innerHeight
            }: document.documentElement && document.documentElement.clientHeight ? {
                width: document.documentElement.clientWidth,
                height: document.documentElement.clientHeight
            }: {
                width: document.body.clientWidth,
                height: document.body.clientHeight
            }
        },
        b.prototype.getScroll = function() {
            var a = 0,
            b = 0;
            return document.documentElement && document.documentElement.scrollTop ? (a = document.documentElement.scrollTop, b = document.documentElement.scrollLeft) : document.body && (a = document.body.scrollTop, b = document.body.scrollLeft),
            {
                top: a,
                left: b
            }
        },
        b.prototype.setMapWidAndHei = function() {
            var b = this,
            c = b._map,
            d = c.container,
            e = a("#tgMap")[0];
            b.setIe6Scroll();
            var f = b.getClientSize().width - 20,
            g = b.getClientSize().height - 20,
            h,
            i,
            j,
            k = a("#main").offset().left,
            l = a("body").offset().top,
            m = b.getScroll().top,
            n = b.getScroll().left;
            c.fullScreenMode ? (b.resizeMap ? b.resizeMap = !1 : (b.smallWidth = parseInt(d.style.width), b.smallHeight = parseInt(d.style.height)), document.body.style.height = g + "px", h = f, i = g, j = function() {
                c.panTo(c._centerPoint)
            },
            e.className = "map_full", e.style.left = n - k + "px", e.style.top = m - l + "px") : (h = b.smallWidth, i = b.smallHeight, j = function() {
                c.centerAndZoom(c._centerPoint, c._zoom)
            }),
            d.style.width = h + "px",
            d.style.height = i + "px",
            b.SetTimer1 && clearTimeout(b.SetTimer1),
            b.SetTimer1 = setTimeout(j, 100)
        },
        b.prototype.setIe6Scroll = function() {
            var a = c,
            b = a._map;
            window.XMLHttpRequest || (b.fullScreenMode || a.getClientSize().width >= 1034 ? document.getElementsByTagName("html")[0].style.overflowX = "hidden": document.getElementsByTagName("html")[0].style.overflowX = "auto")
        },
        b.prototype.toFullSrc = function() {
            var b = this._map,
            d = this._container,
            e = a("#tgMap")[0],
            f = this;
            b.fullScreenMode = !0,
            b._centerPoint = b.getCenter(),
            b._zoom = b.getZoom(),
            f.smallLeft = parseInt(e.style.left),
            f.smallTop = parseInt(e.style.top),
            document.all ? (a("body").css("height", a(window).scrollTop() + 1e3), document.getElementsByTagName("html")[0].style.overflow = "hidden") : document.body.style.overflow = "hidden",
            a("#main-center")[0].style.zIndex = 10,
            f.setMapWidAndHei(),
            d.style.backgroundPosition = "-50px 0px",
            d.style.width = "74px",
            d.title = "\u9000\u51fa\u5168\u5c4f\u72b6\u6001";
            var g = function() {
                setTimeout(function() {
                    c.setIe6Scroll();
                    if (!b.fullScreenMode) return;
                    f.resizeMap = !0,
                    f.setMapWidAndHei()
                },
                50)
            };
            if (!f.resizeEven || f.resizeEven && f.resizeEven.length < 1) a(window).resize(g),
            f.resizeEven = [{
                dom: window,
                type: "resize",
                fun: g
            }]
        },
        b.prototype.returnFullSrc = function() {
            var b = this._map,
            c = this._container,
            d = this,
            e = a("#tgMap")[0];
            b.fullScreenMode = !1,
            document.body.style.height = "auto",
            document.all ? (a("body").css("height", "auto"), document.getElementsByTagName("html")[0].style.overflow = "auto") : document.body.style.overflow = "auto",
            e.className = "map",
            e.style.left = d.smallLeft + "px",
            e.style.top = d.smallTop + "px",
            a("#main-center")[0].style.zIndex = 1,
            d.setMapWidAndHei(),
            c.style.backgroundPosition = "0 0",
            c.style.width = "50px",
            c.style.height = "22px",
            c.title = "\u8fdb\u5165\u5168\u5c4f\u72b6\u6001";
            if (d.resizeEven && d.resizeEven.length > 0 && window.XMLHttpRequest) {
                var f = d.resizeEven[0];
                a(f.dom).unbind(f.type, f.fun),
                d.resizeEven = []
            }
        };
        var c = new b;
        e.myMap.addControl(c)
    },
    e.init = function(f) {
        if (!f) return;
        var g = f.container || a("#main-center"),
        h = f.list || a(".range"),
        i = f.parent || a("#main");
        if (!g || !h || !i) return;
        if (typeof mapData != "undefined" && !a.isEmptyObject(mapData)) {
            var j = '<div id="tgMap" class="map" style="display:none;"><a id="tgMapClose" href="javascript:void(0)" title="\u70b9\u51fb\u5173\u95ed" class="map_close">\u5173\u95ed</a><div class="map_inner"><div id="tgMapInfo" class="map_info"></div><div class="map_detail"><div id="map_container" style="width:320px;height:255px;border:1px solid #b3b3b3;position:relative;z-index:10;"></div></div></div><div id="tgMapBg" class="map_bg" style="height:347px;width:308px;"></div></div>';
            g.after(j),
            b = a("#tgMap"),
            c = a("#tgMapInfo"),
            d = a("#tgMapBg");
            var k = document.createElement("link");
            k.setAttribute("rel", "stylesheet"),
            k.setAttribute("href", "http://api.map.baidu.com/res/11/bmap.css"),
            document.getElementsByTagName("HEAD")[0].appendChild(k),
            h.click(function() {
                return alert("\u5730\u56fe\u6b63\u5728\u52a0\u8f7d\uff0c\u8bf7\u7a0d\u540e\u518d\u8bd5"),
                !1
            }),
            a.ajax({
                type: "GET",
                url: "http://api.map.baidu.com/getscript?v=1.2&key=f0737669fc9c2759bb4e5d35f6d22908&services=true",
                dataType: "script",
                success: function() {
                    typeof BMap != "undefined" ? (e.myMap = new BMap.Map("map_container"), e.myMap.centerAndZoom(new BMap.Point(116.404, 39.915), 10), e.myGeo = new BMap.Geocoder, e.myMap.addControl(new BMap.NavigationControl({
                        type: BMAP_NAVIGATION_CONTROL_ZOOM
                    })), e.myMap.enableScrollWheelZoom(), e.handle(h, i), e.fullScreen()) : h.unbind("click").click(function(a) {
                        alert("\u62b1\u6b49\uff0c\u5730\u56fe\u52a0\u8f7d\u51fa\u9519\uff0c\u8bf7\u53cd\u9988\u60a8\u7684\u4f4d\u7f6e\u548c\u5e26\u5bbd\u53ca\u5efa\u8bae"),
                        h.unbind("click")
                    })
                }
            })
        }
    },
    e
} (jQuery),
Tuan.list = function(a) {
    if (!a || !a.items.length) return;
    return this instanceof Tuan.list ? (this.items = a.items, this.init(), this) : new Tuan.list(a)
},
Tuan.list.prototype = {
    constructor: Tuan.list,
    init: function() {
        var a = this,
        b = $("div.goods");
        return this.countDown(arrEndTime).start(),
        b.delegate("div.wt-good-item", "hover",
        function(a) {
            a.type == "mouseover" ? $(this).addClass("wt-good-item-hover") : $(this).removeClass("wt-good-item-hover")
        }),
        this
    },
    hover: function(a) {
        var b = {};
        return a = a || [],
        b.bind = function() {
            a.hover(function() {
                $(this).addClass("tuan-con-hover"),
                $(this).find("p.img-title").show(),
                $(this).find("div.con-bg").show(),
                $(this).find("a.good-img-a").addClass("good-img-a-hover"),
                $(this).find("span.img-title-mask").show()
            },
            function() {
                $(this).removeClass("tuan-con-hover"),
                $(this).find("p.img-title").hide(),
                $(this).find("div.con-bg").hide(),
                $(this).find("a.good-img-a").removeClass("good-img-a-hover"),
                $(this).find("span.img-title-mask").hide()
            })
        },
        b.unbind = function() {
            a.unbind("hover")
        },
        b
    },
    countDown: function(a) {
        var b = {},
        c = this;
        return a = a || [],
        this.start = function(a, b, c) {
            return setInterval(function() {
                c.diffTime = a,
                b(c),
                a--
            },
            1e3)
        },
        this.stop = function(a) {
            clearInterval(a)
        },
        b.start = function() {
            for (var b = a.length; b--;) {
                var d = a[b];
                d.et == "-1" ? $("#" + d.id).html("\u5546\u54c1\u5df2\u8fc7\u671f") : d.watch = c.start(d.et - TGNOW,
                function(a) {
                    if ( !! a.diffTime && a.diffTime > 0) {
                        diffTime = a.diffTime;
                        var b = Math.floor(diffTime / 86400),
                        e = diffTime - b * 24 * 3600,
                        f = Math.floor(e / 3600),
                        g = Math.floor((e - f * 3600) / 60),
                        h = Math.floor(e - f * 3600 - g * 60);
                        $("#" + a.id).html("<b>" + b + "</b>\u5929<b>" + f + "</b>\u5c0f\u65f6<b>" + g + "</b>\u5206")
                    } else $("#" + a.id).html("\u5546\u54c1\u5df2\u8fc7\u671f"),
                    c.stop(d.watch)
                },
                d)
            }
        },
        b.stop = function() {
            for (var b = a.length; b--;) {
                var d = a[b];
                c.stop(d.watch)
            }
        },
        b
    },
    fresh: function(a, b) {
        this.hover(this.items).unbind(),
        this.countDown(arrEndTime).stop(),
        this.items = a;
        for (var c in b) window[c] = b[c];
        this.hover(this.items).bind(),
        this.countDown(arrEndTime).start()
    }
};
var myTuanList = Tuan.list({
    items: $("div.wt-good-item")
});
(function(a) {
    a("#notice-close").click(function() {
        userCookie.get("QUANGUOCLOSE") || (userCookie.init(), userCookie.set("QUANGUOCLOSE", 1)),
        a(".newnotice").remove()
    })
})(jQuery),
function() {
    function a(a) {
        userCookie.init(".baidu.com").set("tuan_favor_saved", a),
        $("#topbar").hide()
    }
    $("#topbar-favor-btn").click(function() {
        a("true")
    }),
    $("#topbar-close").click(function() {
        a("false")
    })
} ();