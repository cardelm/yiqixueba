/*
 *@Description: myshare.js
 *@Version:     v0.1
 *@Author:     	HS,
 *@Date: 		2012-07-31
 */
var myshare = {
	/**
	* @Name: shareTop
	* @Description: scroll Top or share or customer
	* @Author: HS
	*/
	shareTop : function(options){
		var $gt = $('<div class="go-top"></div>'),
			$top = $('<a class="go-top-btn" href="#"><span class="icon"></span><p>回顶部</p></a>'),
			opt = $.extend(opt,options),
			$share = $('<div class="share-icon"><div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare" style="display:none;padding:0;"><a class="bds_qzone" ><span class="icon" ></span></a><a class="bds_tsina" ><span class="icon"></span></a><a class="bds_tqq" ><span class="icon"></span></a><a class="bds_renren"><span class="icon"></span></a></div></div><a id="share-btn" class="share" href="javascript:;"><span class="icon"></span><p>分享</p></a>'),
			$customer = $('<a class="customer" target="_blank" href="http://support.19lou.com/forum-22-1.html"><span class="icon"></span><p>提建议</p></a>');
		
		if($gt.length <= 0){
			return;
		}
		var mb = 0,
			ib = -parseInt(opt.height);
		$(window).bind('scroll resize',function(){
			var $this = $(this),
				st = $this.scrollTop(),
				cb = ib + st;
			if(cb > mb){
				$gt.css('bottom',mb);
			} else{

				$gt.css('bottom',cb);
			}
			//fix ie6 pos:fixed
			if(App.ie6){
				$gt.attr('class',$gt.attr('class'));
			}
		});
		$top.click(function(){
			$("body,html").animate({scrollTop:0},500);
			return false;
		});
		if(opt.chref != ""){
			$customer.find("a").attr("href",opt.chref);	
		}
		if(opt.share>0){
			$gt.append($share);
		}
		if(opt.customer>0){
			$gt.append($customer);
		}
		$gt.append($top).css({"bottom":-parseInt(opt.height)+"px"});
		$("body").append($gt);
		
		/*baidu share*/
		if(opt.share>0){
			var script1 = document.createElement("script"),script2 = document.createElement("script");
			script1.id = "bdshare_js",script2.id = "bdshell_js";
			script1.setAttribute("data","type=tools");
			script2.src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + new Date().getHours();
			document.body.appendChild(script1);
			document.body.appendChild(script2); 
			var bdshare = $("#bdshare");
			if($.browser.msie && $.browser.version < 7){
				bdshare.css("float","none");
				bdshare.find("a").each(function(){
					$(this).css({"background-position":"100px 100px"});
				});
			}else{
				bdshare.find("a").css({"background-image":"none"});
			}
			 
			$("#share-btn").click(function(){
				var html = $('.share-icon');	
				var _this = $(this);
				
				if($(this).hasClass("select")){
					bdshare.hide();
					$(this).removeClass("select");
					return false;
				}
				bdshare.show();
				$(this).addClass("select");
				 
				html.find("a:eq(0)").css("border-radius","5px 5px 0 0"); 
				html.hover(function(){
					
				},function(){ 
					bdshare.hide();
					_this.removeClass("select");
				});
			}); 
		}
	}
}