<?php
switch(core::$model->CMSInstaller->Config->read('version', '0.2.2 Beta')){
	case '0.2.2 Beta':
		core::$model->CMSInstaller->CMSInstaller('0.2.3 Beta');
		core::$model->CMSInstaller->execSQLFile('update023beta');
		echo '<div class="alert alert-secondary">Zaktualizowano do wersji 0.2.3 Beta</div>';
	case '0.2.3 Beta':
		core::$model->CMSInstaller->CMSInstaller('0.2.4 Beta');
		core::$model->CMSInstaller->execSQLFile('update024beta');
		echo '<div class="alert alert-secondary">Zaktualizowano do wersji 0.2.4 Beta</div>';
	case '0.2.4 Beta':
		core::$model->CMSInstaller->CMSInstaller('0.2.5 Beta');
		core::$model->CMSInstaller->execSQLFile('update025beta');
		echo '<div class="alert alert-secondary">Zaktualizowano do wersji 0.2.5 Beta</div>';
	case '0.2.5 Beta':
		core::$model->CMSInstaller->CMSInstaller('0.2.6 Beta');
		core::$model->CMSInstaller->execSQLFile('update026beta');
		echo '<div class="alert alert-secondary">Zaktualizowano do wersji 0.2.6 Beta</div>';
	case '0.2.6 Beta':
		core::$model->CMSInstaller->CMSInstaller('0.2.7 Beta');
		core::$model->CMSInstaller->execSQLFile('update027beta');
		echo '<div class="alert alert-secondary">Zaktualizowano do wersji 0.2.7 Beta</div>';
	case '0.2.7 Beta':
		core::$model->CMSInstaller->CMSInstaller('0.2.8 Beta');
		core::$model->CMSInstaller->execSQLFile('update028beta');
		echo '<div class="alert alert-secondary">Zaktualizowano do wersji 0.2.8 Beta</div>';
	case '0.2.8 Beta':
		core::$model->CMSInstaller->CMSInstaller('0.2.9 Beta');
		core::$model->CMSInstaller->execSQLFile('update029beta');
		echo '<div class="alert alert-secondary">Zaktualizowano do wersji 0.2.9 Beta</div>';
	case '0.2.9 Beta':
		core::$model->CMSInstaller->CMSInstaller('0.3.0 Beta');
		core::$model->CMSInstaller->execSQLFile('update030beta');
		echo '<div class="alert alert-secondary">Zaktualizowano do wersji 0.3.0 Beta</div>';
}

echo '<div class="alert alert-success">Poprawnie zainstalowaco FourCMS</div>
<div class="alert alert-warning">Nie zapomnij usunąć folderu <b>install</b></div>';