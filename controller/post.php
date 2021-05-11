<?php
return new class() extends core_controller {
	public function __construct() {
		$this->loadModel('Post');
		$this->loadModel('Protect');
		$this->loadModel('Interpreter');
		$this->view();
	}

	public function view() {
		if (isset($_GET['post'])) {
			$id = $this->Protect->protectID($_GET['post']);
			$post = $this->Post->read($id);

			if (!$post) {
				return core::loadController('404');
			} elseif ($post['type'] == "post") {
				$this->viewSetVariable('post', $post);
				$this->loadView('post');
			} else {
				$interpreter = $this->Interpreter->loadScript($post['type']);
				switch ($interpreter[0]) {
					case 'module':
						$GLOBALS['interpreter'] = $interpreter;
						core::loadController('module');
						break;
				}
			}
		} else {
			$posts = $this->Post->list();
			$this->viewSetVariable('posts', $posts);
			$this->loadView('posts');
		}

		return false;
	}
};