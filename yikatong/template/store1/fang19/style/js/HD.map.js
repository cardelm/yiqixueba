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
		//地图标注
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
				App.win({id:"showWindowId",title:"地图标注",content:content,width:500,button:[{idname:"passConfirm",title:"确定",classname:"btn-s",callback:function(){
						$("a[name=mapLink]").html("<em></em>已标注");																															   
						return true;
					}},{title:"取消",classname:"btn-n",callback:function(){
							$("#longitude").val("");
							$("#latitude").val("");
							$("a[name=mapLink]").html("<em></em>标注地图");
							return true
					}
				}]});
			}else{
				App.win({id:"showWindowId",title:"地图标注",content:content,width:500,button:{title:"关闭",classname:"btn-s",callback:function(){
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
	* @Name: map 初始化
	* @Description:this hover
	* @Author: HS
	*/
	initialize : function() {
		//创建地图实例
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
		//创建点坐标
		var point = new BMap.Point(lng, lat);
		//创建点坐标
		map.centerAndZoom(point, scope);
		// 创建控件实例 添加到地图当中  
		map.addControl(new BMap.NavigationControl());//为地图添加鱼骨（默认）控件
		map.addControl(new BMap.MapTypeControl());//为地图添加2D3D切换控件
		if(marked){
			// 创建标注
			var marker = new BMap.Marker(new BMap.Point(lng, lat));
			// 将标注添加到地图中
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
					// 创建地理编码实例  
					var myGeo = new BMap.Geocoder();  
					// 根据坐标得到地址描述  
					myGeo.getLocation(new BMap.Point(e.point.lng, e.point.lat), function(result){  
						 if (result){   
							address.val(result.address);
						 }  
					});
				}
				
			});
	},
	
	/**
	* @Name: 异步加载JS
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
				province = "浙江";
				city = "杭州";
			}else if(city == "" && province != ""){
					city = province;
			} 
			$("body").append('<div id="container" style="display:none;"></div>');
			var map = new BMap.Map("container");  
			map.centerAndZoom(new BMap.Point(), 12);  
			// 创建地址解析器实例  
			var myGeo = new BMap.Geocoder();  
			// 将地址解析结果显示在地图上，并调整地图视野  
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

