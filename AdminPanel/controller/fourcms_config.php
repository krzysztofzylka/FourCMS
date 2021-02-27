<?php
return new class(){
	public function __construct(){
        if(!core::$module['account']->checkPermission('option_editConfig'))
			header('location: 404.html');
        if(isset($_POST['config_save'])){
            unset($_POST['config_save']);
            foreach($_POST as $name => $value)
                core::$model['config']->write($name, $value);
        }
        core::loadView('fourcms_configList');
    }
}
?>