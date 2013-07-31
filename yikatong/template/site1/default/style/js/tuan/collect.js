(function(a) {
    a.alerts = {
        verticalOffset: -75,
        horizontalOffset: 0,
        repositionOnResize: !0,
        overlayOpacity: .2,
        overlayColor: "#b3b3b3",
        draggable: !0,
        okButton: "&nbsp;\u786e\u8ba4&nbsp;",
        cancelButton: "&nbsp;\u53d6\u6d88&nbsp;",
        dialogClass: null,
        confirm: function(b, c, d) {
            c == null && (c = "Confirm"),
            a.alerts._show(c, b, null, "confirm",
            function(a) {
                d && d(a)
            })
        },
        _show: function(b, c, d, e, f) {
            a.alerts._hide(),
            a.alerts._overlay("show"),
            a("BODY").append('<div id="popup_container"><h1 id="popup_title"></h1><div id="popup_content"><span id="popup_close"></span><div id="popup_message"></div></div><span class=shadow></span></div>'),
            a.alerts.dialogClass && a("#popup_container").addClass(a.alerts.dialogClass);
            var g = a.browser.msie && parseInt(a.browser.version) <= 6 ? "absolute": "fixed";
            a("#popup_container").css({
                position: g,
                zIndex: 99999,
                padding: 0,
                margin: 0
            }),
            a("#popup_title").text(b),
            a("#popup_content").addClass(e),
            a("#popup_message").text(c),
            a("#popup_message").html(a("#popup_message").text().replace(/\n/g, "<br />")),
            a("#popup_container").css({
                minWidth: a("#popup_container").outerWidth(),
                maxWidth: a("#popup_container").outerWidth()
            }),
            a.alerts._reposition(),
            a.alerts._maintainPosition(!0);
            switch (e) {
            case "confirm":
                a("#popup_message").after('<div id="popup_panel"><button  id="popup_ok" >' + a.alerts.okButton + '</button> <a id="popup_cancel" >' + a.alerts.cancelButton + "</a></div>"),
                a("#popup_ok").click(function() {
                    a.alerts._hide(),
                    f && f(!0)
                }),
                a("#popup_cancel").click(function() {
                    a.alerts._hide(),
                    f && f(!1)
                }),
                a("#popup_close").click(function() {
                    a.alerts._hide(),
                    f && f(!1)
                }),
                a("#popup_ok").focus(),
                a("#popup_ok, #popup_cancel,#popup_close").keypress(function(b) {
                    b.keyCode == 13 && a("#popup_ok").trigger("click"),
                    b.keyCode == 27 && a("#popup_cancel").trigger("click"),
                    b.keyCode == 27 && a("#popup_close").trigger("click")
                })
            }
            if (a.alerts.draggable) try {
                a("#popup_container").draggable({
                    handle: a("#popup_title")
                }),
                a("#popup_title").css({
                    cursor: "move"
                })
            } catch(h) {}
        },
        _hide: function() {
            a("#popup_container").remove(),
            a.alerts._overlay("hide"),
            a.alerts._maintainPosition(!1)
        },
        _overlay: function(b) {
            switch (b) {
            case "show":
                a.alerts._overlay("hide"),
                a("BODY").append('<div id="popup_overlay"></div>'),
                a("#popup_overlay").css({
                    position: "absolute",
                    zIndex: 99998,
                    top: "0px",
                    left: "0px",
                    width: "100%",
                    height: a(document).height(),
                    background: a.alerts.overlayColor,
                    opacity: a.alerts.overlayOpacity
                });
                break;
            case "hide":
                a("#popup_overlay").remove()
            }
        },
        _reposition: function() {
            var b = a(window).height() / 2 - a("#popup_container").outerHeight() / 2 + a.alerts.verticalOffset,
            c = a(window).width() / 2 - a("#popup_container").outerWidth() / 2 + a.alerts.horizontalOffset;
            b < 0 && (b = 0),
            c < 0 && (c = 0),
            a.browser.msie && parseInt(a.browser.version) <= 6 && (b = b + a(window).scrollTop()),
            a("#popup_container").css({
                top: b + "px",
                left: c + "px"
            }),
            a("#popup_overlay").height(a(document).height())
        },
        _maintainPosition: function(b) {
            if (a.alerts.repositionOnResize) switch (b) {
            case ! 0 : a(window).bind("resize", a.alerts._reposition);
                break;
            case ! 1 : a(window).unbind("resize", a.alerts._reposition)
            }
        }
    },
    jConfirm = function(b, c, d) {
        a.alerts.confirm(b, c, d)
    }
})(jQuery),
function(a) {
    var b = '<div id="collectSuc" style="display:none;position: absolute; z-index: 99999; padding: 0px; margin: 0px;height:0;"><div class="popup_content alert"><span id="collectSuc_close"></span><div class="popup_message">\u6536\u85cf\u6210\u529f</div><div class="popup_panel"><p>\u67e5\u770b&nbsp;&nbsp;<a target="_blank" href="/custom/collectMan" mon="type=tg-popclick" class="gocollectman" id="goCollect">\u6211\u7684\u6536\u85cf>></a></p></div></div><span class="shadow"></span></div>';
    a("#main-center").before(b),
    a("a.favor").live("click",
    function(b) {
        var c = a(b.target),
        d = c.parents("div.wt-good-item"),
        e = c.attr("id");
        a("div.wt-good-item div.msg").each(function(b, c) {
            a(c).attr("style") && a(c).hide()
        }),
        e && !c.data("success") && a.ajax({
            type: "post",
            url: "/custom/collectAdd/",
            data: {
                goods_id: e
            },
            success: function() {
                c.addClass("fcg").data("success", !0).find("i").after("\u5df2"),
                d.addClass("wt-good-item-activated").find("div.msg").slideDown("normal",
                function() {
                    var a = d.find("a.close-ico");
                    a.click(function() {
                        return a.parent().hide(),
                        !1
                    }),
                    window.setTimeout(function() {
                        a.parent().hide()
                    },
                    2e3)
                })
            }
        })
    }),
    a("#collectSuc_close").click(function() {
        a("#collectSuc").css("display", "none")
    }),
    a("#goCollect").click(function() {
        a("#collectSuc").css("display", "none")
    }),
    a("#goCollect").bind("mousedown",
    function() {
        var b = userCookie.get("BAIDUID");
        if (b) var c = b.substr(0, 32);
        var d = "http://www.hao123.com/images/track.gif?level=2&page=hao123-tuangou&baiduid=" + c + "";
        a.trim(a(this).attr("mon")) != "" && ((new Image).src = d + "&" + encodeURI(a(this).attr("mon")) + "&timestamp=" + (new Date).getTime())
    }),
    a(".subfilter-span").click(function() {
        a("#collectSuc").css("display", "none")
    });
    var c = a(".cur-page").html();
    a("a[class='delgoods']").click(function(b) {
        obj = b.target,
        jConfirm("\u60a8\u786e\u5b9a\u8981\u5220\u9664\u8fd9\u6761\u6536\u85cf\u5417\uff1f", "",
        function(b) {
            b && (location.href = "/custom/collectMan?type=1&goods_id=" + a(obj).attr("id") + "&page=" + c)
        })
    }),
    a("#delAll").click(function(a) {
        jConfirm("\u60a8\u786e\u5b9a\u8981\u5220\u9664\u5168\u90e8\u6536\u85cf\u5417\uff1f", "",
        function(a) {
            a && (location.href = "/custom/collectMan?type=2&page=" + c)
        })
    })
} (jQuery),
function(a) {
    var b = {
        init: function(a, b, c) {
            return this.domain = a || getHost(),
            this.path = b || "/",
            this
        },
        set: function(a, b) {
            document.cookie = a + "=" + b + ";path=" + this.path + ";domain=" + this.domain
        },
        get: function(a, b) {
            var c = document.cookie.split(";"),
            a = a + "=",
            b = b ||
            function() {};
            for (var d = 0, e = c.length; d < e; d++) if (c[d].indexOf(a) != "-1") {
                var f = c[d].replace(a, "");
                return b(f),
                f
            }
            return b(null),
            null
        }
    };
    a("#noticeClose").click(function() {
        b.get("COLLECTCLOSE") || b.init(".baidu.com").set("COLLECTCLOSE", 1),
        a("span[class='collect-notice']").remove()
    })
} (jQuery);