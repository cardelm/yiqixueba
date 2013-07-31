/*
 *@Description: map.js
 *@Version:     v0.1
 *@Author:     	HS,
 *@Date: 		2012-07-31
 */
 

(function () {
	/**
	* @Description: hdMap
	* @Author: HS
	*/
	AM("showWin",function(){
		//��ͼ��ע
		$('.map').bind('click',function(){
			var content = "<div id='map-mark' style='height: 300px;'></div>";
			if($(this).siblings("#longitude").length == 0){
				$("#longitude").val($(this).attr("longitude"));
				$("#latitude").val($(this).attr("latitude"));
			}
			if($(this).siblings("#scope").length == 0){
				$("#scope").val($(this).attr("scope"));
			}
			$("#point").val($(this).attr("point"));
			if($("#point").val() == "yes"){
				App.win({id:"showWindowId",title:"��ͼ��ע",content:content,width:500,button:[{idname:"passConfirm",title:"ȷ��",classname:"btn-s",callback:function(){
						$("a[name=mapLink]").html("<em></em>�ѱ�ע");																															   
						return true;
					}},{title:"ȡ��",classname:"btn-n",callback:function(){
							$("#longitude").val("");
							$("#latitude").val("");
							$("a[name=mapLink]").html("<em></em>��ע��ͼ");
							return true
					}
				}]});
			}else{
				App.win({id:"showWindowId",title:"��ͼ��ע",content:content,width:500,button:{title:"�ر�",classname:"btn-s",callback:function(){
						return true;
					}
				}}); 
			}
			hdMap.loadScript();
		});
	 
	}); 
	
})();

var hdMap = {
	/**
	* @Name: map ��ʼ��
	* @Description:this hover
	* @Author: HS
	*/
	initialize : function() {
		//������ͼʵ��
		var map = new BMap.Map('map-mark');
		var marked = true;
		var scope = 12;
	
		var lng = $("#longitude").val();
		var lat = $("#latitude").val();
		var address = $(".map-address");
		if(lng == "" ||lat == ""){
			lng = 120.151;
			lat = 30.284;
			marked = false;
			scope = 12;
		}
		if($("#scope").val() != "" && $("#scope").length > 0)
			scope = $("#scope").val();
		else
			scope = 12; 
		//����������
		var point = new BMap.Point(lng, lat);
		//����������
		map.centerAndZoom(point, scope);
		// �����ؼ�ʵ�� ��ӵ���ͼ����  
		map.addControl(new BMap.NavigationControl());//Ϊ��ͼ�����ǣ�Ĭ�ϣ��ؼ�
		map.addControl(new BMap.MapTypeControl());//Ϊ��ͼ���2D3D�л��ؼ�
		if(marked){
			// ������ע
			var marker = new BMap.Marker(new BMap.Point(lng, lat));
			// ����ע��ӵ���ͼ��
			map.addOverlay(marker);
		}
		
		if(address.length > 0){
			var local = new BMap.LocalSearch(map, {  
			 	renderOptions:{map: map}  
			});  
			local.searchInBounds(address.val(), map.getBounds());
		}
		if($("#point").val() != "" && $("#point").length > 0)
			map.addEventListener("click", function(e){
				map.clearOverlays();
				var marker = new BMap.Marker(new BMap.Point(e.point.lng, e.point.lat));
				map.addOverlay(marker);
				$("#longitude").val(e.point.lng+"");
				$("#latitude").val(e.point.lat+""); 
				$("#defMap").attr("longitude",e.point.lng);
				$("#defMap").attr("latitude",e.point.lat);
				if(address.length > 0){
					// �����������ʵ��  
					var myGeo = new BMap.Geocoder();  
					// ��������õ���ַ����  
					myGeo.getLocation(new BMap.Point(e.point.lng, e.point.lat), function(result){  
						 if (result){   
							address.val(result.address);
						 }  
					});
				}
				
			});
	},
	
	/**
	* @Name: �첽����JS
	* @Description:this hover
	* @Author: HS
	*/
	loadScript : function() {
		var script = document.createElement("script");
		script.src = "http://api.map.baidu.com/api?v=1.2&callback=hdMap.initialize";
		document.body.appendChild(script);
	},
	
	/**
	* @Name: getPoint
	* @Description:getPoint
	* @Author: HS
	*/
	getPoint : function(province,city){
		var mapSelect = $("#mapSelect");
		if(mapSelect.length > 0){
			if(province == ""){
				province = "�㽭";
				city = "����";
			}else if(city == "" && province != ""){
					city = province;
			} 
			$("body").append('<div id="container" style="display:none;"></div>');
			var map = new BMap.Map("container");  
			map.centerAndZoom(new BMap.Point(), 12);  
			// ������ַ������ʵ��  
			var myGeo = new BMap.Geocoder();  
			// ����ַ���������ʾ�ڵ�ͼ�ϣ���������ͼ��Ұ  
			myGeo.getPoint(city, function(point){  
			 if (point){
				$("#longitude").val(point.lng);
				$("#latitude").val(point.lat);
				map.clearOverlays();
			 }  
			}, province);
		}
	}
}

