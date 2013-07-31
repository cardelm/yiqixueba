
/**
 *      [品牌空间] (C)2001-2010 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      jqId: viewgoodspic.js 4823 2010-11-05 05:42:39Z fanshengshuai jq
 */
var jq = jQuery.noConflict();
var msgwidth = 0;
var userAgent = navigator.userAgent.toLowerCase();
var is_opera = userAgent.indexOf('opera') != -1 && opera.version();
var is_moz = (navigator.product == 'Gecko') && userAgent.substr(userAgent.indexOf('firefox') + 8, 3);
var is_ie = (userAgent.indexOf('msie') != -1 && !is_opera) && userAgent.substr(userAgent.indexOf('msie') + 5, 3);

function jqi(id) {
	return document.getElementById(id);
}

function fetchOffset(obj) {
	if(typeof(obj) == "string"){
		obj = jqi(obj);
	}
	var left_offset = obj.offsetLeft;
	var top_offset = obj.offsetTop;
	while((obj = obj.offsetParent) != null) {
		left_offset += obj.offsetLeft;
		top_offset += obj.offsetTop;
	}
	return { 'left' : left_offset, 'top' : top_offset };
}

function thumbImg(obj) {
	var zw = obj.width;
	var zh = obj.height;
	if(is_ie && zw == 0 && zh == 0) {
		var matches
		re = /width=(["']?)(\d+)(\1)/i
		matches = re.exec(obj.outerHTML);
		zw = matches[2];
		re = /height=(["']?)(\d+)(\1)/i
		matches = re.exec(obj.outerHTML);
		zh = matches[2];
	}
	obj.resized = true;
	obj.style.width = zw + 'px';
	obj.style.height = 'auto';
	if(obj.offsetHeight > zh) {
		obj.style.height = zh + 'px';
		obj.style.width = 'auto';
	}
	if(is_ie) {
		var imgid = 'img_' + Math.random();
		obj.id = imgid;
		setTimeout('try {if (jqi(\''+imgid+'\').offsetHeight > '+zh+') {jqi(\''+imgid+'\').style.height = \''+zh+'px\';jqi(\''+imgid+'\').style.width = \'auto\';}} catch(e){}', 1000);
	}
	obj.onload = null;
}

function attachimg(obj, action) {
	if(action == 'load') {
		if(is_ie && is_ie < 7) {
			var objinfo = fetchOffset(obj);
			msgwidth = document.body.clientWidth - objinfo['left'] - 20;
		} else {
			if(!msgwidth) {
				var re = /postcontent|message/i;
				var testobj = obj;
				while((testobj = testobj.parentNode) != null) {
					var matches = re.exec(testobj.className);
					if(matches != null) {
						msgwidth = testobj.clientWidth - 20;
						break;
					}
				}
				if(msgwidth < 1) {
					msgwidth = window.screen.width;
				}
			}
		}
		if(obj.width > msgwidth) {
			obj.resized = true;
			obj.width = msgwidth;
			obj.style.cursor = 'pointer';
		} else {
			obj.onclick = null;
		}
	} else if(action == 'mouseover') {
		if(obj.resized) {
			obj.style.cursor = 'pointer';
		}
	}
}

function attachimginfo(obj, infoobj, show, event) {
	objinfo = fetchOffset(obj);
	if(show) {
		jqi(infoobj).style.left = objinfo['left'] + 'px';
		jqi(infoobj).style.top = obj.offsetHeight < 40 ? (objinfo['top'] + obj.offsetHeight) + 'px' : objinfo['top'] + 'px';
		jqi(infoobj).style.display = '';
	} else {
		if(is_ie) {
			jqi(infoobj).style.display = 'none';
			return;
		} else {
			var mousex = document.body.scrollLeft + event.clientX;
			var mousey = document.documentElement.scrollTop + event.clientY;
			if(mousex < objinfo['left'] || mousex > objinfo['left'] + objinfo['width'] || mousey < objinfo['top'] || mousey > objinfo['top'] + objinfo['height']) {
				jqi(infoobj).style.display = 'none';
			}
		}
	}
}

function copycode(obj) {
	if(is_ie && obj.style.display != 'none') {
		var rng = document.body.createTextRange();
		rng.moveToElementText(obj);
		rng.scrollIntoView();
		rng.select();
		rng.execCommand("Copy");
		rng.collapse(false);
	}
}

function signature(obj) {
	if(obj.style.maxHeightIE != '') {
		var height = (obj.scrollHeight > parseInt(obj.style.maxHeightIE)) ? obj.style.maxHeightIE : obj.scrollHeight;
		if(obj.innerHTML.indexOf('<IMG ') == -1) {
			obj.style.maxHeightIE = '';
		}
		return height;
	}
}

function fastreply(subject, postnum) {
	if(jqi('postform')) {

		jqi('postform').subject.value = subject.replace(/#/, jqi(postnum).innerHTML.replace(/<[\/\!]*?[^<>]*?>/ig, ''));
		jqi('postform').message.focus();
	}
}

function tagshow(event) {
	var obj = is_ie ? event.srcElement : event.target;
	obj.id = !obj.id ? 'tag_' + Math.random() : obj.id;
	ajaxmenu(event, obj.id, 0, '', 1, 3, 0);
	obj.onclick = null;
}

var zoomobj = Array();var zoomadjust;var zoomstatus = 1;


function zoom(obj, zimg,title) {
	this.obj=obj;
	this.zimg=zimg;
	this.title=title;
	this.zoombackend = function zoombackend(){
		var obj=this.obj;
		var zimg=this.zimg;
		var title=this.title;

		if(!zoomstatus) {
			window.open(zimg, '', '');
			return;
		}
		if(!zimg) {
			zimg = obj.src;
		}
		if(!jqi('mask_div') || !jqi('zoomimglayer')) {
			div = document.createElement('div');div.id = 'mask_div';
			div.style.position = 'absolute';
			div.style.left = div.style.top = '0px';
			div.style.width = div.style.width = '100%';
			div.style.zIndex = '1000';
			div.style.height = document.body.scrollHeight + 'px';
			div.style.backgroundColor = '#000';
			div.style.display = 'none';
			//div.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=80,finishOpacity=100,style=0)';
			div.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=80,finishOpacity=10,style=0)';
			div.style.opacity = 0.8;
			jqi('append_parent').appendChild(div);
			div = document.createElement('div');div.id = 'zoomimglayer';
			div.style.position = 'absolute';
			div.className = 'popupmenu_popup';
			//div.style.padding = 0;
			jqi('append_parent').appendChild(div);
		}
		zoomobj['srcinfo'] = fetchOffset(obj);
		zoomobj['srcobj'] = obj;
		zoomobj['zimg'] = zimg;
		zoomobj['title'] = title;
		jqi('zoomimglayer').style.display = '';
		jqi('zoomimglayer').style.left = zoomobj['srcinfo']['left'] + 'px';
		jqi('zoomimglayer').style.top = zoomobj['srcinfo']['top'] + 'px';
		jqi('zoomimglayer').style.width = zoomobj['srcobj'].width + 'px';
		jqi('zoomimglayer').style.height = zoomobj['srcobj'].height + 'px';
		jqi('zoomimglayer').style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=40,finishOpacity=100,style=0)';


		jqi('zoomimglayer').style.opacity = 0.4;
		jqi('zoomimglayer').style.zIndex = 9999;
		jqi('zoomimglayer').innerHTML = '<table width="100%" height="100%" cellspacing="0" cellpadding="0"><tr><td align="center" valign="middle"><img src="static/image/goodview_loading.gif"></td></tr></table><div style="position:absolute;top:-100000px;visibility:hidden"><img onload="zoomimgresize(this)" src="' + zoomobj['zimg'] + '"></div>';
	}
	this.wait=function(){
		setTimeout("this.zoombackend()",300);
	}
	this.wait();
}

var zoomdragstart = new Array();
var zoomclick = 0;
function zoomdrag(e, op) {
	if(op == 1) {
		zoomclick = 1;
		zoomdragstart = is_ie ? [event.clientX, event.clientY] : [e.clientX, e.clientY];
		zoomdragstart[2] = parseInt(jqi('zoomimglayer').style.left);
		zoomdragstart[3] = parseInt(jqi('zoomimglayer').style.top);
		doane(e);
	} else if(op == 2 && zoomdragstart[0]) {
		zoomclick = 0;
		var zoomdragnow = is_ie ? [event.clientX, event.clientY] : [e.clientX, e.clientY];
		jqi('zoomimglayer').style.left = (zoomdragstart[2] + zoomdragnow[0] - zoomdragstart[0]) + 'px';
		jqi('zoomimglayer').style.top = (zoomdragstart[3] + zoomdragnow[1] - zoomdragstart[1]) + 'px';
		doane(e);
	} else if(op == 3) {
		if(zoomclick) zoomclose();
		zoomdragstart = [];
		doane(e);
	}
}

function zoomST(c) {
	if(jqi('zoomimglayer').style.display == '') {
		jqi('zoomimglayer').style.left = (parseInt(jqi('zoomimglayer').style.left) + zoomobj['x']) + 'px';
		jqi('zoomimglayer').style.top = (parseInt(jqi('zoomimglayer').style.top) + zoomobj['y']) + 'px';
		jqi('zoomimglayer').style.width = (parseInt(jqi('zoomimglayer').style.width) + zoomobj['w']) + 'px';
		jqi('zoomimglayer').style.height = (parseInt(jqi('zoomimglayer').style.height) + zoomobj['h']) + 'px';
		var opacity = c * 20;
		jqi('zoomimglayer').style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + opacity + ',finishOpacity=100,style=0)';
		jqi('zoomimglayer').style.opacity = opacity / 100;
		c++;
		if(c <= 5) {
			setTimeout('zoomST(' + c + ')', 5);
		} else {
			zoomadjust = 1;
			jqi('zoomimglayer').style.filter = '';
			jqi('mask_div').style.display = '';
			jqi('zoomimglayer').innerHTML = '<table cellspacing=2" bgcolor="#FFFFFF"><tr bgcolor="#F4F9FE"><td style="text-align: right">鼠标滚轮缩放图片  <a href="###" style="background:none; margin:0; padding:0; width:20px; float:none;" onclick="zoomimgadjust(event, 1)"><img src="static/image/goodview_resize.gif" border="0" style="vertical-align: middle" title="实际大小" /></a> <a href="###" style="background:none; margin:0; padding:0; width:20px; float:none;" onclick="zoomclose()"><img style="vertical-align: middle" src="static/image/goodview_close.gif" title="关闭" /></a>&nbsp;</td></tr><tr><td align="center" id="zoomimgbox"><img id="zoomimg" style="cursor: move; margin: 5px;" src="' + zoomobj['zimg'] + '" width="' + jqi('zoomimglayer').style.width + '" height="' + jqi('zoomimglayer').style.height + '"></td></tr><tr><td>'+zoomobj['title']+'</td></tr></table>';
			jqi('zoomimglayer').style.overflow = 'hidden';
			jqi('zoomimglayer').style.width = jqi('zoomimglayer').style.height = 'auto';
			if(is_ie){
				jqi('zoomimglayer').onmousewheel = zoomimgadjust;
			} else {
				jqi('zoomimglayer').addEventListener("DOMMouseScroll", zoomimgadjust, false);
			}
			jqi('zoomimgbox').onmousedown = function(event) {try{zoomdrag(event, 1);}catch(e){}};
			jqi('zoomimgbox').onmousemove = function(event) {try{zoomdrag(event, 2);}catch(e){}};
			jqi('zoomimgbox').onmouseup = function(event) {try{zoomdrag(event, 3);}catch(e){}};
		}
	}
}

function zoomimgresize(obj) {
	zoomobj['zimginfo'] = [obj.width, obj.height];
	var r = obj.width / obj.height;
	var w = document.body.clientWidth * 0.95;
	w = obj.width > w ? w : obj.width;
	var h = w / r;
	var clientHeight = document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight;
	var scrollTop = document.body.scrollTop ? document.body.scrollTop : document.documentElement.scrollTop;
	if(h > clientHeight) {
		h = clientHeight;
		w = h * r;
	}
	var l = (document.body.clientWidth - w) / 2;
	var t = h < clientHeight ? (clientHeight - h) / 2 : 0;
	t += + scrollTop;
	zoomobj['x'] = (l - zoomobj['srcinfo']['left']) / 5;
	zoomobj['y'] = (t - zoomobj['srcinfo']['top']) / 5;
	zoomobj['_x'] = "45%";
	zoomobj['_y'] = "35%";
	zoomobj['w'] = (w - zoomobj['srcobj'].width) / 5;
	zoomobj['h'] = (h - zoomobj['srcobj'].height) / 5;
	jqi('zoomimglayer').style.filter = '';
	jqi('zoomimglayer').innerHTML = '';
	setTimeout('zoomST(1)', 5);
}

function zoomimgadjust(e, a) {
	if(!a) {
		if(!e) e = window.event;
		if(e.altKey || e.shiftKey || e.ctrlKey) return;
		var l = parseInt(jqi('zoomimglayer').style.left);
		var t = parseInt(jqi('zoomimglayer').style.top);
		if(e.wheelDelta <= 0 || e.detail > 0) {
			if(jqi('zoomimg').width <= 200 || jqi('zoomimg').height <= 200) {
				doane(e);return;
			}
			jqi('zoomimg').width -= zoomobj['zimginfo'][0] / 10;
			jqi('zoomimg').height -= zoomobj['zimginfo'][1] / 10;
			l += zoomobj['zimginfo'][0] / 20;
			t += zoomobj['zimginfo'][1] / 20;
		} else {
			if(jqi('zoomimg').width >= zoomobj['zimginfo'][0]) {
				zoomimgadjust(e, 1);return;
			}
			jqi('zoomimg').width += zoomobj['zimginfo'][0] / 10;
			jqi('zoomimg').height += zoomobj['zimginfo'][1] / 10;
			l -= zoomobj['zimginfo'][0] / 20;
			t -= zoomobj['zimginfo'][1] / 20;
		}
	} else {
		var clientHeight = document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight;
		var scrollTop = document.body.scrollTop ? document.body.scrollTop : document.documentElement.scrollTop;
		jqi('zoomimg').width = zoomobj['zimginfo'][0];jqi('zoomimg').height = zoomobj['zimginfo'][1];
		var l = (document.body.clientWidth - jqi('zoomimg').clientWidth) / 2;l = l > 0 ? l : 0;
		var t = (clientHeight - jqi('zoomimg').clientHeight) / 2 + scrollTop;t = t > 0 ? t : 0;
	}
	jqi('zoomimglayer').style.left = l + 'px';
	jqi('zoomimglayer').style.top = t + 'px';
	jqi('mask_div').style.height = t + jqi('zoomimglayer').clientHeight > jqi('mask_div').clientHeight ? (t + jqi('zoomimglayer').clientHeight) + 'px' : jqi('mask_div').style.height;
	doane(e);
}

function zoomclose() {
	jqi('zoomimglayer').innerHTML = '';
	jqi('zoomimglayer').style.display = 'none';
	jqi('mask_div').style.display = 'none';
}
function doane(event) {
	e = event ? event : window.event;
	if(is_ie) {
		e.returnValue = false;
		e.cancelBubble = true;
	} else if(e) {
		e.stopPropagation();
		e.preventDefault();
	}
}
