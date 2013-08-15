<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subop=') ? $this_page = substr($this_page,0,stripos($this_page,'subop=')-1) : $this_page;

$subop = getgpc('subop');
$subops = array('mokuailist','mokuaiedit');
$subop = in_array($subop,$subops) ? $subop : $subops[0];


$mokuai_array = api_indata('mokuaiinfo',array());
dump($mokuai_array);

if($subop == 'mokuailist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/'.$plugin['identifier'],'mokuai_list_tips'));
		showformheader($this_page.'&subop=mokuailist');
		showtableheader(lang('plugin/'.$plugin['identifier'],'mokuai_list'));
		showsubtitle(array('', lang('plugin/'.$plugin['identifier'],'mokuai_name'),lang('plugin/'.$plugin['identifier'],'mokuai_description'),lang('plugin/'.$plugin['identifier'],'mokuai_status')));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_mokuai')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			showtablerow('', array('style="width:45px"', 'valign="top" style="width:320px"', 'valign="top"', 'align="right" valign="top" style="width:200px"'), array(
				$mokuaiico ?'<img src="'.$mokuaiico.'" width="40" height="40" align="left" style="margin-right:5px" />' : '<img src="'.cloudaddons_pluginlogo_url('yiqixueba_'.$row['identifier']).'" onerror="this.src=\'static/image/admincp/plugin_logo.png\';this.onerror=null" width="40" height="40" align="left" />',
				'<span class="bold">'.$row['name'].'-'.$row['version'].'</span>  <span class="sml">('.str_replace("yiqixueba_","",$row['identifier']).')</span>'.$row['identifier'],
				$row['description'],
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=pluginlang&mokuaiid=$row[mokuaiid]\" >".lang('plugin/'.$plugin['identifier'],'pluginlang')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=shuaxin&mokuaiid=$row[mokuaiid]\" >".lang('plugin/'.$plugin['identifier'],'shuaxin')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=pagelist&mokuaiid=$row[mokuaiid]\" >".lang('plugin/'.$plugin['identifier'],'pagelist')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=mokuaiedit&mokuaiid=$row[mokuaiid]\" >".lang('plugin/'.$plugin['identifier'],'edit')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=mokuaimake&mokuaiid=$row[mokuaiid]\" >".lang('plugin/'.$plugin['identifier'],'mokuai_make')."</a><br /><br />".lang('plugin/'.$plugin['identifier'],'status')."<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['mokuaiid']."]\" value=\"1\" ".($row['available'] > 0 ? 'checked' : '').">&nbsp;&nbsp;".lang('plugin/'.$plugin['identifier'],'displayorder')."<INPUT type=\"text\" name=\"newdisplayorder[]\" value=\"".$row['displayorder']."\" size=\"2\">",
			));
		}
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subop == 'mokuaiedit'){
}

?>