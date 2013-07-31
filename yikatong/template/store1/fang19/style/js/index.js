var jq = jQuery.noConflict();
function showAuto(){
	n = n >= (count - 1) ? 0 : n + 1;
	jq("#play_text span").eq(n).trigger('mouseover');
}

var t = n = count = 0;

if (jq("#play_list")[0]) {
	jq(function() {
		count = jq("#play_list a").size();
		var listr = '';
		if(count > 0) {
			for(var i = 1; i < ( count + 1 ); i++) {
				listr += "<span style=\"background: none repeat scroll 0% 0% rgb(252, 242, 207); color: rgb(217, 75, 1); height: 16px; width: 16px;\">"+i+"</span>";
			}
			jq('#play_text').append(listr);
		}
		jq("#play_list a:not(:first-child)").hide();
		jq("#play_text span:first-child").css({"background":"#FF9415",'color':'#FFF','height':'18px','width':'18px'});

		jq("#play_text span").mouseover(function() {
			var _this = this,
			i = jq(_this).text() - 1;
			n = i;
			if (i >= count) return;
			
			jq(_this).css({"background":"#FF9415",'color':'#FFF','height':'18px','width':'18px'}).siblings().css({"background":"#FCF2CF",'color':'#D94B01','height':'16px','width':'16px'});
			jq("#play_list a").filter(":visible").fadeOut(200).parent().children().eq(i).fadeIn(1000);
		});

		clearInterval(t);
		t = setInterval("showAuto()", 3000);
	});
}

jq("#category ul").find("li").each(
	function() {
		jq(this).mouseover(
			function() {
				jq("#" + this.id + "_menu").show();
				jq(this).addClass("a");
			}
		);
		jq(this).mouseout(
			function() {
				jq(this).removeClass("a");
				jq("#" + this.id + "_menu").hide();
			}
		);
	}
);

showAllCategory = false;
jq("#more_cat").click(function() {
	showAllCategory = !showAllCategory;
	cat_count = 0;
	if (showAllCategory) {
		jq(this).addClass("close");
		jq("#category ul").find("li").each(function() {
			cat_count ++;
			cat_count > 8 ? jq(this).show("slow") : "";
		});
	} else {
		jq(this).removeClass("close");
		jq("#category ul").find("li").each(function() {
			cat_count ++;
			cat_count > 8 ? jq(this).hide("slow") : "";
		});
	}
});

jq("#hot_shop").find("li").each(function() {
	jq(this).mouseover(
		function() {
			jq("#hot_shop").find("li").each(function() {
				jq(this).removeClass("a");
			});
			jq(this).addClass("a");
			jq((jq(this).find("div"))[0]).show();
		}
	);
});
