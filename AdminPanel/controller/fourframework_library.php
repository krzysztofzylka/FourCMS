<?php
return new class(){
	public function __construct(){
		if(!core::$module['account']->checkPermission('service') or !core::$module['account']->checkPermission('service_library'))
			header('location: 404.html');
		core::loadView('fourframework_library');
	}
}
?>