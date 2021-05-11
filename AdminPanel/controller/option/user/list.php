<?php
return new class() extends app_controller {
	public function __construct() {
		core::setError();

		$this->loadModel('Permission');
		$this->loadModel('GuiHelper');

		if (!core::$module->account->checkPermission('option_users')) {
			header('location: 404.html');
		}
	}

	public function view() {
		core::setError();

		$permissionDataList = [];
		foreach ($this->Permission->list() as $item) {
			$permissionData = '';

			foreach ($item['permission'] as $name) {
				$perm = $this->Permission->getPerm($name);
				$permissionData .= ($permissionData !== '' ? ', ' : '') . $perm['name'];
			}

			$permissionDataList[$item['id']] = $permissionData;
		}

		$this->viewSetVariable('permissionDataList', $permissionDataList);
		$this->viewSetVariable('userList', core::$module->account->getUserList());
		$this->loadView('option.user.list');
	}

	public function blockUser(int $id) {
		core::setError();

		if (!core::$module->account->checkPermission('blockUser')) {
			$this->response('Nie posiadasz uprawnień do zablokowania użytkownika', 'ERR');
		} elseif ($id === 1) {
			$this->response('Nie można zablokować konta administratora', 'ERR');
		} else {
			$block = core::$module->account->blockUser($id);

			if ($block) {
				$this->response('Zablokowano użytkownika', 'OK');
			} else {
				$this->response('Nie udało się zablokować użytkownika', 'ERR');
			}
		}
	}

	public function unBlock(int $id) {
		core::setError();

		if (!core::$module->account->checkPermission('blockUser')) {
			$this->response('Nie posiadasz uprawnień do odblokowania użytkownika', 'ERR');
		} elseif ($id === 1) {
			$this->response('Nie można odblokować konta administratora', 'ERR');
		} else {
			$unblock = core::$module->account->unblockUser($id);

			if ($unblock) {
				$this->response('Odblokowano użytkownika', 'OK');
			} else {
				$this->response('Nie udało się odblokować użytkownika', 'ERR');
			}
		}
	}
};