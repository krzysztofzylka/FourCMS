<?php
return new class(){
	public function __construct(){
		if(!core::$module['account']->checkPermission('post'))
			header('location: 404.html');
        if (isset($_GET['id'])) {
			$id = core::$model['protect']->protectID($_GET['id']);
            if (isset($_GET['type'])) {
                switch ($_GET['type']) {
					case 'delete':
						core::$model['gui']->showAlert(core::$model['post']->delete($id), 'Poprawnie usunięto post', 'Błąd usuwania postu'); //show info
						core::loadView('post_list');
						break;
					default:
						core::loadView('post_edit');
						break;
            	}
			}else
				core::loadView('post_edit');
        }else
			core::loadView('post_list');
		core::setError();
	}
}
?>