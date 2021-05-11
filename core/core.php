<?php
//by Krzysztof Żyłka
//programista.vxm.pl/fourframework
class core {
	public static $isError = false;
	public static $error = [
		'number' => -1,
		'name' => null,
		'description' => '',
		'debug_backTrace' => null
	];
	public static $info = [
		'version' => '0.4.1 Alpha',
		'releaseDate' => '09.04.2021',
		'frameworkPath' => null,
		'reversion' => ''
	];
	public static $path = [
		'core' => 'core/',
		'controller' => 'controller/',
		'view' => 'view/',
		'model' => 'model/',
		'module' => 'module/',
		'base' => 'core/base/',
		'temp' => 'core/base/temp/',
		'library' => 'core/library/',
		'library_api' => 'core/library/API/',
		'log' => 'core/base/log/',
		'configuration' => 'core/configuration/'
	];
	public static $controller;
	public static $model;
	public static $module;
	public static $library;
	public static $initialize = false;
	public static $option = [
		'autoCreatePath' => true,
		'multipleModule' => false,
		'enableLocalhostHTTPS' => false,
		'moveToHttps' => false,
		'localPath' => false,
		'localIgnored' => ['library', 'library_api', 'module', 'core'],
		'localPathReversion' => '',
		'showError' => true,
		'saveError' => true,
		'showCoreError' => true,
		'saveCoreError' => true,
	];

	public static function init(array $options = []) : void {
		self::setError();
		self::$initialize = true;

		foreach ($options as $optionKey => $option) {
			if (isset(self::$option[$optionKey])) {
				self::$option[$optionKey] = $option;
			}
		}

		if (self::$option['showError']) {
			error_reporting(E_ALL);
		} else {
			error_reporting(0);
		}

		if (isset($option['moveToHttps']) && $option['moveToHttps']) {
			self::_protectHTTPS($option['enableLocalhostHTTPS']);
		}

		$debugBacktrace = debug_backtrace();

		self::$info['reversion'] = self::_createReversion(pathinfo($debugBacktrace[count($debugBacktrace) - 1]['file'])['dirname']);
		self::$info['frameworkPath'] = dirname(__DIR__) . DIRECTORY_SEPARATOR;

		foreach (self::$path as $name => $value) {
			self::$path[$name] = ((self::$option['localPath'] === true && !in_array($name, self::$option['localIgnored'])) ? self::$option['localPathReversion'] : self::$info['reversion']) . $value; //tworznie ścieżki dla zmiennej $path
			self::$path[$name] = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, self::$path[$name]);

			if (!file_exists(self::$path[$name]) && self::$option['autoCreatePath'] === true) {
				mkdir(self::$path[$name], 0700, true);
			}
		}

		if (self::$option['saveError']) {
			ini_set("log_errors", 1);
			ini_set("error_log", self::$path['log'] . 'php_error_' . date('Ym') . '.log');
		}

		self::$library = include('library.php');
		include('view.php');
		self::$controller = include('controller.php');
		self::$model = include('model.php');
		self::$module = include('module.php');
	}

	public static function setError(int $number = -1, string $name = '', $description = '') : bool {
		self::$isError = $number !== -1;
		self::$error = [
			'number' => $number,
			'name' => htmlspecialchars($name),
			'description' => is_array($description)?$description:htmlspecialchars($description),
			'debug_backTrace' => self::$isError ? debug_backtrace() : null
		];
		self::_writeCoreErrorLog();
		self::_showCoreErrorInHTML();

		return false;
	}

	public static function loadView(string $name, array $option = []) {
		self::setError();

		if (!isset($option['returnPathOnly'])) {
			$option['returnPathOnly'] = false;
		}

		$path = self::$path['view'] . str_replace('.', DIRECTORY_SEPARATOR, $name) . '.php';

		if (!file_exists($path)) {
			return self::setError(1, 'file not exists', 'file not exists in path: (' . $path . ')');
		}

		if ($option['returnPathOnly']) {
			return $path;
		}

		include($path);

		return false;
	}

	public static function loadController(string $name) {
		self::setError();

		if (array_key_exists($name, self::$controller->_list)) {
			return self::setError(3, 'the class has already been loaded');
		}

		$path = self::$path['controller'] . str_replace('.', DIRECTORY_SEPARATOR, $name) . '.php';

		if (!file_exists($path)) {
			return self::setError(1, 'file not exists', 'file not exists in path: (' . $path . ')');
		}

		$includeClass = include($path);

		if (!is_object($includeClass)) {
			return self::setError(2, 'the class is incorrect', 'the class does not return an object');
		}

		self::$controller->{str_replace('.', '__', $name)} = $includeClass;
		self::$controller->_list[] = $name;
		self::$controller->_lastLoadController = $name;

		return $includeClass;
	}

	public static function loadModel(string $modelName, array $option = []) {
		self::setError();

		if (!isset($option['returnOnly'])) {
			$option['returnOnly'] = false;
		}

		if (!isset($option['path'])) {
			$option['path'] = self::$path['model'];
		}

		if (!$option['returnOnly'] && in_array($modelName, self::$model->_list)) {
			return self::$model->{str_replace('.', '__', $modelName)};
		}

		$modelPath = $option['path'] . str_replace('.', DIRECTORY_SEPARATOR, $modelName) . '.php';

		if (!file_exists($modelPath)) {
			$modelName = explode('.', $modelName);
			$modelName[count($modelName) - 1] = lcfirst(end($modelName));
			$modelName = implode('.', $modelName);
			$modelPath = $option['path'] . str_replace('.', DIRECTORY_SEPARATOR, $modelName) . '.php';

			if (!file_exists($modelPath)) {
				trigger_error('Model <b>' . $modelName . '</b> not found', E_USER_WARNING);
				exit;
			}
		}

		if (isset($option['returnObjectPath']) && $option['returnObjectPath'] === true) {
			return $modelPath;
		}

		$modelClass = include($modelPath);

		if (!is_object($modelClass)) {
			return self::setError(2, 'The class is incorrect', 'the class does not return an object');
		}

		if (!$option['returnOnly']) {
			$modelName = explode('.', $modelName);
			$modelName[count($modelName) - 1] = ucfirst(end($modelName));
			$modelName = implode('.', $modelName);
			self::$model->{str_replace('.', '__', ucfirst($modelName))} = $modelClass;
			self::$model->_list[] = $modelName;
		}

		return $modelClass;
	}

	public static function loadModels(...$modelNames) : void {
		self::setError();

		foreach ($modelNames as $modelName) {
			self::loadModel($modelName);
		}
	}

	public static function loadModule(string $moduleName) {
		self::setError();

		if (in_array($moduleName, self::$module->_list) && self::$option['multipleModule'] === false) {
			return self::setError(1, 'The class has already been loaded');
		}

		$modulePath = self::$path['module'] . $moduleName . DIRECTORY_SEPARATOR;

		if (!file_exists($modulePath . 'config.php')) {
			return self::setError(2, 'Config file not found');
		}

		$config = include($modulePath . 'config.php');

		if (!is_array($config)) {
			return self::setError(3, 'Config file error', 'The data returned is not a table');
		}

		$config = array_merge($config, [
			'name' => $moduleName,
			'path' => $modulePath,
		]);

		$moduleClassName = $moduleName;

		if (in_array($moduleName, self::$module->_list) && self::$option['multipleModule'] === true) {
			$nameCounter = 2;
			while (true) {
				$moduleClassName = $moduleName . '_k' . $nameCounter;
				if (!in_array($moduleClassName, self::$module->_list)) {
					break;
				}
				$nameCounter++;
			}
		}

		self::$module->_config[$moduleClassName] = $config;

		if (isset($config['include']) && is_array($config['include'])) {
			foreach ($config['include'] as $includeFileName) {
				include($modulePath . $includeFileName);
			}
		}

		if (isset($config['moduleFile']) && !file_exists($modulePath . $config['moduleFile'])) {
			return self::setError(4, 'module file not found', $modulePath . $config['moduleFile']);
		}

		self::$module->_lastLoadModule = $moduleClassName;
		self::$module->$moduleClassName = include($modulePath . $config['moduleFile']);
		self::$module->_list[] = $moduleClassName;

		return self::$module->{$moduleClassName};
	}

	public static function debug(bool $show = false) : array {
		self::setError();

		$return = [
			'core' => [
				'info' => self::$info,
				'path' => self::$path,
				'option' => self::$option
			],
			'library' => self::$library,
			'controller' => self::$controller,
			'module' => self::$module,
			'model' => self::$model
		];

		if ($show) {
			if (is_object(self::$library)) {
				self::$library->debug->print_r($return);
			} else {
				var_dump($return);
			}
		}

		return $return;
	}

	private static function _protectHTTPS(bool $enableLocalhostHTTPS) : void {
		self::setError();

		$httpsOn = isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === 'on';
		$localhost = $_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1';
		$httpsURL = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

		if ($httpsOn === false && ($localhost === false || $enableLocalhostHTTPS === true)) {
			header('location: ' . $httpsURL);
		}
	}

	private static function _createReversion(string $scriptPath) {
		self::setError();

		$initFilePathExplode = explode(DIRECTORY_SEPARATOR, str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $scriptPath));
		$scriptPath = explode(DIRECTORY_SEPARATOR, str_replace(['/', '\\'], DIRECTORY_SEPARATOR, __DIR__));

		foreach ($initFilePathExplode as $id => $pathName) {
			if ($pathName === $scriptPath[$id]) {
				unset($scriptPath[$id], $initFilePathExplode[$id]);
			} else {
				break;
			}
		}

		unset($scriptPath[array_keys($scriptPath)[count($scriptPath) - 1]]);

		$reversion = str_repeat('..' . DIRECTORY_SEPARATOR, count($initFilePathExplode)) . implode(DIRECTORY_SEPARATOR, $scriptPath) . DIRECTORY_SEPARATOR;

		if ($reversion[0] === DIRECTORY_SEPARATOR) {
			$reversion = substr($reversion, 1, strlen($reversion));
		}

		while (strpos($reversion, DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR) !== false) {
			$reversion = str_replace(DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, $reversion);
		}

		return $reversion;
	}

	private static function _writeCoreErrorLog() : void {
		if (!self::$isError || self::$option['saveCoreError']) {
			return;
		}

		$description = is_array(self::$error['description']) ? json_encode(self::$error['description']) : self::$error['description'];
		$debug_backTrace = base64_encode(json_encode(self::$error['debug_backTrace']));
		$path = self::$path['log'] . 'core_error_' . date('Ymd') . '.log';
		$data = '[' . date('Y_m_d h:m:s') . '] [' . self::$error['number'] . '] [' . self::$error['name'] . '] [' . $description . '] [' . $debug_backTrace . ']' . PHP_EOL;

		file_put_contents($path, $data, FILE_APPEND);
	}

	private static function _showCoreErrorInHTML() : void {
		if (self::$option['showCoreError'] === true || !self::$isError) {
			return;
		}

		echo '<b>Core error:</b> (' . self::$error['number'] . ') [<i>' . self::$error['name'] . '</i>] ';

		if (is_array(self::$error['description'])) {
			var_dump(self::$error['description']);
		} else {
			echo self::$error['description'] . '<br />';
		}
	}
}