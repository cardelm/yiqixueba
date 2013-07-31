/*
 * 
 * ����˽��ҳ�棬��������߼� 
 */

var SendMessage={
	  token:"",
		open: function(thisuser, token,thisuid, url) {			
			if(token == undefined){ 
				token = SendMessage.token; 
			}
			SendMessage.render(thisuser,token, thisuid, url);
		},
		render: function(thisuser,token, thisuid, url) {

			var content = "";
			content +="<form id='SendMessageForm' url="+url+">";
			content += SendMessage.getHiddenInput(thisuser)
			content += SendMessage.getUidHiddenInput(thisuid)
			content += SendMessage.getTokenHiddenInput(token);
			content += "<ul class='win-form link0'>";
			content += SendMessage.getSendMessageUser(thisuser);
			content += SendMessage.getSubjectHtml();				
			content += SendMessage.getContentHtml();			
			content += "<tr><th>&nbsp;</th><td></td></tr>";
			content += "</ul>";
			content +="</form>"
			App.win({
				id: "win-sms",
				title: "��˽��",
				content: content,
				masking: 0,
				button: {idname: "SendMessageButton", title: "�ύ", classname: "btn-s", callback: SendMessage.submit}
			});
		},
		
		getHiddenInput:function(thisuser){
			var content="";
			content +="<input type='hidden' class='txt' name='name' id='name' value='"+thisuser+"'/> ";
			return content;
		},
		
		getUidHiddenInput:function(thisuid){
			var content="";
			if("undefined" == typeof thisuid) {
			    content +="<input type='hidden' class='txt' name='uid' id='uid' value='0'/> ";
			    content +="<input type='hidden' class='txt' name='sendType' id='sendType' value='1'/> ";
			} else {
			     content +="<input type='hidden' class='txt' name='uid' id='uid' value='"+thisuid+"'/> ";
			    content +="<input type='hidden' class='txt' name='sendType' id='sendType' value='2'/> ";
			}

			return content;
		},
		
		getTokenHiddenInput:function(token){
			var content="";
			if("undefined" == typeof token) {
			    content +="<input type='hidden' class='txt' name='token' id='token' value='0'/> ";
			} else {
			     content +="<input type='hidden' class='txt' name='hashToken' id='hashToken' value='"+token+"'/> ";
			}

			return content;
		},
		
		getSendMessageUser:function(thisuser){
			var content="";
			content +="<li class='sms-user'><label class='lab'>���͵���</label>";
			content +="<strong>"+ thisuser.replace(/@\|[a-z]*[0-9]*/g, "")+"</strong>";
			content +="</li>";

			return content;
		},
		getSubjectHtml: function() {
			var content = "";
			content += "<li class='sms-title'><label class='lab' for='subject'>���⣺</label>"
			content += "<input class='txt' id='subject' name='subject'/>"
			content += "</li>";
			return content;
		},
		getContentHtml: function() {
			var content = "";
			content += "<li class='sms-content'><label class='lab' for='magContent'>���ݣ�</label>"
			content += "<textarea class='txt textarea' id='magContent' name='content'></textarea>"
			content += "</li>";
			return content;
		},
		submit: function(){

			if(!$("#subject").validate({required:true})){
				App.winTip({message: '���ⲻ��Ϊ��' , target: this});
				return false
			}
			
			if(!$("#magContent").validate({required:true})){
				App.winTip({message: '���ݲ���Ϊ��' ,target: this});
				return false
			}
			
			if(!$("#subject").validate({maxlength:50})){
				App.winTip({message: '���ⲻ�ܳ���50���ַ�' , target: this});
				return false
			}
			
			if(!$("#magContent").validate({maxlength:2000})){
				App.winTip({message: '���ݲ��ܳ���2000���ַ�' ,target: this});
				return false
			}
			$.getJSON($("#SendMessageForm").attr("url"),$("#SendMessageForm").serialize(),function(res){
				if( res.success) {  							
					$('#win-sms').remove();
					App.tips({type: "right" ,message: "���ͳɹ���" , autoclose: 3});
				} else {
					var code = res.code
					var message = ""
					if(code==2){
						message="�ռ��˲�����"
					}else if(code==3){
						message="�ռ��˳�����ϵͳ����������������"
					}else if(code==4 || code==5){
						message="����Ȩ���Ͷ���"
					}else if(code==6){
						message="��������ݲ����Ϲ淶�������±༭��"
					}else if(code==1296){
						message="����̫��İ����Ŷ~"
					}	
							
					App.winTip({message: message ,target: this});
				}
			});
		}
	}