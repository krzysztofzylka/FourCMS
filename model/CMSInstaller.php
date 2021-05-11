<?php
return new class() extends core_model {
	public function __construct() {
		$this->loadModel('Config');
	}

	public function setCMSVersion(string $version) {
		$this->Config->write('version', $version);
	}

	public function execSQLFile(string $file) {
		core::$library->database->exec(file_get_contents('sql/' . $file . '.sql'));
	}
};