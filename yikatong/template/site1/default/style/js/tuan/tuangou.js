void
function() {
    var i = "toString",
    o = "getBoundingClientRect",
    p = "activeElement",
    P = "previousSibling",
    a = "nodeName",
    m = "innerWidth",
    y = "innerHeight",
    u = "documentElement",
    M = {
        grid: 7,
        pid: 240,
        hid: (function() {
            function al(an) {
                return String(an).replace(/\.html?(\?|$)/, "$1").replace(/\?.*/, "").toLowerCase()
            }
            var w = document.location,
            aj = {},
            am = {
                "tuan.baidu.com": {
                    "\/midpage\/site\/8\/beijing": "590",
                    "\/beijing\/canyinmeishi-tg?sp=1": "591",
                    "\/beijing\/xiuxianyule-tg?sp=1": "567",
                    "\/beijing\/shenghuofuwu-tg?sp=1": "568",
                    "\/beijing\/wangshanggouwu-tg?sp=1": "569",
                    "\/beijing\/jiudianlvyou-tg?sp=1": "570",
                    "\/beijing": "592",
                    "\/beijing\/top": "572",
                    "\/custom\/collectMan": "573"
                }
            },
            ai,
            ak,
            d;
            am = am[w.hostname.toLowerCase()];
            if (!am) {
                return
            }
            w.search.toLowerCase().replace(/([^?&#]+)=([^?&#]*)/g,
            function(ao, an, ap) {
                aj[an] = ap
            });
            w = al(w.pathname);
            for (ai in am) {
                ak = w == al(ai);
                ak && /\?/.test(ai) && ai.toLowerCase().replace(/([^?&#]+)=([^?&#]*)/g,
                function(ao, an, ap) {
                    if (aj[an] != ap) {
                        ak = 0
                    }
                });
                if (ak) {
                    d = am[ai]
                }
            }
            return d
        })(),
        logPath: "http://nsclick.baidu.com/u.gif"
    },
    ab = [],
    X = window,
    ag = document,
    D = ag.body,
    B = ag[u],
    k = ag.defaultView,
    J = Math.max,
    af = 100,
    j,
    K,
    E,
    r,
    F,
    s = X.screen.width + "*" + X.screen.height,
    O,
    z,
    t,
    h = 110,
    v = 2060,
    A = 1000 * 60 * 30,
    l,
    f,
    q,
    n,
    p,
    c,
    Z = [["mousemove", "m"], ["mousedown", "d"], ["contextmenu", "r"], ["mouseup", "u"], ["click", "c"], ["dblclick", "l"], ["keydown", "k"], ["mousewheel", "w"], ["DOMMouseScroll", "w", X], ["scroll", "s", X], ["resize", "e", X], ["beforeunload", "z", X], ["unload", "z", X], ["focusout", "o"], ["blur", "o", X], ["focusin", "i"], ["focus", "i", X]],
    Y,
    g = /gecko/i.test(navigator.userAgent),
    S,
    Q;
    function H(ak, ai, w, d, aj) {
        ak = ag.getElementsByTagName(ag.all ? "object": "embed");
        for (ai = 0; d = ak[ai++];) {
            if (!d[c]) {
                d[c] = 1;
                for (w = 0;
                (aj = Z[w]) && w < 7; w++) {
                    R(d, aj[0], (function(al) {
                        return function(am) {
                            W(al, am)
                        }
                    })(aj[1]))
                }
            }
        }
    }
    function T(al, am, ai, d, aj, ak) {
        al = document.getElementsByTagName("iframe");
        for (ai = 0; ai < al.length; ai++) {
            iframe = al[ai];
            try {
                if (!iframe.contentWindow[c]) {
                    iframe.contentWindow[c] = 1;
                    ak = iframe.contentWindow.document;
                    for (d = 0;
                    (aj = Z[d]) && d < 7; d++) {
                        R(ak, aj[0], (function(an, ap, ao) {
                            return function(aq) {
                                if (g) {
                                    if ("d" == an) {
                                        Q = b(aq)
                                    }
                                    if ("u" == an) {
                                        Q = 0
                                    }
                                }
                                W.call({
                                    path: ap,
                                    doc: ao,
                                    flag: c
                                },
                                an, aq)
                            }
                        })(aj[1], x(iframe), ak))
                    }
                }
            } catch(w) {}
        }
    }
    function R(w, d, ai) {
        ab.push([w, d, ai]);
        if (w.addEventListener) {
            w.addEventListener(d, ai, false)
        } else {
            w.attachEvent && w.attachEvent("on" + d, ai)
        }
    }
    function U(w, d, aj, ai) {
        if (w.removeEventListener) {
            w.removeEventListener(d, aj, false)
        } else {
            w.detachEvent && w.detachEvent("on" + d, aj)
        }
        w[c] = ai
    }
    function b(d) {
        return d.which || d.button && (d.button & 1 ? 1 : (d.button & 2 ? 3 : (d.button & 4 ? 2 : 0)))
    }
    function N(d) {
        while (d = ab.pop()) {
            U(d[0], d[1], d[2])
        }
    }
    function ah() {
        return new Date - j
    }
    function ae(ai, w, d) {
        ai = ai.slice();
        ai[1] = ai[1][i](36);
        if (/[mlducwrkfh]/.test(ai[0])) {
            for (d = 2; d < ai.length; d++) {
                if (("" + ai[d]).length > 1) {
                    if (ai[d] === q[d]) {
                        ai[d] = "^"
                    } else {
                        q[d] = ai[d]
                    }
                }
            }
        }
        w = ai.join("*").replace(/\*0\b/g, "*").replace(/^(.)\*|\*+$/g, "$1") + "!";
        r += w.length;
        if (r > v) {
            ad({
                data: K.join("") + (M.group ? "@@" + E.join("") : "")
            });
            r = h;
            K = [];
            E = []
        }
        K.push(w)
    }
    function W(al, aj, an, ak, d, w, am, ao, ai) {
        ak = ah();
        if (n) {
            clearTimeout(n[0]);
            if (ak - n[2] > 50) {
                n[1]()
            } else {
                n = 0
            }
        }
        if (ag[p] != p) {
            ae(["f", ak, x(ag[p])]);
            p = ag[p]
        }
        if (!aj) {
            ae([al, ak])
        }
        if (ak > A) {
            G();
            return
        }
        if ("i" == al && null !== n) {
            return
        }
        ai = aj.target || aj.srcElement;
        while (ai && ai.nodeType != 1) {
            ai = ai.parentNode
        }
        if (f[0] == ai) {
            an = f[1]
        } else {
            if (this.flag == c && this.doc) {
                an = this.path + "/" + x(ai, this.doc)
            } else {
                an = x(ai)
            }
        }
        f = [ai, an];
        d = [al, ak, an];
        if (/[mw]/.test(al)) {
            if (l[0] == al && ak - l[1] < af && l[2] == d[2]) {
                return
            }
            l = d.slice(0, 3)
        }
        if (ai && !ai[c] && /select/i.test(ai.tagName)) {
            ai[c] = 1;
            R(ai, "change",
            function(ap) {
                W("h", ap)
            })
        }
        if ("o" == al) {
            n && clearTimeout(n[0]);
            n = function() {
                n = null;
                d[2] = +(Math.min(X.screenTop || 0, X.screenY || 0) < -22932);
                ae(d)
            };
            n = [setTimeout(n, 1000), n, ak]
        } else {
            if (/[se]/.test(al)) {
                w = e();
                d[3] = w[[0, 2][ + (al == "e")]];
                d[2] = w[[1, 3][ + (al == "e")]]
            } else {
                if ("i" == al) {
                    d[2] = ""
                } else {
                    if (ai) {
                        if (/[mlducwr]/.test(al)) {
                            am = aa(ai, [aj.clientX, aj.clientY], M.grid);
                            if (!am) {
                                return
                            }
                            d[3] = am[0];
                            d[4] = am[1];
                            if (/[cdul]/.test(al)) {
                                d[5] = b(aj)
                            }
                            if (al == "m") {
                                d[5] = g ? Q: b(aj)
                            }
                            if (al == "w") {
                                d[5] = +((aj.wheelDelta || aj.detail) < 0)
                            }
                        } else {
                            if ("k" == al) {
                                d[3] = /password/i.test(ai.type) ? 1 : aj.keyCode;
                                d[4] = [ + aj.altKey || 0, +aj.ctrlKey || 0, +aj.shiftKey || 0, +aj.metaKey || 0].join("")
                            } else {
                                if ("h" == al) {
                                    d[3] = ai.selectedIndex
                                }
                            }
                        }
                    }
                }
            }
            ae(d)
        }
        if (/[dcukio]/.test(al)) {
            T();
            H();
            S && clearInterval(S);
            Y = 0;
            S = setInterval(function() {
                T();
                H();
                if (Y++>3) {
                    S && clearInterval(S);
                    Y = 0;
                    S = 0
                }
            },
            1000)
        }
    }
    function G() {
        if (!j) {
            return
        }
        ad({
            cmd: "close",
            data: K.join("") + "z" + ah()[i](36) + (M.group ? "@@" + E.join("") : "")
        });
        r = h;
        K = [];
        E = [];
        j = 0;
        N()
    }
    function V(w, d, ai) {
        d = [];
        for (ai in w) {
            if (typeof w[ai] != "undefined") {
                d.push(ai + "=" + decodeURIComponent(w[ai]))
            }
        }
        return d.join("&")
    }
    function L(d, ai, w) {
        if (!B || !B[o]) {
            return
        }
        if (j) {
            return
        }
        j = new Date;
        z = e();
        t = I();
        F = ( + j)[i](36) + ( + Math.random().toFixed(8).substr(2))[i](36);
        c = "_e_" + F;
        O = 0;
        r = h;
        K = [];
        E = [];
        q = [];
        l = [];
        f = [];
        lastGroupRecordParams = [];
        ae(["a", 0, z[0], z[1], z[2], z[3], x(ag[p])]);
        p = ag[p];
        ad({
            cmd: "open",
            ref: encodeURIComponent(ag.referrer),
            data: K.join("")
        });
        for (d = 0; ai = Z[d++];) {
            if (/(focus.)|blur|focus/.test(ai[0]) && (!RegExp.$1 ^ !ag.all)) {
                continue
            }
            R(ai[2] || ag, ai[0], (function(aj) {
                return function(ak) {
                    if (aj == "z") {
                        G();
                        w = ah();
                        while (ah() - w < 100) {}
                        return
                    }
                    if (g) {
                        if ("d" == aj) {
                            Q = b(ak)
                        }
                        if ("u" == aj) {
                            Q = 0
                        }
                    }
                    W(aj, ak)
                }
            })(ai[1]))
        }
        H();
        T()
    }
    function x(aj) {
        if (!aj || aj.nodeType != 1 || /^(html|body)$/i.test(aj.tagName)) {
            return aj && /^html$/i.test(aj.tagName) ? "~html": ""
        }
        var ak = "" + (aj.getAttribute && aj.getAttribute("id"));
        if (ak && ag.getElementById(ak) == aj) {
            return "." + ak.replace(/[!-\/\s~^]/g,
            function(al) {
                return "%" + (256 + al.charCodeAt())[i](16).substr(1)
            })
        }
        var ai = 1,
        w = aj[P],
        d = "nodeName";
        while (w) {
            ai += w[d] == aj[d];
            w = w[P]
        }
        return x(aj.parentNode) + "~" + (ai < 2 ? "": ai) + aj[d].toLowerCase()
    }
    function C(d) {
        if (!d || d.nodeType != 1 || /^(html|body)$/i.test(d.tagName)) {
            return
        }
        var w = d.getAttribute && d.getAttribute("hgroup");
        if (w) {
            return d
        }
        return C(d.parentNode)
    }
    function aa(ai, al, w) {
        var aj = ai[o](),
        d = ac(ai);
        w = w || 1;
        function ak(am) {
            return String( + am.toFixed(3)).replace(/^0\./g, ".")
        }
        return [ak(~~ ((al[0] - aj.left) / w) * w / d[0]), ak(~~ ((al[1] - aj.top) / w) * w / d[1])]
    }
    function ac(d) {
        var w = d[o]();
        return [~~ (w.right - w.left), ~~ (w.bottom - w.top)]
    }
    function I() {
        var w = ac(document[u]),
        d = ac(document.body);
        return [J(w[0], d[0], window[m] || 0), J(w[1], d[1], window[y] || 0)]
    }
    function e() {
        return [J(B.scrollLeft || 0, D.scrollLeft || 0, (k && k.pageXOffset) || 0), J(B.scrollTop || 0, D.scrollTop || 0, (k && k.pageYOffset) || 0), X[m] || B.clientWidth || D.clientWidth || 0, X[y] || B.clientHeight || D.clientHeight || 0]
    }
    function ad(aj) {
        if (!aj) {
            return
        }
        var w = ag.createElement("img"),
        d,
        ai = ag.getElementsByTagName("head")[0] || bd;
        w.src = M.logPath + "?" + V({
            pid: M.pid,
            hid: M.hid,
            qid: X.bdQid,
            gr: M.grid,
            sid: F,
            seq: O++,
            px: s,
            ps: t,
            vr: z,
            dv: 3
        }) + "&" + V(aj);
        w.onerror = w.onload = w.onreadystatechange = function() {
            if (!d && /^(loaded|complete)$/.test(this.readyState)) {
                d = 1;
                ai.removeChild(w);
                w = 0
            }
        };
        ai.appendChild(w);
        z = e();
        t = I();
        q = []
    }
    if (M.hid) {
        L()
    }
} ();