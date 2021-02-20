<?php
return new class(){
	public function __construct(){
        if(!core::$module['account']->checkPermission('option_users'))
			header('location: index.php?page=404');
		core::loadView('fourcms_users');
	}
}
?>