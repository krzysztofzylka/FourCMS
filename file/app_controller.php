<?php

class app_controller extends core_controller {
	public $dialogboxTitle = 'Dialogbox';
	public $dialogboxWidth = 'auto';
	public $dialogboxHeight = 'auto';
	public $dialogboxButton;
	public $dialogboxReload = true;
	public $pageReload = true;
	public $layout = '';

	public function loadView(string $viewName) : view {
		$dialogbox = [
			'title' => $this->dialogboxTitle,
			'width' => $this->dialogboxWidth,
			'height' => $this->dialogboxHeight,
			'button' => json_encode($this->dialogboxButton),
			'reload' => $this->dialogboxReload
		];

		echo '<script>
			viewConfig_dialogbox = "' . base64_encode(json_encode($dialogbox)) . '";
			viewConfig_layout = "' . $this->layout . '";
			viewConfig_pageReload = "' . $this->pageReload . '";
		</script>';

		return parent::loadView($viewName);
	}

	public function viewJavascript() {
		$this->viewSetVariable('__controller', $_GET['page']);
		$this->viewSetVariable('__data', base64_encode(json_encode($_POST)));
		$this->viewSetVariable('__javascriptURL', core::$path['view'] . '{$__viewName}.js');
	}

	public function response(string $message, string $type = 'INFO', bool $reloadPage = true, bool $reloadDialogbox = true) {
		ob_end_clean();
		header('Content-Type: application/json');

		die(
		json_encode(
			[
				'message' => $message,
				'type' => $type,
				'ajaxLoaderConfig' => [
					'dialogbox' => [
						'title' => $this->dialogboxTitle,
						'width' => $this->dialogboxWidth,
						'height' => $this->dialogboxHeight,
						'button' => json_encode($this->dialogboxButton),
						'reload' => $reloadDialogbox
					],
					'layout' => 'toast',
					'pageReload' => $reloadPage
				]
			]
		)
		);
	}
}