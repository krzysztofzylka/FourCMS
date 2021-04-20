<?php
session_start();

echo '<script src="../script/krumo/krumo.min.js"></script>';
include('../script/krumo/class.krumo.php');

$GLOBALS['FourCMS'] = 'admin';
include('../core/core.php');
core::init([
    'localPath' => true,
    'localIgnored' => ['library', 'library_api', 'module', 'core', 'log','model'],
    'showCoreError' => true, //false!
    'saveCoreError' => false
]);

core::$library->global->createArray('permissionConfig');
core::$library->database->connect(include('../file/db_config.php'));

core::loadModel('Config');

core::loadModule('smarty');
core::$module->smarty->setTemplateDir(__DIR__.'/template/');
core::$module->smarty->smarty->setCaching(false);
core::$module->smarty->smarty->assign('title', 'FourCMS - Admin Panel');
core::$module->smarty->smarty->assign('config', core::$model->Config->getAllConfigArray());
core::loadModule('bootstrap');
core::$module->bootstrap->loadBootstrapDataTable(true);
core::$module->bootstrap->loadCustomFileInput();
core::loadModule('font-awesome');
core::loadModule('adminlte');
core::loadModule('summernote');

core::loadModule('account');
core::$module->account->setTablePrefix('AP');
core::$module->account->defaultPermissionGroup = (int)core::$model->Config->read('defaultUserPermissionGroup', 2);
if (core::$module->account->checkUser()) {
    core::$module->account->userGetData();
}

if (!core::$module->account->checkUser()) {
    core::loadController('login');
} else {
    core::loadModel('AdminPanel.Menu');
    core::loadModel('AdminPanel.User');
    core::loadModel('Permission');
    core::loadModel('Module');
    core::loadModel('GuiHelper');

    core::$module->smarty->smarty->assign('menu', core::$model->AdminPanel__Menu->loadMenu());
    core::$module->smarty->smarty->assign('user', core::$module->account->userData);
	core::$module->smarty->smarty->assign('userAvatar', core::$model->AdminPanel__User->getAvatar(-1));
	core::$module->smarty->smarty->assign('userPermission', core::$model->Permission->getFullPermissionArray());

    $page = isset($_GET['page'])?$_GET['page']:'main_panel';

    foreach (core::$model->Module->moduleConfiguratorList() as $modulePath) {
		include($modulePath);
    }

    $dataContainer = loadController($page);

    ob_end_clean();
    if (!isset($_GET['ajaxControllerLoader'])) {
		core::$module->smarty->smarty->assign('data', $dataContainer);
		core::$module->smarty->smarty->display('main/main.tpl');
	} else {
		core::$module->smarty->smarty->display('main/scriptLoader.tpl');
		echo $dataContainer;
	}
}

function loadController($page){
	ob_start();
	core::loadController($page);
	if(core::$isError && !isset($_GET['ajaxControllerLoader'])){
		echo '<div class="content pt-2">
            <div class="alert alert-danger">
                <h4 class="alert-heading">
                    Wystąpił błąd: ('.core::$error['number'].') <i>'.core::$error['name'].'</i>
                </h4>
                <i>'.core::$error['description'].'</i>
            </div>
        </div>';
	}
	$data = ob_get_contents();
	ob_end_clean();
	return $data;
}
?>