<?php
return new class() extends core_controller {
	public function __construct() {
		core::setError();

		if (!core::$module->account->checkPermission('jumbotron')) {
			header('location: 404.html');
		}

		$this->loadModel('Jumbotron');
		$this->loadModel('GuiHelper');

		$this->saveForm();

		$this->view();
	}

	public function view() {
		core::setError();

		$this->viewSetVariable('jumbotron', $this->Jumbotron->read(true));

		$this->loadView('jumbotron');
	}

	public function saveForm() {
		core::setError();

		if (isset($_POST['jumbotronSave'])) {
			$this->Jumbotron->write($_POST['header'], (isset($_POST['show']) ? 1 : 0), $_POST['text'], $_POST['url']);
			$this->GuiHelper->contentAlert('Poprawnie zapisano telebim', 'success');
		}
	}
};