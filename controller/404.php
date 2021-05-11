<?php
return new class() extends core_controller{
	public function __construct(){
        $this->loadView('404');
        $this->view->execute();
    }
};