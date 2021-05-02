<?php
return new class() {
	public $smarty;
	public $templateDir;

	public function __construct() {
		$config = core::$module->_config['smarty'];

		include($config['path'] . 'smarty/Smarty.class.php');

		$this->smarty = new Smarty;
		$this->smarty->caching = true;
		$this->smarty->cache_lifetime = 5;
		$temp = core::$path['temp'] . 'smarty/';
		$path = ['cache' => $temp . 'cache/', 'compile' => $temp . 'templates_c/'];
		$this->templateDir = core::$info['frameworkPath'] . 'template/';

		if (!file_exists($this->templateDir)) {
			mkdir($this->templateDir, 0777, true);
		}

		$protectedFile = $this->templateDir . '.htaccess';

		if (!file_exists($protectedFile)) {
			copy($config['path'] . '.htaccess', $protectedFile);
		}

		foreach ($path as $dirPath) {
			if (!file_exists($dirPath)) {
				mkdir($dirPath, 0777, true);
			}
		}

		$this->smarty->setTemplateDir($this->templateDir)
			->setCompileDir($path['compile'])
			->setCacheDir($path['cache']);
	}

	public function setTemplateDir(string $path) {
		$this->smarty->setTemplateDir($path);
	}

	public function setCaching($data = 5) : bool {
		if ($data === false) {
			$this->smarty->caching = false;
			return true;
		}

		$this->smarty->cache_lifetime = (int)$data;

		return true;
	}
};