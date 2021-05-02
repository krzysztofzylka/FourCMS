<?php
return new class() extends core_controller {
	public function __construct() {
		core::setError();

		if (!core::$module->account->checkPermission('option_users')
			|| !core::$module->account->checkPermission('option_usersAdd')
		) {
			header('location: 404.html');
			return;
		}

		$this->loadModel('GuiHelper');
		$this->loadModel('AdminPanel.User');

		$this->submitForm();
		$this->view();
	}

	public function submitForm() {
		if (isset($_POST['addUser'])) {
			if ($_POST['password'] <> $_POST['password2']) {
				$this->GuiHelper->contentAlert('Podane hasła się nie zgadzają', 'danger');
			} elseif (strlen($_POST['password']) < 6) {
				$this->GuiHelper->contentAlert('Hasło musi posiadać przynajmniej 6 znaków', 'danger');
			} elseif (strlen($_POST['login']) < 4) {
				$this->GuiHelper->contentAlert('Login musi posiadać minimum 4 znaki', 'danger');
			} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				$this->GuiHelper->contentAlert('Niepoprawny adres e-mail', 'danger');
			} else {
				core::$module->account->createUser(htmlspecialchars($_POST['login']), htmlspecialchars($_POST['password']), htmlspecialchars($_POST['email']));

				if (core::$isError) {
					switch (core::$error[0]) {
						case 1:
							$this->GuiHelper->contentAlert('Niepoprawny adres e-mail', 'danger');
							break;
						case 2:
							$this->GuiHelper->contentAlert('Użytkownik o takim loginie już istnieje', 'danger');
							break;
						case 3:
							$this->GuiHelper->contentAlert('Błąd wykonywania polecenia', 'danger');
							break;
						default:
							$this->GuiHelper->contentAlert('Nieznany błąd o numerze ' . core::$error[0], 'danger');
							break;
					}
				} else {
					$idUser = core::$module->account->getUserID(htmlspecialchars($_POST['login']));
					$this->AdminPanel_User->changeName($idUser, $_POST['name']);
					$this->GuiHelper->contentAlert('Poprawnie dodano użytkownika', 'success');
				}
			}
		}
	}

	public function view() {
		$this->loadView('option.user.addUser');
	}
};