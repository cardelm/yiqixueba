var siteDeal = {};
siteDeal.displayed = false;
siteDeal.displayMoreDealDetail = function(node, dealId, container, btn_hide){
	if (siteDeal.displayed){
		node.innerHTML = '<strong>�鿴��������</strong><span class="F_grey2">���չ��</span><i></i>';
		container.style.display = "none";
		btn_hide.style.display = "none";
		siteDeal.displayed = false;
		return true;
	} else {
		node.innerHTML = '<strong>�鿴��������</strong><span class="F_grey2">�������</span><i class="on"></i>';
		siteDeal.displayed = true;
		container.style.display = "";
		btn_hide.style.display = "";
		ajax({url:"/data/detail/"+dealId, data:{}}).getHTML(function(data){container.innerHTML=data;});
	}
};

siteDeal.hideMoreDealDetail = function(node, container){
	var display_detail = document.getElementById('btn_display_detail');
	display_detail.innerHTML = '<strong>�鿴��������</strong><span class="F_grey2">���չ��</span><i></i>';
	node.style.display="none";
	container.style.display="none";
	siteDeal.displayed = false;
};

document.ready(function(){
	//��ȡZoom
	var sectionDiv = document.querySelector('section');
	var zoom = parseFloat(document.defaultView.getComputedStyle(sectionDiv,false)['zoom']);
	
	var btnDisplayDetail = document.getElementById('btn_display_detail');
	var btnHideDetail = document.getElementById('btn_hide_detail');
	var moreDetailContainer = document.getElementById('moreDetailContainer');
	var oTop = btnDisplayDetail.offsetTop;
	btnHideDetail.style.display = 'none';
	window.onscroll = function(e){
		var divTop = parseInt(document.body.scrollTop)-parseInt(oTop * zoom);
		if (divTop > 0){
			if ('none' != moreDetailContainer.style.display && '' != moreDetailContainer.innerText)
				btnHideDetail.style.display = '';
		}else{
			btnHideDetail.style.display = 'none';
		}
	};
	
	//����ʱ
	siteDeal.countDown.obj = document.querySelector('#countDown');
	siteDeal.countDown.setDisplay();
});

siteDeal.countDown = {};
siteDeal.countDown.obj = null;
siteDeal.countDown.setDisplay = function (){
	if ( siteDeal.countDown.obj ) {
		if (timeSecond < 3*24*60*60 && timeSecond > -3){
			siteDeal.countDown.obj.style.display = '';
		}else{
			siteDeal.countDown.obj.style.display = 'none';
		}
	}
};
siteDeal.countDown.setTimer = function (){
	timeSecond -= 1;console.log(timeSecond);
	if (timeSecond > 3*24*60*60){
		return;
	}
	var str;
	if (timeSecond > 0){
		str = '�Ź�����ʱ��' + formatTime(timeSecond);
	}else{
		str = '�Ź�����';
	}
	console.log(str);
	if ( siteDeal.countDown.obj ) {
		siteDeal.countDown.obj.innerHTML = str;
		if (timeSecond < -3){
			siteDeal.countDown.obj.style.display = 'none';
			window.clearInterval(siteDeal.countDown.countDownTimer);
		}
	}
	siteDeal.countDown.setDisplay();
};
siteDeal.countDown.countDownTimer = setInterval(siteDeal.countDown.setTimer, 1000);
