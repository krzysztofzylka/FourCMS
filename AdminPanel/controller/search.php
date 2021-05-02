<?php
return new class() extends core_controller {
	public function __construct() {
		core::setError();

		$this->view();
	}

	public function view() {
		core::setError();

		$search = isset($_GET['searchMenu']) ? ($_GET['searchMenu'] == '' ? ' ' : $_GET['searchMenu']) : ' ';
		$searchArray = include('../file/search.php');

		$this->viewSetVariable('search', $search);
		$this->viewSetVariable('searchArray', $searchArray);
		$this->loadView('search');
	}
};