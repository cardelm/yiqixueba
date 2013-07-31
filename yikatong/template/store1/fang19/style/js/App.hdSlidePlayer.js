/*
 *@Description: App.slidePlayer.js
 *@Version:     v2.0
 *@Author:      GaoLi
 *@Update:      GaoLi(2011-12-30 17:00)
 */
$.fn.hdSlidePlayer = function(options){
    
    var slide = {};
    
    slide.version = '2.0';
    
    slide._data = {
    
        obj: $(this),
        
        def: {
            time: '3000',
            page: 1
        },
        
        opt: options

    };

    slide._util = {};
    
    slide._fn = {};
    
    /**
     *  util
     */
    
    (function(data, util) {
        
        var opt, num;
        
        util.getAttr = function(k) {
            opt = opt || $.extend(data.def, data.opt);
            return opt[k];
        };

        util.getNum = function() {
            return num;
        };

        util.setNum = function(n) {
            num = n;
        };

    })(slide._data, slide._util);
    
    /**
     * fn.init
     */
    
    (function(data, util, fn) {
        
        var obj = data.obj,
            item = obj.find("li"),
            page = {},
			parent = obj.parent(),
            html = "",
			height =  util.getAttr("height"); 
        fn.init = function() { 
            obj.addClass("slide-player").css({ 
                'width': util.getAttr("width") || obj.width()
            }); 
            item.each(function(i) {
				var sp = $(this).find("span"),hf = $(this).find("a").attr("href"); 
                html += '<a href="'+hf+'" target="_blank" >'+sp.html()+'</a>';
				sp.remove(); 
            })
            page = $('<div class="slideimg-page clearall"></div>').appendTo(parent);
            page.html(html);
        }();
        
        fn.getItem = function() {
            return item;
        };

        fn.getPage = function() {
            return page; 
        };
		
		fn.getHeight = function() {
			return height;
		}
        
    })(slide._data, slide._util, slide._fn);
    
    /**
     * fn.bind
     */
    
    (function(data, util, fn) {

        fn.bind = function() {
            
            fn.getPage().delegate("a[class!=trigger]", "mouseover", function() {
                util.setNum(parseInt($(this).index()+1) - 1); 
                fn.fade();
            });
            fn.getItem().hover(function(){
				fn.auto(false);					
			},function(){
				fn.auto(true);
			});
            fn.getPage().hover(function() {
                fn.auto(false);
            }, function() {
                fn.auto(true);
            });
            
        }();
        
    })(slide._data, slide._util, slide._fn);

    /**
     * fn.fade
     */
    
    (function(data, util, fn) {
        
        var item = fn.getItem(),
            page = fn.getPage().find("a"),
            len = item.length - 1;

        fn.fade = function() {

            var n = util.getNum(),
                l = len,
				tp = parseInt(fn.getHeight())*n; 
            if (n < len) {
                util.setNum(n + 1);
            } else {
                util.setNum(0);
            }

            page.removeClass("trigger").eq(n).addClass("trigger");
			data.obj.stop(true,false).animate({"top":-tp+"px"});
            /*for (; n < l; l--) {
                item.eq(l).hide();
            }
            
            (n !== 0) ? item.eq(n - 1).show() : "";
            item.eq(n).hide().fadeIn(200);*/
            
        };
        
    })(slide._data, slide._util, slide._fn);
    
    /**
     * fn.auto
     */
    
    (function(data, util, fn) {
        
        var t;
        
        fn.auto = function(flag) {
             
            if (flag) {
                t = setInterval(fn.fade, util.getAttr("time"));
            } else {
                clearInterval(t);
            }
            
        };

        util.setNum(util.getAttr("page") - 1);
        fn.fade();
        fn.auto(true);
        
    })(slide._data, slide._util, slide._fn);
    
}
