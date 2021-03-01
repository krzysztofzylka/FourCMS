<?php
return new class(){
	public function __construct(){
		core::setError();
        if(!core::$module['account']->checkPermission('option_users'))
			header('location: 404.html');
		core::loadView('option.user.list');
	}
}
?>