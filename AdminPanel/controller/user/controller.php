<?php
return new class() extends app_controller {
	public function saveSetting() {
		core::setError();

		$this->loadModel('UserOption');

		if (isset($_POST['hiddenSearch'])) {
			$this->UserOption->write('hiddenSearch', 1);
		} else {
			$this->UserOption->write('hiddenSearch', 0);
		}

		$this->response('Poprawnie  zapisano ustawienia', 'OK');
	}
};