<?php
return new class() extends core_controller{
	public function __construct() {
		core::setError();

		$this->loadModel('Widget');

		$this->view();
	}
	public function view() {
		$userWidgetsArray = [];
		$userWidgets = $this->Widget->getUserWidget(core::$module->account->userData['id']);

		foreach ($userWidgets as $widget) {
			if (isset($this->Widget->widgetList[$widget['uniqueIDWidget']])) {
				$widgetData = $this->Widget->widgetList[$widget['uniqueIDWidget']];
				
				if (file_exists($widgetData['widgetPath'])) {
					ob_start();
					include($widgetData['widgetPath']);
					$userWidgetsArray[] = ob_get_contents();
					ob_end_clean();
				}
			} else {
				//TODO: Usunięcie z bazy danych starych widgetów które już nie istnieją
			}
		}

		$this->viewSetVariable('userWidgetsArray', $userWidgetsArray);
		$this->loadView('main_panel');
	}
}
?>