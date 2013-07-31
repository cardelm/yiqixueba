/*
 * 
 * 关注添加
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
            html:"已关注",
            tmessage:"关注成功！",
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
					App.tips({type: "error" ,message: "关注失败，请稍后再试" , autoclose: 3});
				}
            }
        };
        if(_options.uids.length == 1){
            if($('body').data(AttentionAct.cacheId(_options.uids[0]))!=undefined && $('body').data(AttentionAct.cacheId(_options.uids[0]))==true){
                App.tips({type: "right" ,message: "你已经关注该用户！", autoclose: 3});
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
                App.tips({type: "right" ,message: "你已经关注该些用户！", autoclose: 3});
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
            			App.tips({type: "error" ,message: "你关注的好友数超过你所在组允许的上限！" , autoclose: 3});
            			return false;
				}
                for (index in uidNeed){
                    var uid = uidNeed[index];
					if(_options.uids.length == 1 && res.data.hasSelfUid == "true"){
						App.tips({type: "error" ,message: "抱歉，无法加自己为关注！" , autoclose: 3});
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
                    title:"提示",
                    content:"取消之后将无法收到对方的信息，确定取消？",
                    button: [
                        {
                            title:"确定",
                            callback:function() {
												        var defaults = {
												            uid:"",
												            prefixcontrol:"",
												            html:"加关注",
												            tmessage:"取消关注成功！",
												            id:"",
												            tclass:['JFollowOpt','icon-follow','icon-followed']
												        },
												        _options=$.extend(defaults,options),
												        id = _options.id||(_options.prefixcontrol+_options.uid),
												        callback=_options.callback||function(r){
																	if(r.success){
																		App.tips({type: "right" ,message: _options.tmessage , autoclose: 3,redirectUrl:location.href});
																	}else{
																		App.tips({type: "error" ,message: "取消关注失败，请稍后再试" , autoclose: 3});
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
                            title:"取消",
                            callback:function() {
                                return true;
                            }
                        }
                    ]
                });
    },
    changeGroup:function(dataMap){
        var arr=[],sl,content=$("<div>");
        arr.push('<p class="color9" style="margin:0;">分组之后便于对关注用户的寻找和管理，在空间首页可按分组查阅动态信息</p>');
        sl = $("<select>",{id:"group",ttname:"re_attention_tkgroup"});
        var left=10;
        var tips="&nbsp;分组已满，请选择分组";
        var options=["选择"];
        $(dataMap.groups).each(function(){
            var group = this;
            options.push(group.groupName);
            left --;
        });
        if(left>0)
        	tips="&nbsp;还可以创建"+left+"个分组";
        arr.push($("<div>",{"class":"tc"}).append($("<label>",{"class":"iblock"}).append("分组：",sl),'<span class="iblock mt10 tl">&nbsp;<input type="text" maxlength="16" id="create-text" class="txt mt10" style="width:125px;"  placeholder="创建新分组" /><br/><em class="iblock color9">'+tips+'</em></span>'));
        content.append.apply(content,arr);
        arr=[];
        for(n in options)arr.push($("<option>",{value:options[n]}).html(options[n]));
        sl.append.apply(sl,arr);

        App.win({id:'follow-group',title:'关注设置分组',content:content,button:[{title:"保存",callback: function(){
            var uid = dataMap.addList[0];
            var group = $.trim($("#create-text").val());
            if(group=="创建新分组")
            	group="";
            //sbsAjax Start
            App.ajax("",{
                type: 'POST',
                url: '/user/attention/updategroup',
                data: {uid: uid, group: group},
                success: function(res){
                    if (res.success) {
                        App.tips({type: "right", message: "关注成功！", autoclose: 3});                                            
                    	$("#follow-group").remove();
                    }else if(res.code == 101){
                    	App.tips({type: "error", message: "该组不存在！", autoclose: 3});
                    }else if(res.code == 102){
                    	App.tips({type: "error", message: "你关注的用户不存在！", autoclose: 3});
                    }else if(res.code == 103){
                    	App.tips({type: "error", message: "分组已达上限，请选择已有分组", autoclose: 3});
                    }else {
                    	App.tips({type: "error", message: "关注分组失败！", autoclose: 3});
                    }
                },
                error: function() {
                    App.tips({type: "error", message: "服务器忙，请稍后再试！", autoclose: 3});
                    return false
                },
                dataType: 'json'
            });//sbsAjax end
        }},{title:"取消"}]});
        
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