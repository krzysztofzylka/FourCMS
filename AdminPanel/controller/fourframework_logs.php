<?php
return new class(){
	public function __construct(){
		if(!core::$module['account']->checkPermission('service') or !core::$module['account']->checkPermission('service_logs'))
			header('location: 404.html');
		if(isset($_GET['debug']))
			core::loadView('fourframework_logDebug');
		elseif(isset($_GET['file']))
			core::loadView('fourframework_logInspect');
		elseif(isset($_GET['delete'])){
			$this->_deleteFile(basename($_GET['delete'])); //function - delete file
			core::loadView('fourframework_logList');
		}else
			core::loadView('fourframework_logList');
	}
	private function _deleteFile($file){
		$file = htmlspecialchars($file);
		$path = core::$path['log'].$file.'.log';
		if(!file_exists($path))
			core::$model['gui']->alert('Nie znaleziono takiego pliku', 'danger');
		else{
			unlink($path);
			core::$model['gui']->alert('Poprawnie usunięto plik', 'success');
		}
	}
}
?>
