<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subop=') ? $this_page = substr($this_page,0,stripos($this_page,'subop=')-1) : $this_page;

$subop = getgpc('subop');
$subops = array('mokuailist','install','update','uninstall');
$subop = in_array($subop,$subops) ? $subop : $subops[0];

$mokuaiid = getgpc('mokuaiid');
$mokuai_array = api_indata('mokuaiinfo',array());


if($subop == 'mokuailist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/'.$plugin['identifier'],'mokuai_list_tips'));
		showformheader($this_page.'&subop=mokuailist');
		showtableheader(lang('plugin/'.$plugin['identifier'],'mokuai_list'));
		foreach($mokuai_array as $k=>$row ){
			showtablerow('', array('style="width:45px"', 'valign="top" style="width:320px"', 'valign="top"', 'align="right" valign="top" style="width:200px"'), array(
				$row['ico'] ?'<img src="'.$row['ico'].'" width="40" height="40" align="left" style="margin-right:5px" />' : '<img src="'.cloudaddons_pluginlogo_url('yiqixueba_'.$row['identifier']).'" onerror="this.src=\'static/image/admincp/plugin_logo.png\';this.onerror=null" width="40" height="40" align="left" />',
				'<span class="bold">'.$row['name'].'-'.$row['version'].'</span>  <span class="sml">('.str_replace("yiqixueba_","",$row['identifier']).')</span><br />'.$row['description'],
				lang('plugin/'.$plugin['identifier'],'price').$row['price'],
				(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_mokuai')." WHERE identifier='".$row['identifier']."'")==0 ? ("<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=install&mokuaiid=$row[mokuaiid]\" >".lang('plugin/'.$plugin['identifier'],'install')."</a>&nbsp;&nbsp;"):"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=update&mokuaiid=$row[mokuaiid]\" >".lang('plugin/'.$plugin['identifier'],'update')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=uninstall&mokuaiid=$row[mokuaiid]\" >".lang('plugin/'.$plugin['identifier'],'uninstall')."</a>")."<br /><br />".lang('plugin/'.$plugin['identifier'],'status')."<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['mokuaiid']."]\" value=\"1\" ".($row['available'] > 0 ? 'checked' : '').">&nbsp;&nbsp;".lang('plugin/'.$plugin['identifier'],'displayorder')."<INPUT type=\"text\" name=\"newdisplayorder[]\" value=\"".$row['displayorder']."\" size=\"2\">",
			));
		}
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subop == 'install'){
	$step = getgpc('step');
	$step = $step ? $step : 0;
	$install_data = api_indata('installmokuai',array('mokuaiid'=>$mokuaiid,'step'=>$step));
	var_dump($install_data);
	cpmsg($install_data['return_text'], 'action='.$this_page.$install_data['step'],$install_data['type'], array('volume' => $volume));
}elseif($subop == 'update'){
	$mokuaiid = getgpc('mokuaiid');
	unset($mokuai_array[$mokuaiid]['pluginid']);
	unset($mokuai_array[$mokuaiid]['currentversion']);
	unset($mokuai_array[$mokuaiid]['mokuaiid']);
	unset($mokuai_array[$mokuaiid]['ico']);
	unset($mokuai_array[$mokuaiid]['mokuaiinformation']);
	if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_mokuai')." WHERE identifier='".$mokuai_array[$mokuaiid]['identifier']."'")==0){
		$mokuai_array[$mokuaiid]['createtime'] = time();
		DB::insert('yiqixueba_mokuai', $mokuai_array[$mokuaiid]);
	}else{
		$mokuai_array[$mokuaiid]['updatetime'] = time();

		DB::update('yiqixueba_mokuai', $mokuai_array[$mokuaiid],array('identifier'=>$mokuai_array[$mokuaiid]['identifier']));
	}
	cpmsg(lang('plugin/'.$plugin['identifier'],'mokuai_update_succeed'), 'action='.$this_page.'&subop=mokuailist', 'succeed');
}elseif($subop == 'uninstall'){
	DB::delete('yiqixueba_mokuai',array('identifier'=>$mokuai_array[$mokuaiid]['identifier']));
	cpmsg(lang('plugin/'.$plugin['identifier'],'mokuai_update_succeed'), 'action='.$this_page.'&subop=mokuailist', 'succeed');
}

?>