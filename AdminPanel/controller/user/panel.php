<?php
return new class() extends core_controller {
	public function __construct() {
		core::setError();

		$this->loadModel('GuiHelper');
		$this->loadModel('AdminPanel.User');

		$this->formSubmit();
		$this->view();
	}

	public function view() {
		core::setError();

		$userID = isset($_GET['userID']) ? (int)$_GET['userID'] : (int)core::$module->account->userData['id'];

		if (!core::$module->account->checkPermission('otherUser') && $userID !== (int)core::$module->account->userData['id']) {
			$userID = (int)core::$module->account->userData['id'];
			$this->GuiHelper->contentAlert('Nie posiadasz uprawnień do przeglądania profili użytkowników, wyświetlony zostanie aktualny profil użytkownika.', 'warning');
		}

		$userAccount = $userID === (int)core::$module->account->userData['id'];
		$userData = core::$module->account->getData($userID);
		$userAvatar = $this->AdminPanel_User->getAvatar($userID);
		$permission = [
			'permissionUserEdit' => core::$module->account->checkPermission('permissionUserEdit'),

		];
		$userData['permissionName'] = core::$module->account->getPermissionName((int)$userData['permission']);
		$permissionList = core::$module->account->getPermissionList();

		$this->viewSetVariable('permissionList', $permissionList);
		$this->viewSetVariable('permission', $permission);
		$this->viewSetVariable('userAvatar', $userAvatar);
		$this->viewSetVariable('userAccount', $userAccount);
		$this->viewSetVariable('user', $userData);
		$this->loadView('user.panel');
	}

	public function formSubmit() {
		core::setError();

		$userID = isset($_GET['userID']) ? (int)$_GET['userID'] : (int)core::$module->account->userData['id'];
		$userAccount = $userID === (int)core::$module->account->userData['id'];
		$userData = core::$module->account->getData($userID);

		if ($userAccount) {
			if (isset($_POST['save_name'])) {
				if (strlen(htmlspecialchars($_POST['name'])) < 6) {
					$this->GuiHelper->contentAlert('Nazwa użytkownika powinna zawierać <b>przynajmniej</b> 6 znaków', 'danger');
				} else {
					$this->AdminPanel_User->changeName($userID, $_POST['name']);
					$this->GuiHelper->contentAlert('Poprawnie zmieniono nazwę użytkownika', 'success');
				}
			}

			if (isset($_POST['save_email'])) {
				if ($_POST['email'] === core::$module->account->userData['email']) {
					$this->GuiHelper->contentAlert('Taki adres e-mail jest już ustawiony', 'warning');
				} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
					$this->GuiHelper->contentAlert('Adres e-mail nie jest poprawny', 'danger');
				} else {
					$this->AdminPanel_User->changeEMail($userID, $_POST['email']);
					$this->GuiHelper->contentAlert('Poprawnie zmieniono adres E-Mail', 'success');
				}
			}
		}

		if (isset($_POST['save_permission'])) {
			if (!core::$module->account->checkPermission('permissionUserEdit')) {
				$this->GuiHelper->contentAlert('Nie posiadasz uprawnień do zmiany tej opcji', 'danger');
			} else {
				core::$module->account->setUserPermission($userData['id'], (int)$_POST['permission']);
				$this->GuiHelper->contentAlert('Poprawnie zmieniono grupę uprawnień użytkownika', 'success');
			}
		}
	}
};