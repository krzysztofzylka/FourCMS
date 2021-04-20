<?php
return new class(){
    private $config;
    public function __construct(){
        $this->config = core::$module->_config['emptyModule'];
    }
}
?>