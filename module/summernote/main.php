<?php
return new class(){
	public function __construct(){
		$config = core::$module_add['summernote']['config'];
		$module_list = array_keys(core::$module_add);
		$search = array_search('smarty', $module_list);
		if($search === false) return core::setError(1, 'smarty not exists');
		$search = array_search('bootstrap', $module_list);
		if($search === false) return core::setError(1, 'bootstrap not exists');
		$summernote = '<link rel="stylesheet" href="'.$config['path'].'script/summernote-bs4.css">
		<script src="'.$config['path'].'script/summernote-bs4.js"></script>
		<script src="'.$config['path'].'script/lang/summernote-pl-PL.min.js"></script>';
		core::$module['smarty']->smarty->assign('summernote', $summernote);
	}
}
?>