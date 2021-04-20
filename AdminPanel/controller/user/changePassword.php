<?php
return new class() extends core_controller {
	public function __construct(){
        core::setError();

		$this->loadModel('AdminPanel.User');

		$this->formSubmit();

        $this->view();
    }
    public function view(){
		$this->loadView('user.changePassword');
    }
    public function formSubmit(){
		if (isset($_POST['haslo'])) {
			$this->AdminPanel_User->changePassword();
		}
    }
}
?>