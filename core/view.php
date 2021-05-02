<?php

class view {
	private $__viewTypeList = [
		'prepend' => [],
		'append' => []
	];
	private $__viewGuiHelper = null;
	private $__viewType = null;
	private $__viewFileName;
	private $__viewName;
	private $__viewVariable = [];

	public function __construct($__viewPath, $__viewOption = []) {
		core::setError();

		$this->__viewFileName = $__viewPath;
		$this->_loadConfiguration();
		$this->__viewName = pathinfo($__viewPath)['filename'];

		if (isset($__viewOption['controllerObject'])
			&& is_object($__viewOption['controllerObject'])
		) {
			$this->__viewVariable = $__viewOption['controllerObject']->__view['variable'];
			$this->__viewType = $__viewOption['controllerObject']->__view['viewType'] ?? null;
		}

		foreach ($this->__viewVariable as $__variableName => $__variableValue) {
			${$__variableName} = $__variableValue;
		}

		if (!is_null($this->__viewGuiHelper)) {
			$this->{$this->__viewGuiHelper} = core::loadModel(
				$this->__viewGuiHelper,
				[
					'returnOnly' => true
				]
			);
		}

		ob_start();
		echo $this->_loadViewType('prepend');
		include($this->__viewFileName);
		echo $this->_loadViewType('append');
		$__viewData = ob_get_contents();
		ob_get_clean();

		echo $__viewData;
	}

	private function _loadViewType($type) {
		core::setError();

		if ($this->__viewType <> null and isset($this->__viewTypeList[$type][$this->__viewType])) {
			header('contentType: ' . $this->__viewType);

			return $this->_pregReplaceVariable($this->__viewTypeList[$type][$this->__viewType]);
		}
		return '';
	}

	private function _loadConfiguration() {
		$configurationPath = core::$path['configuration'] . 'view.php';
		if (file_exists($configurationPath)) {
			$configuration = include($configurationPath);

			if (isset($configuration['viewType'])) {
				$this->__viewTypeList = $configuration['viewType'];
			}

			if (isset($configuration['GuiHelperModel'])) {
				$this->__viewGuiHelper = $configuration['GuiHelperModel'];
			}
		}
	}

	private function _pregReplaceVariable($string) {
		core::setError();

		return preg_replace_callback('/{\$([a-zA-Z_\-.0-9]*)([|])?(.*?)}/sm', function ($matches) {
			switch (true) {
				case isset($this->__viewVariable[$matches[1]]):
					return $this->_pregReplaceVariable($this->__viewVariable[$matches[1]]);
				case $matches[2] === '|':
					return $matches[3];
				default:
					switch ($matches[1]) {
						case '__randomGuiId':
							$this->__viewVariable[$matches[1]] = md5(uniqid(rand(), true));
							return $this->__viewVariable[$matches[1]];
						case '__viewPath':
							return $this->__viewFileName;
						case '__viewName':
							return $this->__viewName;
					}

					return $matches[0];
			}
		}, $string);
	}
}