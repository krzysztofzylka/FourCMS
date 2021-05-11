<?php
return new class() extends core_controller {
	public function __construct() {
		core::setError();

		$this->loadModel('Permission');
		$this->loadModel('GuiHelper');

		$this->view();
	}

	public function view() {
		if (isset($_GET['editID'])) {
			if (!core::$module->account->checkPermission('option_users') || !core::$module->account->checkPermission('option_permissionEdit')) {
				header('location: 404.html');
				return;
			}

			if (isset($_POST) && isset($_POST['savePermission'])) {
				if ($_GET['editID'] === 1) {
					$this->GuiHelper->contentAlert('Nie można edytować uprawnień Administratora', 'danger');
				} else {
					$permissionName = $_POST['permissionName'];

					unset($_POST['permissionName'], $_POST['savePermission']);

					$permission = [];

					foreach ($_POST as $name => $value) {
						$permission[] = $name;
					}

					$this->Permission->editPerm($_GET['editID'], $permissionName, $permission);
					$this->GuiHelper->contentAlert('Poprawnie zapisano uprawnienia', 'success');
				}
				$this->view_edit();
			} elseif (isset($_POST) && isset($_POST['addPermission'])) {
				$permissionName = $_POST['permissionName'];

				unset($_POST['permissionName'], $_POST['addPermission']);

				$permission = [];

				foreach ($_POST as $name => $value) {
					$permission[] = $name;
				}

				$this->Permission->addPerm($permissionName, $permission);
				$this->GuiHelper->contentAlert('Poprawnie dodano uprawnienia', 'success');
				$this->view_list();
			} else {
				$this->view_edit();
			}
		} else {
			$this->view_list();
		}
	}

	public function view_edit() {
		core::setError();

		core::loadModel('Permission');

		core::loadView('option.permission.edit');
	}

	public function view_list() {
		core::setError();

		$permissionList = $this->Permission->list();

		$this->viewSetVariable('modelPermission', $this->Permission);
		$this->viewSetVariable('permissionList', $permissionList);
		$this->loadView('option.permission.list');
	}
};