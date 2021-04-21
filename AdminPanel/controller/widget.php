<?php
return new class() extends core_controller{
	public function __construct() {
        core::setError();

        $this->loadModel('Widget');
        $this->loadModel('GuiHelper');
    }
    public function view() {
        core::setError();
        
        $this->viewSetType('page');
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
	public function posDown(){
		core::setError();

		if (isset($_GET['posDown'])) {
			$this->Widget->positionDown((int)$_GET['posDown'], (int)core::$module->account->userData['id']);
		}

		$this->view();
	}
    public function posUp(){
		core::setError();

		if (isset($_GET['posUp'])) {
			$this->Widget->positionUp((int)$_GET['posUp'], (int)core::$module->account->userData['id']);
		}

		$this->view();
	}
	public function delete(){
		core::setError();

		if (isset($_GET['delete'])){
			$delete = $this->Widget->deleteUserWidget((int)$_GET['delete'], (int)core::$module->account->userData['id']);

			if ($delete) {
				$this->GuiHelper->toast('Poprawnie usunięto widget', 'success');
			} else {
				$this->GuiHelper->toast('Błąd usuwania widgetu', 'danger');
			}
		}

		$this->view();
	}
    public function add(){
		core::setError();

		if (isset($_GET['add']))  {
			$add = $this->Widget->userAddWidget(core::$module->account->userData['id'], $_GET['add']);
			if ($add) {
				$this->GuiHelper->toast('Poprawnie dodano widget', 'success');
			} else {
				$this->GuiHelper->toast('Błąd dodania widgetu', 'danger');
			}
		}

		$this->view();
    }
}
?>