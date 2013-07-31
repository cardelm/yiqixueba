
function play(widths,heights,url,title){
		Iframe({   
		    Title:title,
	    	Url:"/video_1.jsp?url="+url+"&heights="+(heights+18)+"&widths="+widths, 
	    	Width:widths,   
	    	Height:(heights+54),
	    	scrolling:'no',
			isShowIframeTitle:true,
	    	call:function(data){  
	      } 
	    });	
	}
//选择器
function $a(id,tag){var re=(id&&typeof id!="string")?id:document.getElementById(id);if(!tag){return re;}else{return re.getElementsByTagName(tag);}}

//焦点滚动图 点击移动
function movec()
{
	var o=$a("bd1lfimg","");
	var oli=$a("bd1lfimg","dl");
    var oliw=oli[0].offsetWidth; //每次移动的宽度	 
	var ow=o.offsetWidth-2;
	var dnow=0; //当前位置	
	var olf=oliw-(ow-oliw+10)/2;
		o["scrollLeft"]=olf+(dnow*oliw);
	var rqbd=$a("bd1lfsj","ul")[0];
	var extime;

	<!--for(var i=1;i<oli.length;i++){rqbd.innerHTML+="<li>"+i+"</li>";}-->
	var rq=$a("bd1lfsj","li");
	for(var i=0;i<rq.length;i++){reg(i);};
	oli[dnow].className=rq[dnow].className="show";
	var wwww=setInterval(uu,2000);

	function reg(i){rq[i].onclick=function(){oli[dnow].className=rq[dnow].className="";dnow=i;oli[dnow].className=rq[dnow].className="show";mv();}}
	function mv(){clearInterval(extime);clearInterval(wwww);extime=setInterval(bc,15);wwww=setInterval(uu,8000);}
	function bc()
	{
		var ns=((dnow*oliw+olf)-o["scrollLeft"]);
		var v=ns>0?Math.ceil(ns/10):Math.floor(ns/10);
		o["scrollLeft"]+=v;if(v==0){clearInterval(extime);oli[dnow].className=rq[dnow].className="show";v=null;}
	}
	function uu()
	{
		if(dnow<oli.length-2)
		{
			oli[dnow].className=rq[dnow].className="";
			dnow++;
			oli[dnow].className=rq[dnow].className="show";
		}
		else{oli[dnow].className=rq[dnow].className="";dnow=0;oli[dnow].className=rq[dnow].className="show";}
		mv();
	}
	o.onmouseover=function(){clearInterval(extime);clearInterval(wwww);}
	o.onmouseout=function(){extime=setInterval(bc,15);wwww=setInterval(uu,8000);}
}
/*
$(function(){
	$("#live_online_content").fixedIn({selecter:"#live_online",offsetX:0,offsetY:30});

	$("#userName").UiText();
	$("#passWord").UiText();

	$("body").keydown(function(event){
		 event.keyCode==13 && $("#doLoginSimple").trigger("click"); 
	});

	$("#doLoginSimple").click(function(){
		if(login()) $("#loginform").submit();
	});

	$("#taoMain .commodity-list").each(function(){
		var $this=$(this);
		var timer;

		$this.find(".commodity-hd .clearfix").hover(function(){
			var _$this=$(this);
			
			clearTimeout(timer);
			timer = setTimeout(function(){
				if(_$this.find("li").length>6){
					_$this.addClass("clearfix2");
				}
			},80);
		},function(){
			clearTimeout(timer);
			$(this).removeClass("clearfix2");
		});
	});
});

*/


function login(){
	var userName = $("#userName").val();
	var passWord = $("#passWord").val();
	if(userName.length==0||userName.length<2){
		$("#userName").Title({Title:"请输入注册时的用户名。",StyleName:"TitleError",Offset:16,OffsetY:6,IsShow:true});
		return false;
	}
	if(passWord.length==0||passWord.length<6){
		$("#passWord").Title({Title:"请正确输入登陆密码。",StyleName:"TitleError",Offset:16,OffsetY:6,IsShow:true});
		return false;
	}
	return true;
}
  
function showDiv(ids){
 
	var sp=ids.split('_');
	var id=sp[1];
	var $this=jq("#ul_"+ids);
	if($this.attr("init")=="true")
		jq("#ul_div_"+ids).show();
	else{
		var dis='';
		if(id==88888)
			dis=' style="display:none;" ';
		
		var ls='<div id="ul_div_'+ids+'" class="shop_info_box" style="display:none;"><div class="shop_info"><ul><li class="li-pic"></li><li class="btn"><a class="red" '+dis+' title="直接去'+jq("#mingzi_"+id).text()+'购物" target="_blank" href="plugin.php?id=yikatong:brand&mod=store&sid='+id+'" target="_blank">进入店铺</a></li><li class="info">'+jq("#mingzi_"+id).attr("title")+'</li> </ul></div></div>';
		$this.append(ls);
		$this.attr("init","true");
		jq("#ul_div_"+ids).show();
	}
}
function closeDiv(ids){
 	jq("#ul_div_"+ids).hide();
}

/**
 * 滚动
 *   
 */
function simplescroll(C,A){
	this.config=A?A:{start_delay:0,speed:23,delay:3000,direction:1,scrollItemCount:1,movecount:1};
	this.container=document.getElementById(C);
	this.pause=false;
	var B=this;
	this.init=function(){
		var H=B.container;
		B.scrollTimeId=null;
		if(B.config.direction==2||B.config.direction==4){
			var G=document.createElement("div");
			var F=H.getElementsByTagName("li").length;
			var D=H.getElementsByTagName("li")[0].offsetWidth;
			var E=H.getElementsByTagName("li")[0].offsetHeight;
			G.innerHTML=H.innerHTML;
			H.innerHTML="";
			G.style.width=F*D+"px";
			H.appendChild(G);
		}
		setTimeout(B.start,B.config.start_delay);
	}; 
	this.start=function(){
		var F=B.container;
		if(B.config.direction==1||B.config.direction==3){
			var E=F.getElementsByTagName("li")[0].offsetHeight;
//			if(F.scrollHeight-F.offsetHeight>=E){
				B.scrollTimeId=setInterval(B.scroll,B.config.speed);
//			}
		}else{
			if(B.config.direction==2){
				F.scrollLeft=F.scrollWidth;
				var D=F.getElementsByTagName("li")[0].offsetWidth;
				B.scrollTimeId=setInterval(B.scroll,B.config.speed);
			}else{
				if(B.config.direction==4){
					var D=F.getElementsByTagName("li")[0].offsetWidth;
					B.scrollTimeId=setInterval(B.scroll,B.config.speed);
				}
			}
		}
	};
	this.scroll=function(){
		if(B.pause){return false;}
		var G=B.container;
		switch(B.config.direction){
			case 1:
				G.scrollTop+=2;
				var F=G.getElementsByTagName("li")[0].offsetHeight;
				if(G.scrollTop%(F*B.config.scrollItemCount)<=1){
					if(B.config.movecount!=undefined){
						for(var E=0;E<B.config.movecount;E++){
							G.appendChild(G.getElementsByTagName("li")[0]);
						}
					}else{
						for(var E=0;E<B.config.scrollItemCount;E++){
							G.appendChild(G.getElementsByTagName("li")[0]);
						}
					}
					G.scrollTop=0;
					clearInterval(B.scrollTimeId);
					setTimeout(B.start,B.config.delay);
				}
			break;
			case 4:
				G.scrollLeft+=2;
				var D=G.childNodes[0].getElementsByTagName("li")[0].offsetWidth;
				if(G.scrollLeft%(D*B.config.scrollItemCount)<=1){
					if(B.config.movecount!=undefined){
						for(var E=0;E<B.config.movecount;E++){
							G.childNodes[0].appendChild(G.childNodes[0].getElementsByTagName("li")[0]);
						}
					}else{
						for(var E=0;E<B.config.scrollItemCount;E++){
							G.childNodes[0].appendChild(G.childNodes[0].getElementsByTagName("li")[0]);
						}
					}
					G.scrollLeft=0;
					clearInterval(B.scrollTimeId);
					setTimeout(B.start,B.config.delay);
				}
				break
		}
	};
	this.container.onmouseover=function(){
		B.pause=true
	};
	this.container.onmouseout=function(){
		B.pause=false
	};
	this.init();
}
