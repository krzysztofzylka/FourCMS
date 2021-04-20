<?php
return new class() extends core_controller {
	public function __construct() {
        core::setError();

        if (!core::$module->account->checkPermission('option_editTemplate')) {
			header('location: 404.html');
		}

		$this->loadModel('Template');
		$this->loadModel('GuiHelper');

		$this->submitForm();
		$this->view();
    }
    public function view() {
		core::setError();

		$this->viewSetVariable('templateName', $this->Template->templateName);
		$this->viewSetVariable('templateDir', $this->Template->templateDir);
		$this->viewSetVariable('templateDirSize',
			core::$library->memory->formatBytes(core::$library->file->dirSize('../' . $this->Template->templateDir)));
		$this->viewSetVariable('templateDirFileCount',
			core::$library->file->fileCount('../' . $this->Template->templateDir));
		$this->viewSetVariable('templateDirFileList',
			array_diff(scandir('../' . $this->Template->templateDir), ['.', '..']));

		if (isset($_POST['file'])) {
			$file = basename($_POST['file']);
			$fileContent = file_get_contents('../' . $this->Template->templateDir . $file);
			$this->viewSetVariable('fileEditName', $file);
			$this->viewSetVariable('fileEditContent', $fileContent);
		}

		$this->loadView('option.templateEdit');
    }
    public function submitForm() {
		core::setError();

		if (isset($_POST['createFile'])) {
			$file = basename($_POST['createFile']);
			file_put_contents('../' . $this->Template->templateDir . $file, '');
			$_POST['file'] = $file;
			$this->GuiHelper->contentAlert('Poprawnie utworzono plik', 'success');
		}

		if (isset($_POST['fileData'])) {
			$file = basename($_POST['file']);
			file_put_contents('../' . $this->Template->templateDir . $file, $_POST['fileData']);
			$this->GuiHelper->contentAlert('Poprawnie zapisano plik', 'success');
		}
    }
}
?>