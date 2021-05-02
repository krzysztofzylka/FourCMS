<?php
ob_start();
session_start();
include('core/core.php');
$GLOBALS['FourCMS'] = 'user';

core::init([
	'showError' => true,
	'saveError' => false,
	'showCoreError' => false,
	'saveCoreError' => false
]);
core::loadModel('Config');
core::$option['saveCoreError'] = false;

core::$library->database->connect(include('file/db_config.php'));

//front-end script and module
core::loadModule('smarty');
core::$module->smarty->smarty->setCaching(false);
core::loadModel('Template');
core::$model->Template->setSmartyDir();
core::loadModule('bootstrap');

//load model
core::loadModel('Menu');
core::loadModel('Jumbotron');

//account
core::loadModule('account');
core::$module->account->setTablePrefix('AP');
core::$module->account->defaultPermissionGroup = (int)core::$model->Config->read('defaultUserPermissionGroup', 2);

if (core::$module->account->checkUser()) {
	core::$module->account->userGetData();
}

//smarty
core::$module->smarty->smarty->assign('user_isLogged', core::$module->account->checkUser());
core::$module->smarty->smarty->assign('user', core::$module->account->userData);
core::$module->smarty->smarty->assign('menu', core::$model->Menu->read());
core::$module->smarty->smarty->assign('config', core::$model->Config->getAllConfigArray());
$jumbotron = core::$model->Jumbotron->read();

if ($jumbotron <> false) {
	core::$module->smarty->smarty->assign('jumbotron', $jumbotron);
}

ob_start();
core::loadController('main');
$dataContainer = ob_get_contents();
ob_end_clean();
core::$module->smarty->smarty->assign('dataContainer', $dataContainer);

core::$module->smarty->smarty->display('empty.tpl');