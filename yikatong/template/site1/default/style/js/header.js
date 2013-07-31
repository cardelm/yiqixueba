
/**
 *      [Æ·ÅÆ¿Õ¼ä] (C)2001-2010 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      jqId: header.js 5200 2010-11-30 02:19:27Z fanshengshuai jq
 */
var jq = jQuery.noConflict();
search_w = jq("#srchtxt").val();

var search = {};
search.searchRedirect = function() {
	jq("#searchoption li a").click(function() {
		if ("" == jq("#srchtxt").val() || search_w == jq("#srchtxt").val()) {
			jq("#srchtxt").focus();
			return false;
		}
		actionUrl = "";
		searchType = jq(this).attr('search_type');
		switch (searchType) {
		case 'shopsearch':
			actionUrl = 'street.php?range=all';
			break;
		case 'consume':
			actionUrl = 'consume.php';
			break;
		case 'goodssearch':
			actionUrl = 'goodsearch.php';
			break;
		default:
			break;
		}
		if ("" == actionUrl) return false;
		jq("#srchtxt").attr("name", "keyword");
		jq("#form_search").attr("action", actionUrl);
		jq("#form_search").submit();
		return false;
	});
};

function changeclass(obj, Otar, type) {
	if (type == 1) {
		jq("#" + Otar).hide();
		jq("#addto_supnav").unbind().bind("mouseover", function() {
			jq("#brandspce > a").addClass("mouseover");
		}).bind("mouseout", function() {
			jq("#brandspce > a").removeClass("mouseover");
		});
	} else {
		jq("#" + Otar).show();
	}
}

jq(function(){
	search.searchRedirect();
	jq("#srchtxt").click(function() { if (jq(this).val() == search_w) {jq(this).val("");};});
	jq("#srchtxt").blur(function() { if (jq(this).val() == "") {jq(this).val(search_w);};});
	jq("#search_submit").click(function() {if (jq("#srchtxt").val() == search_w || jq("#srchtxt").val() == "") {alert(search_w);return false;}});
	jq("#nav_message_handle").hover(
		function() {
			jq(this).addClass("on");
			jq("#show_navmsg").addClass("nav_msg_active");
			jq("#show_navmsg").show();
			jq("#show_navmsg").css({top:'30px'});
			
		},
		function() {
			jq(this).removeClass("on");
			jq("#show_navmsg").removeClass("nav_msg_active");
			jq("#show_navmsg").hide();
	});
	jq("#nav_myshops_handle").hover(
		function() {
			jq(this).addClass("on");
			jq("#show_myshops").show();
			
		},
		function() {
			jq(this).removeClass("on");
			jq("#show_myshops").hide();
	});
});

