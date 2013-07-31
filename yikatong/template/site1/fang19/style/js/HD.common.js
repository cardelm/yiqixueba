/*
 *@Description: common.js
 *@Version:     v0.9
 *@Author:     	William Dong,
 *@Date: 		2012-05-07
 */

(function () {

	/**
	* @Description: show more telphones, show hot rank detail info
	* @Author: William Dong
	*/
	(function(){
		$('.J_down_hd').hover(function(){
			var _target = $(this).find('.J_down_bd');
			_target.show();
		},function(){
			var _target = $(this).find('.J_down_bd');
			_target.hide();
		});		
	})();

	/**
	* @Description: map icon animate
	* @Author: William Dong
	*/
	(function(){
		$('.J_zoom_icon').css({'-webkit-transition':'all 0.6s ease-in','-moz-transition':'all 0.6s ease-in','-webkit-transform':'scale(2)','-moz-transform':'scale(2)'});
		var zoomOut = "$('.J_zoom_icon').css({'-webkit-transition':'all 0.6s ease-in','-moz-transition':'all 0.6s ease-in','-webkit-transform':'scale(1)','-moz-transform':'scale(1)'});";
		setTimeout(zoomOut,600);
	})();

	/**
	* @Description: copy url to clipboard
	* @Author: ZeroClipboard
	*/	
	(function(){
		AM('ZeroClipboard', 'showTips', function(){
			var clip = null;
			ZeroClipboard.setMoviePath(AM_Config.baseUrl + '/ZeroClipboard.swf' + AM_Config.baseVersion);
			function clipInit() {
				var clip = new ZeroClipboard.Client();
				clip.setHandCursor(true);
				clip.addEventListener('mouseOver', function(client){
					clip.setText($('.J_url').text());
				});
				clip.addEventListener('complete', function(client,text){
					App.tips({message:"地址成功复制代码到剪贴板，粘贴就可以和好友分享了！",autoclose:1.5});
				});  
				clip.glue('J_copy_URL');
			}
			
			if($('#J_copy_URL').length>0){
				clipInit();
			}

		});

	})();

	/**
	* @Description: fix ie6's position bug for 
	* @Author: William Dong
	*/
	(function() {
		$(".J_fix-brand-x").click(function() {
			$(".fix-brand").hide();
		})
		AM.ready("fixed",function(){
			App.fixed({obj:".fix-brand", top: "40px"});
		});
	})(); 
	
	/**
	* @Description: Scroll Top 
	* @Author: HS
	*/
	(function(){
		 $(window).scroll(function(){
			if($(window).scrollTop() <= $('.hd-navTop').height()){
				$('.hd-navTop').css({'position':'relative',top:'0px'});
				$(".defaultTop").show().siblings(".layout").hide();
			}else{ 
				$('.hd-navTop').css({'position':'fixed'}); 
				if($.browser.msie && $.browser.version=='6.0'){
					$('.hd-navTop').css({'position':'absolute','top':$(window).scrollTop() + 'px','z-index':10000});
				}
				if($(window).scrollTop() >= 600)
					$(".brandTop").show().siblings(".layout").hide();
			}
		});
	})(); 
	
})();
var common = {
		
		/**
		* @Name: showTip
		* @Description: show hdbuild tip   
		* @Author: HS
		*/
		showTip : function (tipId,msg,bool){
			var obj=$(tipId),html=$("<span class='msg'></span>");
			obj.siblings(".msg").remove();
			if(msg!=""){
				bool?html.addClass("true"):html.addClass("false");
				html.html(msg);
				obj.parent().append(html);
			}
		},
		
		/**
		* @Name: isEmpty
		* @Description: fix ie's position bug for validate value  
		* @Author: HS
		*/
		isEmpty : function (obj){
			var bool = false;
			 
			if(!obj.validate({required:""}) || $.trim(obj.val())==obj.attr("placeholder"))
				bool = true;
			 
			 return bool;
		},
		
		/**
		* @Name: getValidatedValue
		* @Description: get value without placeholder value
		* @Author: HS
		*/
		getValidatedValue : function (id,defaultvalue){
			var str =defaultvalue;
			if(!common.isEmpty($(id))){
        		str = $.trim($(id).val());
        	} 
			return str;
		},
		
		/**
		* @Name: showTab
		* @Description: show table  
		* @Author: HS
		*/
		showTab : function (obj,name){			
			AM.ready(function(){
				var parent,index;
				
				obj.find("a").click(function(){
					parent = $(this).parent(),index = parent.index();
					parent.addClass("on").siblings().removeClass("on");
					$(name).eq(index).show().siblings(name).hide();
				})
			 })
		}, 
		
		/**
		* @Name: thisHover
		* @Description:this hover
		* @Author: HS
		*/
		thisHover : function(obj){
			obj.hover(function(){
				$(this).addClass("hover");
			},function(){
				$(this).removeClass("hover");
			});
		}, 
		
		 /**
		 * 鼠标划词语添加样式
		 * @param  string id
		 * @param  string tagStart
		 * @param  string tagEnd
		 * @return object
		 * @Author HS
		 */
		insertAtTag : function(id, tagStart, tagEnd) {
	
			var _this =  $(id)[0];
			if (window.getSelection) { // FF
				var startPos = _this.selectionStart;
				var endPos = _this.selectionEnd;
				var restoreTop = _this.scrollTop;  // save scrollTop before insert
				var myValue = (startPos != undefined && endPos != undefined) ? _this.value.substring(startPos, endPos) : '';
	
				if (0 < myValue.length){
					if(myValue.indexOf(tagEnd)>0){
						myValue = myValue.split(']')[1].split("[")[0];
					}
					myValue = tagStart + myValue + tagEnd;
				}
	
				_this.value = _this.value.substring(0, startPos) + myValue + _this.value.substring(endPos, _this.value.length);
	
				if (0 < restoreTop) _this.scrollTop = restoreTop;
	
				_this.focus();
				_this.selectionStart = startPos + myValue.length;
				_this.selectionEnd = startPos + myValue.length;
	
			} else { // IE
				_this.focus();
				sel = document.selection.createRange();
				if (0 < sel.text.length){
					if(sel.text.indexOf(tagEnd)>0){
						sel.text = sel.text.split(']')[1].split("[")[0];
					}
					sel.text = tagStart + sel.text + tagEnd;
				}
				sel.select();
			}
			return $(this);
		},
		
		/**
		* @Name: validateTags 
		* @Description: validate Tags
		* @Author: HS
		*/
		validateTags : function(){
					var bool = true, _this = this;
					AM("validate","showTips",function(){
						var placeholder=$("#tagAddInput").attr("placeholder");
						var count = $.trim($("#tagAddInput").val());
						var selected="";
						if(count.length >0 && count !=placeholder )
							count=count.split(/\s+/).length;
						else
							count=0;
						if(selected.length >0)
							selected = selected.split(/\s+/).length;
						else
							selected = 0;
						count =count + selected;
						if(count > 5 ){
							App.tips({type:"error",message:"最多只能添加5个标签哦",autoclose:3});
							bool = false;
						}
						//验证每个标签 长度及是否与已有重复
						var inputTag = $.trim($("#tagAddInput").val());
						if(inputTag.length >0 && inputTag !=placeholder){
							if(!$("#tagAddInput").validate({tag:true})){
								App.tips({type: "error" ,message: "标签只能输入文字和数字哦", autoclose: 3});
								bool = false;
							} 
							var inputNames=inputTag.split(/\s+/);
							for( i in inputNames){
								var tag = inputNames[i];
								if(tag.length + tag.replace(/[^\u4E00-\u9FA5]/g,'').length >16 ){
									App.tips({type:"error",message:"最多不能超过16个字符（8个汉字）哦",autoclose:3});
									bool = false;
								} 
							}//for
						}
					}) 
					return bool; 
			} 
	}
