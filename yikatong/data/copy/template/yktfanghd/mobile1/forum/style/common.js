
var COMPUTER = 0;
var ANDROID = 1;
var IPHONE = 2;
var DEVICE = ANDROID;
var VEVENT = {};
var MINUTE = 60;
var HOUR = 3600;
var DAY = 86400;

if (navigator.platform && (navigator.platform == 'Win32' || navigator.platform == 'MacIntel')) {
	DEVICE = COMPUTER;
}
console.log('DEVICE = ' + DEVICE);
//set vevent
if (DEVICE == COMPUTER) {
	VEVENT = {
		mouseup   : 'mouseup',
		mousedown : 'mousedown',
		mousemove : 'mousemove',
		mouseout  : 'mouseout'
	};
}
else {
	VEVENT = {
		mouseup   : 'touchend',
		mousedown : 'touchstart',
		mousemove : 'touchmove',
		mouseout  : 'touchcancel'
	};
}
isAndroid = (/android/gi).test(navigator.appVersion);
isIDevice = (/iphone|ipad/gi).test(navigator.appVersion);
isTouchPad = (/hp-tablet/gi).test(navigator.appVersion);

//样式适配
(function(){
	var A=window.navigator.userAgent.toLowerCase();
	var screenWidth = screen.width;
	var pixelRat = window.devicePixelRatio;
	setTimeout(function(){
		if(/android 2/.test(A)){
			document.getElementById('addStyle').setAttribute("href","/css/style_android_2.css");
		}
	},1);
})();

function timeFormat(sec) {
	if (sec <= 0) return '';
	str = '';
	if (sec > DAY) {
		day  = Math.floor(sec / DAY);
		sec -= day * DAY;
		hour = Math.floor(sec / HOUR);
		sec -= hour * HOUR;
		minute = Math.ceil(sec / MINUTE);
		str = day+'天:'+hour+'时:'+minute+'分';
	}
	else {
		hour = Math.floor(sec / HOUR);
		sec -= hour * HOUR;
		minute = Math.floor(sec / MINUTE);
		sec -= minute * MINUTE;
		str = hour+'时:'+minute+'分:'+sec+'秒';
	}
	return str;
}

//绑定事件
window.bindEvent = function(selector, event, callback) {
    var elements = new Array();
    if (selector[0] == '#') {
        var el = document.querySelector(selector);
        if (el) {
            elements.push(el);
        }
    }
    else {
        var elements = document.querySelectorAll(selector);
    }
    if (elements.length > 0) {
        for (var i=0; i<elements.length; i++) {
            elements[i].addEventListener(event, callback);
        }
    }
};
//定义 document.ready 方法，用法同 $(document).ready();
(function () {
    var ie = !!(window.attachEvent && !window.opera);
    var wk = /webkit\/(\d+)/i.test(navigator.userAgent) && (RegExp.$1 < 525);
    var fn = [];
    var run = function () { for (var i = 0; i < fn.length; i++) fn[i](); };
    var d = document;
    d.ready = function (f) {
        if (!ie && !wk && d.addEventListener)
            return d.addEventListener('DOMContentLoaded', f, false);
        if (fn.push(f) > 1) return;
        if (ie)
            (function () {
                try { d.documentElement.doScroll('left'); run(); }
                catch (err) { setTimeout(arguments.callee, 0); }
            })();
        else if (wk)
            var t = setInterval(function () {
                if (/^(loaded|complete)$/.test(d.readyState))
                    clearInterval(t), run();
            }, 0);
    };
})();

//分享和关注
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {

    // 设置字段大小的回调,目前有1-4个大小等级
    WeixinJSBridge.on('menu:setfont',function(argv){
        // 示例代码
        var num = parseInt(argv.fontSize);
        changefont(num);
        return;

    });
    var shareDiv = document.querySelector('#shareDiv');
    function sendShareCommand(obj) {
        var dealId = shareDiv ? shareDiv.getAttribute('dealid') : obj.getAttribute('dealid');
        var imgUrl = shareDiv ? shareDiv.getAttribute('img') : obj.getAttribute('img');
        var command = obj.getAttribute('id');
        var desc = shareDiv ? shareDiv.getAttribute('desc') : obj.getAttribute('desc');
        var title = shareDiv ? shareDiv.getAttribute('tt') : obj.getAttribute('title');
        var stateS = '1468';
        var stateA = obj.getAttribute('state_a') ? obj.getAttribute('state_a') : 0;
        
        if (!command || command != 'sendAppMessage'){command = 'shareTimeline';}
        
		//alert('dealId='+dealId+'\nstateS='+stateS+'\nimgUrl='+imgUrl+'\ncommand='+command+'\nstateA='+stateA+'\ndesc='+desc+'\ntitle='+title);return;
        
        WeixinJSBridge.invoke(command,{
            "appid" : 'asdfafd',
            "img_url": imgUrl, // 分享到朋友圈的缩略图
            "img_width": "470",// 图片的长度
            "img_height": "310", // 图片高度
            "link": SERVER_HOST+'/deal/view/'+dealId+'?S='+stateS+'&A='+stateA,// 连接地址
            "desc": desc, // 描述
            "title": title // 分享标题
        },function(res){
            // 返回res.err_msg,取值
            // share_timeline:fail　发送失败
            // share_timeline:ok 发送成功
        	
            // share_timeline:cancel 用户取消朋友圈分享
        	// share_timeline:confirm 分享朋友圈成功
        	// send_app_msg:cancel  用户取消分享朋友成功
        	// send_app_msg:confirm 分享朋友成功
        	WeixinJSBridge.log(res.err_msg);
            if (res && res.err_msg && res.err_msg.indexOf('confirm') > -1 ){
            	var arg = {'shareType':command,'dealId':dealId}
            	WxShareHandle(arg);
            }
        });
    }
    
    /* *
     * 微信分享 统计
     * */
    function WxShareHandle(arg){
    	if (!arg) return false;
    	ajax({url:"/data/wxshare",method:'POST',data:arg}).getScript(function(data){
    		if (data && data.err == 0){
    			window.location.href=window.location.href;
    		}else{
    			//alert(data.info);
    		}
    	});
    }
    
    // 分享到朋友圈
    window.bindEvent('#shareTimeline', 'click', function(){
        sendShareCommand(this);
    });
    window.bindEvent('#sendAppMessage', 'click', function(){
        sendShareCommand(this);
    });
    
    window.bindEvent('#isShareBuy', 'click', function(){
        sendShareCommand(this);
    });
    
    function addContact(node){
		var url = node.getAttribute('url');
		WeixinJSBridge.invoke('addContact',{
				"webtype" : "1", // 添加联系人的场景，1表示企业联系人。
				"username" : "weituangou"　// 需要添加的联系人username
			},function(res){
				// 返回res.err_msg,取值
				// add_contact:added 已添加过
				// add_contact:cancel 用户取消
				// add_contact:fail　添加失败
				// add_contact:ok 添加成功
				if (res.err_msg == 'add_contact:ok' || res.err_msg == 'add_contact:added') {
					location.href=url;
				}
				else {
					alert('关注失败');
				}
				WeixinJSBridge.log(res.err_msg);
			});
	}
	window.bindEvent('#addContact', 'click', function(){
        addContact(this);
    });

    WeixinJSBridge.log('yo~ ready.');

}, false);

//其他通用方法
document.ready(function(){
    var d = document;
    //跳转地址
    window.bindEvent('.button', 'click', function(){
        var url = this.getAttribute('url');
        location.href = url;
    });
    //发送微信
    window.bindEvent('.sendCode', 'click', function(){
        if (this.className == 'fcqli2_grey') return false;
        var url = '/send/code';
        var param = this.getAttribute('param');//格式如 orderId=1232&code=3455443
        var title = this.getAttribute('codetitle');//显示的券号，格式如 1234 3232 2343
        d.querySelector('#loadingBox').style.display = 'block';
        var options = {
            url:url+'?'+param,
            onError:function(){
                d.querySelector('#loadingBox').style.display = 'none';
                //alert('网络连接错误');
            }
        }
        ajax(options).getScript(function(json){
            d.querySelector('#loadingBox').style.display = 'none';
            if (!json || typeof json.retCode == 'undefined') {
                alert('服务器错误，请重试');
                return false;
            }
            if (json.retCode != 0) {
                if (json.retCode == '300001') {
                    alert('您已掉线，点击\"确定\"后将重新登录');
                    location.href = '/';
                    return false;
                }
                if (json.retMsg) {
                    alert(json.retMsg);
                }
                return false;
            }
            var tip = d.querySelector('#tipMessage');
            tip.querySelector('h1').innerHTML = '微团券：'+title;
            zindex = 8;
            var gdiv = createGreyDiv(zindex);
            tip.style.zIndex = zindex+1;
            tip.style.display = 'block';
            
            setTimeout(function(){
                tip.style.display = 'none';
                gdiv.parentNode.removeChild(gdiv);
                tip.style.zIndex = "";
            }, 3000);
        });
    });
    //点击下载客户端
    var gdiv = null;
    window.bindEvent('#btnDownApp', 'click', function(){
        var url = '';
        if (isAndroid) url = d.querySelector('#androidDownUrl').getAttribute('href');
        else if (isIDevice)  url = d.querySelector('#iosDownUrl').getAttribute('href');
        if (url!='') {
            location.href = url;
            return ;
        }
        var zindex = 8;
        gdiv = createGreyDiv(zindex);
	    d.querySelector('#selectClient').style.zIndex = zindex+1;
        d.querySelector('#selectClient').style.display = 'block';
        window.bindEvent('#'+gdiv.id, 'click', function(){
	    	d.querySelector('#selectClient').style.display = 'none';
	    	gdiv.parentNode.removeChild(gdiv);
	    	d.querySelector('#selectClient').style.zIndex = "";
	    });
    });
    
    
    //抢购按钮二态
    btnStatus('.fhbtn',VEVENT.mousedown,'fhbtn_d', 1);
    btnStatus('.fhbtn',VEVENT.mouseup,'fhbtn_d', 2);
    btnStatus('.fhbtn',VEVENT.mouseout,'fhbtn_d', 2);
    
    //橙色按钮二态
    btnStatus('.fc_btn_o',VEVENT.mousedown,'fc_btn_od', 1);
    btnStatus('.fc_btn_o',VEVENT.mouseup,'fc_btn_od', 2);
    btnStatus('.fc_btn_o',VEVENT.mouseout,'fc_btn_od', 2);
    
    //绿色按钮二态
    btnStatus('#BtnOrder',VEVENT.mousedown,'fc_btn_d', 1);
    btnStatus('#BtnOrder',VEVENT.mouseup,'fc_btn_d', 2);
    btnStatus('#BtnOrder',VEVENT.mouseout,'fc_btn_d', 2);
    
    btnStatus('#btnSelectPayType',VEVENT.mousedown,'fc_btn_d', 1);
    btnStatus('#btnSelectPayType',VEVENT.mouseup,'fc_btn_d', 2);
    btnStatus('#btnSelectPayType',VEVENT.mouseout,'fc_btn_d', 2);
    
    
});
/*
 * 按钮二态公共方法 @NICK.H
 * s：选择器
 * e：需要绑定的事件
 * c：改变的样式
 * t：改变类型：0:改变（默认）；1：追加；2：删除
 * */
function btnStatus(s, e, c, t){
	if (typeof(s) == 'undefined' || typeof(e) == 'undefined' || typeof(c) == 'undefined') return;
	if (typeof(t) == 'undefined' || !t ) t = 0;
	else t = parseInt(t);
	window.bindEvent(s, e, function(){
		try{
		var d = document, b = ' ';
		var n = b + d.querySelector(s).className;
		if (t == 1){d.querySelector(s).className += b + c;}
		else if (t == 2){d.querySelector(s).className = n.replace(b+c,'').Trim();}
		else{d.querySelector(s).className = c.Trim();}
		}catch(e){}
    	
    });
}

function createGreyDiv(index){
	var newMask = document.createElement("div");
    newMask.id = 'm';
    newMask.style.position = "absolute";
    newMask.style.zIndex = index;
    _scrollWidth = Math.max(document.body.scrollWidth, document.documentElement.scrollWidth);
    _scrollHeight = Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
    newMask.style.width = _scrollWidth + "px";
    newMask.style.height = _scrollHeight + "px";
    newMask.style.top = "0px";
    newMask.style.left = "0px";
    newMask.style.background = "#33393C";
    newMask.style.filter = "alpha(opacity=10)";
    newMask.style.opacity = "0.60";
    document.body.appendChild(newMask);
    return newMask;
}

function goBackOrMain(node){
	var uri = document.referrer.toLowerCase();
	if(/order/.test(uri) || /ticket/.test(uri)){
		history.go(-1);
	}else{
		window.location.href="/";
	}
}

function imgOnerror(){
	var img=event.srcElement;
	var def = img.getAttribute('def');
	img.src= def;
	img.onerror=null;
}





//js去除空格函数
//此处为string类添加三个成员
String.prototype.Trim = function(){ return Trim(this);}
String.prototype.LTrim = function(){return LTrim(this);}
String.prototype.RTrim = function(){return RTrim(this);}

//此处为独立函数
function LTrim(str){
	var i;
	for(i=0;i<str.length;i++){
		if(str.charAt(i)!=" "&&str.charAt(i)!=" ")break;
	}
	str=str.substring(i,str.length);
	return str;
}
function RTrim(str){
	var i;
	for(i=str.length-1;i>=0;i--){
   		if(str.charAt(i)!=" "&&str.charAt(i)!=" ")break;
	}
	str=str.substring(0,i+1);
	return str;
}
function Trim(str){
	return LTrim(RTrim(str));
}


/**
 * 格式化剩余时间显示
 * @param  integer  second  秒数
 */
function formatTime(sec)
{
	if (sec <= 0) return '';
	str = '';
	if (sec > DAY) {
		day  = Math.floor(sec / DAY);
		sec -= day * DAY;
		hour = Math.floor(sec / HOUR);
		sec -= hour * HOUR;
		minute = Math.floor(sec / MINUTE);
		sec -= minute * MINUTE;
		str = day+'天 '+hour+'时 '+minute+'分 '+sec+'秒';
	}
	else {
		hour = Math.floor(sec / HOUR);
		sec -= hour * HOUR;
		minute = Math.floor(sec / MINUTE);
		sec -= minute * MINUTE;
		str = hour+'时 '+minute+'分 '+sec+'秒';
	}
	return str;
}

Array.prototype.in_array = function(e) {  
        for(i=0; i<this.length && this[i]!=e; i++);  
        return !(i==this.length);  
    }