<?php
return new class(){
	public $defaultAvatar = 'images/userImage/defaultUser.png';

	public function changePassword(){
		core::setError();

		$haslo = htmlspecialchars($_POST['haslo']);
		$haslo2 = htmlspecialchars($_POST['haslo2']);
		$haslo2_re = htmlspecialchars($_POST['haslo2_re']);

		if (strlen($haslo2) < 6) {
			$this->GuiHelper->contentAlert('Hasło musi posiadać minimum 6 znaków', 'danger');
		} elseif($haslo2 <> $haslo2_re) {
			$this->GuiHelper->contentAlert('Podane hasła się nie zgadzają', 'danger');
		} else {
			$changePassword = core::$module->account->changePassword(core::$module->account->userData['login'], $haslo, $haslo2);

			if (core::$isError or !$changePassword) {
				switch(core::$error['number']){
					case 1:
						$this->GuiHelper->contentAlert('Nie znaleziono takiego użytkownika', 'danger');
						break;
					case 2:
						$this->GuiHelper->contentAlert('Podane hasła się nie zgadzają', 'danger');
						break;
					case 3:
						$this->GuiHelper->contentAlert('Błąd SQL', 'danger');
						break;
					default:
						$this->GuiHelper->contentAlert('Błąd zmiany hasła', 'danger');
						break;
				}
			}else
				$this->GuiHelper->contentAlert('Poprawnie zmieniono hasło', 'success');
		}
		core::setError();
	}
	public function getAvatar(int $userID=-1){
		if ($userID == -1) {
			$avatar = core::$module->account->userData['avatar'];

			if (is_null($avatar) or !file_exists($avatar)) {
				return file_exists('../'.$this->defaultAvatar)?'../'.$this->defaultAvatar:$this->defaultAvatar;
			}

			return file_exists('../'.$avatar)?'../'.$avatar:$avatar;
		} else {
			$userAvatar = core::$module->account->getData((int)$userID)['avatar'];
			
			if (is_null($userAvatar) or !file_exists($userAvatar)) {
				return file_exists('../'.$this->defaultAvatar)?'../'.$this->defaultAvatar:$this->defaultAvatar;
			}

			return file_exists('../'.$userAvatar)?'../'.$userAvatar:$userAvatar;
		}
	}
	public function changeName(int $userID=-1, string $name) : bool{
		$userID = $userID==-1?core::$module->account->userData['id']:$userID;
		$prepare = core::$library->database->prepare('UPDATE AP_user SET name=:name WHERE id='.$userID);
		$prepare->bindParam(':name', $name, PDO::PARAM_STR);
		if(!$prepare->execute()) return false;
		return true;
	}
	public function changeEMail(int $userID=-1, string $email) : bool{
		$userID = $userID==-1?core::$module->account->userData['id']:$userID;
		$prepare = core::$library->database->prepare('UPDATE AP_user SET email=:email WHERE id='.$userID);
		$prepare->bindParam(':email', $email, PDO::PARAM_STR);
		if(!$prepare->execute()) return false;
		return true;
	}
}
?>