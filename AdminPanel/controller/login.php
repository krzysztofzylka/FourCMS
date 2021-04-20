<?php
return new class() extends core_controller {
	public function __construct() {
		core::setError();

		if (isset($_POST['login']) and isset($_POST['haslo'])) {
			if (core::$module->account->loginUser($_POST['login'], $_POST['haslo'])) {
				header('location: index.html');
			} else {
				switch (core::$error['number']) {
					case 1:
						core::$module->smarty->smarty->assign('error', 'Użytkownik o takim loginie nie istnieje');
						break;
					case 2:
						core::$module->smarty->smarty->assign('error', 'Błędne hasło');
						break;
					case 3:
						core::$module->smarty->smarty->assign('error', 'Błąd SQL');
						break;
					case 4:
						core::$module->smarty->smarty->assign('error', 'Konto jest zablokowane');
						break;
					default:
						core::$module->smarty->smarty->assign('error', 'Błędne dane logowania');
						break;
				}
			}
		}
		$this->view();
	}
	public function view(){
		core::setError();
		
		core::$module->smarty->smarty->display('main/login.tpl');
	}
}
?>