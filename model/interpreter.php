<?php
return new class() extends core_model {
	public function __construct() {
		core::setError();

		$this->loadModel('Post');
	}

	public function loadScript(string $data) {
		core::setError();

		$data = explode('/', $data, 2);

		/* brzydkie ale potrzebne dla starszych wersji
		TODO: jakiś interpreter który podczas aktualizacji to poprawi i to nie będzie potrzebne */
		if (count($data) == 1) {
			$data = explode('-', $data[0], 2);
		}

		switch ($data[0]) {
			case 'controller':

				return $data;
			case 'post':
				$_GET['post'] = $data[1];

				return $data;
			case 'module':
				$data[2] = explode('/', $data[1], 2);

				if (count($data[2]) == 1) {
					/* brzydkie ale potrzebne dla starszych wersji
					TODO: jakiś interpreter który podczas aktualizacji to poprawi i to nie będzie potrzebne */
					$data[2] = explode('-', $data[1], 2);
					$data[2][1] = str_replace('.html', '', $data[2][1]);
				}

				return $data;
			case 'link':
				header('location: ' . $data[1]);
				break;
		}

		return false;
	}

	public function generateLink(string $data) : string {
		core::setError();

		$dataOrginal = $data;
		$data = explode('/', $data, 2);

		switch ($data[0]) {
			case 'post':
				return 'post-' . $data[1] . '.html';
			case 'module':
				return 'module-' . str_replace('/', '-', $data[1]) . '.html';
			default:
				return $dataOrginal;
		}
	}

	public function showPrettyText($data) : string {
		core::setError();

		$dataOrginal = $data;
		$data = explode('/', $data, 2);

		if (count($data) == 1) {
			$data = explode('-', $data[0], 2);
		}

		switch ($data[0]) {
			case 'post':
				$data[1] = str_replace('.html', '', $data[1]);
				$post = $this->Post->read((int)$data[1]);
				if ($post == false) {
					return '-- Nie znaleziono postu --';
				}
				$data[1] = $post['title'];

				return $data[0] . ' -> ' . $data[1];
			case 'module':
				$exp = explode('-', $data[1], 2);
				$post = core::$path['module'];
				$configPath = core::$library->file->repairPath($post . $exp[0] . '/config.php');

				if (!file_exists($configPath)) {
					$data[1] = 'Nie można znaleść pliku konfiguracyjnego modułu';
					break;
				}
				$config = include($configPath);
				$data[1] = $exp[0] . ' -> ' . $config['fourCMS']['displayPage'][str_replace('.html', '', $exp[1])]['name'];

				return $data[0] . ' -> ' . $data[1];
		}

		return $dataOrginal;
	}
};