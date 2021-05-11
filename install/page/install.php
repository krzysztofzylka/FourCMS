<?php
core::$model->CMSInstaller->execSQLFile('install');

core::loadModule('account');
core::$module->account->setTablePrefix('AP');
core::$module->account->createUser($_POST['admin_login'], $_POST['admin_password'], 'admin@admin.pl');

file_put_contents('../file/db_config.php', '<?php return [\'type\' => \'mysql\', \'host\' => \''.$_POST['db_host'].'\', \'name\' => \''.$_POST['db_name'].'\', \'user\' => \''.$_POST['db_username'].'\', \'password\' => \''.$_POST['db_password'].'\']; ?>');

echo '<div class="alert alert-success">Poprawnie zainstalowaco FourCMS</div>
<div class="alert alert-warning">Nie zapomnij usunąć folderu <b>install</b></div>';