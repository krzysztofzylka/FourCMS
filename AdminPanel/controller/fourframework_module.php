<?php
return new class(){
	public function __construct(){
		if(isset($_GET['type']) and $_GET['type'] == 'adminpanel'){
			if(!core::$module['account']->checkPermission('module'))
				header('location: index.php?page=404');
		}else{
			if(!core::$module['account']->checkPermission('service'))
				header('location: index.php?page=404');
			if(!core::$module['account']->checkPermission('service_module'))
				header('location: index.php?page=404');
		}
		if(isset($_GET['type'])){
			switch(htmlspecialchars($_GET['type'])){
				case 'info':
					if(!isset($_GET['name']))
						header('location: index.php?page=404');
					core::loadView('fourframework_moduleInfo');
					break;
				case 'debug':
					if(!isset($_GET['name']))
						header('location: index.php?page=404');
					core::loadView('fourframework_debug');
					break;
				case 'adminpanel':
					if(!isset($_GET['modul']))
						header('location: ?page=404');
					core::loadView('fourframework_moduleAdminPanel');
					break;
				default:
					header('location: index.php?page=404');
					break;
			}
		}else
			core::loadView('fourframework_module');
	}
}
?>
