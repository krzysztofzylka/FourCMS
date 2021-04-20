<?php
return new class() extends core_controller{
	public function __construct(){
        $this->loadModel('Interpreter');

        if (isset($_GET['post'])) {
            core::loadController('post');
        } elseif(isset($_GET['module'])) {
            $interpreter = $this->Interpreter->loadScript('module/'.htmlspecialchars($_GET['module']));
            $this->view($interpreter);
            return;
        } else {
            $interpreter = $this->Interpreter->loadScript(core::$model->Config->read('mainPage'));
            $this->view($interpreter);
            return;
        }
    }
    public function view($interpreter){
        if (is_array($interpreter)) {
            switch($interpreter[0]){
                case 'controller':
                    core::loadController($interpreter[1]);
                    break;
            }
            return;
        } else {
            core::loadController('404');
            return;
        }
    }
}
?>