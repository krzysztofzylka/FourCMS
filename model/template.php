<?php
return new class() {
	public $templateDir;
	public $templateName;
	public $defaultTemplateDir = 'defaultBlog';
	private $extendsListAdminPanel;

	public function __construct() {
		core::setError();

		$this->templateName = core::$model->Config->read('template_name');

		if (!file_exists('template/' . $this->templateDir)) {
			$this->templateName = $this->defaultTemplateDir;
		}

		$this->templateDir = core::$library->file->repairPath('template/' . $this->templateName . '/');
	}

	public function setSmartyDir() {
		core::setError();

		core::$module->smarty->setTemplateDir($this->templateDir);
	}

	public function templateList() : array {
		core::setError();

		$return = [];

		foreach (array_diff(scandir('../template/'), ['.', '..']) as $dir) {
			if (is_dir('../template/' . $dir)) {
				$path = core::$library->file->repairPath('../template/' . $dir . '/');

				if (file_exists($path . 'template.php')) {
					$include = include($path . 'template.php');

					if (is_array($include)) {
						$return[] = [
							'name' => $include['name'] ?? $dir,
							'description' => $include['description'] ?? '',
							'image' => isset($include['image']) ? $path . $include['image'] : '',
							'templateName' => $dir
						];
					}
				}
			}
		}
		return $return;
	}

	public function display($fileName) {
		core::setError();

		if (is_null($this->extendsListAdminPanel)) {
			$this->scanModuleResource();
		}

		if (isset($this->extendsListAdminPanel[$fileName])) {
			$extendsData = implode('|', $this->extendsListAdminPanel[$fileName]);
			core::$module['smarty']->smarty->addTemplateDir('../module/');
			core::$model['template']->display('extends:' . $fileName . '|' . $extendsData);
		} else {
			core::$module['smarty']->smarty->display($fileName);
		}
	}

	public function scanModuleResource() {
		core::setError();

		$extendsListAdminPanel = [];

		foreach (core::$library->module->moduleList(true) as $moduleData) {
			$modulePath = $moduleData['path'];
			$resourceTemplateDir = $modulePath . 'Resources/adminPanel/template/';

			if (file_exists($resourceTemplateDir)) {
				foreach ($this->__getDirContents($resourceTemplateDir) as $resourcePath) {
					if (!is_dir($resourcePath)) {
						$extendsListAdminPanel[str_replace($modulePath . 'Resources/adminPanel/', '', $resourcePath)][] = str_replace('../module/', '', $resourcePath);
					}
				}
			}
		}
		$this->extendsListAdminPanel = $extendsListAdminPanel;
	}

	private function __getDirContents($dir, &$results = []) {
		core::setError();

		$files = scandir($dir);

		foreach ($files as $value) {
			$path = core::$library->file->repairPath($dir . DIRECTORY_SEPARATOR . $value);

			if (!is_dir($path)) {
				$results[] = $path;
			} elseif ($value !== "." && $value !== "..") {
				$this->__getDirContents($path, $results);
				$results[] = $path;
			}
		}
		return $results;
	}
};