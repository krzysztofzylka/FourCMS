<?php
return new class(){
	public function __construct(){
		if(!core::$module['account']->checkPermission('jumbotron'))
			header('location: index.php?page=404');
		core::loadModel('jumbotron');
		if(isset($_POST['jumbotronSave'])){
			core::$model['jumbotron']->write($_POST['header'], (isset($_POST['show'])?1:0), $_POST['text'], $_POST['url']);
			core::$model['gui']->alert('Poprawnie zapisano dane', 'success');
		}
		core::loadView('jumbotron');
	}
}
?>