<?php
return new class() {
	public function __construct() {
		$config = core::$module->_config['font-awesome'];
		$search = array_search('smarty', core::$module->_list);

		if ($search === false) {
			return core::setError(1, 'smarty not exists');
		}

		$fontawesome = '<link rel="stylesheet" href="' . $config['path'] . 'script/css/all.min.css">';
		core::$module->smarty->smarty->assign('fontawesome', $fontawesome);

		return true;
	}
};