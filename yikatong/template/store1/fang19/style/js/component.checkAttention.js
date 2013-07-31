/***********************************/
/*             判断是否关注js           */
/*      @author liliang 2011-3-10        */
/***********************************/
var AttentionStatus = {
    attentionUrl:'',
    currentUid:'',
    	check:function(currentUid,attentionUrl){
			AttentionStatus.attentionUrl=attentionUrl;
            AttentionStatus.currentUid=currentUid;
            setTimeout(function(){
			    AttentionStatus.attentionStatusThread();
            },5000);
		},

		attentionStatusThread:function(){
			if($("[name^='attend_']").length>0){
				var hisUids = '';
				$("[name^='attend_']").each(function(){
					var hisUid = $(this).attr("name");
					var uid = hisUid.split("_")[1];
					hisUids += uid+' ';
				});
				AttentionStatus.get(hisUids,AttentionStatus.attentionStatusCallback,1,null);
			}
		},
    checkstatus:function(currentUid, attentionUrl, attentionUid, type, obj) {
        AttentionStatus.attentionUrl = attentionUrl;
        AttentionStatus.currentUid = currentUid;
        AttentionStatus.attentionStatusThreadByMove(attentionUid, type, obj);
    },

    attentionStatusThreadByMove:function(attentionUid, type, obj) {
        var hisUids = attentionUid;
        if(!$("body").data("attention_doing_"+hisUids)){
            $("body").data("attention_doing_"+hisUids,true);
            AttentionStatus.get(hisUids, AttentionStatus.attentionStatusCallback, type, obj);
         }else{
             if(type==2){
                   AttentionStatus.addAttentionByAffirm(obj)
             }else if(type ==3){
                   AttentionStatus.addAttention(obj)
             }
         }
    },

    attentionStatusCallback:function(attentionInfos, hisUid) {
        AttentionStatus.set(attentionInfos, hisUid);
    },

    get:function(uids, callback, type, obj) {
        jQuery.ajax({
            type:'POST',
            dataType:'json',
            url:AttentionStatus.attentionUrl,
            data:{"uid":AttentionStatus.currentUid,"attendUids":uids},
            success:function(attentionInfos) {
                if (type == 1) {
                    callback($.parseJSON(attentionInfos.data), uids);
                } else if (type == 2||type == 3) {
                    var attentionInfos = $.parseJSON(attentionInfos.data)
                    var result = attentionInfos[uids];
                    if (result) {
                         var hasAttended = "<span class='uoption-followed'>已关注</span>";
                        $(obj).replaceWith(hasAttended);
                    } else {
                        if(type==2){
                            AttentionStatus.addAttentionByAffirm(obj)
                        }else if(type ==3){
                            AttentionStatus.addAttention(obj)
                        }
                    }
                }
            },
            error:function() {
                $("body").data("attention_doing_"+uid,false);
            }
        });
    },

    addAttention:function(obj) {
    var uid = $(obj).attr("userId");
    AttentionAct.attention({uids:[uid], callback:function(r) {
        if (r.success) {
            if (r.data.symbol == true) {
				if(r.data.existList.length>0){
					App.tips({type: "warn" ,message: "你已经关注该些用户！" , autoclose: 3});
				}else{
                	AttentionAct.changeGroup(r.data);
				}
                $("#JF" + uid).replaceWith("<span class='uoption-followed'>已关注</span>");
            } else {
                App.tips({type: "error" ,message: "关注失败！" , autoclose: 3});
            }
        }
    }});
},



    addAttentionByAffirm:function(obj) {
        var _this = $(obj);
        var uid = _this.attr("userId");
        var content = "<H3>是否确定关注该用户？</H3>";
        App.win({title:"温馨提醒",content:content,button:[
            {title:"确定",callback:function() {
                AttentionAct.attention({uids:[uid],callback:function(r) {
                    if (r.success) {
                        if (r.data.symbol == true) {
                            if (r.data.existList.length > 0)
                                App.tips({type: "right" ,message: "你已经关注该用户!" , autoclose: 3});
                            else
                               AttentionAct.changeGroup(r.data);
                            _this.replaceWith("<span class='uoption-followed'>已关注</span>");
                        } else {
                            App.tips({type: "error" ,message: "关注失败，请稍后再试" , autoclose: 3});
                        }
                    }
                }});
                return true;
            }},
            {title:"取消",callback:function() {
                return true;
            }}
        ]
        })
    },


    set:function(attentionInfos, postUid) {
        $("[name^='attend_']").each(function() {
            var hisUid = $(this).attr("name");
            var uid = hisUid.split("_")[1];
            if (attentionInfos[uid] == true) {
                var hasAttended = "<span class='uoption-followed'>已关注</span>";
                $(this).replaceWith(hasAttended);
            }
        });
    }
}