<?php
return new class() extends app_controller {
	public function __construct() {
		core::setError();

		$this->loadModel('GuiHelper');
	}

	public function toast() {
		core::setError();
		$this->viewJavascript();

		$this->viewSetType('dialogbox');
		$this->viewSetVariable('title', 'Tytuł DB');
		$this->loadView('empty-modal');

		$this->GuiHelper->toast($_POST['text']);

	}

	public function contentAlert() {
		core::setError();

		$this->GuiHelper->contentAlert($_POST['text']);
	}
}
?>