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
			){//ͼƬ�Ѿ����ػ��߻���Ͳ��ü�����
			return false;
		}
		if(img.getAttribute("reload") != null)
			return ;
		img.setAttribute('_src',img.src);
		img.src='http://img2.citysbs.com/css/0.5.21.57-hd-app/brand/brandspace/images/dot.gif';
		//���������ʾռλloadingͼƬ��Ҳ�����Ƴ�src��img.removeAttribute('src'); 
		//ò���Ƴ�src��webkit�����������safari & chrome���²�������ֹ���������ͼƬ��������û���ʹ��ռλͼƬ��ʽ
		//�����벻Ҫ��src����Ϊ�գ�img.src=""; ò��ĳЩ������»�����������������IE����
		var action=function(img){//��Ӧ����
			if(img.getAttribute('loaded')){//�ж��Ƿ�loaded��
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
			//ͨ������Ƚ�ͼƬ�뵱ǰ��������ڵ�λ���ж�ͼƬ�Ƿ��ѽ��뵱ǰ��������
				img.setAttribute('loaded','loaded');//����loaded���ԣ���Ǵ�img�Ѿ���ʼ����
				img.src=img.getAttribute('_src');//����src
				img.onload=img.onerror=img.onreadystatechange=function(){
				//IEͨ��onreadystatechange������onload
					if(img&&img.readyState&&img.readyState!='loaded'&&img.readyState!='complete'){
						return false;
					}
					img.onload = img.onreadystatechange = img.onerror = null;
					var animat=function(el){//һ���򵥵�fadeInЧ��
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
		//ie8�����������ͨ��scroll�¼���ò��������,��ʱ���ö�ʱ��ʵ��
			img.timer=setInterval(function(){action(img)},1000);
		}else{
			addListener(window,'scroll',function(){action(img)},false);
		}
	}


var imgs=document.getElementsByTagName('img');
for(var i=0,j=imgs.length;i<j;i++){
	lazyload(imgs[i]);
}