<?php
return new class(){
	public function __construct(){
        if(!core::$module['account']->checkPermission('option_users'))
			header('location: 404.html');
		core::loadView('fourcms_users');
	}
}
?>