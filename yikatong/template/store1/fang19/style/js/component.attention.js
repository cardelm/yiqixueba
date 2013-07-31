/*
 * 
 * ��ע���
 * shijinping 20110303
 */

var AttentionAct = {
    cacheId:function(uid){
       return "followed_"+uid;
    },
    attention:function(options){
        var defaults = {
            uids:[],
            prefixcontrol:"JF",
            html:"�ѹ�ע",
            tmessage:"��ע�ɹ���",
            id:"",
            tclass:['JFollowOpt','icon-follow','icon-followed']
        },
        _options=$.extend(defaults,options),
        uidNeed = [],
        hasAttendUids = false,
        id = _options.id||(_options.prefixcontrol+_options.uids[0]),
        callback=_options.callback||function(r){
            if(r.success){
				if(r.data.symbol == true){
					if(r.data.addList.length == 1)
                        AttentionAct.changeGroup(r.data);
                    else
                        App.tips({type: "right" ,message: _options.tmessage , autoclose: 3});
					$("#"+id).html(_options.html).toggleClass(_options.tclass.join(" "));
				}else{
					App.tips({type: "error" ,message: "��עʧ�ܣ����Ժ�����" , autoclose: 3});
				}
            }
        };
        if(_options.uids.length == 1){
            if($('body').data(AttentionAct.cacheId(_options.uids[0]))!=undefined && $('body').data(AttentionAct.cacheId(_options.uids[0]))==true){
                App.tips({type: "right" ,message: "���Ѿ���ע���û���", autoclose: 3});
                return false;
            }
            uidNeed.push(_options.uids[0]);
            hasAttendUids = true;
        }else{
            var index = 0;
            for (index in _options.uids){
                var uid = _options.uids[index];
                if($('body').data(AttentionAct.cacheId(uid))==undefined|| $('body').data(AttentionAct.cacheId(uid))==true){
                    hasAttendUids = true;
					uidNeed.push(uid);
                }
            }
            if(!hasAttendUids && uidNeed.length == 0){
                App.tips({type: "right" ,message: "���Ѿ���ע��Щ�û���", autoclose: 3});
				return false;
            }
        }
        App.ajax(id,{
            type: 'POST',
            url: '/user/attention/add',
            contentType: 'application/json',
            data: JSON.stringify(uidNeed) ,
            success: function(res){ 
            	if(!res.success && res.code == 104){
            			App.tips({type: "error" ,message: "���ע�ĺ�������������������������ޣ�" , autoclose: 3});
            			return false;
				}
                for (index in uidNeed){
                    var uid = uidNeed[index];
					if(_options.uids.length == 1 && res.data.hasSelfUid == "true"){
						App.tips({type: "error" ,message: "��Ǹ���޷����Լ�Ϊ��ע��" , autoclose: 3});
						return false;
					}else{
						$('body').data(AttentionAct.cacheId(uid),true);
					}
                }
                callback(res);
            },
            dataType: 'json'
        })
    },
    cancelAttention:function(options){
    	        App.win({id:"vest-showwin",
                    title:"��ʾ",
                    content:"ȡ��֮���޷��յ��Է�����Ϣ��ȷ��ȡ����",
                    button: [
                        {
                            title:"ȷ��",
                            callback:function() {
												        var defaults = {
												            uid:"",
												            prefixcontrol:"",
												            html:"�ӹ�ע",
												            tmessage:"ȡ����ע�ɹ���",
												            id:"",
												            tclass:['JFollowOpt','icon-follow','icon-followed']
												        },
												        _options=$.extend(defaults,options),
												        id = _options.id||(_options.prefixcontrol+_options.uid),
												        callback=_options.callback||function(r){
																	if(r.success){
																		App.tips({type: "right" ,message: _options.tmessage , autoclose: 3,redirectUrl:location.href});
																	}else{
																		App.tips({type: "error" ,message: "ȡ����עʧ�ܣ����Ժ�����" , autoclose: 3});
																	}
												        };
												        App.ajax(id,{
												            type: 'POST',
												            url: '/user/attention/delete',
												            data: {uid:_options.uid} ,
												            success: function(res){
												                callback(res);
												                $('body').data(AttentionAct.cacheId(_options.uid),false);
												            },
												            dataType: 'json'
												        });        
                                return true;
                            }
                        },
                        {
                            title:"ȡ��",
                            callback:function() {
                                return true;
                            }
                        }
                    ]
                });
    },
    changeGroup:function(dataMap){
        var arr=[],sl,content=$("<div>");
        arr.push('<p class="color9" style="margin:0;">����֮����ڶԹ�ע�û���Ѱ�Һ͹����ڿռ���ҳ�ɰ�������Ķ�̬��Ϣ</p>');
        sl = $("<select>",{id:"group",ttname:"re_attention_tkgroup"});
        var left=10;
        var tips="&nbsp;������������ѡ�����";
        var options=["ѡ��"];
        $(dataMap.groups).each(function(){
            var group = this;
            options.push(group.groupName);
            left --;
        });
        if(left>0)
        	tips="&nbsp;�����Դ���"+left+"������";
        arr.push($("<div>",{"class":"tc"}).append($("<label>",{"class":"iblock"}).append("���飺",sl),'<span class="iblock mt10 tl">&nbsp;<input type="text" maxlength="16" id="create-text" class="txt mt10" style="width:125px;"  placeholder="�����·���" /><br/><em class="iblock color9">'+tips+'</em></span>'));
        content.append.apply(content,arr);
        arr=[];
        for(n in options)arr.push($("<option>",{value:options[n]}).html(options[n]));
        sl.append.apply(sl,arr);

        App.win({id:'follow-group',title:'��ע���÷���',content:content,button:[{title:"����",callback: function(){
            var uid = dataMap.addList[0];
            var group = $.trim($("#create-text").val());
            if(group=="�����·���")
            	group="";
            //sbsAjax Start
            App.ajax("",{
                type: 'POST',
                url: '/user/attention/updategroup',
                data: {uid: uid, group: group},
                success: function(res){
                    if (res.success) {
                        App.tips({type: "right", message: "��ע�ɹ���", autoclose: 3});                                            
                    	$("#follow-group").remove();
                    }else if(res.code == 101){
                    	App.tips({type: "error", message: "���鲻���ڣ�", autoclose: 3});
                    }else if(res.code == 102){
                    	App.tips({type: "error", message: "���ע���û������ڣ�", autoclose: 3});
                    }else if(res.code == 103){
                    	App.tips({type: "error", message: "�����Ѵ����ޣ���ѡ�����з���", autoclose: 3});
                    }else {
                    	App.tips({type: "error", message: "��ע����ʧ�ܣ�", autoclose: 3});
                    }
                },
                error: function() {
                    App.tips({type: "error", message: "������æ�����Ժ����ԣ�", autoclose: 3});
                    return false
                },
                dataType: 'json'
            });//sbsAjax end
        }},{title:"ȡ��"}]});
        
     	var text=$("#create-text");

        $("#group").change(function(){
            if(this.selectedIndex==0)return false;
            text.val(this.options[this.selectedIndex].value);
            this.selectedIndex=0;
        });
        AM("limitInput","placeholder",function(){
        	App.placeholder();
        	App.limitInput($("#create-text"),16);        	
        });
    }
}