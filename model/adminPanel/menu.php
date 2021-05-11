<?php
return new class() extends core_model {
	private $load;
	private $active = [
		'url' => null,
		'fullUrl' => null
	];
	private $data;

	public function __construct() {
		core::setError();

		$this->loadModel('Config');

		$this->setActiveURL(basename($_SERVER['REDIRECT_URL'] ?? $_SERVER['SCRIPT_NAME']));
		$this->load = include('../file/adminPanel_menu.php');

		$this->loadModule();

		if ((bool)$this->Config->read('APmenu_jumbotron') === false) {
			unset($this->load['jumbotron']);
		}

		if ((bool)$this->Config->read('APmenu_serwis') === false) {
			unset($this->load['service']);
		}

		if ((bool)$this->Config->read('APmenu_menu') === false) {
			unset($this->load['menu']);
		}

		$this->load = $this->hiddenElement($this->load);
	}

	public function hiddenElement($array) {
		foreach ($array as $key => $item) {
			if (isset($item['permission']) && !core::$module->account->checkPermission($item['permission'])) {
				unset($array[$key]);
			}

			if (isset($item['menu'])) {
				$array[$key]['menu'] = $this->hiddenElement($item['menu']);
				if(empty($array[$key]['menu'])){
					unset($array[$key]);
				}
			}
		}

		return $array;
	}

	public function loadMenu($array = null) : string {
		core::setError();

		if ($array === null) {
			$array = $this->load;
		}

		foreach ($array as $item) {
			$actUrl = false;

			if (isset($item['htmlPage'])) {
				if (!is_bool(array_search($this->active['url'], $item['htmlPage']))
					or !is_bool(array_search($this->active['fullUrl'], $item['htmlPage']))
				) {
					$actUrl = true;
				}
			}

			if ($actUrl) {
				$item['class'] = 'active';
			}

			$lastGroupID = core::$library->string->generateString(15, [true, true, false, false]);
			$this->data .= '<li id="' . (isset($item['menu']) ? $lastGroupID : '') . '" class="nav-item ' . (isset($item['menu']) ? 'has-treeview' : '') . '">
						<a href="' . $item['href'] . '" class="nav-link ' . ($item['class'] ?? '') . '">
							<i class="nav-icon ' . ($item['icon'] ?? 'fas fa-circle') . '"></i>
							<p>' . $item['name'] . '</p>
							' . (isset($item['menu']) ? '<i class="right fas fa-angle-left"></i>' : '') . '
						</a>';

			if (isset($item['menu'])) {
				$this->data .= '<ul class="nav nav-treeview">';
				$this->loadMenu($item['menu']);
				$this->data .= '</ul>';
			}

			$this->data .= '</li>';
		}

		return $this->data;
	}

	public function setActiveURL($url) : void {
		core::setError();

		$urlFull = $url;

		if (!is_bool(strpos($url, '-'))) {
			$between = core::$library->string->between($url, '-', '.html');

			if (!is_null($between)) {
				$urlFull = $url;
				$url = str_replace($between, '*', $url);
			}
		}

		$this->active['url'] = $url;
		$this->active['fullUrl'] = $urlFull;
	}

	private function loadModule() {
		core::setError();

		if (!core::$module->account->checkPermission('module')) {
			return;
		}

		$search = core::$library->array->searchByKey($this->load, 'name', 'Moduły');
		$list = core::$library->module->moduleList(true);

		foreach ($list as $item) {

			if (isset($item['config']['adminPanel']['menu'])) {
				$apMenu = $item['config']['adminPanel']['menu'];
				$array = [
					'href' => 'FrameworkModuleAP-' . $item['name'] . '.html',
					'icon' => 'fas ' . $apMenu['icon'],
					'name' => $apMenu['name'],
					'htmlPage' => $apMenu['htmlPage'] ?? [],
				];

				if (isset($apMenu['permission'])) {
					$array['permission'] = $apMenu['permission'];
				}

				$this->load[$search]['menu'][] = $array;
			}

			if (!isset($item['config']['fourCMS'])) {
				continue;
			}

			$config = $item['config']['fourCMS']['menuItem'];

			$insert = [
				'href' => 'FrameworkModuleAP-' . $item['name'] . '.html',
				'name' => $config['name'],
				'icon' => $config['icon'] ?? 'fas fa-circle',
				'htmlPage' => $config['htmlPage'] ?? [],
			];

			if (isset($config['permission'])) {
				$insert['permission'] = $config['permission'];
			}

			array_splice($this->load, 4, 0, [$insert]);
		}

		if (count($this->load[$search]['menu']) === 0) {
			unset($this->load[$search]);
		}
	}
};