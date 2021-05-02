<?php
return new class() extends app_controller {
	public function __construct() {
		core::setError();

		$this->loadModel('GuiHelper');

		$this->view_toast();
	}

	public function view_toast() {
		core::setError();

		echo $this->GuiHelper->ajaxLink(
			'form-modal/toast',
			'toast',
			[
				'text' => 'treść'
			]
		);
	}
};