<?php
return new class() extends core_controller {
	public function __construct(){
		core::setError();

		if(!core::$module->account->checkPermission('service')
			&& !core::$module->account->checkPermission('service_phpinfo')
		) {
			header('location: 404.html');
		}

		$this->view();
	}
	public function view() {
		core::setError();

		$this->loadView('service.phpinfo');
	}
}
?>