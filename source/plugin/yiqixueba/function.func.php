<?php

function get_page($submod){
	$submod_array = explode("_",$submod);
	$submod_file = DISCUZ_ROOT.'source/plugin/yiqixueba_'.$submod_array[0].'/'.$submod_array[1].'.inc.php';

	return $submod_file;
}
?>
