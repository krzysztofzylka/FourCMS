<?php
return new class() extends core_controller{
	public function __construct() {
        core::setError();

        $this->loadModel('Widget');
        $this->loadModel('GuiHelper');

        $this->view();
    }
    public function view() {
        core::setError();
        
        $this->viewSetType('page');
        $this->viewSetVariable('pageTitle', 'Zarządzanie  widgetami');

		if (isset($_GET['posDown'])) {
			$this->Widget->positionDown((int)$_GET['posDown'], (int)core::$module['account']->userData['id']);
		}

		if (isset($_GET['posUp'])) {
			$this->Widget->positionUp((int)$_GET['posUp'], (int)core::$module['account']->userData['id']);
		}

		if (isset($_GET['delete'])){
			$delete = $this->Widget->deleteUserWidget((int)$_GET['delete'], (int)core::$module->account->userData['id']);

			if ($delete) {
				$this->GuiHelper->contentAlert('Poprawnie usunięto widget');
			} else {
				$this->GuiHelper->contentAlert('Błąd usuwania widgetu', 'danger');
			}
		}

        if (isset($_GET['add']))  {
            $add = $this->Widget->userAddWidget(core::$module->account->userData['id'], $_GET['add']);
            if ($add) {
                $this->GuiHelper->contentAlert('Poprawnie dodano widget');
            } else {
                $this->GuiHelper->contentAlert('Błąd dodania widgetu', 'danger');
            }
        }

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
}
?>