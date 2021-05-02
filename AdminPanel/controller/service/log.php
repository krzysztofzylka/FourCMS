<?php
return new class() extends core_controller {
	public function __construct() {
		core::setError();

		$this->loadModel('GuiHelper');
		$this->loadModel('Link');

		if (!core::$module->account->checkPermission('service')
			|| !core::$module->account->checkPermission('service_logs')
		) {
			header('location: 404.html');
		}

		$this->view();
	}

	public function view() {
		core::setError();

		if (isset($_GET['debug'])) {
			$this->view_logDebug();
		} elseif (isset($_GET['file'])) {
			$this->view_logInspect();
		} else {
			if (isset($_GET['delete'])) {
				$this->_deleteFile(basename($_GET['delete']));
			}
			core::loadView('service.logList');
		}
	}

	public function view_logInspect() {
		core::setError();

		$file = htmlspecialchars(basename($_GET['file']));
		$path = core::$path['log'] . $file . '.log';

		if (!file_exists($path)) {
			header('location: 404.html');
			return;
		}

		$coreErrorList = explode(PHP_EOL, file_get_contents($path));
		$coreErrorListUrl = [];
		foreach ($coreErrorList as $key => $data) {
			$debug = core::$library->string->between($data, '[', ']', 4);
			$coreErrorListUrl[$key] = 'logs.html?debug=' . $debug;//$this->Link->generate(['page', 'debug' => $debug]);
		}

		$this->viewSetVariable('coreErrorListUrl', $coreErrorListUrl);
		$this->viewSetVariable('coreErrorList', $coreErrorList);
		$this->viewSetVariable('path', $path);
		$this->viewSetVariable('file', $file);
		$this->loadView('service.logInspect');
	}

	public function view_logDebug() {
		core::setError();

		$this->loadView('service.logDebug');
	}

	private function _deleteFile($file) {
		core::setError();

		$file = htmlspecialchars($file);
		$path = core::$path['log'] . $file . '.log';

		if (!file_exists($path)) {
			$this->GuiHelper->contentAlert('Nie znaleziono takiego pliku', 'danger');
		} else {
			unlink($path);
			$this->GuiHelper->contentAlert('Poprawnie usunięto plik', 'success');
		}
	}
};