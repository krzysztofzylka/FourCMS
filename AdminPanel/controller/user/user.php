<?php
return new class() extends app_controller {
	public function __construct() {
		core::setError();
	}

	public function restartPassword(int $userId, bool $message = true) {
		if (!$this->checkPermission('option_userResetPassword')) {
			return $this->response('Nie masz uprawnień do resetowania hasła użytkownika', 'ERR');
		}

		if ($userId === 1) {
			return $this->response('Nie można zresetować hasła głównego administratora', 'ERR');
		}

		if ($message) {
			$this->restartPasswordDB($userId);
		} else {
			$this->generatePasswordDB($userId);
		}

		return false;
	}

	public function generatePasswordDB(int $userId) {
		$user = core::$module->account->getData($userId);

		$this->dialogboxTitle = 'Nowe hasło dla użytkownika ' . $user['login'];

		$generatePassword = core::$library->string->generateString(10, [true, true, false, false]);
		$newPassword = core::$library->crypt->hash(htmlspecialchars($generatePassword), core::$module->account->hashAlghoritm);

		$prepare = core::$module->account->dbConn->prepare('UPDATE ' . core::$module->account->dbTable['user'] . ' SET `password`=:password WHERE `id`=:id');
		$prepare->bindParam(':password', $newPassword, PDO::PARAM_STR);
		$prepare->bindParam(':id', $userId, PDO::PARAM_INT);

		if (!$prepare->execute()) {
			return $this->response('Błąd zmiany hasła', 'ERR');
		}

		$this->viewSetVariable('user', $user);
		$this->viewSetVariable('generatePassword', $generatePassword);
		$this->loadView('user.generatePassword');

		return false;
	}

	public function restartPasswordDB(int $userId) {
		$user = core::$module->account->getData($userId);
		$this->dialogboxTitle = 'Resetowanie hasła użykownika ' . $user['login'];
		$this->dialogboxWidth = 400;
		$this->dialogboxButton = [
			[
				'text' => 'Zresetuj hasło',
				'dataAjax' => 'user.user/restartPassword/' . $user['id'] . '/0'
			]
		];
		$this->viewSetVariable('user', $user);
		$this->loadView('user.resetPassword');
	}
};