<?php

$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE available=1 order by displayorder asc");
while($row = DB::fetch($query)) {
	$function_file = DISCUZ_ROOT.'source/plugin/yiqixueba/source/'.md5($row['mokuaikey'].'function').'.php';
	////////////////debug//////////////////////
	$server_mokuaiid = DB::result_first("SELECT mokuaiid FROM ".DB::table('yiqixueba_server_mokuai')." WHERE identifier='".$row['identifier']."' AND currentversion = 1");
	if($server_mokuaiid && file_exists(DISCUZ_ROOT.'source/plugin/yiqixueba/mokuai/'.$server_mokuaiid.'/function.func.php')){
		file_put_contents($function_file,file_get_contents(DISCUZ_ROOT.'source/plugin/yiqixueba/mokuai/'.$server_mokuaiid.'/function.func.php'));
	}
	////////////////debug//////////////////////
	if(file_exists($function_file)){
		require_once $function_file;
	}
}

?>