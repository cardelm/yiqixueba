
/**
 *      [品牌空间] (C)2001-2010 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      jqId: store_index.js 5499 2010-12-03 15:26:10Z fanshengshuai jq
 */
var jq = jQuery.noConflict();
function showCaptcha() {
	jq("#hiddenCaptcha").attr("style", "display:block");
	if (!jq("img#captcha").attr("src")) jq("img#captcha").attr("src", "do.php?action=seccode&rand=" + new Date().getTime());
}

function getRemoteCaptcha() {
	jq("img#captcha").attr("src", "do.php?action=seccode&rand=" + new Date().getTime());
	jq('input#inputCaptcha').val('');
}

String.prototype.trim = function() {
	return this.replace(/(^\s*)|(\s*jq)/g, "");
};

function showReplyForm(obj) {
	jq(obj).parents('div').children('form').eq(0).show();
}

function showEditReplyForm(obj) {
	var textarea = jq(obj).parents('div').children('form').children('textarea');
	var dl = jq(obj).parents('div').children(dl).children('dd').next().children('div').html();

	jq(textarea).val(dl);
	jq(obj).parents('div').children('form').eq(0).show();
	textarea = null;
	dl = null;
}

function hideReplyForm(obj) {
	jq(obj).parents('form').hide();
}

function submitReplyForm(obj) {
	replayString = jq(obj).children('textarea').val().trim();
	if (replayString.length < 2 || replayString.length > 250) {
		jq(obj).children('textarea').focus();
		jq(obj).children('label.error').show();
		return false;
	} else {
		jq(obj).children('label.error').hide();
		jq(obj).submit();
	}
}

function deleteMsg(url) {
	setTimeout("deleteMsgBackend('" + url + "')", 200);
}

function deleteMsgBackend(url) {
	if (confirm('jqlang[comment_confirm]')) {
		self.location.href = url;
	}
}


jq("#publishnew").hide();
jq("#menulist div").hide();
jq("#menulist div").eq(0).show();
changeoptions(jq("#newmovementmenu"), "li", jq("#menulist"), "div");

changeoptions(jq("#hotgoods"), "li", jq("#productlist"), "ul");

jq("#productlist ul").hide();
jq("#productlist ul").eq(0).show();
changeoptions(jq("#newproductmenu"), "li", jq("#productlist"), "ul");

jq(".movement dl").hover(
function() {
	jq(this).css("backgroundPosition", "0 -127px");
},
function() {
	jq(this).css("backgroundPosition", "0 0 ");
});

var istate = ostate = 1;
jq(".showpic h4").hover(
function() {
	if (istate == 0) return;
	istate = 0;
	jq(".showpic div").animate({
		left: '532px'
	},
	"slow", function() {
		istate = 1;
	});
},
function() {
	if (ostate == 0) return;
	ostate = 0;
	jq(".showpic div").animate({
		left: '690px'
	},
	"slow", function() {
		ostate = 1;
	});
});

function changeoptions(eventobj, echildnode, resultobj, rchildnode) {
	var eventobject = eventobj.children(echildnode);
	var reusultobject = resultobj.children(rchildnode);
	eventobject.each(function(i) {
		jq(this).mouseover(function() {
			eventobject.removeClass("mouseover");
			jq(this).addClass("mouseover");
			reusultobject.hide();
			reusultobject.eq(i).show();
			if (this.id == "coinauction") {
				jq("#publishnewauction").show();
				jq("#publishnewconsume").hide();
			} else if (this.id == 'coinconsume') {
				jq('#moreConsumeLink').show();
				jq("#publishnewconsume").show();
				jq("#publishnewauction").hide();
			} else {
				jq("#publishnew").hide();
				jq("#publishnewauction").hide();
				jq("#publishnewconsume").hide();
			}
			if (this.id == "allGoodsList") {
				jq("#moreGoodsLink").show();
			} else {
				jq("#moreGoodsLink").hide();
			}
		});
	});
}
jq(function() {
	jq('#shop_notice').cycle({
		fx: 'scrollUp',
		prev: '#shop_notice_prev',
		next: '#shop_notice_next',
		pause: true,
		timeout: 6000
	}).find("li").css({
		background: "none"
	});
});
