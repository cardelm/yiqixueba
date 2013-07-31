// JavaScript Document
var addListener=function(e, n, o, u){
	if(e.addEventListener) {
		e.addEventListener(n, o, u);
		return true;
	} else if(e.attachEvent) {
		e['e' + n + o] = o;
		e[n + o] = function() {
			e['e' + n + o](window.event);
		};
		e.attachEvent('on' + n, e[n + o]);
		return true;
	}
	return false;
},
getObjPoint=function(o){
	var x=y=0;
	do {
		x += o.offsetLeft || 0;
		y += o.offsetTop  || 0;
		o = o.offsetParent;
	} while (o);

	return {'x':x,'y':y};
},
IE=function(){
	if(/msie (\d+\.\d)/i.test(navigator.userAgent)){
		return document.documentMode || parseFloat(RegExp.$1);
	}
	return 0;
}
var lazyload=function(img){
		if(img.complete||img.readyState&&(
			img.readyState=='loaded'||img.readyState=='complete')
			){//图片已经下载或者缓存就不用继续了
			return false;
		}
		if(img.getAttribute("reload") != null)
			return ;
		img.setAttribute('_src',img.src);
		img.src='http://img2.citysbs.com/css/0.5.21.57-hd-app/brand/brandspace/images/dot.gif';
		//如果不想显示占位loading图片，也可以移除src：img.removeAttribute('src'); 
		//貌似移除src在webkit核心浏览器（safari & chrome）下并不会阻止浏览器下载图片，所以最好还是使用占位图片方式
		//但是请不要将src设置为空，img.src=""; 貌似某些浏览器下还会下载其他东西（IE？）
		var action=function(img){//响应操作
			if(img.getAttribute('loaded')){//判断是否loaded了
				clearInterval(img.timer);
				return;
			}
			var doc=document.documentElement,
				body=document.body,
				sy=(doc&&doc.scrollTop || body&&body.scrollTop || 0) - (doc&&doc.clientTop || body&&body.clientTop || 0),
				np=getObjPoint(img),
				ny=np.y,
				wy=doc&&doc.clientHeight || body&&body.clientHeight;
			//console.log(ny+'|'+sy+'|'+wy)
			if(Math.abs(ny-sy)<wy){
			//通过计算比较图片与当前浏览器窗口的位置判断图片是否已进入当前可视区域
				img.setAttribute('loaded','loaded');//设置loaded属性，标记此img已经开始加载
				img.src=img.getAttribute('_src');//修正src
				img.onload=img.onerror=img.onreadystatechange=function(){
				//IE通过onreadystatechange，其他onload
					if(img&&img.readyState&&img.readyState!='loaded'&&img.readyState!='complete'){
						return false;
					}
					img.onload = img.onreadystatechange = img.onerror = null;
					var animat=function(el){//一个简单的fadeIn效果
						var s=0,
							timer=setInterval(function(){
							el.style.opacity=s;
							el.style.filter=('opacity='+(s*100));
							s+=0.05;
							if(s>1)clearInterval(timer);
						},30)
					}
					animat(img);
				};
			}
		}
		action(img);
		if(IE()&&IE()<9){
		//ie8及以下浏览器通过scroll事件绑定貌似有问题,暂时先用定时器实现
			img.timer=setInterval(function(){action(img)},1000);
		}else{
			addListener(window,'scroll',function(){action(img)},false);
		}
	}


var imgs=document.getElementsByTagName('img');
for(var i=0,j=imgs.length;i<j;i++){
	lazyload(imgs[i]);
}