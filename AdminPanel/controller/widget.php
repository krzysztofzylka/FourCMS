<?php
return new class() extends app_controller {
	public function __construct() {
		core::setError();

		$this->loadModel('Widget');
		$this->loadModel('GuiHelper');
	}

	public function view() {
		core::setError();

		$this->layout = 'dialogbox';
		$this->dialogboxTitle = 'Zarządzanie  widgetami';
		$this->dialogboxWidth = 900;
		$this->viewSetType('blankPage');
		$this->viewSetVariable('pageTitle', 'Zarządzanie  widgetami');

		$userWidget = $this->Widget->getUserWidget(core::$module->account->userData['id']);
		foreach ($userWidget as $key => $data) {
			if (!isset($this->Widget->widgetList[$data['uniqueIDWidget']])) {
				unset($userWidget[$key]);
			} else {
				$userWidget[$key]['widgetData'] = $this->Widget->widgetList[$data['uniqueIDWidget']];
			}
		}

		$this->viewSetVariable('userWidget', $userWidget);
		$this->viewSetVariable('widgetList', $this->Widget->widgetList);

		$this->loadView('widget');
	}

	public function posDown($id) {
		core::setError();

		$this->Widget->positionDown((int)$_GET['posDown'], (int)$id);

		die();
	}

	public function posUp($id) {
		core::setError();

		$this->Widget->positionUp((int)$_GET['posUp'], (int)$id);

		die();
	}

	public function delete($id) {
		core::setError();

		$delete = $this->Widget->deleteUserWidget((int)$id, (int)core::$module->account->userData['id']);

		if ($delete) {
			$this->response('Poprawnie usunięto widget', 'OK');
		} else {
			$this->response('Błąd usuwania widgetu', 'ERR');
		}
	}

	public function add($id) {
		core::setError();

		$add = $this->Widget->userAddWidget((int)core::$module->account->userData['id'], $id);

		if ($add) {
			$this->response('Poprawnie dodano widget', 'OK');
		} else {
			$this->response('Błąd dodania widgetu', 'ERR');
		}
	}
};