<?php
return new class() extends core_controller {
	public function __construct(){
		core::setError();

		$this->view();
	}
	public function view(){
		core::setError();

		$this->viewSetType('dialogbox');
		$this->loadView('empty-modal');
	}
}
?>