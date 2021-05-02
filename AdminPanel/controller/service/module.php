<?php
return new class() extends core_controller {
	public function __construct() {
		core::setError();

		if (isset($_GET['type']) and $_GET['type'] == 'adminpanel') {
			if (!core::$module->account->checkPermission('module')) {
				header('404.html');
			}
		} else {
			if (!core::$module->account->checkPermission('service')
				|| !core::$module->account->checkPermission('service_module')
			) {
				header('location: 404.html');
			}
		}

		$this->loadModel('GuiHelper');
		$this->loadModel('Module');
		$this->view();
	}

	public function view() {
		core::setError();

		if (isset($_GET['type'])) {
			switch (htmlspecialchars($_GET['type'])) {
				case 'info':
					$this->view_moduleInfo();
					break;
				case 'debug':
					$this->view_moduleDebug();
					break;
				case 'adminpanel':
					$this->view_moduleAdminPanel();
					break;
				default:
					header('location: 404.html');
					break;
			}
		} else {
			$this->view_moduleList();
		}
	}

	public function view_moduleAdminPanel() {
		core::setError();

		if (!isset($_GET['modul'])) {
			header('location: 404.html');
			return;
		}

		$moduleName = htmlspecialchars($_GET['modul']);

		ob_start();
		core::$library->module->loadAdminPanel($moduleName);
		if (core::$isError) {
			$this->viewSetType('blankPage');

			switch (core::$error['number']) {
				case 1:
					$this->GuiHelper->alert('Wybrany moduł nie posiada panelu administracyjnego', 'danger');
					break;
				default:
					$this->GuiHelper->alert('Wystąpił błąd (' . core::$error['number'] . ')', 'danger');
					break;
			}
		}
		$moduleContent = ob_get_contents();
		ob_end_clean();

		$this->viewSetVariable('moduleContent', $moduleContent);
		$this->loadView('service.moduleAdminPanel');
	}

	public function view_moduleDebug() {
		core::setError();


		$moduleName = htmlspecialchars($_GET['name']);
		$modulePath = core::$path['module'] . $moduleName . '/';
		if (!file_exists($modulePath . 'config.php')) {
			header('location: 404.html');
		}

		$this->viewSetVariable('name', $moduleName);
		$this->viewSetVariable('path', $modulePath);
		$this->loadView('service.moduleDebug');
	}

	public function view_moduleInfo() {
		core::setError();

		$moduleName = htmlspecialchars($_GET['name']);
		$modulePath = core::$path['module'] . $moduleName . '/';

		if (!file_exists($modulePath . 'config.php')) {
			header('location: 404.html');
		}

		$moduleConfig = include($modulePath . 'config.php');

		$this->viewSetVariable('name', $moduleName);
		$this->viewSetVariable('path', $modulePath);
		$this->viewSetVariable('config', $moduleConfig);
		$this->loadView('service.moduleInfo');
	}

	public function view_moduleList() {
		core::setError();

		$this->viewSetVariable('moduleList', $this->Module->fullModuleList());
		$this->loadView('service.module');
	}
};