<?php
return new class(){
	public $defaultAvatar = 'images/userImage/defaultUser.png';
	public function zmienHaslo(){
		core::setError();
		$haslo = htmlspecialchars($_POST['haslo']);
		$haslo2 = htmlspecialchars($_POST['haslo2']);
		$haslo2_re = htmlspecialchars($_POST['haslo2_re']);
		if(strlen($haslo2) < 8)
			echo '<div class="alert alert-danger" role="alert">Hasło musi posiadać minimum 8 znaków</div>';
		elseif($haslo2 <> $haslo2_re)
			echo '<div class="alert alert-danger" role="alert">Podane hasła się nie zgadzają</div>';
		else{
			core::$module['account']->changePassword(core::$module['account']->userData['login'], $haslo, $haslo2);
			if(core::$error[0] > -1){
				switch(core::$error[0]){
					case 1:
						echo '<div class="alert alert-danger" role="alert">Nie znaleziono takiego użytkownika</div>';
						break;
					case 2:
						echo '<div class="alert alert-danger" role="alert">Podane hasło się nie zgadza</div>';
						break;
					default:
						echo '<div class="alert alert-danger" role="alert">Błąd zmiany hasła</div>';
						break;
				}
			}else
				echo '<div class="alert alert-success" role="alert">Poprawnie zmieniono hasło</div>';
		}
	}
	public function getAvatar(int $userID=-1){
		if($userID == -1){
			$avatar = core::$module['account']->userData['avatar'];
			if(is_null($avatar) or !file_exists($avatar))
				return file_exists('../'.$this->defaultAvatar)?'../'.$this->defaultAvatar:$this->defaultAvatar;
			return file_exists('../'.$avatar)?'../'.$avatar:$avatar;
		}else{
			$userAvatar = core::$module['account']->getData((int)$userID)['avatar'];
			if(is_null($userAvatar) or !file_exists($userAvatar))
				return file_exists('../'.$this->defaultAvatar)?'../'.$this->defaultAvatar:$this->defaultAvatar;
			return file_exists('../'.$userAvatar)?'../'.$userAvatar:$userAvatar;
		}
	}
	public function changeName(int $userID=-1, string $name){
		$userID = $userID==-1?core::$module['account']->userData['id']:$userID;
		$prepare = core::$library->database->prepare('UPDATE AP_user SET name=:name WHERE id='.$userID);
		$prepare->bindParam(':name', $name, PDO::PARAM_STR);
		$prepare->execute();
		return true;
	}
	public function changeEMail(int $userID=-1, string $email){
		$userID = $userID==-1?core::$module['account']->userData['id']:$userID;
		$prepare = core::$library->database->prepare('UPDATE AP_user SET email=:email WHERE id='.$userID);
		$prepare->bindParam(':email', $email, PDO::PARAM_STR);
		$prepare->execute();
		return true;
	}
}
?>