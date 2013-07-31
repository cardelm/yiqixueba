$.fn.floatMark = function(options){
	var float={};
	float._data = {
        obj: $(this),
        def: {
            time: '4000' 
        },
        opt: options
    };
    float._util = {};
    float._fn = {};
	 /**
     *  util
     */
    (function(data, util) { 
        var opt, num; 
        util.getAttr = function(k) {
            opt = opt || $.extend(data.def, data.opt);
            return opt[k];
        };
    })(float._data, float._util);
	
	  /**
     * fn.init
     */
    (function(data, util, fn) {  
        var obj = data.obj,
			speed = util.getAttr("time"),
			mark = util.getAttr("mark"),
			allscreen = util.getAttr("allscreen"),t= null;
            
        fn.init = function() { 
			obj.find("a").each(function(){
				var html = $(this).siblings(".user-show");
				width = parseInt($(this).find("img").width()),
				height = parseInt($(this).find("img").height()),
				span = $("<span class='mark'></span>");
				if(mark>0){
					span.css({"width":width+"px","height":height+"px"}).hide();
					$(this).append(span);
				}
				allscreen>0?html.css({padding:"10px",width:(width-20)+"px",height:(height-20)+"px",bottom:-height+"px"}):html.css({padding:"10px",width:(width-20)+"px"});
			});  
        }();   
		obj.find(".pic-box").hover(function(){
			var $this = $(this);
			
			t = setTimeout(function(){
				$this.find("em").hide();
				$this.find(".user-show").animate({"bottom":0},200);
			},300)
			
			if(mark>0){
				$(this).find(".mark").hide().addClass("select");
				$(this).parents("ul").find(".mark").not(".select").show();
			}
		},function(){
			var _this = $(this),h = 68;
			clearTimeout(t);
			mark>0?$(this).find(".mark").show().removeClass("select"):"";
			if(allscreen>0)
				h = $(this).find("img").height(); 
			$(this).find(".user-show").animate({"bottom":-h+"px"},200,function(){
				_this.find("em").show();
			});
			
		});
		if(mark>0){
			obj.hover(function(){},function(){
				$(this).find(".mark").hide();
			});
		}
    })(float._data, float._util, float._fn);
}