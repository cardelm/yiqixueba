<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class threadplugin_yikatong {
	var $name = '商品';
	var $iconfile = '';
	var $buttontext = '发布商品';
	//发主题时页面新增的表单项目，通过 return 返回即可输出到发帖页面中
	function newthread($fid) {
//		global $_G;
//		if($_G['uid']==0){
//			showmessage('需要登录', '', array(), array('login' => true));
//		}
//		if($fid == DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='shop_forum'")){
//			$sortid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='shop_zidingyi'");
//			$goods_options = array();
//			$gk = 0;
//			$query = DB::query("SELECT * FROM ".DB::table('forum_typevar')." WHERE sortid = $sortid" );
//			while($value = DB::fetch($query)){
//				$goods_options1[$gk] = $value;
//				$goods_options2[$gk] = DB::fetch_first("SELECT * FROM ".DB::table('forum_typeoption')." WHERE optionid = ".intval($value['optionid']));
//				$goods_options3[$gk] = $goods_options2[$gk]['protect'] ? unserialize($goods_options2[$gk]['protect']) : array();;
//				$goods_options4[$gk] = $goods_options2[$gk]['rules'] ? unserialize($goods_options2[$gk]['rules']) : array();
//				$goods_options[$gk] = array_merge($goods_options1[$gk],$goods_options2[$gk],$goods_options3[$gk],$goods_options4[$gk]);
//				if($goods_options[$gk]['inputsize']==''){
//					$goods_options[$gk]['inputsize'] = 20;
//				}
//				$gk++;
//			}
//			include template('yikatong:forum/newshop');
//		}elseif($fid == DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='goods_forum'")){
//			$shop_count = DB::result_first("SELECT count(*) FROM ".DB::table('brand_shopitems')." WHERE uid = ".$_G['uid']);
//			$addtype = $_GET['addtype'];
//			$shopid = $_GET['shopid'] ? $_GET['shopid'] : 0;
//			if($shop_count==0||$addtype == 'shopadd'){
//				//分类列表
//				$categorylist = array();
//				$query = DB::query("SELECT * FROM ".DB::table('brand_categories')." WHERE upid = 0 and type='shop' order by displayorder" );
//				while($value = DB::fetch($query)){
//						$categorylist[] = $value;
//				}
//				$site_prov = 3;
//				$site_city = 73;
//				//省份城市
//				if(!in_array($site_prov,array(1,2,9,22))) {
//					$prov_city = DB::result_first("SELECT name FROM ".DB::table('common_district')." WHERE id = $site_prov").DB::result_first("SELECT name FROM ".DB::table('common_district')." WHERE id = $site_city");
//					$distlist = array();
//					$query = DB::query("SELECT * FROM ".DB::table('common_district')." WHERE upid = $site_city order by displayorder" );
//					while($value = DB::fetch($query)){
//						$distlist[] = $value;
//					}
//					//var_dump($distlist);
//				}else{
//					$prov_city = DB::result_first("SELECT name FROM ".DB::table('common_district')." WHERE id = $site_prov");
//					$citylist = array();
//					$query = DB::query("SELECT * FROM ".DB::table('common_district')." WHERE upid = $site_prov order by displayorder" );
//					while($value = DB::fetch($query)){
//						$citylist[] = $value;
//					}
//				}
//				$banklist = array("工商银行", "农业银行", "建设银行", "中国银行", "交通银行", "招商银行", "深圳发展银行", "浦发银行", "桂林商业银行", "湛江商行", "鄞州银行", "进出口银行", "农业发展银行", "国家开发银行", "富滇银行", "深圳农村商业银行", "柳州市商业银行", "吉林银行", "上海农商行", "西安商行", "民生银行", "华夏银行","兴业银行", "中信银行", "北京银行", "上海银行", "光大银行", "浙商银行", "东亚银行", "恒生银行", "汇丰中国", "渣打银行", "广东发展银行", "花旗银行", "星展银行", "徽商银行", "南京银行", "恒丰银行", "平安银行", "广州银行", "厦门国际银行", "荷兰银行", "华侨银行", "德意志银行", "杭州银行", "宁波银行", "渤海银行", "永亨银行中国", "南商银行中国", "友利银行中国", "中信嘉华", "巴黎银行中国", "三菱东京日联银行", "瑞穗银行", "北京农商行", "邮政储蓄银行", "东莞银行", "汉口银行", "法国兴业银行", "泉州商业银行", "成都银行", "厦门市商业银行", "福建海峡银行", "包商银行", "大连银行", "哈尔滨银行", "大庆商行");
//				include template('yikatong:forum/newshop');
//			}else{
//				if($shopid == 0){
//					$query = DB::query("SELECT * FROM ".DB::table('brand_shopitems')." WHERE uid = ".$_G['uid']." order by displayorder" );
//					while($row = DB::fetch($query)){
//						$shoplist[] = $row;
//					}
//					include template('yikatong:forum/shoplist');
//				}else{
//					$shop_info = DB::fetch_first("SELECT * FROM ".DB::table('brand_shopitems')." WHERE itemid = ".intval($_GET['shopid']));
//					$sortid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='goods_zidingyi'");
//					$goods_options = array();
//					$gk = 0;
//					$query = DB::query("SELECT * FROM ".DB::table('forum_typevar')." WHERE sortid = $sortid order by displayorder" );
//					while($value = DB::fetch($query)){
//						$goods_options1[$gk] = $value;
//						$goods_options2[$gk] = DB::fetch_first("SELECT * FROM ".DB::table('forum_typeoption')." WHERE optionid = ".intval($value['optionid']));
//						$goods_options3[$gk] = $goods_options2[$gk]['protect'] ? unserialize($goods_options2[$gk]['protect']) : array();;
//						$goods_options4[$gk] = $goods_options2[$gk]['rules'] ? unserialize($goods_options2[$gk]['rules']) : array();
//						$goods_options[$gk] = array_merge($goods_options1[$gk],$goods_options2[$gk],$goods_options3[$gk],$goods_options4[$gk]);
//						if($goods_options[$gk]['inputsize']==''){
//							$goods_options[$gk]['inputsize'] = 20;
//						}
//						$gk++;
//					}
//					//dump($goods_options);
//					include template('yikatong:forum/newgoods');
//				}
//			}
//		}

		return $return;
	}//end func

	//主题发布后的数据判断
	function newthread_submit($fid){
//		global $_G;
//		$addtype = $_POST['addtype'] ? $_POST['addtype'] : 'shopadd';
//			if($addtype == 'shopadd'){
//			
//			if($_POST['shopname']==''||empty($_POST['shopname'])){
//				showmessage('店铺名称不能为空', '');
//			}
//			if($_POST['shopaddress']==''||empty($_POST['shopaddress'])){
//				showmessage('店铺地址不能为空', '');
//			}
//			if($_POST['catid']=='-1'||$_POST['subcatid']=='-1'){
//				showmessage('店铺分类不能为空', '');
//			}
//			if(!in_array($site_prov,array(1,2,9,22))&&$_POST['communityid']=='-1'||in_array($site_prov,array(1,2,9,22))&&$_POST['distid']=='-1') {
//				showmessage('所属地区不能为空', '');
//			}
//			if($_POST['applicantbank']=='-1'||empty($_POST['applicantbank'])){
//				showmessage('银行信息不能为空', '');
//			}
//			//if($_POST['applicantbankid']==''||empty($_POST['applicantbankid'])){
//				//showmessage('银行卡号不能为空', '');
//			//}
//			$data['message'] = $_POST['message1'];
//			$data['catid'] = $_POST['catid'];
//			$data['subcatid'] = $_POST['subcatid'];
//			$data['validity_start'] = strtotime($data['validity_start']);
//			$data['validity_end'] = strtotime($data['validity_end']);
//			$data['zhekou'] = (float)(string)$data['zhekou'];
//			$data['grade'] = $data['grade'];
//			$data['dateline'] = $_G['timestamp'];
//			$data['districtid'] = in_array(intval($site_prov),array(1,2,9,22))?intval($_POST['cityid']):intval($_POST['distid']);
//			$data['subdistrictid'] = in_array(intval($site_prov),array(1,2,9,22))?intval($_POST['distid']):intval($_POST['communityid']);
//
//		}else{
//			$query = DB::query("SELECT * FROM ".DB::table('forum_typevar')." WHERE sortid = $sortid order by displayorder" );
//			while($value = DB::fetch($query)){
//				$goods_options[$gk] = $value;
//				$data[$value['identifier']] = $_POST[$value['identifier']];
//			}
//			$sortid = 10;

//		}
	}//end func

	//主题发布后的数据处理
	function newthread_submit_end($fid, $tid){
//		global $_G;
//		global $tid, $pid;
//		$sortid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='goods_zidingyi'");
//		$gk = 0;
//		$query = DB::query("SELECT * FROM ".DB::table('forum_typevar')." WHERE sortid = $sortid order by displayorder" );
//		while($value = DB::fetch($query)){
//			$goods_options1[$gk] = $value;
//			$goods_options2[$gk] = DB::fetch_first("SELECT * FROM ".DB::table('forum_typeoption')." WHERE optionid = ".intval($value['optionid']));
//			$goods_options[$gk] = array_merge($goods_options1[$gk],$goods_options2[$gk]);
//			if($goods_options[$gk]['type']=='image'){
//				if(!empty($_POST['typeoption'][$goods_options[$gk]['identifier']]['aid'])){
//					convertunusedattach($_POST['typeoption'][$goods_options[$gk]['identifier']['aid']],$tid,$pid);
//					//$data[$goods_options[$gk]['identifier']] = $_POST['typeoption'][$goods_options[$gk]['identifier']['url']];
//					$data[$goods_options[$gk]['identifier']] = serialize(array('aid'=>$_POST['typeoption'][$goods_options[$gk]['identifier']['aid']],'url'=>$_POST['sortaid_'.$goods_options[$gk]['identifier'].'_url']));
//				}
//			}else{
//				$data[$goods_options[$gk]['identifier']] = $_POST['typeoption'][$goods_options[$gk]['identifier']];
//			}
//			$gk++;
//		}
//		$data['tid'] = $tid;
//		$data['fid'] = $fid;
//		$data['dateline'] = TIMESTAMP;
//		
//		DB::insert('forum_optionvalue'.$sortid,$data);
					
		
	}//end func
	//编辑主题时页面新增的表单项目，通过 return 返回即可输出到编辑主题页面中 
	function editpost($fid, $tid){
		
	}//end func

	//主题编辑后的数据判断
	function editpost_submit($fid, $tid){
		
	}//end func

	//主题编辑后的数据处理
	function editpost_submit_end($fid, $tid){
		
	}//end func

	//回帖后的数据处理
	function newreply_submit_end($fid, $tid){
		
	}//end func

	//查看主题时页面新增的内容，通过 return 返回即可输出到主题首贴页面中
	function viewthread($tid){
//		global $_G,$skipaids,$thread;
//		$fid = DB::result_first("SELECT fid FROM ".DB::table('forum_post')." WHERE tid=$tid");
//		
//		$sortid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='goods_zidingyi'");
//		if(DB::result_first("SELECT COUNT(*) FROM ".DB::table('forum_optionvalue'.$sortid)." WHERE tid='$tid'")>0) {
//
//			$auction = DB::fetch_first("SELECT * FROM ".DB::table('forum_optionvalue'.$sortid)." WHERE tid='$tid'");
//			$notstart = $auction['starttimefrom'] > $_G['timestamp'];
//			$auction['js_timeto'] = $auction['status'] ? '01/01/1970 00:00' : dgmdate($auction['starttimeto'], 'm/d/Y H:i:s');
//			$auction['js_timefrom'] = $auction['status'] ? '01/01/1970 00:01' : dgmdate($auction['starttimefrom'], 'm/d/Y H:i:s');
//			$auction['js_timenow'] = TIMESTAMP;
//			$auction['starttimefrom'] = dgmdate($auction['starttimefrom'], 'Y-m-d H:i:s');
//			$auction['starttimeto_0'] = $auction['starttimeto'];
//			$auction['starttimeto'] = dgmdate($auction['starttimeto'], 'Y-m-d H:i:s');
//			$auction['typeid'] == 2 && $auction['top_price'] = !empty($auction['top_price']) ? $auction['top_price'] : $auction['base_price'];
//			$auction['extid'] = empty($auction['extid']) ? $_G['cache']['plugin']['auction']['auc_extcredit'] : $auction['extid'];
//			if($auction['aid']) {
//				$auctionatt['attachment'] = getforumimg($auction['aid'], 0, 250, 300);
//				$auctionatt['encodeaid'] = aidencode($auction['aid']);
//				$skipaids[] = $auction['aid'];
//			}
//
//			if($auction['typeid'] == 1 && $auction['extra'] == 1) {
//				$auction['ctypeid'] = 1;
//			} elseif($auction['typeid'] == 1 && $auction['extra'] == 0) {
//				$auction['ctypeid'] = 2;
//			} elseif($auction['typeid'] == 2) {
//				$auction['ctypeid'] = 3;
//			}
//
//		} else {
//			return ' ';
//		}
//
//		include template('yikatong:forum/viewthread');
//		return $return;
		
	}//end func

}

//http://localhost/Test/dz25gbk/forum.php?mod=viewthread&tid=19



?>