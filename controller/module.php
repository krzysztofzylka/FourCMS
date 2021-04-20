<?php
return new class() extends core_controller{
	public function __construct(){
        $interpreter = $GLOBALS['interpreter'];
        $moduleConfig = core::$library->module->getConfig($interpreter[2][0], true);
        
        if(!isset($moduleConfig['fourCMS']['displayPage'][$interpreter[2][1]]['path'])){
            return core::loadController('404');
        }
        
        $moduleConfigDisplay = $moduleConfig['fourCMS']['displayPage'][$interpreter[2][1]]['path'];
        $displayPath = $moduleConfig['path'].$moduleConfigDisplay;
        
        if (!file_exists($displayPath)) {
            return core::loadController('404');
        }

        include($displayPath);
    }
}
?>