<?php
return new class(){
	public function __construct(){
		if(!core::$module['account']->checkPermission('menu'))
			header('location: 404.html');
		if(isset($_GET['type'])){
			switch ($_GET['type']){
				case 'add':
					if(isset($_POST['name'])){
						if(strlen($_POST['name']) >= 3){
							core::$model['menu']->topMenu_create($_POST['name'], $_POST['link']);
							core::$model['gui']->showAlert(!core::$isError, 'Poprawnie dodano menu', 'Błąd dodania menu'); //show info
							core::loadView('menu');
						}else
							core::$model['gui']->alert('Nazwa musi posiadać przynajmniej 3 znaki', 'danger');
					}else
						core::loadView('menu_edit');
					break;
				case 'delete':
					core::$model['menu']->topMenu_delete((int)$_GET['id']);
					core::$model['gui']->showAlert(!core::$isError, 'Poprawnie usunięto element', 'Błąd usuwanięcia elementu'); //show info
					core::loadView('menu');
					break;
				case 'edit':
					$id = core::$model['protect']->protectID($_GET['id']);
					if(isset($_POST['name'])){
						if(strlen($_POST['name']) >= 3){
							core::$model['menu']->topMenu_write($id, $_POST['name'], $_POST['link']);
							core::$model['gui']->showAlert(!core::$isError, 'Poprawnie zapisano zmiany', 'Błąd aktualizacji menu'); //show info
						}else
							core::$model['gui']->alert('Nazwa musi posiadać przynajmniej 3 znaki', 'danger');
					}
					core::loadView('menu_edit');
					break;
				case 'positionUp':
					core::$model['menu']->topMenu_positionUp((int)$_GET['id']);
					core::loadView('menu');
					break;
				case 'positionDown':
					core::$model['menu']->topMenu_positionDown((int)$_GET['id']);
					core::loadView('menu');
					break;
				default:
					core::loadView('menu');
					break;
			}
		}else
			core::loadView('menu');
	}
}
?>