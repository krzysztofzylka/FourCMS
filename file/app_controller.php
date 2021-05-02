<?php

class app_controller extends core_controller {
	public function viewJavascript() {
		$this->viewSetVariable('__controller', $_GET['page']);
		$this->viewSetVariable('__data', base64_encode(json_encode($_POST)));
		$this->viewSetVariable('__javascriptURL', core::$path['view'] . '{$__viewName}.js');
	}

	public function response(string $message, string $type = 'INFO') {
		header('Content-Type: application/json');
		die(json_encode(['message' => $message, 'type' => $type]));
	}
}