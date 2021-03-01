<?php
return new class(){
	public function moduleList(){
		core::setError();
        $return = [];
        $moduleList = core::$library->module->moduleList(true);
        foreach($moduleList as $item){
            $config = $item['config'];
            if(!isset($config['fourCMS']['displayPage']))
                continue;
            foreach($config['fourCMS']['displayPage'] as $value => $item2)
                $return[] = ['name' => $item['name'].'-'.$value, 'title' => $item['name'].' - '.$item2['name']];
        }
        return $return;
    }
    public function moduleDisplay($moduleName, $displayName){
		core::setError();
        core::loadModule($moduleName);
        $config = core::$library->module->getConfig($moduleName);
        $configFCMS = $config['fourCMS']['displayPage'];
        if(!isset($configFCMS[$displayName]))
            header('location: index.php?page=404');
        $path = $config['path'].$configFCMS[$displayName]['path'];
        include($path);
    }
    public function moduleIncConfigList(){
        core::setError();
        $array = [];
        foreach(core::$library->module->moduleList(true) as $name => $module)
            if(isset($module['config']['fourCMS']['includeFile']))
                $array[$name] = $module['path'].$module['config']['fourCMS']['includeFile'];
        return $array;
    }
}
?>