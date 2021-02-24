<?php
return new class(){
	public function __construct(){
		if(!core::$module['account']->checkPermission('option_template'))
			header('location: index.php?page=404');
		if(isset($_GET['template'])){
			core::$model['config']->write('template_name', $_GET['template']);
			core::$model['gui']->alert('Poprawnie zmieniono szablon', 'success');
		}
		core::loadView('fourcms_template');
	}
}
?>