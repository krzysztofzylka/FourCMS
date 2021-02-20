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
};
?>