<?php
return new class() extends core_controller {
	public function __construct(){
		core::setError();

		if (!core::$module->account->checkPermission('option_template')) {
			header('location: 404.html');
		}

		$this->loadModel('Template');
		$this->loadModel('Config');

		$this->submitForm();
		$this->view();
	}
	public function view() {
		core::setError();

		$this->viewSetVariable('templateList', $this->Template->templateList());
		$this->viewSetVariable('activeTemplate', $this->Config->read('template_name'));
		$this->loadView('option.template');
	}
	public function submitForm() {
		core::setError();

		if (isset($_GET['template'])) {
			core::$model['config']->write('template_name', $_GET['template']);
			core::$model['gui']->alert('Poprawnie zmieniono szablon', 'success');
		}
	}
}
?>