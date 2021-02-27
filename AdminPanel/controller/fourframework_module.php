<?php
return new class(){
	public function __construct(){
		if(isset($_GET['type']) and $_GET['type'] == 'adminpanel'){
			if(!core::$module['account']->checkPermission('module'))
				header('404.html');
		}else{
			if(!core::$module['account']->checkPermission('service') or !core::$module['account']->checkPermission('service_module'))
				header('location: 404.html');
		}
		if(isset($_GET['type'])){
			switch(htmlspecialchars($_GET['type'])){
				case 'info':
					if(!isset($_GET['name']))
						header('location: 404.html');
					core::loadView('fourframework_moduleInfo');
					break;
				case 'debug':
					if(!isset($_GET['name']))
						header('location: 404.html');
					core::loadView('fourframework_debug');
					break;
				case 'adminpanel':
					if(!isset($_GET['modul']))
						header('location: 404.html');
					core::loadView('fourframework_moduleAdminPanel');
					break;
				default:
					header('location: 404.html');
					break;
			}
		}else
			core::loadView('fourframework_module');
	}
}
?>
