loadscript("mdialog");

function check_username(obj) {
	if(!obj.value) {
		$('#msg_username').html('<span class="font_1">�������Ա����.</span>').show();
		return;
	}
	$.post(Url('member/reg/op/check_username'), {'username':obj.value,'in_ajax':1}, function(data) {
		$('#msg_username').html(data).show();
	});
}

function check_email(obj) {
	if(!obj.value) {
		$('#msg_email').html('<span class="font_1">������E-mail��ַ.</span>').show();
		return;
	}
	$.post(Url('member/reg/op/check_email'), {'email':obj.value,'in_ajax':1}, function(data) {
		$('#msg_email').html(data).show();
	});
}

function send_message(recvuid, subject) {
	if(!subject) subject = '';
	$.post(Url('member/index/ac/pm/op/write'), { recvuid:recvuid, subject:subject, in_ajax:1 }, 
	function(result) {
		if(result.match(/\{\s+caption:".*",message:".*".*\s*\}/)) {
			myAlert(result);
		} else {
			dlgOpen('���Ͷ���', result, 500, 285);
		}
	});
}

function checkpm() {
	var form = document.getElementById('pmform');
	
	if(form.recv_users.value == ''){
		msgOpen('δ��ӷ��Ͷ���');
		return false;
	} else if(form.subject.value == '') {
		msgOpen('δ��д�������⡣');
		return false;
	} else if(form.subject.value.length > 60) {
		msgOpen('�������ⲻ�ܳ���60���ַ���');
		return false;
	} else if(form.content.value == '') {
		msgOpen('δ��д�������ݡ�');
		return false;
	} else if(form.content.value.length > 500) {
		msgOpen('�������ݲ��ܳ���500���ַ���');
		return false;
	}
	return true;
}

function add_friend(friend_uid) {
	if(!is_numeric(friend_uid)) { alert('��Ч��UID'); return; }
	$.post(Url('member/index/ac/friend/op/add'), { friend_uid:friend_uid, in_ajax:1}, 
	function(result) {
		if(result.match(/\{\s+caption:".*",message:".*".*\s*\}/)) {
			myAlert(result);
		} else {
			dlgOpen('��Ӻ���', result, 500, 220);
		}
	});
}

function post_addfriend() {
	var form = document.addfriendfrm;
	if(!is_numeric(form.friendid.value)){
		alert('��Ա�����ڣ��޷���ӡ�');
		return false;
	} else if(form.content.value.length > 300) {
		alert('�Ժ��ѵ����Բ��ܳ���300���֣��뾫��һ�����ԡ�');
		return false;
	}

	return true;
}