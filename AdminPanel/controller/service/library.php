<?php
return new class() extends core_controller {
	public function __construct() {
		core::setError();

		if (!core::$module->account->checkPermission('service') || !core::$module->account->checkPermission('service_library')) {
			header('location: 404.html');
		}

		$this->view();
	}

	public function view() {
		$libraryList = [];
		$apiList = [];

		foreach (scandir(core::$path['library']) as $fileName) {
			if (core::$library->string->strpos($fileName, '.php') === -1) {
				continue;
			}
			$libraryName = str_replace('.php', '', $fileName);
			$libraryList[] = [
				'name' => $libraryName,
				'version' => core::$library->{$libraryName}->version
			];
		}

		foreach (scandir(core::$path['library'] . 'API/') as $fileName) {
			if (core::$library->string->strpos($fileName, '.php') === -1) {
				continue;
			}
			$apiName = str_replace('.php', '', $fileName);
			$api = core::$library->api->start($apiName);
			$libraryList[] = [
				'name' => $apiName,
				'version' => $api->version
			];
		}

		$this->viewSetVariable('libraryList', $libraryList);
		$this->viewSetVariable('apiList', $apiList);
		$this->loadView('service.library');
	}
};