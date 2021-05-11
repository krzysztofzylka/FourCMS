<?php

class core_controller {
	public $__view = [
		'variable' => [],
		'viewType' => null,
	];

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

	public function loadView(string $viewName) : view {
		core::setError();

		if (isset($this->moduleConfig['pathList']['view'])) {
			$viewPath = $this->moduleConfig['pathList']['view'] . str_replace('.', '/', $viewName) . '.php';
		} else {
			$viewPath = core::loadView(
				$viewName,
				[
					'returnPathOnly' => true
				]
			);
		}

		return new view(
			$viewPath,
			[
				'controllerObject' => $this
			]
		);
	}

	public function checkPermission($permissionName) {
		return core::$module->account->checkPermission($permissionName);
	}

	public function viewSetVariable(string $variableName, $variableValue) {
		$this->__view['variable'][$variableName] = $variableValue;
	}

	public function viewSetType(string $typeName) {
		$this->__view['viewType'] = $typeName;
	}
}

return new class() {
	public $_lastLoadController;
	public $_list = [];
};