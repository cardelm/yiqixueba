/***********************************/
/*             �ж��Ƿ��עjs           */
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
                         var hasAttended = "<span class='uoption-followed'>�ѹ�ע</span>";
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
					App.tips({type: "warn" ,message: "���Ѿ���ע��Щ�û���" , autoclose: 3});
				}else{
                	AttentionAct.changeGroup(r.data);
				}
                $("#JF" + uid).replaceWith("<span class='uoption-followed'>�ѹ�ע</span>");
            } else {
                App.tips({type: "error" ,message: "��עʧ�ܣ�" , autoclose: 3});
            }
        }
    }});
},



    addAttentionByAffirm:function(obj) {
        var _this = $(obj);
        var uid = _this.attr("userId");
        var content = "<H3>�Ƿ�ȷ����ע���û���</H3>";
        App.win({title:"��ܰ����",content:content,button:[
            {title:"ȷ��",callback:function() {
                AttentionAct.attention({uids:[uid],callback:function(r) {
                    if (r.success) {
                        if (r.data.symbol == true) {
                            if (r.data.existList.length > 0)
                                App.tips({type: "right" ,message: "���Ѿ���ע���û�!" , autoclose: 3});
                            else
                               AttentionAct.changeGroup(r.data);
                            _this.replaceWith("<span class='uoption-followed'>�ѹ�ע</span>");
                        } else {
                            App.tips({type: "error" ,message: "��עʧ�ܣ����Ժ�����" , autoclose: 3});
                        }
                    }
                }});
                return true;
            }},
            {title:"ȡ��",callback:function() {
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
                var hasAttended = "<span class='uoption-followed'>�ѹ�ע</span>";
                $(this).replaceWith(hasAttended);
            }
        });
    }
}