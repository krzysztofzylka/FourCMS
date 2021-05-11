<?php
return new class() extends app_controller {
	public function __construct() {
		core::setError();
	}

	public function view() {
		core::setError();

		$this->viewSetType('blankPage');

		$search = isset($_GET['searchMenu']) ? ($_GET['searchMenu'] === '' ? ' ' : $_GET['searchMenu']) : ' ';
		$searchArray = include('../file/search.php');

		foreach ($searchArray as $key => $searchData) {
			if (isset($searchData['permission']) && !$this->checkPermission($searchData['permission'])) {
				unset($searchArray[$key]);
			}
		}

		$this->layout = 'dialogbox';
		$this->dialogboxTitle = 'Wyszukiwanie frazy ' . $search;
		$this->dialogboxWidth = 900;
		$this->viewSetVariable('search', $search);
		$this->viewSetVariable('searchArray', $searchArray);
		$this->loadView('search');
	}
};