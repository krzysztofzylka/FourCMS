<?php
return new class() {
    public $templateDir = null;
    public $templateName = null;
    public $defaultTemplateDir = 'defaultBlog';
	public function __construct(){
		core::setError();
        $this->templateName = core::$model['config']->read('template_name');
        if(!file_exists('template/'.$this->templateDir))
            $this->templateName = $this->defaultTemplateDir;
        $this->templateDir = core::$library->file->repairPath('template/'.$this->templateName.'/');
    }
    public function setSmartyDir(){
        core::setError();
        core::$module['smarty']->setTemplateDir($this->templateDir);
    }
    public function templateList(){
        core::setError();
        $return = [];
        foreach(scandir('../template/') as $dir){
            $path = core::$library->file->repairPath('../template/'.$dir.'/');
            if(file_exists($path.'template.php')){
                $include = include($path.'template.php');
                if(is_array($include)){
                    $return[] = [
                        'name' => isset($include['name'])?$include['name']:$dir,
                        'description' => isset($include['description'])?$include['description']:'',
                        'image' => isset($include['image'])?$path.$include['image']:'',
                        'templateName' => $dir
                    ];
                }
            }
        }
        return $return;
    }
};
?>