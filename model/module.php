<?php
return new class() extends core_model {
	public function __construct() {
		core::setError();

		$this->loadModel('Config');
	}

	public function moduleDisplayPageList() : array {
		core::setError();

		$return = [];
		$moduleList = core::$library->module->moduleList(true);

		foreach ($moduleList as $item) {
			$config = $item['config'];

			if (!isset($config['fourCMS']['displayPage'])) {
				continue;
			}

			foreach ($config['fourCMS']['displayPage'] as $value => $item2) {
				$return[] = ['name' => $item['name'] . '-' . $value, 'title' => $item['name'] . ' - ' . $item2['name']];
			}
		}

		return $return;
	}

	public function moduleDisplay(string $moduleName, string $displayName) {
		core::setError();

		core::loadModule($moduleName);

		$config = core::$library->module->getConfig($moduleName);
		$configFCMS = $config['fourCMS']['displayPage'];

		if (isset($configFCMS[$displayName]['parameters'])) {
			$GLOBALS['parameters'] = $configFCMS[$displayName]['parameters'];
		}

		if (!isset($configFCMS[$displayName])) {
			header('location: index.php?page=404');
			return;
		}

		$path = $config['path'] . $configFCMS[$displayName]['path'];

		include($path);
	}

	public function moduleConfiguratorList() : array {
		core::setError();

		$array = [];

		foreach (core::$library->module->moduleList(true) as $name => $module) {
			if (isset($module['config']['fourCMS']['includeFile'])) {
				$array[$name] = $module['path'] . $module['config']['fourCMS']['includeFile'];
			}
		}

		return $array;
	}

	public function installModule(string $zipPath) : bool {
		core::setError();

		if (!file_exists($zipPath)) {
			return core::setError(1);
		}

		$tempDir = core::$path['temp'] . 'installModule' . DIRECTORY_SEPARATOR;

		if (file_exists($tempDir)) {
			return core::setError(2);
		}

		if (!extension_loaded('zip')) {
			return core::setError(3);
		}

		$zip = new ZipArchive;

		if ($zip->open($zipPath) === true) {
			$zip->extractTo($tempDir);
			$zip->close();

			if (!file_exists($tempDir . 'config.php')) {
				core::$library->file->rmdir($tempDir);
				return core::setError(5);
			}

			$config = include($tempDir . 'config.php');

			if (!isset($config['moduleDirectory'])) {
				core::$library->file->rmdir($tempDir);
				return core::setError(6);
			}

			if (!file_exists($tempDir . $config['moduleDirectory'])) {
				core::$library->file->rmdir($tempDir);
				return core::setError(7);
			}

			$modulePath = core::$path['module'] . $config['moduleDirectory'] . DIRECTORY_SEPARATOR;

			if (file_exists($modulePath)) {
				$GLOBALS['moduleConfig'] = include($modulePath . 'config.php');

				if (!file_exists($tempDir . 'update.php')) {
					core::$library->file->rmdir($tempDir);
					return core::setError(8);
				}

				$update = include($tempDir . 'update.php');

				if (!$update) {
					core::$library->file->rmdir($tempDir);
					return core::setError(10);
				}

				if (isset($config['copyDirectory']) && $config['copyDirectory']) {
					core::$library->file->rmdir($modulePath);
					core::$library->file->recurseCopy($tempDir . $config['moduleDirectory'] . DIRECTORY_SEPARATOR, $modulePath);
				}

			} else {
				if (!file_exists($tempDir . 'install.php')) {
					core::$library->file->rmdir($tempDir);
					return core::setError(9);
				}

				$install = include($tempDir . 'install.php');

				if (!$install) {
					core::$library->file->rmdir($tempDir);
					return core::setError(11);
				}

				if (isset($config['copyDirectory']) && $config['copyDirectory']) {
					core::$library->file->rmdir($modulePath);
					core::$library->file->recurseCopy($tempDir . $config['moduleDirectory'] . DIRECTORY_SEPARATOR, $modulePath);
				}

			}
			core::$library->file->rmdir($tempDir);
			return true;
		} else {
			return core::setError(4);
		}
	}

	public function API_getData($uniqueID = null, $downloadKey = null) {
		core::setError();
		$urlToModuleAPI = $this->Config->read('api_module');

		if ($urlToModuleAPI === '') {
			return core::setError(1);
		}

		$urlToModuleAPI .= is_null($uniqueID) ? '' : '?uniqueID=' . $uniqueID;
		$urlToModuleAPI .= is_null($downloadKey) ? '' : '&downloadKey=' . $downloadKey;
		$getDataFromAPI = core::$library->network->get($urlToModuleAPI);

		if (core::$isError) {
			return core::setError(2);
		}

		return json_decode($getDataFromAPI, true);
	}

	public function fullModuleList() : array {
		$scanModuleList = scandir(core::$path['module']);
		$scanModuleList = array_diff($scanModuleList, ['.', '..', '.htaccess']);
		$moduleList = [];

		foreach ($scanModuleList as $dirName) {
			$configPath = core::$path['module'] . $dirName . '/config.php';

			if (file_exists($configPath)) {
				$moduleList[] = [
					'name' => $dirName,
					'config' => include($configPath)
				];
			}
		}

		return $moduleList;
	}
};