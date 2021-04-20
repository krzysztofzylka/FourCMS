<?php
return new class() extends core_controller {
	public function __construct(){
		core::setError();

		$this->loadModel('GuiHelper');

		$this->view();
	}
	public function view(){
		core::setError();

		$this->GuiHelper->toast($_POST['text']);
	}
}
?>