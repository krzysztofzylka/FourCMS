<?php
return new class(){
	public function __construct(){
		if(isset($_GET['editID'])){
			if(!core::$module['account']->checkPermission('option_users') or !core::$module['account']->checkPermission('option_permissionEdit'))
				header('location: 404.html');
			if(isset($_POST) and isset($_POST['savePermission'])){
				if($_GET['editID'] == 1){
					core::$model['gui']->alert('Nie można edytować uprawnień Administratora', 'danger');
				}else{
					$permissionName = $_POST['permissionName'];
					unset($_POST['permissionName'], $_POST['savePermission']);
					$permission = [];
					foreach($_POST as $name => $value)
						$permission[] = $name;
					core::$model['permission']->editPerm($_GET['editID'], $permissionName, $permission);
					core::$model['gui']->alert('Poprawnie zapisano uprawnienia', 'success');
				}
				core::loadView('fourcms_permissionEdit');
			}elseif(isset($_POST) and isset($_POST['addPermission'])){
				$permissionName = $_POST['permissionName'];
				unset($_POST['permissionName'], $_POST['addPermission']);
				$permission = [];
				foreach($_POST as $name => $value)
					$permission[] = $name;
				core::$model['permission']->addPerm($permissionName, $permission);
				core::$model['gui']->alert('Poprawnie dodano uprawnienia', 'success');
				core::loadView('fourcms_permission');
			}else
				core::loadView('fourcms_permissionEdit');
		}else
			core::loadView('fourcms_permission');
	}
}
?>