<?php
return new class() {
	public $__list = [];

	public function __get($name) {
		$path = core::$path['library'] . $name;

		if (is_file($path . '.php')) {
			$this->__list[] = $name;

			return include($path . '.php');
		} elseif (is_dir($path)) {
			$initPath = $path . '/init.php';

			if (file_exists($initPath)) {
				return include($initPath);
			}
		}

		core::setError(1, 'library file not found');
		trigger_error($name . ' library not found', E_USER_ERROR);
	}

	public function __list(array $config = []) : array {
		$return = [];
		$scanDir = array_diff(scandir(core::$path['library']), ['.', '..']);

		if (!isset($config['version'])) {
			$config['version'] = null;
		}

		foreach ($scanDir as $name) {
			$path = core::$path['library'] . $name;
			if (is_file($path)) {
				if (substr($name, strlen($name) - 4) !== '.php') {
					continue;
				}
				$libName = str_replace('.php', '', $name);
			} elseif (is_dir($path)) {
				if (!file_exists($path . '/init.php')) {
					continue;
				}
				$libName = $name;
			}

			$libVersion = $config['version'] === true ? (core::$library->{$libName}->version ?? '-') : null;

			$return[] = ['name' => $libName, 'version' => $libVersion];
		}

		return $return;
	}
};