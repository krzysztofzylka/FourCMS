<?php
return new class(){
	public function __construct(){
		if(!core::$module['account']->checkPermission('service'))
			header('location: index.php?page=404');
		if(!core::$module['account']->checkPermission('service_library'))
			header('location: index.php?page=404');
		core::loadView('fourframework_library');
	}
}
?>