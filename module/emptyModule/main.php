<?php
return new class() extends core_module {
	public function __construct() {
		parent::__construct();

		$this->loadModuleModel('Default');

//		$this->model['Default']->printString('abcd');

		$this->viewSetType('page');
		$this->viewSetVariable('pageTitle', 'Panel administracyjny');
		$this->loadView('empty');
	}
};