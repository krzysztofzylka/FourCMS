<?php
return new class() extends core_controller {
	public function __construct() {
		core::setError();

		$this->loadModel('Permission');
		$this->loadModel('GuiHelper');

        if (!core::$module->account->checkPermission('option_users')) {
			header('location: 404.html');
			return;
		}

		$this->form_blockUser();
		$this->form_unblockUser();

		$this->view();
	}
	public function view() {
		core::setError();

		$permissionDataList = [];
		foreach ($this->Permission->list() as $item) {
			$permissionData = '';

			foreach ($item['permission'] as $name) {
				$perm = $this->Permission->getPerm($name);
				$permissionData .= ($permissionData<>''?', ':'').$perm['name'];
			}

			$permissionDataList[$item['id']] = $permissionData;
		}

		$this->viewSetVariable('permissionDataList', $permissionDataList);
		$this->viewSetVariable('userList', core::$module->account->getUserList());
		$this->loadView('option.user.list');
	}
	public function form_blockUser() {
		core::setError();

		if (isset($_GET['blockUser'])) {
			if (!core::$module->account->checkPermission('blockUser')) {
				$this->GuiHelper->contentAlert('Nie posiadasz uprawnień do zablokowania użytkownika', 'danger');
			} elseif((int)$_GET['blockUser'] == 1) {
				$this->GuiHelper->contentAlert('Nie można zablokować konta administratora', 'warning');
			} else {
				$block = core::$module->account->blockUser((int)$_GET['blockUser']);

				if ($block) {
					$this->GuiHelper->contentAlert('Zablokowano użytkownika', 'success');
				} else {
					$this->GuiHelper->contentAlert('Nie udało się zablokować użytkownika', 'danger');
				}
			}
		}
	}
	public function form_unblockUser() {
		core::setError();

		if(isset($_GET['unblockUser'])) {
			if (!core::$module->account->checkPermission('blockUser')) {
				$this->GuiHelper->contentAlert('Nie posiadasz uprawnień do odblokowania użytkownika', 'danger');
			} elseif ((int)$_GET['unblockUser'] == 1) {
				$this->GuiHelper->contentAlert('Nie można odblokować konta administratora', 'warning');
			} else {
				$unblock = core::$module->account->unblockUser((int)$_GET['unblockUser']);

				if ($unblock) {
					$this->GuiHelper->contentAlert('Odblokowano użytkownika', 'success');
				} else {
					$this->GuiHelper->contentAlert('Nie udało się odblokować użytkownika', 'danger');
				}
			}
		}
	}
}
?>