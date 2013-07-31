
var controlid = null;
var currdate = null;
var startdate = null;
var enddate  = null;
var yy = null;
var mm = null;
var hh = null;
var ii = null;
var currday = null;
var addtime = false;
var today = new Date();
var lastcheckedyear = false;
var lastcheckedmonth = false;



var BROWSER = {};
var USERAGENT = navigator.userAgent.toLowerCase();
BROWSER.ie = window.ActiveXObject && USERAGENT.indexOf('msie') != -1 && USERAGENT.substr(USERAGENT.indexOf('msie') + 5, 3);
BROWSER.firefox = document.getBoxObjectFor && USERAGENT.indexOf('firefox') != -1 && USERAGENT.substr(USERAGENT.indexOf('firefox') + 8, 3);
BROWSER.chrome = window.MessageEvent && !document.getBoxObjectFor && USERAGENT.indexOf('chrome') != -1 && USERAGENT.substr(USERAGENT.indexOf('chrome') + 7, 10);
BROWSER.opera = window.opera && opera.version();
BROWSER.safari = window.openDatabase && USERAGENT.indexOf('safari') != -1 && USERAGENT.substr(USERAGENT.indexOf('safari') + 7, 8);
BROWSER.other = !BROWSER.ie && !BROWSER.firefox && !BROWSER.chrome && !BROWSER.opera && !BROWSER.safari;
BROWSER.firefox = BROWSER.chrome ? 1 : BROWSER.firefox;
function fetchOffset(obj) {
	var left_offset = 0, top_offset = 0;

	if(obj.getBoundingClientRect){
		var rect = obj.getBoundingClientRect();
		var scrollTop = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
		var scrollLeft = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
		if(document.documentElement.dir == 'rtl') {
			scrollLeft = scrollLeft + document.documentElement.clientWidth - document.documentElement.scrollWidth;
		}
		left_offset = rect.left + scrollLeft - document.documentElement.clientLeft;
		top_offset = rect.top + scrollTop - document.documentElement.clientTop;
	}
	if(left_offset <= 0 || top_offset <= 0) {
		left_offset = obj.offsetLeft;
		top_offset = obj.offsetTop;
		while((obj = obj.offsetParent) != null) {
			left_offset += obj.offsetLeft;
			top_offset += obj.offsetTop;
		}
	}
	return { 'left' : left_offset, 'top' : top_offset };
}

function doane(event) {
	e = event ? event : window.event;
	if(!e) return;
	if(BROWSER.ie) {
		e.returnValue = false;
		e.cancelBubble = true;
	} else if(e) {
		e.stopPropagation();
		e.preventDefault();
	}
}


function loadcalendar() {
	s = '';
	s += '<div id="calendar" style="display:none; position:absolute; z-index:100000;" onclick="doane(event)">';
	s += '<div style="width: 210px;"><table cellspacing="0" cellpadding="0" width="100%" style="text-align: center;">';
	s += '<tr align="center" id="calendar_week"><td><a href="###" onclick="refreshcalendar(yy, mm-1)" title="上一月">《</a></td><td colspan="5" style="text-align: center"><a href="###" onclick="showdiv(\'year\');doane(event)" class="dropmenu" title="点击选择年份" id="year"></a>&nbsp; - &nbsp;<a id="month" class="dropmenu" title="点击选择月份" href="###" onclick="showdiv(\'month\');doane(event)"></a></td><td><A href="###" onclick="refreshcalendar(yy, mm+1)" title="下一月">》</A></td></tr>';
	s += '<tr id="calendar_header"><td>日</td><td>一</td><td>二</td><td>三</td><td>四</td><td>五</td><td>六</td></tr>';
	for(var i = 0; i < 6; i++) {
		s += '<tr>';
		for(var j = 1; j <= 7; j++)
			s += "<td id=d" + (i * 7 + j) + " height=\"19\">0</td>";
		s += "</tr>";
	}
	s += '<tr id="hourminute"><td colspan="7" align="center"><input type="text" size="2" value="" id="hour" class="txt" onKeyUp=\'this.value=this.value > 23 ? 23 : zerofill(this.value);controlid.value=controlid.value.replace(/\\d+(\:\\d+)/ig, this.value+"jq1")\'> 点 <input type="text" size="2" value="" id="minute" class="txt" onKeyUp=\'this.value=this.value > 59 ? 59 : zerofill(this.value);controlid.value=controlid.value.replace(/(\\d+\:)\\d+/ig, "jq1"+this.value)\'> 分</td></tr>';
	s += '</table></div></div>';
	s += '<div id="calendar_year" onclick="doane(event)" style="display: none;z-index:100001; background:#fff;"><div class="col">';
	for(var k = 2020; k >= 1931; k--) {
		s += k != 2020 && k % 10 == 0 ? '</div><div class="col">' : '';
		s += '<a href="###" onclick="refreshcalendar(' + k + ', mm);jq(\'#calendar_year\')[0].style.display=\'none\'"><span' + (today.getFullYear() == k ? ' class="calendar_today"' : '') + ' id="calendar_year_' + k + '">' + k + '</span></a><br />';
	}
	s += '</div></div>';
	s += '<div id="calendar_month" onclick="doane(event)" style="display: none;z-index:100001;background:#fff;">';
	for(var k = 1; k <= 12; k++) {
		s += '<a href="###" onclick="refreshcalendar(yy, ' + (k - 1) + ');jq(\'#calendar_month\')[0].style.display=\'none\'"><span' + (today.getMonth()+1 == k ? ' class="calendar_today"' : '') + ' id="calendar_month_' + k + '">' + k + ( k < 10 ? '&nbsp;' : '') + ' 月</span></a><br />';
	}
	s += '</div>';
	if(BROWSER.ie && BROWSER.ie < 7) {
		s += '<iframe id="calendariframe" frameborder="0" style="display:none;position:absolute;filter:progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)"></iframe>';
		s += '<iframe id="calendariframe_year" frameborder="0" style="display:none;position:absolute;filter:progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)"></iframe>';
		s += '<iframe id="calendariframe_month" frameborder="0" style="display:none;position:absolute;filter:progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)"></iframe>';
	}

	var div = document.createElement('div');
	div.innerHTML = s;
	document.getElementById('append_parent').appendChild(div);
	document.onclick = function(event) {
		jq('#calendar')[0].style.display = 'none';
		jq('#calendar_year')[0].style.display = 'none';
		jq('#calendar_month')[0].style.display = 'none';
		if(BROWSER.ie && BROWSER.ie < 7) {
			jq('#calendariframe')[0].style.display = 'none';
			jq('#calendariframe_year')[0].style.display = 'none';
			jq('#calendariframe_month')[0].style.display = 'none';
		}
	};
	jq('#calendar')[0].onclick = function(event) {
		doane(event);
		jq('#calendar_year')[0].style.display = 'none';
		jq('#calendar_month')[0].style.display = 'none';
		if(BROWSER.ie && BROWSER.ie < 7) {
			jq('#calendariframe_year')[0].style.display = 'none';
			jq('#calendariframe_month')[0].style.display = 'none';
		}
	};
}

function parsedate(s) {
	/(\d+)\-(\d+)\-(\d+)\s*(\d*):?(\d*)/.exec(s);
	var m1 = (RegExp.jq1 && RegExp.jq1 > 1899 && RegExp.jq1 < 2101) ? parseFloat(RegExp.jq1) : today.getFullYear();
	var m2 = (RegExp.jq2 && (RegExp.jq2 > 0 && RegExp.jq2 < 13)) ? parseFloat(RegExp.jq2) : today.getMonth() + 1;
	var m3 = (RegExp.jq3 && (RegExp.jq3 > 0 && RegExp.jq3 < 32)) ? parseFloat(RegExp.jq3) : today.getDate();
	var m4 = (RegExp.jq4 && (RegExp.jq4 > -1 && RegExp.jq4 < 24)) ? parseFloat(RegExp.jq4) : 0;
	var m5 = (RegExp.jq5 && (RegExp.jq5 > -1 && RegExp.jq5 < 60)) ? parseFloat(RegExp.jq5) : 0;
	/(\d+)\-(\d+)\-(\d+)\s*(\d*):?(\d*)/.exec("0000-00-00 00\:00");
	return new Date(m1, m2 - 1, m3, m4, m5);
}

function settime(d) {
	jq('#calendar')[0].style.display = 'none';
	jq('#calendar_month')[0].style.display = 'none';
	if(BROWSER.ie && BROWSER.ie < 7) {
		jq('#calendariframe')[0].style.display = 'none';
	}
	controlid.value = yy + "-" + zerofill(mm + 1) + "-" + zerofill(d) + (addtime ? ' ' + zerofill(jq('#hour')[0].value) + ':' + zerofill(jq('#minute')[0].value) : '');
}

function showcalendar(event, controlid1, addtime1, startdate1, enddate1) {
	controlid = controlid1;
	addtime = addtime1;
	startdate = startdate1 ? parsedate(startdate1) : false;
	enddate = enddate1 ? parsedate(enddate1) : false;
	currday = controlid.value ? parsedate(controlid.value) : today;
	hh = currday.getHours();
	ii = currday.getMinutes();
	var p = fetchOffset(controlid);
	jq('#calendar')[0].style.display = 'block';
	jq('#calendar')[0].style.left = p['left']+'px';
	jq('#calendar')[0].style.top	= (p['top'] + 20)+'px';
	doane(event);
	refreshcalendar(currday.getFullYear(), currday.getMonth());
	if(lastcheckedyear != false) {
		jq('#calendar_year_' + lastcheckedyear)[0].className = 'calendar_default';
		jq('#calendar_year_' + today.getFullYear())[0].className = 'calendar_today';
	}
	if(lastcheckedmonth != false) {
		jq('#calendar_month_' + lastcheckedmonth)[0].className = 'calendar_default';
		jq('#calendar_month_' + (today.getMonth() + 1))[0].className = 'calendar_today';
	}
	jq('#calendar_year_' + currday.getFullYear())[0].className = 'calendar_checked';
	jq('#calendar_month_' + (currday.getMonth() + 1))[0].className = 'calendar_checked';
	jq('#hourminute')[0].style.display = addtime ? '' : 'none';
	lastcheckedyear = currday.getFullYear();
	lastcheckedmonth = currday.getMonth() + 1;
	if(BROWSER.ie && BROWSER.ie < 7) {
		jq('#calendariframe')[0].style.top = jq('#calendar')[0].style.top;
		jq('#calendariframe')[0].style.left = jq('#calendar')[0].style.left;
		jq('#calendariframe')[0].style.width = jq('#calendar')[0].offsetWidth;
		jq('#calendariframe')[0].style.height = jq('#calendar')[0].offsetHeight;
		jq('#calendariframe')[0].style.display = 'block';
	}
}

function refreshcalendar(y, m) {
	var x = new Date(y, m, 1);
	var mv = x.getDay();
	var d = x.getDate();
	var dd = null;
	yy = x.getFullYear();
	mm = x.getMonth();
	jq("#year")[0].innerHTML = yy;
	jq("#month")[0].innerHTML = mm + 1 > 9  ? (mm + 1) : '0' + (mm + 1);

	for(var i = 1; i <= mv; i++) {
		dd = jq("#d" + i)[0];
		dd.innerHTML = "&nbsp;";
		dd.className = "";
	}

	while(x.getMonth() == mm) {
		dd = jq("#d" + (d + mv))[0];
		dd.innerHTML = '<a href="###" onclick="settime(' + d + ');return false">' + d + '</a>';
		if(x.getTime() < today.getTime() || (enddate && x.getTime() > enddate.getTime()) || (startdate && x.getTime() < startdate.getTime())) {
			dd.className = 'calendar_expire';
		} else {
			dd.className = 'calendar_default';
		}
		if(x.getFullYear() == today.getFullYear() && x.getMonth() == today.getMonth() && x.getDate() == today.getDate()) {
			dd.className = 'calendar_today';
			dd.firstChild.title = '今天';
		}
		if(x.getFullYear() == currday.getFullYear() && x.getMonth() == currday.getMonth() && x.getDate() == currday.getDate()) {
			dd.className = 'calendar_checked';
		}
		x.setDate(++d);
	}

	while(d + mv <= 42) {
		dd = jq("#d" + (d + mv))[0];
		dd.innerHTML = "&nbsp;";
		d++;
	}

	if(addtime) {
		jq('#hour')[0].value = zerofill(hh);
		jq('#minute')[0].value = zerofill(ii);
	}
}

function showdiv(id) {
	var p = fetchOffset(jq("#"+id)[0]);
	jq('#calendar_' + id)[0].style.left = p['left']+'px';
	jq('#calendar_' + id)[0].style.top = (p['top'] + 16)+'px';
	jq('#calendar_' + id)[0].style.display = 'block';
	if(BROWSER.ie && BROWSER.ie < 7) {
		jq('#calendariframe_' + id)[0].style.top = jq('#calendar_' + id)[0].style.top;
		jq('#calendariframe_' + id)[0].style.left = jq('#calendar_' + id)[0].style.left;
		jq('#calendariframe_' + id)[0].style.width = jq('#calendar_' + id)[0].offsetWidth;
		jq('#calendariframe_' + id )[0].style.height = jq('#calendar_' + id)[0].offsetHeight;
		jq('#calendariframe_' + id)[0].style.display = 'block';
	}
}

function zerofill(s) {
	var s = parseFloat(s.toString().replace(/(^[\s0]+)|(\s+jq)/g, ''));
	s = isNaN(s) ? 0 : s;
	return (s < 10 ? '0' : '') + s.toString();
}

//loadcalendar();
