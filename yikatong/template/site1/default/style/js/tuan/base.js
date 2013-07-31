function encodeText(a) {
    return a = a.replace(/</g, "&lt;"),
    a = a.replace(/>/g, "&gt;"),
    a = a.replace(/\'/g, "&#39;"),
    a = a.replace(/\"/g, "&#34;"),
    a = a.replace(/\\/g, "&#92;"),
    a = a.replace(/\[/g, "&#91;"),
    a = a.replace(/\]/g, "&#93;"),
    a
}
function decodeHtml(a) {
    return a = a.replace(/&lt;/g, "<"),
    a = a.replace(/&gt;/g, ">"),
    a = a.replace(/&#39;/g, "'"),
    a = a.replace(/&#34;/g, '"'),
    a = a.replace(/&#92;/g, "\\"),
    a = a.replace(/&#91;/g, "["),
    a = a.replace(/\&#93;/g, "]"),
    a
}
function byteLength(a) {
    return a.replace(/[^\u0000-\u007f]/g, "aa").length
}
function byteSlice(a, b) {
    var c = 0,
    d = "";
    for (var e = 0; e < a.length; e++) {
        a.charCodeAt(e) > 128 ? c += 2 : c++,
        d += a.charAt(e);
        if (c >= b) return d
    }
    return d
}
function getHost(a) {
    var b = a || location.host,
    c = b.indexOf(":");
    return c == -1 ? b: b.substring(0, c)
}
var format = function(a, b) {
    if (arguments.length > 1) {
        var c = format,
        d = /([.*+?^=!:${}()|[\]\/\\])/g,
        e = (c.left_delimiter || "{").replace(d, "\\$1"),
        f = (c.right_delimiter || "}").replace(d, "\\$1"),
        g = c._r1 || (c._r1 = new RegExp("#" + e + "([^" + e + f + "]+)" + f, "g")),
        h = c._r2 || (c._r2 = new RegExp("#" + e + "(\\d+)" + f, "g"));
        if (typeof b == "object") return a.replace(g,
        function(a, c) {
            var d = b[c];
            return typeof d == "function" && (d = d(c)),
            typeof d == "undefined" ? "": d
        });
        if (typeof b != "undefined") {
            var i = Array.prototype.slice.call(arguments, 1),
            j = i.length;
            return a.replace(h,
            function(a, b) {
                return b = parseInt(b, 10),
                b >= j ? a: i[b]
            })
        }
    }
    return a
},
userCookie = {
    init: function(a, b, c) {
        var c = c !== undefined ? c: 365,
        d = new Date;
        return d.setTime(d.getTime() + 864e5 * c),
        this.domain = a || getHost(),
        this.path = b || "/",
        this.expdate = d,
        this.time = c,
        this
    },
    set: function(a, b, c) {
        var d = this.expdate,
        c = c || this.domain;
        this.time == 0 ? document.cookie = a + "=" + b + ";path=" + this.path + ";domain=" + c: document.cookie = a + "=" + b + ";expires=" + d.toGMTString() + ";path=" + this.path + ";domain=" + c
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
    },
    is: function(a) {
        var b = this.get(a);
        return b != null && b != "" ? !0 : !1
    },
    remove: function(a, b) {
        var b = b || this.domain;
        this.is(a) && (document.cookie = a + "=" + (this.path ? "; path=" + this.path: "") + (this.domain ? "; domain=" + b: "") + "; expires=Thu, 01-Jan-70 00:00:01 GMT")
    }
},
UserTrack = function() {
    var a = encodeURI(jq("#wt-city-title").html()),
    b = userCookie.get("BAIDUID"),
    c = "http://www.hao123.com";
    if (b) var d = $.trim(b).substr(0, 32);
    if (typeof testing != "undefined") var e = "/images/track.gif?level=2&page=hao123-tuangou&ab=b&s=" + key_s + "&qa_test_flag=" + qa_test_flag + "&ipcity=" + a + "&baiduid=" + d + "&category=" + category + "&subcategory=" + subcategory;
    else var e = "/images/track.gif?level=2&page=hao123-tuangou&s=" + key_s + "&qa_test_flag=" + qa_test_flag + "&ipcity=" + a + "&baiduid=" + d + "&category=" + category + "&subcategory=" + subcategory;
    var f = {};
    return f.send = function(a, b) {
        var d = (new Date).getTime(),
        f = "img_" + d,
        g = [],
        h = tStr = "";
        if (typeof a == "string") if (a.indexOf("#") == 0) {
            tStr = a.slice(1),
            !tStr || g.push(tStr);
            if ( !! b) {
                var i = b.parentNode;
                while ( !! i) {
                    tStr = i.getAttribute("mon"),
                    !tStr || g.push(tStr);
                    if (/^body$/i.test(i.tagName)) break;
                    i = i.parentNode
                }
            }
            qa_test_flag == 0 ? (strTemp = g.join("&"), h = strTemp.replace(/&qa_test_type=2/, "")) : h = g.join("&")
        } else h = a;
        if (typeof a == "object") for (var j in a) h += j + "=" + a[j] + "&";
        if (h != "") return h = encodeURI(h),
        window[f] = new Image,
        window[f].onload = window[f].onerror = function() {
            window[f] = null
        },
        window[f].src = c + e + "&" + h + "&timestamp=" + d + "&version=2",
        c + e + "&" + h + "&timestamp=" + d + "&version=2"
    },
    f.bind = function(a) { !! a && a.length && jq(a).live("mousedown",
        function() {
            jq.trim(jq(this).attr("mon")) != "" && f.send(jq(this).attr("mon"), this)
        })
    },
    f
} ();
UserTrack.bind(jq("a[mon]")),
function(a) {
    var b = a("#loginUsername"),
    c = a("#user-tip"),
    d,
    e,
    f;
    if (!b) return;
    a("#loginUsername").bind("mouseenter",
    function() {
        d = setTimeout(function() {
            d && clearTimeout(d),
            c.css({
                display: "block"
            })
        },
        200)
    }),
    a("#loginUsername").bind("mouseleave",
    function() {
        e = setTimeout(function() {
            e && clearTimeout(e),
            c.css({
                display: "none"
            })
        },
        200)
    }),
    a("#user-tip").bind("mouseenter",
    function() {
        e && clearTimeout(e),
        f && clearTimeout(f)
    }),
    a("#user-tip").bind("mouseleave",
    function() {
        f = setTimeout(function() {
            e && clearTimeout(e),
            f && clearTimeout(f),
            c.css({
                display: "none"
            })
        },
        10)
    })
} (jQuery);
try {
    document.execCommand("BackgroundImageCache", !1, !0)
} catch(e) {};