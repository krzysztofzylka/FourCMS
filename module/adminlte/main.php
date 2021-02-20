<?php
return new class(){
	public function __construct(){
		$config = core::$module_add['adminlte']['config'];
		$module_list = array_keys(core::$module_add);
		$search = array_search('smarty', $module_list);
		if($search === false) 
			return core::setError(1, 'smarty not exists');
		$adminlte = '<link rel="stylesheet" href="'.$config['path'].'script/adminlte.min.css">
		<link rel="stylesheet" href="'.$config['path'].'script/ion.rangeSlider.min.css">
		<link rel="stylesheet" href="'.$config['path'].'script/bootstrap-duallistbox.min.css">
		<script src="'.$config['path'].'script/adminlte.min.js"></script>
		<script src="'.$config['path'].'script/ion.rangeSlider.min.js"></script>
		<script src="'.$config['path'].'script/jquery.bootstrap-duallistbox.min.js"></script>';
		core::$module['smarty']->smarty->assign('adminlte', $adminlte);
	}
}
?>