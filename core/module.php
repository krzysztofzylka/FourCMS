<?php

class core_module {
	public $model = [];
	private $moduleConfig;

	public function __construct() {
		$this->moduleConfig = core::$module->_config[core::$module->_lastLoadModule];
		$this->moduleConfig['pathList'] = [
			'model' => $this->moduleConfig['path'] . 'model' . DIRECTORY_SEPARATOR,
			'view' => $this->moduleConfig['path'] . 'view' . DIRECTORY_SEPARATOR,
			'controller' => $this->moduleConfig['path'] . 'controller' . DIRECTORY_SEPARATOR
		];
	}

	public function checkPermission($permissionName) {
		return core::$module->account->checkPermission($permissionName);
	}

	public function loadModel(...$modelsName) {
		core::setError();

		foreach ($modelsName as $modelName) {
			$this->{str_replace('.', '_', $modelName)} = core::loadModel(
				$modelName,
				[
					'returnOnly' => true
				]
			);
		}
	}

	public function loadModuleModel(...$modelsName) {
		core::setError();

		foreach ($modelsName as $modelName) {
			$this->model[str_replace('.', '_', $modelName)] = include($this->moduleConfig['pathList']['model'] . $modelName . '.php');
		}
	}

	public function loadModuleView(string $name) {
		core::setError();

		$path = $this->moduleConfig['pathList']['view'] . str_replace('.', DIRECTORY_SEPARATOR, $name) . '.php';

		if (!file_exists($path)) {
			return core::setError(1, 'file not exists', 'file not exists in path: (' . $path . ')');
		}

		return include($path);
	}

	public function loadModelController(string $name) {
		core::setError();

		$path = $this->moduleConfig['pathList']['controller'] . str_replace('.', DIRECTORY_SEPARATOR, $name) . '.php';

		if (!file_exists($path)) {
			return core::setError(1, 'file not exists', 'file not exists in path: (' . $path . ')');
		}

		return include($path);
	}
}

return new class() {
	public $_lastLoadModule;
	public $_list = [];
	public $_config = [];
};