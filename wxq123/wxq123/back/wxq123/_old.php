<?php
exit();
//weixin.inc.php
	$signature = trim(htmlspecialchars($_GET["signature"]));
	$timestamp = trim(htmlspecialchars($_GET["timestamp"]));
	$nonce = trim(htmlspecialchars($_GET["nonce"]));
	$type = trim(htmlspecialchars($_GET["wxqtype"]));
	$token = $_G['cache']['plugin']['wxq123']['weixintoken'];
	$tmpArr = array($token, $timestamp, $nonce);
	sort($tmpArr);
	$tmpStr = implode( $tmpArr );
	$tmpStr = sha1( $tmpStr );

	if( $tmpStr == $signature ){
		$postStr = file_get_contents("php://input");

		if (!empty($postStr)){
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$inputtype = $postObj->MsgType;
			if($inputtype == 'text'){
				$content = iconv('UTF-8','gbk',trim($postObj->Content));
				$keyword = $content?true:false;

			}elseif($inputtype == 'location'){
				$location_x = trim($postObj->Location_X);
				$location_y = trim($postObj->Location_Y);
				$scale = trim($postObj->Scale);
				$label = iconv('UTF-8','gbk',trim($postObj->Label));
				$keyword = ($location_x&&$location_y)?true:false;
			}elseif($inputtype == 'image'){
				$picurl = trim($postObj->PicUrl);
				$keyword = $picurl?true:false;

			}elseif($inputtype == 'link'){
				$linktitle = trim($postObj->Title);
				$linkdescription = trim($postObj->Description);
				$linkurl = trim($postObj->Url);
				$keyword = $picurl?true:false;
			}elseif($inputtype == 'event'){
			}
			$fromusername = $postObj->FromUserName;
			reg_member(htmlspecialchars($fromusername));
			$tousername = $postObj->ToUserName;
			$data['time'] = time();
			$data['postxml'] = htmlspecialchars(trim($postStr)).$keyword;
			$data['type'] = htmlspecialchars($inputtype);
			$data['inputtype'] = $type;
			$data['get'] = $_GET ? serialize($_GET) : 'kong';
			$data['post'] = $_POST?serialize($_POST):'kong';
			$data['fromusername'] = htmlspecialchars($fromusername);
			$data['tousername'] = htmlspecialchars($tousername);
			DB::insert('wxq123_weixin_temp',$data);
			if(!empty( $keyword )) {
				$music_info = array();
				$music_info['title'] = "谢雨欣【老公老公我爱你】";
				$music_info['description'] = "微信音乐回复测试";
				$music_info['music_url'] = "http://www.wxq123.com/lglgwan.mp3";
				$music_info['hq_music_url'] = "http://www.wxq123.com/lglgwan.mp3";
				//echo display_music($music_info);
				display_help('news');
				//echo display_text('fsdafsdf');
				//echo display_news($newsarray);
			}else{//关注回复
				echo display_text('fsdafsdf');
				//display_help('news');
			}
		}else {
			$echoStr = $_GET["echostr"];
			echo $echoStr;
			exit;
		}
	}
	//var_dump(display_help('news'));

	//display_help('news');

	//
	function display_text($contentStr,$FuncFlag = 0) {
		global $_G,$fromusername, $tousername;
		$contentStr = $_G['charset'] == 'gbk' ? iconv('gbk','UTF-8',$contentStr) : $contentStr;
		$return = "<xml>
		<ToUserName><![CDATA[$fromusername]]></ToUserName>
		<FromUserName><![CDATA[$tousername]]></FromUserName>
		<CreateTime>".time()."</CreateTime>
		<MsgType><![CDATA[text]]></MsgType>
		<Content><![CDATA[$contentStr]]></Content>
		<FuncFlag>$FuncFlag</FuncFlag>
		</xml>";
		return $return;

	}//end func
	//
	function display_music($music_info,$FuncFlag = 0) {
		global $_G,$fromusername, $tousername;
		$title = $_G['charset'] == 'gbk' ? iconv('gbk','UTF-8',$music_info['title']):$music_info['title'];
		$description = $_G['charset'] == 'gbk' ? iconv('gbk','UTF-8',$music_info['description']): $music_info['description'];
		$return ="<xml>
			 <ToUserName><![CDATA[$fromusername]]></ToUserName>
			 <FromUserName><![CDATA[$tousername]]></FromUserName>
			 <CreateTime>".time()."</CreateTime>
			 <MsgType><![CDATA[music]]></MsgType>
			 <Music>
			 <Title><![CDATA[$title]]></Title>
			 <Description><![CDATA[$description]]></Description>
			 <MusicUrl><![CDATA[$music_info[music_url]]]></MusicUrl>
			 <HQMusicUrl><![CDATA[$music_info[hq_music_url]]]></HQMusicUrl>
			 </Music>
			 <FuncFlag>0</FuncFlag>
			 </xml>";
		return $return;
	}//end func
	//
	function display_news($newsarray,$FuncFlag = 0) {
		global $_G,$fromusername, $tousername;
		$return = "<xml>
			 <ToUserName><![CDATA[$fromusername]]></ToUserName>
			 <FromUserName><![CDATA[$tousername]]></FromUserName>
			 <CreateTime>".time()."</CreateTime>
			 <MsgType><![CDATA[news]]></MsgType>
			 <ArticleCount>".count($newsarray)."</ArticleCount>
			 <Articles>";
			foreach ( $newsarray as $news) {
				$title = $_G['charset'] == 'gbk' ? iconv('gbk','UTF-8',$news['title']):$news['title'];
				$description = $_G['charset'] == 'gbk' ? iconv('gbk','UTF-8',$news['description']):$news['description'];
				$return .="<item>
					 <Title><![CDATA[".$title."]]></Title>
					 <Description><![CDATA[".$description."]]></Description>
					 <PicUrl><![CDATA[".$news['picurl']."]]></PicUrl>
					 <Url><![CDATA[".$news['url']."]]></Url>
					 </item>";
			}
		$return .="</Articles>
			 <FuncFlag>$FuncFlag</FuncFlag>
			 </xml>";

		return $return;
	}//end func
	//
	function reg_member($fromusername) {
		if(!empty($fromusername)) {
			if(DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_member')." WHERE wid='".$fromusername."'")==0) {
				DB::insert('wxq123_member',array('wid'=>$fromusername,'regtime'=>time()));
			}
		}
		return ;
	}//end func

	//
	function display_help($type='') {
		global $_G;
		if($type=='') {
			$type = 'text';
		}
		if($type == 'text') {
			$content = "欢迎关注微信墙123\n";
			$content .= "--------------------------\n";
			$query = DB::query("SELECT * FROM ".DB::table('wxq123_mokuai')." order by displayorder asc");
			while($row = DB::fetch($query)) {
				$content .= "发送“".$row['wxsearch']."”进入".$row['mokuaititle']."\n";
			}
			$content .= "--------------------------\n";
			$content .= "发送“0”返回本页面";
			echo display_text($content);
		}elseif($type == 'news'){
			$newsarray[] = array(
				'title'=>"欢迎关注微信墙123",
				'description'=>"欢迎关注微信墙123",
				'picurl'=>"http://www.wxq123.com/source/plugin/wxq123/style/image/wxq123.jpg",
				'url'=>"",
			);
			$query = DB::query("SELECT * FROM ".DB::table('wxq123_mokuai')." WHERE status = 1 order by displayorder asc");
			while($row = DB::fetch($query)) {
				$mokuaiico = '';
				if($row['mokuaiico']!='') {
					$mokuaiico = str_replace('{STATICURL}', STATICURL, $row['mokuaiico']);
					if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
						$mokuaiico = $_G['siteurl'].$_G['setting']['attachurl'].'temp/'.$row['mokuaiico'].'?'.random(6);
					}
				}
				$newsarray[] = array(
					'title'=>$row['mokuaititle']."\n".$row['mokuaidescription'],
					'description'=>$row['mokuaidescription'],
					'picurl'=>$mokuaiico,
					'url'=>'http://www.wxq123.com/plugin.php?id=wxq123:moblic&mokuaiid=1',
				);
			}
			$newsarray[] = array(
				'title'=>"帮助信息",
				'description'=>"发送“0”返回本页面",
				'picurl'=>"欢迎关注微信墙123",
				'url'=>"",
			);
			//var_dump(display_news($newsarray));
			echo display_news($newsarray);
		}
		//return $content;
	}//end func

//weixinsetting.inc.php
	if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
		exit('Access Denied');
	}

	$query = DB::query("SELECT * FROM ".DB::table('wxq123_setting'));
	while($row = DB::fetch($query)) {
		$wxq123_setting[$row['skey']] = $row['svalue'];
	}


	if(!submitcheck('submit')) {
		showtips(lang('plugin/wxq123','weixin_setting_tips'));
		showformheader("plugins&identifier=wxq123&pmod=weixinsetting");
		showtableheader(lang('plugin/wxq123','weixin_setting'));
		showsetting(lang('plugin/wxq123','wxq_token'),'wxq123_setting[token]',$wxq123_setting['token'],'text','','',lang('plugin/wxq123','wxq_token_comments'));
		showsetting(lang('plugin/wxq123','wxq_logo'),'wxq123_setting[logo]',$wxq123_setting['logo'],'filetext','','',lang('plugin/wxq123','wxq_logo_comments'));
		showsetting(lang('plugin/wxq123','wxq_bg'),'wxq123_setting[bg]',$wxq123_setting['bg'],'filetext','','',lang('plugin/wxq123','wxq_bg_comments'));
		showsetting(lang('plugin/wxq123','wxq_shopgroup'),'wxq123_setting[shopgroup]',$wxq123_setting['shopgroup'],'text','','',lang('plugin/wxq123','wxq_shopgroup_comments'));
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
	}
	$urlToEncode="login";
	generateQRfromGoogle($urlToEncode);
	function generateQRfromGoogle($chl,$widhtHeight ='150',$EC_level='L',$margin='0') {
		$chl = urlencode($chl);
		echo '<A href="http://weixin.qq.com/r/6HXFymLEelwFh3OpnyDM"><img src="http://chart.apis.google.com/chart?chs='.$widhtHeight.'x'.$widhtHeight.'&cht=qr&chld='.$EC_level.'|'.$margin.'&chl='.$chl.'" alt="QR code" widhtHeight="'.$widhtHeight.'" widhtHeight="'.$widhtHeight.'"/></a>';
	}

//mokuai.inc.php
	if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
		exit('Access Denied');
	}

	$mysql_keywords = array( 'ADD', 'ALL', 'ALTER', 'ANALYZE', 'AND', 'AS', 'ASC', 'ASENSITIVE', 'BEFORE', 'BETWEEN', 'BIGINT', 'BINARY', 'BLOB', 'BOTH', 'BY', 'CALL', 'CASCADE', 'CASE', 'CHANGE', 'CHAR', 'CHARACTER', 'CHECK', 'COLLATE', 'COLUMN', 'CONDITION', 'CONNECTION', 'CONSTRAINT', 'CONTINUE', 'CONVERT', 'CREATE', 'CROSS', 'CURRENT_DATE', 'CURRENT_TIME', 'CURRENT_TIMESTAMP', 'CURRENT_USER', 'CURSOR', 'DATABASE', 'DATABASES', 'DAY_HOUR', 'DAY_MICROSECOND', 'DAY_MINUTE', 'DAY_SECOND', 'DEC', 'DECIMAL', 'DECLARE', 'DEFAULT', 'DELAYED', 'DELETE', 'DESC', 'DESCRIBE', 'DETERMINISTIC', 'DISTINCT', 'DISTINCTROW', 'DIV', 'DOUBLE', 'DROP', 'DUAL', 'EACH', 'ELSE', 'ELSEIF', 'ENCLOSED', 'ESCAPED', 'EXISTS', 'EXIT', 'EXPLAIN', 'FALSE', 'FETCH', 'FLOAT', 'FLOAT4', 'FLOAT8', 'FOR', 'FORCE', 'FOREIGN', 'FROM', 'FULLTEXT', 'GOTO', 'GRANT', 'GROUP', 'HAVING', 'HIGH_PRIORITY', 'HOUR_MICROSECOND', 'HOUR_MINUTE', 'HOUR_SECOND', 'IF', 'IGNORE', 'IN', 'INDEX', 'INFILE', 'INNER', 'INOUT', 'INSENSITIVE', 'INSERT', 'INT', 'INT1', 'INT2', 'INT3', 'INT4', 'INT8', 'INTEGER', 'INTERVAL', 'INTO', 'IS', 'ITERATE', 'JOIN', 'KEY', 'KEYS', 'KILL', 'LABEL', 'LEADING', 'LEAVE', 'LEFT', 'LIKE', 'LIMIT', 'LINEAR', 'LINES', 'LOAD', 'LOCALTIME', 'LOCALTIMESTAMP', 'LOCK', 'LONG', 'LONGBLOB', 'LONGTEXT', 'LOOP', 'LOW_PRIORITY', 'MATCH', 'MEDIUMBLOB', 'MEDIUMINT', 'MEDIUMTEXT', 'MIDDLEINT', 'MINUTE_MICROSECOND', 'MINUTE_SECOND', 'MOD', 'MODIFIES', 'NATURAL', 'NOT', 'NO_WRITE_TO_BINLOG', 'NULL', 'NUMERIC', 'ON', 'OPTIMIZE', 'OPTION', 'OPTIONALLY', 'OR', 'ORDER', 'OUT', 'OUTER', 'OUTFILE', 'PRECISION', 'PRIMARY', 'PROCEDURE', 'PURGE', 'RAID0', 'RANGE', 'READ', 'READS', 'REAL', 'REFERENCES', 'REGEXP', 'RELEASE', 'RENAME', 'REPEAT', 'REPLACE', 'REQUIRE', 'RESTRICT', 'RETURN', 'REVOKE', 'RIGHT', 'RLIKE', 'SCHEMA', 'SCHEMAS', 'SECOND_MICROSECOND', 'SELECT', 'SENSITIVE', 'SEPARATOR', 'SET', 'SHOW', 'SMALLINT', 'SPATIAL', 'SPECIFIC', 'SQL', 'SQLEXCEPTION', 'SQLSTATE', 'SQLWARNING', 'SQL_BIG_RESULT', 'SQL_CALC_FOUND_ROWS', 'SQL_SMALL_RESULT', 'SSL', 'STARTING', 'STRAIGHT_JOIN', 'TABLE', 'TERMINATED', 'THEN', 'TINYBLOB', 'TINYINT', 'TINYTEXT', 'TO', 'TRAILING', 'TRIGGER', 'TRUE', 'UNDO', 'UNION', 'UNIQUE', 'UNLOCK', 'UNSIGNED', 'UPDATE', 'USAGE', 'USE', 'USING', 'UTC_DATE', 'UTC_TIME', 'UTC_TIMESTAMP', 'VALUES', 'VARBINARY', 'VARCHAR', 'VARCHARACTER', 'VARYING', 'WHEN', 'WHERE', 'WHILE', 'WITH', 'WRITE', 'X509', 'XOR', 'YEAR_MONTH', 'ZEROFILL', 'ACTION', 'BIT', 'DATE', 'ENUM', 'NO', 'TEXT', 'TIME');

	$submod = getgpc('submod');
	$submods = array('list','edit','table','tableedit','field','fieldedit','shop','shopedit','goods');
	$submod = in_array($submod,$submods) ? $submod : $submods[0];

	$mokuaiid = getgpc('mokuaiid');
	$mokuai_info = $mokuaiid ? DB::fetch_first("SELECT * FROM ".DB::table('wxq123_mokuai')." WHERE mokuaiid=".$mokuaiid) : array();

	$optionid = getgpc('optionid');
	$option_info = $optionid ? DB::fetch_first("SELECT * FROM ".DB::table('wxq123_typeoption')." WHERE optionid=".$optionid) : array();


	//模块列表
	if($submod == 'list') {
		if(!submitcheck('submit')) {
			showtips(lang('plugin/wxq123','mokuai_list_tips'));
			showformheader('plugins&identifier=wxq123&pmod=mokuai&submod=list');
			showtableheader(lang('plugin/wxq123','mokuai_list'));
			showsubtitle(array('', lang('plugin/wxq123','displayorder'),lang('plugin/wxq123','mokuaiico'), lang('plugin/wxq123','mokuaititle'), lang('plugin/wxq123','mokuaipice'), lang('plugin/wxq123','mokuaidescription'),lang('plugin/wxq123','status'), ''));
			$query = DB::query("SELECT * FROM ".DB::table('wxq123_mokuai')." order by displayorder asc");
			while($row = DB::fetch($query)) {
				$mokuaiico = '';
				if($row['mokuaiico']!='') {
					$mokuaiico = str_replace('{STATICURL}', STATICURL, $row['mokuaiico']);
					if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
						$mokuaiico = $_G['setting']['attachurl'].'temp/'.$row['mokuaiico'].'?'.random(6);
					}
					$mokuaiico = '<img src="'.$mokuaiico.'" width="40" height="40"/>';
				}else{
					$mokuaiico = '';
				}
				$goods_link = "";
				if($row['shopuser']) {
					if(dunserialize($row['goodsclass'])) {
						foreach ( dunserialize($row['goodsclass']) as $k=>$v) {
							$goods_link .= "&nbsp;<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=mokuai&submod=shop&mokuaiid=".$row['mokuaiid']."&classid=".($k+1)."\" class=\"act\">".$v."</a>";
						}
					}else{
						$goods_link = "&nbsp;<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=mokuai&submod=shop&mokuaiid=$row[mokuaiid]&classid=1\" class=\"act\">".lang('plugin/wxq123','goods')."</a>";
					}
				}
				showtablerow('', array('class="td25"','class="td25"', 'class="td25"', 'class="td23"','class="td23"','class="td29"', 'class="td25"',''), array(
					"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[mokuaiid]\">",
					'<input type="text" class="txt" name="displayordernew['.$row['mokuaiid'].']" value="'.$row['displayorder'].'" size="2" />',
					$mokuaiico.'<input type="hidden" name="mokuainamenew['.$row['mokuaiid'].']" value="'.$row['mokuainame'].'">',
					$row['mokuaititle'].'('.$row['mokuainame'].')',
					$row['mokuaipice'],
					$row['mokuaidescription'],
					"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['mokuaiid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
					"<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=mokuai&submod=edit&mokuaiid=$row[mokuaiid]\" class=\"act\">".$lang['edit']."</a>".
					"<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=mokuai&submod=table&mokuaiid=$row[mokuaiid]\" class=\"act\">".lang('plugin/wxq123','field')."</a>".
					($row['urluser']?"&nbsp;<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=mokuai&submod=shop&mokuaiid=$row[mokuaiid]&classid=0\" class=\"act\">".lang('plugin/wxq123','url_user')."</a>":"").
					($row['shopuser']?"&nbsp;<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=mokuai&submod=shop&mokuaiid=$row[mokuaiid]&classid=0\" class=\"act\">".lang('plugin/wxq123','shop_user')."</a>":"").
					$goods_link,
				));
			}
			echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action=plugins&identifier=wxq123&pmod=mokuai&submod=edit" class="addtr">'.lang('plugin/wxq123','add_mokuai').'</a></div></td></tr>';
			showsubmit('submit','submit','del');
			showtablefooter();
			showformfooter();
		}else{
			if($ids = $_GET['delete']) {
				$ids = dintval($ids, is_array($ids) ? true : false);
				if($ids) {
					DB::delete('wxq123_mokuai', DB::field('mokuaiid', $ids));
				}
			}
			$displayordernew = $_GET['displayordernew'];
			$statusnew = $_GET['statusnew'];
			$mokuainamenew = $_GET['mokuainamenew'];
			if(is_array($displayordernew)&&is_array($statusnew)) {
				foreach ( $displayordernew as $k=>$v) {
					$data['displayorder'] = intval($v);
					$data['status'] = intval($statusnew[$k]);
					$mokuainame = htmlspecialchars(trim($mokuainamenew[$k]));
					if($data['status'] && DB::result_first("SELECT urluser FROM ".DB::table('wxq123_mokuai')." WHERE mokuaiid=".$k)) {
						if(!DB::result_first("describe ".DB::table('wxq123_site')." m_".$mokuainame)) {
							$sql = "alter table ".DB::table('wxq123_site')." add `m_".$mokuainame."` tinyint(1) not Null;";
							runquery($sql);
						}
					}else{
						if(DB::result_first("describe ".DB::table('wxq123_site')." m_".$mokuainame)) {
							$sql = "alter table ".DB::table('wxq123_site')." DROP `m_".$mokuainame."`;";
							runquery($sql);
						}
					}
					if($data['status'] && DB::result_first("SELECT shopuser FROM ".DB::table('wxq123_mokuai')." WHERE mokuaiid=".$k)) {
						if(!DB::result_first("describe ".DB::table('wxq123_shop')." m_".$mokuainame)) {
							$sql = "alter table ".DB::table('wxq123_shop')." add `m_".$mokuainame."` tinyint(1) not Null;";
							runquery($sql);
						}
					}else{
						if(DB::result_first("describe ".DB::table('wxq123_shop')." m_".$mokuainame)) {
							$sql = "alter table ".DB::table('wxq123_shop')." DROP `m_".$mokuainame."`;";
							runquery($sql);
						}
					}
					DB::update('wxq123_mokuai',$data,array('mokuaiid'=>$k));
				}
			}
			cpmsg(lang('plugin/wxq123', 'mokuai_edit_succeed'), 'action=plugins&identifier=wxq123&pmod=mokuai', 'succeed');
		}
	//模块新增或编辑
	}elseif($submod == 'edit'){

		if(!submitcheck('submit')) {

			if($mokuai_info['mokuaiico']!='') {
				$mokuaiico = str_replace('{STATICURL}', STATICURL, $mokuai_info['mokuaiico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
					$mokuaiico = $_G['setting']['attachurl'].'temp/'.$mokuai_info['mokuaiico'].'?'.random(6);
				}
				$mokuaiicohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete1" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$mokuaiico.'" width="40" height="40"/>';
			}

			showtips(lang('plugin/wxq123','mokuai_edit_tips'));
			showformheader('plugins&identifier=wxq123&pmod=mokuai&submod=edit','enctype');
			showtableheader(lang('plugin/wxq123','mokuai_edit'));
			$mokuaiid ? showhiddenfields($hiddenfields = array('mokuaiid'=>$mokuaiid)) : '';
			showsetting(lang('plugin/wxq123','mokuainame'),'mokuainame',$mokuai_info['mokuainame'],'text');
			showsetting(lang('plugin/wxq123','mokuaititle'),'mokuaititle',$mokuai_info['mokuaititle'],'text');
			showsetting(lang('plugin/wxq123','mokuaipice'),'mokuaipice',$mokuai_info['mokuaipice'],'text');
			showsetting(lang('plugin/wxq123','mokuaiico'),'mokuaiico',$mokuai_info['mokuaiico'],'filetext','','',lang('plugin/wxq123','mokuaiico_comment').$mokuaiicohtml);
			showsetting(lang('plugin/wxq123','mokuaidescription'),'mokuaidescription',$mokuai_info['mokuaidescription'],'textarea');
			showsetting(lang('plugin/wxq123','wxsearch'),'wxsearch',$mokuai_info['wxsearch'],'text');
			showsetting(lang('plugin/wxq123','urluser'),'urluser',$mokuai_info['urluser'],'radio','','',lang('plugin/wxq123','urluser_comment'));
			showsetting(lang('plugin/wxq123','shopuser'),'shopuser',$mokuai_info['shopuser'],'radio','','',lang('plugin/wxq123','shopuser_comment'));
			showsetting(lang('plugin/wxq123','goodsclass'),'goodsclass',implode("\n", dunserialize($mokuai_info['goodsclass'])),'textarea','','',lang('plugin/wxq123','goodsclass_comment'));
			showsetting(lang('plugin/wxq123','category'),'category',implode("\n", dunserialize($mokuai_info['category'])),'textarea','','',lang('plugin/wxq123','category_comment'));
			showsetting(lang('plugin/wxq123','status'),'status',$mokuai_info['status'],'radio','','',lang('plugin/wxq123','status_comment'));
			showsubmit('submit');
			showtablefooter();
			showformfooter();
		}else{
			$mokuaiico = addslashes($_POST['mokuaiico']);
			if($_FILES['mokuaiico']) {
				if(!is_dir($_G['setting']['attachurl'].'wxq123')) {
					dmkdir($_G['setting']['attachurl'].'wxq123');
				}
				$upload = new discuz_upload();
				if($upload->init($_FILES['mokuaiico'], 'wxq123') && $upload->save()) {
					$mokuaiico = $upload->attach['attachment'];
				}
			}
			if($_POST['delete1'] && addslashes($_POST['mokuaiico'])) {
				$valueparse = parse_url(addslashes($_POST['mokuaiico']));
				if(!isset($valueparse['host']) && !strexists(addslashes($_POST['mokuaiico']), '{STATICURL}')) {
					@unlink($_G['setting']['attachurl'].'temp/'.addslashes($_POST['mokuaiico']));
				}
				$mokuaiico = '';
			}
			$data['mokuainame'] = htmlspecialchars(trim($_GET['mokuainame']));
			$data['mokuaititle'] = htmlspecialchars(trim($_GET['mokuaititle']));
			$data['mokuaipice'] =intval($_GET['mokuaipice']);
			$data['mokuaiico'] = $mokuaiico;
			$data['mokuaidescription'] = htmlspecialchars(trim($_GET['mokuaidescription']));
			$data['wxsearch'] = htmlspecialchars(trim($_GET['wxsearch']));
			$data['urluser'] = intval($_GET['urluser']);
			$data['shopuser'] = intval($_GET['shopuser']);
			$data['goodsclass'] = trim($_GET['goodsclass']) ? serialize(explode("\n",trim($_GET['goodsclass']))) : '';
			$data['category'] = trim($_GET['category']) ? serialize(explode("\n",trim($_GET['category']))) : '';
			$data['status'] = intval($_GET['status']);
			if($mokuaiid) {
				if (DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_mokuai')." WHERE mokuainame='".$data['mokuainame']."' AND mokuaiid <>".$mokuaiid)==0){
					DB::update('wxq123_mokuai',$data,array('mokuaiid'=>$mokuaiid));
				}else{
					cpmsg(lang('plugin/wxq123','wxsearch_err'));
				}
			}else{
				DB::insert('wxq123_mokuai',$data);
			}
			if($data['urluser'] && $data['status']) {
				if(!DB::result_first("describe ".DB::table('wxq123_site')." m_".$data['mokuainame'])) {
					$sql = "alter table ".DB::table('wxq123_site')." add `m_".$data['mokuainame']."` tinyint(1) not Null;";
					runquery($sql);
				}
			}else{
				if(DB::result_first("describe ".DB::table('wxq123_site')." m_".$data['mokuainame'])) {
					$sql = "alter table ".DB::table('wxq123_site')." DROP `m_".$data['mokuainame']."`;";
					runquery($sql);
				}
			}
			if($data['shopuser'] && $data['status']) {
				if(!DB::result_first("describe ".DB::table('wxq123_shop')." m_".$data['mokuainame'])) {
					$sql = "alter table ".DB::table('wxq123_shop')." add `m_".$data['mokuainame']."` tinyint(1) not Null;";
					runquery($sql);
				}
			}else{
				if(DB::result_first("describe ".DB::table('wxq123_shop')." m_".$data['mokuainame'])) {
					$sql = "alter table ".DB::table('wxq123_shop')." DROP `m_".$data['mokuainame']."`;";
					runquery($sql);
				}
			}
			cpmsg(lang('plugin/wxq123', 'mokuai_edit_succeed'), 'action=plugins&identifier=wxq123&pmod=mokuai', 'succeed');
		}
	//字段列表
	}elseif($submod == 'table'){
		if(empty($mokuaiid)) {
			cpmsg(lang('plugin/wxq123','mikuai_nonexistence'), 'action=plugins&identifier=wxq123&pmod=goodsadmin&submod=list', 'form', array(), '<select name="mokuaiid">'.$mokuai_select.'</select>');
		}
		if(!submitcheck('submit')) {
			showtips(lang('plugin/wxq123','table_list_tips'));
			showformheader('plugins&identifier=wxq123&pmod=mokuai&submod=table');
			showtableheader(DB::result_first("SELECT mokuaititle FROM ".DB::table('wxq123_mokuai')." WHERE mokuaiid=".$mokuaiid).lang('plugin/wxq123','table_list'));
			showsubtitle(array('', lang('plugin/wxq123','displayorder'),lang('plugin/wxq123','tabletype'),lang('plugin/wxq123','tablename'),lang('plugin/wxq123','tabletitle'),  lang('plugin/wxq123','tabledescription'),lang('plugin/wxq123','status'), ''));
			$query = DB::query("SELECT * FROM ".DB::table('wxq123_table')." order by tableid asc");
			while($row = DB::fetch($query)) {
			}
			echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action=plugins&identifier=wxq123&pmod=mokuai&submod=tableedit" class="addtr">'.lang('plugin/wxq123','add_table').'</a></div></td></tr>';
			showsubmit('submit','submit','del');
			showtablefooter();
			showformfooter();
		}else{
		}
	}elseif($submod == 'tableedit'){
		$tableid = intval(getgpc('tableid'));
		if(!submitcheck('submit')) {
			$tabletype_select = '<select name="tabletype"><option value ="web" '.($table_info['tabletype']=='web'?' selected':'').'>'.lang('plugin/wxq123','web').'</option><option value ="shop" '.($table_info['tabletype']=='shop'?' selected':'').'>'.lang('plugin/wxq123','shop').'</option><option value ="goods" '.($table_info['tabletype']=='goods'?' selected':'').'>'.lang('plugin/wxq123','goods').'</option></select>';
			showtips($datatypeid?lang('plugin/wxq123','edit_table_tips'):lang('plugin/wxq123','add_table_tips'));
			showformheader('plugins&identifier=wxq123&pmod=mokuai&submod=table');
			showtableheader($datatypeid?lang('plugin/wxq123','edit_table'):lang('plugin/wxq123','add_table'));
			showsetting(lang('plugin/wxq123','tabletype'),'','',$tabletype_select,'',0,lang('plugin/wxq123','tabletype_comment'),'','',true);
			showsetting(lang('plugin/wxq123','tablename'),'tablename',$table_info['tablename'],'text','',0,lang('plugin/wxq123','tablename_comment'),'','',true);
			showsetting(lang('plugin/wxq123','tabletitle'),'tabletitle',$table_info['tabletitle'],'text','',0,lang('plugin/wxq123','tabletitle_comment'),'','',true);
			showsetting(lang('plugin/wxq123','tabledescription'),'tabledescription',$table_info['tabledescription'],'textarea','',0,lang('plugin/wxq123','tabledescription_comment'),'','',true);
			showsubmit('submit');
			showtablefooter();
			showformfooter();
		}else{
		}
	//商家列表
	}elseif($submod == 'shop'){

		$classid = intval(getgpc('classid'));

		if(!submitcheck('submit')) {
			showtips('option_shop_tips');
			showformheader("plugins&identifier=wxq123&pmod=mokuai&submod=shop&classid=".$classid);
			showtableheader('');
			showsubtitle(array('', 'display_order', 'available', 'name', 'type', 'required', 'unchangeable', 'threadtype_infotypes_formsearch', 'threadtype_infotypes_fontsearch', lang('plugin/wxq123','weixin_display'), ''));
			$query = DB::query("SELECT * FROM ".DB::table('wxq123_threadtype')." WHERE classid = ".$classid." and mokuaiid=".$mokuaiid." order by displayorder asc");
			while($row = DB::fetch($query)) {
				$mkoptions[$row['optionid']] = $row;
				$optionids[$row['optionid']] = $row['optionid'];
			}
			$query = DB::query("SELECT * FROM ".DB::table('wxq123_typeoption')." WHERE classid = ".$classid." order by optionid desc");
			while($row = DB::fetch($query)) {
				$options[$row['optionid']] = $row;
				if(!in_array($row['optionid'],$optionids)) {
					$optionids[$row['optionid']] = $row['optionid'];
				}
			}
			foreach ( $optionids as $optionid=>$v) {
				if($options[$optionid]['display']) {
					showtablerow('id="optionid'.$optionid.'"', array('class="td25"', 'class="td28 td23"'), array(
						"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$optionid\" ".($options[$optionid]['system'] ? 'disabled' : '').">",
						"<input type=\"text\" class=\"txt\" size=\"2\" name=\"displayorder[$optionid]\" value=\"".($mkoptions[$optionid]['displayorder']?$mkoptions[$optionid]['displayorder']:0)."\">",
						"<input class=\"checkbox\" type=\"checkbox\" name=\"available[$optionid]\" value=\"1\" ".($mkoptions[$optionid]['available'] || $options[$optionid]['system'] ? 'checked' : '')." ".($options[$optionid]['system'] ? 'disabled' : '').">",
						dhtmlspecialchars($options[$optionid]['title']).'('.$options[$optionid]['identifier'].')',
						$options[$optionid]['type'],
						"<input class=\"checkbox\" type=\"checkbox\" name=\"required[$optionid]\" value=\"1\" ".($mkoptions[$optionid]['required'] ? 'checked' : '')." ".($row['model'] ? 'disabled' : '').">",
						"<input class=\"checkbox\" type=\"checkbox\" name=\"unchangeable[$optionid]\" value=\"1\" ".($mkoptions[$optionid]['unchangeable'] ? 'checked' : '').">",
						"<input class=\"checkbox\" type=\"checkbox\" name=\"searchform[$optionid]\" value=\"1\" ".($mkoptions[$optionid]['searchform'] ? 'checked' : '').">",
						"<input class=\"checkbox\" type=\"checkbox\" name=\"searchfont[$optionid]\" value=\"1\" ".($mkoptions[$optionid]['searchfont'] ? 'checked' : '').">",
						"<input class=\"checkbox\" type=\"checkbox\" name=\"weixinshow[$optionid]\" value=\"1\" ".($mkoptions[$optionid]['weixinshow'] ? 'checked' : '').">",
						"<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=mokuai&submod=shopedit&optionid=$optionid\" class=\"act\">".$lang['edit']."</a>"
					));
				}
			}
			echo '<tr><td><INPUT type="hidden" name="mokuaiid" value="'.$mokuaiid.'"></td><td colspan="5"><div><a href="'.ADMINSCRIPT.'?action=plugins&identifier=wxq123&pmod=mokuai&submod=shopedit&classid='.$classid.'" class="addtr">'.lang('plugin/wxq123','add_field').'</a></div></td></tr>';
			showsubmit('submit', 'submit', 'del','','',$multi);
			showtablefooter();
			showformfooter();
		}else{
			if($ids = $_GET['delete']) {
				$ids = dintval($ids, is_array($ids) ? true : false);
				if($ids) {
					DB::delete('wxq123_typeoption', DB::field('optionid', $ids));
				}
			}
			foreach ( $_GET['displayorder'] as $k=>$v) {
				$data['displayorder'] = intval($v);
				$data['available'] = intval($_GET['available'][$k]);
				$data['required'] = intval($_GET['required'][$k]);
				$data['unchangeable'] = intval($_GET['unchangeable'][$k]);
				$data['searchform'] = intval($_GET['searchform'][$k]);
				$data['searchfont'] = intval($_GET['searchfont'][$k]);
				$data['weixinshow'] = intval($_GET['weixinshow'][$k]);
				$data['mokuaiid'] = $mokuaiid;
				if(DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_threadtype')." WHERE classid=0 and mokuaiid=".$mokuaiid." and optionid = ".$k)==0) {
					$data['optionid'] = intval($k);
					DB::insert('wxq123_threadtype',$data);
				}else{
					DB::update('wxq123_threadtype',$data,array('optionid'=>$k));
				}
			}
			cpmsg(lang('plugin/wxq123', 'mokuai_edit_succeed'), 'action=plugins&identifier=wxq123&pmod=mokuai&submod=shop&mokuaiid='.$mokuaiid, 'succeed');

		}
	//商家编辑
	}elseif($submod == 'shopedit'){

		$classid = intval(getgpc('classid'));

		if($optionid) {
			$query = DB::query("SELECT * FROM ".DB::table('wxq123_typeoption')." WHERE optionid=".$optionid." order by optionid asc");
			while($row = DB::fetch($query)) {
				$option = $row;
			}
			if(!$option) {
				cpmsg('typeoption_not_found', '', 'error');
			}
		}

		if(!submitcheck('editsubmit')) {

			$typeselect = '<select name="typenew" onchange="var styles, key;styles=new Array(\'number\',\'text\',\'radio\', \'checkbox\', \'textarea\', \'select\', \'image\', \'calendar\', \'range\',\'baidu\',\'editarea\',\'district\', \'info\'); for(key in styles) {var obj=$(\'style_\'+styles[key]); if(obj) { obj.style.display=styles[key]==this.options[this.selectedIndex].value?\'\':\'none\';}}">';
			foreach(array('number', 'text', 'radio', 'checkbox', 'textarea', 'select', 'calendar', 'email', 'url', 'image', 'range', 'baidu', 'editarea','district') as $type) {
				$typeselect .= '<option value="'.$type.'" '.($option['type'] == $type ? 'selected' : '').'>'.lang('plugin/wxq123','option_'.$type).'</option>';
			}
			$typeselect .= '</select>';

			$option['rules'] = dunserialize($option['rules']);
			$option['protect'] = dunserialize($option['protect']);

			$groups = $forums = array();
			foreach(C::t('common_usergroup')->range() as $group) {
				$groups[] = array($group['groupid'], $group['grouptitle']);
			}
			$verifys = array();
			if($_G['setting']['verify']['enabled']) {
				foreach($_G['setting']['verify'] as $key => $verify) {
					if($verify['available'] == 1) {
						$verifys[] = array($key, $verify['title']);
					}
				}
			}

			foreach(C::t('common_member_profile_setting')->fetch_all_by_available_formtype(1, 'text') as $result) {
				$threadtype_profile = !$threadtype_profile ? "<select id='rules[text][profile]' name='rules[text][profile]'><option value=''></option>" : $threadtype_profile."<option value='{$result[fieldid]}' ".($option['rules']['profile'] == $result['fieldid'] ? "selected='selected'" : '').">{$result[title]}</option>";
			}
			$threadtype_profile .= "</select>";

			showformheader("plugins&identifier=wxq123&pmod=mokuai&submod=shopedit&classid=".$classid."&optionid=$_GET[optionid]");
			showtableheader();
			showtitle('threadtype_infotypes_option_config');
			showsetting('name', 'titlenew', $option['title'], 'text');
			showsetting('threadtype_variable', 'identifiernew', $option['identifier'], 'text');
			showsetting('type', '', '', $typeselect);
			showsetting('threadtype_edit_desc', 'descriptionnew', $option['description'], 'textarea');
			showsetting('threadtype_unit', 'unitnew', $option['unit'], 'text');
			showsetting('threadtype_expiration', 'expirationnew', $option['expiration'], 'radio');
			if(in_array($option['type'], array('calendar', 'number', 'text', 'email', 'textarea'))) {
				showsetting('threadtype_protect', 'protectnew[status]', $option['protect']['status'], 'radio', 0, 1);
				showsetting('threadtype_protect_mode', array('protectnew[mode]', array(
					array(1, $lang['threadtype_protect_mode_pic']),
					array(2, $lang['threadtype_protect_mode_html'])
				)), $option['protect']['mode'], 'mradio');
				showsetting('threadtype_protect_usergroup', array('protectnew[usergroup][]', $groups), explode("\t", $option['protect']['usergroup']), 'mselect');
				$verifys && showsetting('threadtype_protect_verify', array('protectnew[verify][]', $verifys), explode("\t", $option['protect']['verify']), 'mselect');
				showsetting('threadtype_protect_permprompt', 'permpromptnew', $option['permprompt'], 'textarea');
			}

			showtagheader('tbody', "style_calendar", $option['type'] == 'calendar');
			showtitle('threadtype_edit_vars_type_calendar');
			showsetting('threadtype_edit_inputsize', 'rules[calendar][inputsize]', $option['rules']['inputsize'], 'text');
			showtagfooter('tbody');

			showtagheader('tbody', "style_number", $option['type'] == 'number');
			showtitle('threadtype_edit_vars_type_number');
			showsetting('threadtype_edit_maxnum', 'rules[number][maxnum]', $option['rules']['maxnum'], 'text');
			showsetting('threadtype_edit_minnum', 'rules[number][minnum]', $option['rules']['minnum'], 'text');
			showsetting('threadtype_edit_inputsize', 'rules[number][inputsize]', $option['rules']['inputsize'], 'text');
			showsetting('threadtype_defaultvalue', 'rules[number][defaultvalue]', $option['rules']['defaultvalue'], 'text');
			showtagfooter('tbody');

			showtagheader('tbody', "style_text", $option['type'] == 'text');
			showtitle('threadtype_edit_vars_type_text');
			showsetting('threadtype_edit_textmax', 'rules[text][maxlength]', $option['rules']['maxlength'], 'text');
			showsetting('threadtype_edit_inputsize', 'rules[text][inputsize]', $option['rules']['inputsize'], 'text');
			showsetting('threadtype_edit_profile', '', '', $threadtype_profile);
			showsetting('threadtype_defaultvalue', 'rules[text][defaultvalue]', $option['rules']['defaultvalue'], 'text');
			showtagfooter('tbody');

			showtagheader('tbody', "style_textarea", $option['type'] == 'textarea');
			showtitle('threadtype_edit_vars_type_textarea');
			showsetting('threadtype_edit_textmax', 'rules[textarea][maxlength]', $option['rules']['maxlength'], 'text');
			showsetting('threadtype_edit_colsize', 'rules[textarea][colsize]', $option['rules']['colsize'], 'text');
			showsetting('threadtype_edit_rowsize', 'rules[textarea][rowsize]', $option['rules']['rowsize'], 'text');
			showsetting('threadtype_defaultvalue', 'rules[textarea][defaultvalue]', $option['rules']['defaultvalue'], 'text');
			showtagfooter('tbody');

			showtagheader('tbody', "style_select", $option['type'] == 'select');
			showtitle('threadtype_edit_vars_type_select');
			showsetting('threadtype_edit_select_choices', 'rules[select][choices]', $option['rules']['choices'], 'textarea');
			showsetting('threadtype_edit_inputsize', 'rules[select][inputsize]', $option['rules']['inputsize'], 'text');
			showtagfooter('tbody');

			showtagheader('tbody', "style_radio", $option['type'] == 'radio');
			showtitle('threadtype_edit_vars_type_radio');
			showsetting('threadtype_edit_choices', 'rules[radio][choices]', $option['rules']['choices'], 'textarea');
			showtagfooter('tbody');

			showtagheader('tbody', "style_checkbox", $option['type'] == 'checkbox');
			showtitle('threadtype_edit_vars_type_checkbox');
			showsetting('threadtype_edit_choices', 'rules[checkbox][choices]', $option['rules']['choices'], 'textarea');
			showtagfooter('tbody');

			showtagheader('tbody', "style_image", $option['type'] == 'image');
			showtitle('threadtype_edit_vars_type_image');
			showsetting('threadtype_edit_images_weight', 'rules[image][maxwidth]', $option['rules']['maxwidth'], 'text');
			showsetting('threadtype_edit_images_height', 'rules[image][maxheight]', $option['rules']['maxheight'], 'text');
			showsetting('threadtype_edit_inputsize', 'rules[image][inputsize]', $option['rules']['inputsize'], 'text');
			showtagfooter('tbody');

			showtagheader('tbody', "style_range", $option['type'] == 'range');
			showtitle('threadtype_edit_vars_type_range');
			showsetting('threadtype_edit_maxnum', 'rules[range][maxnum]', $option['rules']['maxnum'], 'text');
			showsetting('threadtype_edit_minnum', 'rules[range][minnum]', $option['rules']['minnum'], 'text');
			showsetting('threadtype_edit_inputsize', 'rules[range][inputsize]', $option['rules']['inputsize'], 'text');
			showsetting('threadtype_edit_searchtxt', 'rules[range][searchtxt]', $option['rules']['searchtxt'], 'text');
			showtagfooter('tbody');

			showtagheader('tbody', "style_baidu", $option['type'] == 'baidu');
			showtitle('threadtype_edit_vars_type_range');
			showsetting('threadtype_edit_maxnum', 'rules[range][maxnum]', $option['rules']['maxnum'], 'text');
			showsetting('threadtype_edit_minnum', 'rules[range][minnum]', $option['rules']['minnum'], 'text');
			showsetting('threadtype_edit_inputsize', 'rules[range][inputsize]', $option['rules']['inputsize'], 'text');
			showsetting('threadtype_edit_searchtxt', 'rules[range][searchtxt]', $option['rules']['searchtxt'], 'text');
			showtagfooter('tbody');

			showtagheader('tbody', "style_editarea", $option['type'] == 'editarea');
			showtitle('threadtype_edit_vars_type_range');
			showsetting('threadtype_edit_maxnum', 'rules[range][maxnum]', $option['rules']['maxnum'], 'text');
			showsetting('threadtype_edit_minnum', 'rules[range][minnum]', $option['rules']['minnum'], 'text');
			showsetting('threadtype_edit_inputsize', 'rules[range][inputsize]', $option['rules']['inputsize'], 'text');
			showsetting('threadtype_edit_searchtxt', 'rules[range][searchtxt]', $option['rules']['searchtxt'], 'text');
			showtagfooter('tbody');

			showtagheader('tbody', "style_district", $option['type'] == 'district');
			showtitle('threadtype_edit_vars_type_range');
			showsetting('threadtype_edit_maxnum', 'rules[range][maxnum]', $option['rules']['maxnum'], 'text');
			showsetting('threadtype_edit_minnum', 'rules[range][minnum]', $option['rules']['minnum'], 'text');
			showsetting('threadtype_edit_inputsize', 'rules[range][inputsize]', $option['rules']['inputsize'], 'text');
			showsetting('threadtype_edit_searchtxt', 'rules[range][searchtxt]', $option['rules']['searchtxt'], 'text');
			showtagfooter('tbody');

			showsubmit('editsubmit');
			showtablefooter();
			showformfooter();

		} else {

			$titlenew = trim($_GET['titlenew']);
			$_GET['identifiernew'] = trim($_GET['identifiernew']);
			if(!$titlenew || !$_GET['identifiernew']) {
				cpmsg('threadtype_infotypes_option_invalid', '', 'error');
			}

			if(in_array(strtoupper($_GET['identifiernew']), $mysql_keywords)) {
				cpmsg('threadtype_infotypes_optionvariable_iskeyword', '', 'error');
			}

			if(DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_typeoption')." WHERE identifier='".$_GET['identifiernew']."'".($optionid?" and optionid <> $optionid":""))>0 || strlen($_GET['identifiernew']) > 40  || !ispluginkey($_GET['identifiernew'])) {
				cpmsg('threadtype_infotypes_optionvariable_invalid', '', 'error');
			}

			$_GET['protectnew']['usergroup'] = $_GET['protectnew']['usergroup'] ? implode("\t", $_GET['protectnew']['usergroup']) : '';
			$_GET['protectnew']['verify'] = $_GET['protectnew']['verify'] ? implode("\t", $_GET['protectnew']['verify']) : '';

			$data = array(
				'title' => $titlenew,
				'description' => $_GET['descriptionnew'],
				'identifier' => $_GET['identifiernew'],
				'type' => $_GET['typenew'],
				'unit' => $_GET['unitnew'],
				'expiration' => $_GET['expirationnew'],
				'protect' => serialize($_GET['protectnew']),
				'rules' => serialize($_GET['rules'][$_GET['typenew']]),
				'permprompt' => $_GET['permpromptnew'],
				'classid' => $classid,
				'display' => 1,
				'system' => 0,
			);
			if($optionid) {
				DB::update('wxq123_typeoption',$data,array('optionid'=>$optionid));
			}else{
				DB::insert('wxq123_typeoption',$data);
			}
			cpmsg('threadtype_infotypes_option_succeed', 'action=plugins&identifier=wxq123&pmod=mokuai&submod=shop&classid='.$option['classid'].'&mokuaiid='.$mokuaiid, 'succeed');
		}
	}

//weixince.inc.php
	//define your token
	define("TOKEN", "weixin");
	$wechatObj = new wechatCallbackapiTest();
	$wechatObj->valid();

	class wechatCallbackapiTest
	{
		public function valid()
		{
			$echoStr = $_GET["echostr"];

			//valid signature , option
			if($this->checkSignature()){
				echo $echoStr;
				exit;
			}
		}

		public function responseMsg()
		{
			//get post data, May be due to the different environments
			$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

			//extract post data
			if (!empty($postStr)){

					$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
					$fromUsername = $postObj->FromUserName;
					$toUsername = $postObj->ToUserName;
					$keyword = trim($postObj->Content);
					$time = time();
					$textTpl = "<xml>
								<ToUserName><![CDATA[%s]]></ToUserName>
								<FromUserName><![CDATA[%s]]></FromUserName>
								<CreateTime>%s</CreateTime>
								<MsgType><![CDATA[%s]]></MsgType>
								<Content><![CDATA[%s]]></Content>
								<FuncFlag>0</FuncFlag>
								</xml>";
					if(!empty( $keyword ))
					{
						$msgType = "text";
						$contentStr = "Welcome to wechat world!";
						$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						echo $resultStr;
					}else{
						echo "Input something...";
					}

			}else {
				echo "";
				exit;
			}
		}

		private function checkSignature()
		{
			$signature = $_GET["signature"];
			$timestamp = $_GET["timestamp"];
			$nonce = $_GET["nonce"];

			$token = TOKEN;
			$tmpArr = array($token, $timestamp, $nonce);
			sort($tmpArr);
			$tmpStr = implode( $tmpArr );
			$tmpStr = sha1( $tmpStr );

			if( $tmpStr == $signature ){
				return true;
			}else{
				return false;
			}
		}
	}

//beifenshopadmin.inc.php
	$subop = getgpc('subop');
	$subops = array('shoplist','shopedit','shopsetting');
	$subop = in_array($subop,$subops) ? $subop : $subops[0];

	$shopid = getgpc('shopid');


	loadcache('plugin');

	if($subop == 'shoplist'){
		$select[$_GET['tpp']] = $_GET['tpp'] ? "selected='selected'" : '';
		$tpp_options = "<option value='20' $select[20]>20</option><option value='50' $select[50]>50</option><option value='100' $select[100]>100</option>";
		$tpp = !empty($_GET['tpp']) ? $_GET['tpp'] : '20';
		$renling = $_GET['renling'];
		$renlingoptions = '<option value="0" '.(!$renling?' selected':'').'>'.lang('plugin/wxq123','all').'</option><option value="1" '.($renling ==1?' selected':'').'>'.lang('plugin/wxq123','renling_no').'</option><option value="2" '.($renling ==2?' selected':'').'>'.lang('plugin/wxq123','renling_yes').'</option>';
		$qianfei = $_GET['qianfei'];
		$qianfeioptions = '<option value="0" '.(!$qianfei?' selected':'').'>'.lang('plugin/wxq123','all').'</option><option value="1" '.($qianfei ==1?' selected':'').'>'.lang('plugin/wxq123','qianfei_no').'</option><option value="2" '.($qianfei ==2?' selected':'').'>'.lang('plugin/wxq123','qianfei_yes').'</option><option value="3" '.($qianfei ==3?' selected':'').'>'.lang('plugin/wxq123','qianfei_mian').'</option>';
		$baohanmokuais = '';
		$query = DB::query("SELECT * FROM ".DB::table('wxq123_mokuai')." WHERE status = 1 order by displayorder asc");
		while($row = DB::fetch($query)) {
			$mokuais_n[$row['mokuaiid']] = $row['mokuaititle'];
			$baohanmokuais .= "&nbsp;<input name=\"baohanmokuai\" type=\"checkbox\" class=\"checkbox\" value=\"".$row['mokuaiid']."\" ".(!$baohanmokuai ? ' checked="checked"' : '')."/>".$row['mokuaititle'];
		}

		showtips(lang('plugin/wxq123','shop_list_tips'));
		showtableheader('search');
		showtablerow('', array('width="60"', 'width="160"', 'width="60"'),
			array(
				lang('plugin/wxq123','shopname'), "<input size=\"15\" name=\"shopname\" type=\"text\" value=\"$_GET[username]\" />",
				lang('plugin/wxq123','baohanmokuai'), $baohanmokuais,
			)
		);
		showtablerow('', array('width="60"', 'width="160"', 'width="60"'),
				array(
						"$lang[perpage]",
						"<select name=\"tpp\">$tpp_options</select><label><input name=\"showcensor\" type=\"checkbox\" class=\"checkbox\" value=\"yes\" ".($showcensor ? ' checked="checked"' : '')."/> $lang[moderate_showcensor]</label>",
						"$lang[moderate_bound]",
						"<select name=\"renling\">$renlingoptions</select>
						<select name=\"qianfei\">$qianfeioptions</select>
						<input class=\"btn\" type=\"submit\" value=\"$lang[search]\" />"
				)
		);
		showformheader("plugins&identifier=wxq123&pmod=shopadmin&submod=list");
		showtableheader(lang('plugin/wxq123','shop_list').'&nbsp;&nbsp;<a href="'.ADMINSCRIPT.'?action=plugins&identifier=wxq123&pmod=shopadmin&subop=shopsetting">'.lang('plugin/wxq123','shopsetting').'</a>');
		showsubtitle(array('',lang('plugin/wxq123','shopname'),lang('plugin/wxq123','shop_type'),lang('plugin/wxq123','shop_name'), lang('plugin/wxq123','shop_credit'),lang('plugin/wxq123','shop_validity'),lang('plugin/wxq123','shop_mokuais'),lang('plugin/wxq123','shop_stauts'),'' ));
		$perpage = $tpp;
		$start = ($page - 1) * $perpage;
		$where = "";
		$shopcount = DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_shop').$where);
		$multi = multi($shopcount, $perpage, $page, ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=shopadmin");
		$query = DB::query("SELECT * FROM ".DB::table('wxq123_shop').$where." order by shopid desc limit ".$start.",".$perpage." ");
		while($row = DB::fetch($query)) {
			$shopmokuais = '';
			if(dunserialize($row['shopmokuais'])){
				$mokuais_t = array();
				foreach ( dunserialize($row['shopmokuais']) as $k=>$v ){
					$mokuais_t[] = $mokuais_n[$v];
				}
				$shopmokuais =implode(",",$mokuais_t) ;
			}

			showtablerow('', array('class="td25"', 'class="td23"', '', ''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shopid]\">",
				$row['shopname'],
				'',
				$row['groupexpiry'] ? dgmdate($row['groupexpiry'],'d') : '--',
				$shopmokuais,
				$row['stauts'] ? '<img src="static/image/common/access_allow.gif" width="16" height="16" />':'<img src="static/image/common/access_disallow.gif" width="16" height="16" />',
				"<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=shopadmin&subop=shopedit&shopid=$row[shopid]\" class=\"act\">".$lang['edit']."</a>",
			));
		}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action=plugins&identifier=wxq123&pmod=shopadmin&subop=shopedit" class="addtr">'.lang('plugin/wxq123','add_shop').'</a></div></td></tr>';
		showsubmit('submit','submit','del','',$multi);
		showtablefooter();
		showformfooter();
	}elseif($subop == 'shopedit'){
		if($shopid){
			$shop_info = DB::fetch_first("SELECT * FROM ".DB::table('wxq123_shop')." WHERE shopid='".$shopid."'");
		}
		if(!submitcheck('submit')) {
			if($shop_info['shoplogo']!='') {
				$shoplogo = str_replace('{STATICURL}', STATICURL, $shop_info['shoplogoshoplogo']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $shoplogo) && !(($valueparse = parse_url($shoplogo)) && isset($valueparse['host']))) {
					$shoplogo = $_G['setting']['attachurl'].'temp/'.$shop_info['shoplogo'].'?'.random(6);
				}
				$shoplogohtml = '<label><input type="checkbox" class="checkbox" name="delete1" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$shoplogo.'" width="240" height="120"/>';
			}
			if($shop_info['weixinimage']!='') {
				$weixinimage = str_replace('{STATICURL}', STATICURL, $shop_info['weixinimageweixinimage']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $weixinimage) && !(($valueparse = parse_url($weixinimage)) && isset($valueparse['host']))) {
					$weixinimage = $_G['setting']['attachurl'].'temp/'.$shop_info['weixinimage'].'?'.random(6);
				}
				$weixinimagehtml = '<label><input type="checkbox" class="checkbox" name="delete2" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$weixinimage.'" width="120" height="120"/>';
			}
			$mokuais = dunserialize($shop_info['shopmokuais']);
			$mokuai_select = '<select name="shopmokuais[]" multiple="multiple" size="10">';
			$query = DB::query("SELECT * FROM ".DB::table('wxq123_mokuai')." WHERE status = 1 order by displayorder asc");
			while($row = DB::fetch($query)) {
				$mokuai_select .= '<option value="'.$row['mokuaiid'].'" '.(in_array($row['mokuaiid'],$mokuais) ? ' selected':'').'>'.$row['mokuaititle'].'</option>';
			}
			$mokuai_select .= '</select>';
			$baidus = dunserialize($shop_info['shopbaidu']);
			showtips($shopid ? lang('plugin/wxq123','shop_edit_tips') : lang('plugin/wxq123','shop_add_tips'));
			showformheader("plugins&identifier=wxq123&pmod=shopadmin&subop=shopedit",'enctype');
			showtableheader(lang('plugin/wxq123','shop_edit'));
			showhiddenfields(array('shopid'=>$shopid));
			echo '<input type="hidden" name="baidu_x" id="baidu_x" value="'.$baidus['x'].'">';
			echo '<input type="hidden" name="baidu_y" id="baidu_y" value="'.$baidus['y'].'">';
			showsetting(lang('plugin/wxq123','shopname'),'shopname',$shop_info['shopname'],'text','',0,lang('plugin/wxq123','shop_name'),'','',true);
			showsetting(lang('plugin/wxq123','shopshortname'),'shopshortname',$shop_info['shopshortname'],'text','',0,lang('plugin/wxq123','shop_name'),'','',true);
			showsetting(lang('plugin/wxq123','shoplogo'),'shoplogo',$shop_info['shoplogo'],'filetext','','',$shoplogohtml);
			showsetting(lang('plugin/wxq123','shopphone'),'shopphone',$shop_info['shopphone'],'text','',0,'','','',true);
			showsetting(lang('plugin/wxq123','shopaddress'),'shopaddress',$shop_info['shopaddress'],'text','',0,'jsdhfsd','','',true);
			showtablefooter();
			showtableheader();
			echo '<tr class="noborder" ><td colspan="2" class="td27" s="1">'.lang('plugin/wxq123','shop_baidu').'</td></tr>';
			echo '<tr class="noborder" ><td colspan="2" ><iframe id="baidumapboa" src="plugin.php?id=wxq123:baidumap" width="600" height="400" frameborder="0" ></iframe></td></tr>';
			echo '<script src="static/js/calendar.js" type="text/javascript"></script>';
			showtablefooter();
			showtableheader();
			showsetting(lang('plugin/wxq123','shop_validity'),'groupexpiry',$shop_info['groupexpiry'] ? dgmdate($shop_info['groupexpiry'],'d') : (intval(date('Y')+1).'-'.date('m').'-'.date('d')),'calendar','',0,'','','',true);
			showsetting(lang('plugin/wxq123','shop_mokuais'),'','',$mokuai_select);
			showsetting(lang('plugin/wxq123','shop_token'),'token',$shop_info['token']?$shop_info['token']:random(6),'text','',0,'','','',true);
			showsetting(lang('plugin/wxq123','shop_weixinimage'),'weixinimage',$shop_info['weixinimage'],'filetext','',0,$weixinimagehtml,'','',true);
			//showsetting(lang('plugin/wxq123','shop_weixinhao'),'weixinhao',$shop_info['weixinhao'],'text','',0,'','','',true);
			//showsetting(lang('plugin/wxq123','shop_weixinpass'),'weixinpass',$shop_info['weixinpass'],'password','',0,'','','',true);
			showsetting(lang('plugin/wxq123','shop_wxqimage'),'','','plugin.php?id=wxq123:weixinimage','','','','',0,'','','',true);
			showsetting(lang('plugin/wxq123','shop_stauts'),'stauts',$shop_info['stauts'],'radio','',0,'','','',true);
			showsubmit('submit');
			showtablefooter();
			showformfooter();
		}else{
			$shoplogo = addslashes($_POST['shoplogo']);
			if($_FILES['shoplogo']) {
				if(!is_dir($_G['setting']['attachurl'].'wxq123')) {
					dmkdir($_G['setting']['attachurl'].'wxq123');
				}
				$upload = new discuz_upload();
				if($upload->init($_FILES['shoplogo'], 'wxq123') && $upload->save()) {
					$shoplogo = $upload->attach['attachment'];
				}
			}
			if($_POST['delete1'] && addslashes($_POST['shoplogo'])) {
				$valueparse = parse_url(addslashes($_POST['shoplogo']));
				if(!isset($valueparse['host']) && !strexists(addslashes($_POST['shoplogo']), '{STATICURL}')) {
					@unlink($_G['setting']['attachurl'].'temp/'.addslashes($_POST['shoplogo']));
				}
				$shoplogo = '';
			}
			$weixinimage = addslashes($_POST['weixinimage']);
			if($_FILES['weixinimage']) {
				if(!is_dir($_G['setting']['attachurl'].'wxq123')) {
					dmkdir($_G['setting']['attachurl'].'wxq123');
				}
				$upload = new discuz_upload();
				if($upload->init($_FILES['weixinimage'], 'wxq123') && $upload->save()) {
					$weixinimage = $upload->attach['attachment'];
				}
			}
			if($_POST['delete2'] && addslashes($_POST['weixinimage'])) {
				$valueparse = parse_url(addslashes($_POST['weixinimage']));
				if(!isset($valueparse['host']) && !strexists(addslashes($_POST['weixinimage']), '{STATICURL}')) {
					@unlink($_G['setting']['attachurl'].'temp/'.addslashes($_POST['weixinimage']));
				}
				$weixinimage = '';
			}
			$data['shopname'] = htmlspecialchars($_GET['shopname']);
			$data['shopshortname'] = htmlspecialchars($_GET['shopshortname']);
			$data['shoplogo'] = $shoplogo;
			$data['shopphone'] = htmlspecialchars($_GET['shopphone']);
			$data['shopaddress'] = htmlspecialchars($_GET['shopaddress']);
			$data['shopmokuais'] = serialize($_GET['shopmokuais']);
			$data['shopbaidu'] = serialize(array('x'=>$_GET['baidu_x'],'y'=>$_GET['baidu_y']));
			$data['groupexpiry'] = strtotime(trim(htmlspecialchars($_GET['groupexpiry'])));
			$data['stauts'] = intval($_GET['stauts']);
			$data['weixinhao'] = htmlspecialchars($_GET['weixinhao']);
			$data['weixinpass'] = htmlspecialchars($_GET['weixinpass']);
			$data['token'] = htmlspecialchars($_GET['token']);
			$data['weixinimage'] = $weixinimage;
			if($shopid){
				DB::update('wxq123_shop', $data,array('shopid'=>$shopid));
			}else{
				if ($data['shopname'] && DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_shop')." WHERE shopname= '".$data['shopname']."'")==0 ){
					DB::insert('wxq123_shop', $data);
					$shopid = insert_id();
				}
			}
			$query = DB::query("SELECT * FROM ".DB::table('wxq123_mokuai')." WHERE status = 1 order by displayorder asc");
			while($row = DB::fetch($query)) {
				if (in_array($row['mokuaiid'],$_GET['shopmokuais'])){
					if (DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_shop_count')." WHERE mokuaiid= ".$row['mokuaiid']." and shopid=".$shopid)==0){
						DB::insert('wxq123_shop_count', array('mokuaiid'=>$row['mokuaiid'],'shopid'=>$shopid));
					}
				}else{
					if (DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_shop_count')." WHERE mokuaiid= ".$row['mokuaiid']." and shopid=".$shopid)==1){
						//DB::delete('wxq123_shop_count', array('mokuaiid'=>$row['mokuaiid'],'shopid'=>$shopid));
					}
				}
			}
			cpmsg(lang('plugin/wxq123', 'shop_edit_succeed'), 'action=plugins&identifier=wxq123&pmod=shopadmin', 'succeed');
		}

	}

//adminsitekey.inc.php
	$submod = getgpc('submod');
	$submods = array('list','edit');
	$submod = in_array($submod,$submods) ? $submod : $submods[0];

	if($submod == 'list') {
		if(!submitcheck('submit')) {
			showtips(lang('plugin/wxq123','sitekey_list_tips'));
			showformheader('plugins&identifier=wxq123&pmod=adminsitekey&submod=list');
			showtableheader(lang('plugin/wxq123','sitekey_list'));
			showsubtitle(array(lang('plugin/wxq123','siteurl'),lang('plugin/wxq123','charset'), lang('plugin/wxq123','clientip'), lang('plugin/wxq123','installtime'),lang('plugin/wxq123','status'), ''));
			$perpage = 20;
			$start = ($page - 1) * $perpage;
			$sitecount = DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_sitekey'));
			$multi = multi($sitecount, $perpage, $page, ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=adminsitekey");
			$query = DB::query("SELECT * FROM ".DB::table('wxq123_sitekey')." order by siteid asc");
			while($row = DB::fetch($query)) {
				showtablerow('', array('class="td29"','class="td25"', 'class="td28"', 'class="td28"','class="td25"',''), array(
					$row['siteurl'],
					$row['charset'],
					$row['clientip'],
					dgmdate($row['installtime'],'dt'),
					"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['mokuaiid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
					"<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=mokuai&submod=edit&mokuaiid=$row[mokuaiid]\" class=\"act\">".$lang['edit']."</a>".
					"<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=mokuai&submod=table&mokuaiid=$row[mokuaiid]\" class=\"act\">".lang('plugin/wxq123','field')."</a>".
					($row['urluser']?"&nbsp;<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=mokuai&submod=shop&mokuaiid=$row[mokuaiid]&classid=0\" class=\"act\">".lang('plugin/wxq123','url_user')."</a>":"").
					($row['shopuser']?"&nbsp;<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=mokuai&submod=shop&mokuaiid=$row[mokuaiid]&classid=0\" class=\"act\">".lang('plugin/wxq123','shop_user')."</a>":"").
					$goods_link,
				));
			}
			showsubmit('submit','submit','del','',$multi);
			showtablefooter();
			showformfooter();
		}else{
		}
	}else{
	}

//api.inc.php
	$apidata = trim($_GET['apidata']);
	$sign = trim($_GET['sign']);
	if($sign != md5(md5($apidata))){
		echo 'system_error';
		exit();
	}
	$apidata = base64_decode($apidata);
	$apidata = dunserialize($apidata);
	$apidata['siteurl'] = $apidata['siteurl'];
	$apidata['searchurl'] = str_replace("http://","",$apidata['siteurl']);
	$apidata['searchurl'] = str_replace("www.","",$apidata['searchurl']);
	if ($apidata['action']){
		$api_file = DISCUZ_ROOT.'source/plugin/wxq123/api/'.$apidata['action'].'.php';
	}else{
		$api_file = DISCUZ_ROOT.'source/plugin/wxq123/api/error.php';
	}
	if (file_exists($api_file)){
		require_once $api_file;
	}else{
		$outdata['error'] = lang('plugin/wxq123','action_error');
	}
	if(is_array($outdata)){
		require_once libfile('class/xml');
		$filename = $data['action'].'.xml';
		$plugin_export = array2xml($outdata, 1);
		ob_end_clean();
		dheader('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		dheader('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
		dheader('Cache-Control: no-cache, must-revalidate');
		dheader('Pragma: no-cache');
		dheader('Content-Encoding: none');
		dheader('Content-Length: '.strlen($plugin_export));
		dheader('Content-Disposition: attachment; filename='.$filename);
		dheader('Content-Type: text/xml');
		echo $plugin_export;
		define('FOOTERDISABLED' , 1);
		exit();
	}

//member.inc.php
	$subop = getgpc('subop');

	$wxquser_info = DB::fetch_first("SELECT * FROM ".DB::table('wxq123_member')." WHERE uid=".$_G['uid']);
	$mokuais = dunserialize($wxquser_info['mokuai']);
	$mymanagesite = dunserialize($wxquser_info['sitemanage']);
	$myjoinsite = dunserialize($wxquser_info['siteuser']);
	$mymanageshop = dunserialize($wxquser_info['shopmanage']);
	$myjoinshop = dunserialize($wxquser_info['shopdianyuan']);

	$subops = array();
	if($_G['groupid'] == $_G['cache']['plugin']['wxq123']['sitegroup']){
		$subops = array('base_setting','shop_manage','goods_manage','weixin_setting');
	}elseif($_G['groupid'] == $_G['cache']['plugin']['wxq123']['shopgroup']){
		$subops = array('base_setting','shop_manage','goods_manage','weixin_setting');
	}elseif($_G['groupid'] == $_G['cache']['plugin']['wxq123']['weixingroup']){
		$subops = array('base_setting','shop_manage','goods_manage','weixin_setting');
	}else{
		$subops = array('baseinfo','shopadd','pagesetting');
	}
	$subop = in_array($subop,$subops) ? $subop : $subops[0];

	foreach ( $subops as $v) {
		$lang_subops[$v] = lang('plugin/wxq123',$v);
	}

	if($subop) {
		$source_file = 'source/plugin/wxq123/source/member/member_'.$subop.'.php';
		if(!file_exists($source_file)) {
			$contents = htmlspecialchars(file_get_contents('source/plugin/wxq123/source/member/member_yangben.php'));
			$contents = str_replace("&lt;","<",$contents);
			$contents = str_replace("&gt;",">",$contents);
			file_put_contents($source_file, $contents);
		}
		require_once($source_file);
	}

//wxqoption.inc.php
	/**
	 *      [17xue8.cn] (C)2013-2099 杨文.
	 *      这不是免费的。
	 *
	 */

	if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
		exit('Access Denied');
	}
	$mysql_keywords = array( 'ADD', 'ALL', 'ALTER', 'ANALYZE', 'AND', 'AS', 'ASC', 'ASENSITIVE', 'BEFORE', 'BETWEEN', 'BIGINT', 'BINARY', 'BLOB', 'BOTH', 'BY', 'CALL', 'CASCADE', 'CASE', 'CHANGE', 'CHAR', 'CHARACTER', 'CHECK', 'COLLATE', 'COLUMN', 'CONDITION', 'CONNECTION', 'CONSTRAINT', 'CONTINUE', 'CONVERT', 'CREATE', 'CROSS', 'CURRENT_DATE', 'CURRENT_TIME', 'CURRENT_TIMESTAMP', 'CURRENT_USER', 'CURSOR', 'DATABASE', 'DATABASES', 'DAY_HOUR', 'DAY_MICROSECOND', 'DAY_MINUTE', 'DAY_SECOND', 'DEC', 'DECIMAL', 'DECLARE', 'DEFAULT', 'DELAYED', 'DELETE', 'DESC', 'DESCRIBE', 'DETERMINISTIC', 'DISTINCT', 'DISTINCTROW', 'DIV', 'DOUBLE', 'DROP', 'DUAL', 'EACH', 'ELSE', 'ELSEIF', 'ENCLOSED', 'ESCAPED', 'EXISTS', 'EXIT', 'EXPLAIN', 'FALSE', 'FETCH', 'FLOAT', 'FLOAT4', 'FLOAT8', 'FOR', 'FORCE', 'FOREIGN', 'FROM', 'FULLTEXT', 'GOTO', 'GRANT', 'GROUP', 'HAVING', 'HIGH_PRIORITY', 'HOUR_MICROSECOND', 'HOUR_MINUTE', 'HOUR_SECOND', 'IF', 'IGNORE', 'IN', 'INDEX', 'INFILE', 'INNER', 'INOUT', 'INSENSITIVE', 'INSERT', 'INT', 'INT1', 'INT2', 'INT3', 'INT4', 'INT8', 'INTEGER', 'INTERVAL', 'INTO', 'IS', 'ITERATE', 'JOIN', 'KEY', 'KEYS', 'KILL', 'LABEL', 'LEADING', 'LEAVE', 'LEFT', 'LIKE', 'LIMIT', 'LINEAR', 'LINES', 'LOAD', 'LOCALTIME', 'LOCALTIMESTAMP', 'LOCK', 'LONG', 'LONGBLOB', 'LONGTEXT', 'LOOP', 'LOW_PRIORITY', 'MATCH', 'MEDIUMBLOB', 'MEDIUMINT', 'MEDIUMTEXT', 'MIDDLEINT', 'MINUTE_MICROSECOND', 'MINUTE_SECOND', 'MOD', 'MODIFIES', 'NATURAL', 'NOT', 'NO_WRITE_TO_BINLOG', 'NULL', 'NUMERIC', 'ON', 'OPTIMIZE', 'OPTION', 'OPTIONALLY', 'OR', 'ORDER', 'OUT', 'OUTER', 'OUTFILE', 'PRECISION', 'PRIMARY', 'PROCEDURE', 'PURGE', 'RAID0', 'RANGE', 'READ', 'READS', 'REAL', 'REFERENCES', 'REGEXP', 'RELEASE', 'RENAME', 'REPEAT', 'REPLACE', 'REQUIRE', 'RESTRICT', 'RETURN', 'REVOKE', 'RIGHT', 'RLIKE', 'SCHEMA', 'SCHEMAS', 'SECOND_MICROSECOND', 'SELECT', 'SENSITIVE', 'SEPARATOR', 'SET', 'SHOW', 'SMALLINT', 'SPATIAL', 'SPECIFIC', 'SQL', 'SQLEXCEPTION', 'SQLSTATE', 'SQLWARNING', 'SQL_BIG_RESULT', 'SQL_CALC_FOUND_ROWS', 'SQL_SMALL_RESULT', 'SSL', 'STARTING', 'STRAIGHT_JOIN', 'TABLE', 'TERMINATED', 'THEN', 'TINYBLOB', 'TINYINT', 'TINYTEXT', 'TO', 'TRAILING', 'TRIGGER', 'TRUE', 'UNDO', 'UNION', 'UNIQUE', 'UNLOCK', 'UNSIGNED', 'UPDATE', 'USAGE', 'USE', 'USING', 'UTC_DATE', 'UTC_TIME', 'UTC_TIMESTAMP', 'VALUES', 'VARBINARY', 'VARCHAR', 'VARCHARACTER', 'VARYING', 'WHEN', 'WHERE', 'WHILE', 'WITH', 'WRITE', 'X509', 'XOR', 'YEAR_MONTH', 'ZEROFILL', 'ACTION', 'BIT', 'DATE', 'ENUM', 'NO', 'TEXT', 'TIME');

	$lang['threadtype_edit_vars_type_baidu'] = lang('plugin/wxq123','option_baidu');
	$lang['threadtype_edit_vars_type_editarea'] = lang('plugin/wxq123','option_editarea');
	$lang['threadtype_edit_vars_type_district'] = lang('plugin/wxq123','option_district');

	$optionid = getgpc('optionid');

	if($optionid) {
		if($optionid) {
			$query = DB::query("SELECT * FROM ".DB::table('wxq123_typeoption')." WHERE optionid=".$optionid." order by optionid asc");
			while($row = DB::fetch($query)) {
				$option = $row;
			}
			if(!$option) {
				cpmsg('typeoption_not_found', '', 'error');
			}
		}

		if(!submitcheck('editsubmit')) {

			$typeselect = '<select name="typenew" onchange="var styles, key;styles=new Array(\'number\',\'text\',\'radio\', \'checkbox\', \'textarea\', \'select\', \'image\', \'calendar\', \'range\',\'baidu\',\'editarea\',\'district\', \'info\'); for(key in styles) {var obj=$(\'style_\'+styles[key]); if(obj) { obj.style.display=styles[key]==this.options[this.selectedIndex].value?\'\':\'none\';}}">';
			foreach(array('number', 'text', 'radio', 'checkbox', 'textarea', 'select', 'calendar', 'email', 'url', 'image', 'range', 'baidu', 'editarea','district') as $type) {
				$typeselect .= '<option value="'.$type.'" '.($option['type'] == $type ? 'selected' : '').'>'.$lang['threadtype_edit_vars_type_'.$type].'</option>';
			}
			$typeselect .= '</select>';

			$option['rules'] = dunserialize($option['rules']);
			$option['protect'] = dunserialize($option['protect']);

			$groups = $forums = array();
			foreach(C::t('common_usergroup')->range() as $group) {
				$groups[] = array($group['groupid'], $group['grouptitle']);
			}
			$verifys = array();
			if($_G['setting']['verify']['enabled']) {
				foreach($_G['setting']['verify'] as $key => $verify) {
					if($verify['available'] == 1) {
						$verifys[] = array($key, $verify['title']);
					}
				}
			}

			foreach(C::t('common_member_profile_setting')->fetch_all_by_available_formtype(1, 'text') as $result) {
				$threadtype_profile = !$threadtype_profile ? "<select id='rules[text][profile]' name='rules[text][profile]'><option value=''></option>" : $threadtype_profile."<option value='{$result[fieldid]}' ".($option['rules']['profile'] == $result['fieldid'] ? "selected='selected'" : '').">{$result[title]}</option>";
			}
			$threadtype_profile .= "</select>";

			showformheader("plugins&identifier=wxq123&pmod=wxqoption&optionid=$_GET[optionid]");
			showtableheader();
			showtitle('threadtype_infotypes_option_config');
			showsetting('name', 'titlenew', $option['title'], 'text');
			showsetting('threadtype_variable', 'identifiernew', $option['identifier'], 'text');
			showsetting(lang('plugin/wxq123','option_system'), 'systemnew', $option['system'], 'radio');
			showsetting(lang('plugin/wxq123','option_display'), 'displaynew', $option['display'], 'radio');
			showsetting('type', '', '', $typeselect);
			showsetting('threadtype_edit_desc', 'descriptionnew', $option['description'], 'textarea');
			showsetting('threadtype_unit', 'unitnew', $option['unit'], 'text');
			showsetting('threadtype_expiration', 'expirationnew', $option['expiration'], 'radio');
			if(in_array($option['type'], array('calendar', 'number', 'text', 'email', 'textarea'))) {
				showsetting('threadtype_protect', 'protectnew[status]', $option['protect']['status'], 'radio', 0, 1);
				showsetting('threadtype_protect_mode', array('protectnew[mode]', array(
					array(1, $lang['threadtype_protect_mode_pic']),
					array(2, $lang['threadtype_protect_mode_html'])
				)), $option['protect']['mode'], 'mradio');
				showsetting('threadtype_protect_usergroup', array('protectnew[usergroup][]', $groups), explode("\t", $option['protect']['usergroup']), 'mselect');
				$verifys && showsetting('threadtype_protect_verify', array('protectnew[verify][]', $verifys), explode("\t", $option['protect']['verify']), 'mselect');
				showsetting('threadtype_protect_permprompt', 'permpromptnew', $option['permprompt'], 'textarea');
			}

			showtagheader('tbody', "style_calendar", $option['type'] == 'calendar');
			showtitle('threadtype_edit_vars_type_calendar');
			showsetting('threadtype_edit_inputsize', 'rules[calendar][inputsize]', $option['rules']['inputsize'], 'text');
			showtagfooter('tbody');

			showtagheader('tbody', "style_number", $option['type'] == 'number');
			showtitle('threadtype_edit_vars_type_number');
			showsetting('threadtype_edit_maxnum', 'rules[number][maxnum]', $option['rules']['maxnum'], 'text');
			showsetting('threadtype_edit_minnum', 'rules[number][minnum]', $option['rules']['minnum'], 'text');
			showsetting('threadtype_edit_inputsize', 'rules[number][inputsize]', $option['rules']['inputsize'], 'text');
			showsetting('threadtype_defaultvalue', 'rules[number][defaultvalue]', $option['rules']['defaultvalue'], 'text');
			showtagfooter('tbody');

			showtagheader('tbody', "style_text", $option['type'] == 'text');
			showtitle('threadtype_edit_vars_type_text');
			showsetting('threadtype_edit_textmax', 'rules[text][maxlength]', $option['rules']['maxlength'], 'text');
			showsetting('threadtype_edit_inputsize', 'rules[text][inputsize]', $option['rules']['inputsize'], 'text');
			showsetting('threadtype_edit_profile', '', '', $threadtype_profile);
			showsetting('threadtype_defaultvalue', 'rules[text][defaultvalue]', $option['rules']['defaultvalue'], 'text');
			showtagfooter('tbody');

			showtagheader('tbody', "style_textarea", $option['type'] == 'textarea');
			showtitle('threadtype_edit_vars_type_textarea');
			showsetting('threadtype_edit_textmax', 'rules[textarea][maxlength]', $option['rules']['maxlength'], 'text');
			showsetting('threadtype_edit_colsize', 'rules[textarea][colsize]', $option['rules']['colsize'], 'text');
			showsetting('threadtype_edit_rowsize', 'rules[textarea][rowsize]', $option['rules']['rowsize'], 'text');
			showsetting('threadtype_defaultvalue', 'rules[textarea][defaultvalue]', $option['rules']['defaultvalue'], 'text');
			showtagfooter('tbody');

			showtagheader('tbody', "style_select", $option['type'] == 'select');
			showtitle('threadtype_edit_vars_type_select');
			showsetting('threadtype_edit_select_choices', 'rules[select][choices]', $option['rules']['choices'], 'textarea');
			showsetting('threadtype_edit_inputsize', 'rules[select][inputsize]', $option['rules']['inputsize'], 'text');
			showtagfooter('tbody');

			showtagheader('tbody', "style_radio", $option['type'] == 'radio');
			showtitle('threadtype_edit_vars_type_radio');
			showsetting('threadtype_edit_choices', 'rules[radio][choices]', $option['rules']['choices'], 'textarea');
			showtagfooter('tbody');

			showtagheader('tbody', "style_checkbox", $option['type'] == 'checkbox');
			showtitle('threadtype_edit_vars_type_checkbox');
			showsetting('threadtype_edit_choices', 'rules[checkbox][choices]', $option['rules']['choices'], 'textarea');
			showtagfooter('tbody');

			showtagheader('tbody', "style_image", $option['type'] == 'image');
			showtitle('threadtype_edit_vars_type_image');
			showsetting('threadtype_edit_images_weight', 'rules[image][maxwidth]', $option['rules']['maxwidth'], 'text');
			showsetting('threadtype_edit_images_height', 'rules[image][maxheight]', $option['rules']['maxheight'], 'text');
			showsetting('threadtype_edit_inputsize', 'rules[image][inputsize]', $option['rules']['inputsize'], 'text');
			showtagfooter('tbody');

			showtagheader('tbody', "style_range", $option['type'] == 'range');
			showtitle('threadtype_edit_vars_type_range');
			showsetting('threadtype_edit_maxnum', 'rules[range][maxnum]', $option['rules']['maxnum'], 'text');
			showsetting('threadtype_edit_minnum', 'rules[range][minnum]', $option['rules']['minnum'], 'text');
			showsetting('threadtype_edit_inputsize', 'rules[range][inputsize]', $option['rules']['inputsize'], 'text');
			showsetting('threadtype_edit_searchtxt', 'rules[range][searchtxt]', $option['rules']['searchtxt'], 'text');
			showtagfooter('tbody');

			showtagheader('tbody', "style_baidu", $option['type'] == 'baidu');
			showtitle('threadtype_edit_vars_type_range');
			showsetting('threadtype_edit_maxnum', 'rules[range][maxnum]', $option['rules']['maxnum'], 'text');
			showsetting('threadtype_edit_minnum', 'rules[range][minnum]', $option['rules']['minnum'], 'text');
			showsetting('threadtype_edit_inputsize', 'rules[range][inputsize]', $option['rules']['inputsize'], 'text');
			showsetting('threadtype_edit_searchtxt', 'rules[range][searchtxt]', $option['rules']['searchtxt'], 'text');
			showtagfooter('tbody');

			showtagheader('tbody', "style_editarea", $option['type'] == 'editarea');
			showtitle('threadtype_edit_vars_type_editarea');
			showsetting(lang('plugin/wxq123','option_editarea_cols'), 'rules[editarea][cols]', $option['editarea']['cols'], 'text');
			showsetting('threadtype_edit_minnum', 'rules[range][minnum]', $option['rules']['minnum'], 'text');
			showsetting('threadtype_edit_inputsize', 'rules[range][inputsize]', $option['rules']['inputsize'], 'text');
			showsetting('threadtype_edit_searchtxt', 'rules[range][searchtxt]', $option['rules']['searchtxt'], 'text');
			showtagfooter('tbody');

			showtagheader('tbody', "style_district", $option['type'] == 'district');
			showtitle('threadtype_edit_vars_type_district');
			showsetting('threadtype_edit_maxnum', 'rules[range][maxnum]', $option['rules']['maxnum'], 'text');
			showsetting('threadtype_edit_minnum', 'rules[range][minnum]', $option['rules']['minnum'], 'text');
			showsetting('threadtype_edit_inputsize', 'rules[range][inputsize]', $option['rules']['inputsize'], 'text');
			showsetting('threadtype_edit_searchtxt', 'rules[range][searchtxt]', $option['rules']['searchtxt'], 'text');
			showtagfooter('tbody');

			showsubmit('editsubmit');
			showtablefooter();
			showformfooter();

		} else {

			$titlenew = trim($_GET['titlenew']);
			$_GET['identifiernew'] = trim($_GET['identifiernew']);
			if(!$titlenew || !$_GET['identifiernew']) {
				cpmsg('threadtype_infotypes_option_invalid', '', 'error');
			}

			if(in_array(strtoupper($_GET['identifiernew']), $mysql_keywords)) {
				cpmsg('threadtype_infotypes_optionvariable_iskeyword', '', 'error');
			}

			if(DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_typeoption')." WHERE identifier='".$_GET['identifiernew']."'".($optionid?" and optionid <> $optionid":""))>0 || strlen($_GET['identifiernew']) > 40  || !ispluginkey($_GET['identifiernew'])) {
				cpmsg('threadtype_infotypes_optionvariable_invalid', '', 'error');
			}

			$_GET['protectnew']['usergroup'] = $_GET['protectnew']['usergroup'] ? implode("\t", $_GET['protectnew']['usergroup']) : '';
			$_GET['protectnew']['verify'] = $_GET['protectnew']['verify'] ? implode("\t", $_GET['protectnew']['verify']) : '';

			$data = array(
				'title' => $titlenew,
				'description' => $_GET['descriptionnew'],
				'identifier' => $_GET['identifiernew'],
				'type' => $_GET['typenew'],
				'unit' => $_GET['unitnew'],
				'expiration' => $_GET['expirationnew'],
				'protect' => serialize($_GET['protectnew']),
				'rules' => serialize($_GET['rules'][$_GET['typenew']]),
				'permprompt' => $_GET['permpromptnew'],
				'display' => $_GET['displaynew'],
				'system' => $_GET['systemnew'],
			);
			DB::update('wxq123_typeoption',$data,array('optionid'=>$optionid));
			cpmsg('threadtype_infotypes_option_succeed', 'action=plugins&identifier=wxq123&pmod=wxqoption&classid='.$option['classid'], 'succeed');
		}
	}else{
		if(!submitcheck('submit')) {
			$classid = getgpc('classid');
			$classid_text = '<select name="classid" id="classid" onchange="window.location.href=\''.ADMINSCRIPT.'?action=plugins&identifier=wxq123&pmod=wxqoption&classid=\'+this.form.classid.value">';
			$query = DB::query("SELECT * FROM ".DB::table('wxq123_typeoption')." WHERE classid = 0 order by displayorder asc");
			while($row = DB::fetch($query)) {
				$classid = $classid ? $classid : $row['optionid'];
				$classid_text .= '<option value="'.$row['optionid'].'" '.($classid == $row['optionid'] ? ' selected' : '').' >'.$row['title'].'</option>';
			}
			$classid_text .= '</select>';
			showtips(lang('plugin/wxq123','option_list_tips'));
			showformheader("plugins&identifier=wxq123&pmod=wxqoption");
			showtableheader($classid_text.lang('plugin/wxq123','option_list'));
			showsubtitle(array('', 'display_order', 'name', 'threadtype_variable', 'threadtype_type', lang('plugin/wxq123','option_system'),lang('plugin/wxq123','option_display'),''));
			$query = DB::query("SELECT * FROM ".DB::table('wxq123_typeoption')." WHERE classid=".$classid." order by displayorder asc");
			while($row = DB::fetch($query)) {
				showtablerow('', array('class="td25"', 'class="td28"'), array(
						"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[optionid]\" ".($row['system'] ? 'disabled' : '').">",
						"<input type=\"text\" class=\"txt\" size=\"2\" name=\"displayorder[$row[optionid]]\" value=\"$row[displayorder]\">",
						"<input type=\"text\" class=\"txt\" size=\"15\" name=\"title[$row[optionid]]\" value=\"".dhtmlspecialchars($row['title'])."\">",
						"$row[identifier]<input type=\"hidden\" name=\"wxqidentifier[$row[optionid]]\" value=\"$row[identifier]\">",
						$row['type'],
						"<input class=\"checkbox\" type=\"checkbox\" name=\"wxqsystem[$row[optionid]]\" value=\"1\" ".($row['system'] ? 'checked' : '').">",
						"<input class=\"checkbox\" type=\"checkbox\" name=\"wxqdisplay[$row[optionid]]\" value=\"1\" ".($row['display'] ? 'checked' : '').">",
						"<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=wxqoption&optionid=$row[optionid]\" class=\"act\">$lang[detail]</a>"
					));
			}
			echo '<tr><td></td><td colspan="7"><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.$lang['threadtype_infotypes_add_option'].'</a></div></td></tr>';
			showsubmit('submit', 'submit', 'del');
			showtablefooter();
			showformfooter();
			echo <<<EOT
	<script type="text/JavaScript">
		var rowtypedata = [
			[
				[1, '', 'td25'],
				[1, '<input type="text" class="txt" size="2" name="newdisplayorder[]" value="0">', 'td28'],
				[1, '<input type="text" class="txt" size="15" name="newtitle[]">'],
				[1, '<input type="text" class="txt" size="15" name="newidentifier[]">'],
				[1, '<select name="newtype[]"><option value="number">$lang[threadtype_edit_vars_type_number]</option><option value="text" selected>$lang[threadtype_edit_vars_type_text]</option><option value="textarea">$lang[threadtype_edit_vars_type_textarea]</option><option value="radio">$lang[threadtype_edit_vars_type_radio]</option><option value="checkbox">$lang[threadtype_edit_vars_type_checkbox]</option><option value="select">$lang[threadtype_edit_vars_type_select]</option><option value="calendar">$lang[threadtype_edit_vars_type_calendar]</option><option value="email">$lang[threadtype_edit_vars_type_email]</option><option value="image">$lang[threadtype_edit_vars_type_image]</option><option value="url">$lang[threadtype_edit_vars_type_url]</option><option value="range">$lang[threadtype_edit_vars_type_range]</option><option value="baidu">$lang[threadtype_edit_vars_type_baidu]</option><option value="baidu">$lang[threadtype_edit_vars_type_editarea]</option><option value="baidu">$lang[threadtype_edit_vars_type_district]</option></select>'],
				[3, '']
			],
		];
	</script>
	EOT;
		}else{
			if($ids = $_GET['delete']) {
				$ids = dintval($ids, is_array($ids) ? true : false);
				if($ids) {
					DB::delete('wxq123_typeoption',DB::field('optionid', $ids));
				}
			}
			if(is_array($_GET['title'])) {
				foreach($_GET['title'] as $id => $val) {
					if(in_array(strtoupper($_GET['wxqidentifier'][$id]), $mysql_keywords)) {
						continue;
					}
					DB::update('wxq123_typeoption',array(
						'displayorder' => $_GET['displayorder'][$id],
						'title' => $_GET['title'][$id],
						'identifier' => $_GET['wxqidentifier'][$id],
						'system' => $_GET['wxqsystem'][$id],
						'display' => $_GET['wxqdisplay'][$id],
					),array('optionid'=>$id));
				}
			}

			if(is_array($_GET['newtitle'])) {
				foreach($_GET['newtitle'] as $key => $value) {
					$newtitle1 = dhtmlspecialchars(trim($value));
					$newidentifier1 = trim($_GET['newidentifier'][$key]);
					if($newtitle1 && $newidentifier1) {
						if(in_array(strtoupper($newidentifier1), $mysql_keywords)) {
							cpmsg('threadtype_infotypes_optionvariable_iskeyword', '', 'error');
						}
						if(DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_typeoption')." WHERE identifier='".$newidentifier1."'".($optionid?" and optionid <> $optionid":""))>0 || strlen($newidentifier1) > 40  || !ispluginkey($newidentifier1)) {
							cpmsg('threadtype_infotypes_optionvariable_invalid', '', 'error');
						}
						$data = array(
							'classid' => $_GET['classid'],
							'displayorder' => $_GET['newdisplayorder'][$key],
							'title' => $newtitle1,
							'identifier' => $newidentifier1,
							'type' => $_GET['newtype'][$key],
						);
						DB::insert('wxq123_typeoption',$data);
					} elseif($newtitle1 && !$newidentifier1) {
						cpmsg('threadtype_infotypes_option_invalid', 'action=plugins&identifier=wxq123&pmod=wxqoption&classid='.$_GET['classid'], 'error');
					}
				}
			}
			cpmsg('threadtype_infotypes_succeed', 'action=plugins&identifier=wxq123&pmod=wxqoption&classid='.$_GET['classid'], 'succeed');
		}
	}




?>