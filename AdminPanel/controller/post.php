<?php
return new class() extends core_controller {
	public function __construct(){
		core::setError();

		$this->loadModel('GuiHelper');
		$this->loadModel('Post');
		$this->loadModel('Link');

		if (!core::$module->account->checkPermission('post')) {
			header('location: 404.html');
		}

		$this->view();
	}
	public function view() {
		core::setError();

		if (isset($_GET['id'])) {
			if (isset($_GET['type'])) {
				switch ($_GET['type']) {
					case 'delete':
						$delete = $this->Post->delete($_GET['id']);

						if ($delete) {
							$this->GuiHelper->contentAlert('Poprawnie usunięto post');
						} else {
							$this->GuiHelper->contentAlert('Błąd usuwania postu', 'danger');
						}

						$this->view_list();
						break;
					default:
						$this->view_edit();
						break;
				}
			} else {
				$this->view_edit();
			}
		} else {
			$this->view_list();
		}
	}
	public function view_list(){
		core::setError();

		$this->viewSetVariable('postList', $this->Post->list());
		$this->loadView('post.list');
	}
	public function view_edit(){
		core::setError();

		if (!isset($_GET['id'])) {
			header('location: 404.html');
		}

		$this->saveForm();

		if ($_GET['id'] != 'dodaj') {
			$post = $this->Post->read((int)$_GET['id']);

			if (!$post) {
				header('location: 404.html');
			}

			$this->viewSetVariable('post', $post);
		}

		$this->viewSetVariable('addPost', $_GET['id'] == 'dodaj' ? true : false);
		$this->loadView('post.edit');
	}
	public function saveForm(){
		if (isset($_POST['text'])) {
			if (strlen($_POST['title']) >= 3) {
				$addPost = $_GET['id'] == 'dodaj' ? true : false;
				$type = isset($_POST['type_default']) ? 'post' : $_POST['type'];
				$hidden = isset($_POST['hidden']) ? 1 : 0;
				$showMetadata = isset($_POST['showMetadata']) ? 1 : 0;

				if ($addPost) {
					$id = $this->Post->create($_POST['title'], $_POST['text'], core::$module->account->userData['id'], $_POST['url'], $type, boolval((int)$hidden), boolval((int)$showMetadata));

					if (!$id) {
						$this->GuiHelper->contentAlert('Błąd dodawania posta', 'danger');
					} else {
						header('location: postEdit-' . $id . '.html');
					}
				} else {
					$edit = $this->Post->update((int)$_GET['id'], $_POST['title'], $_POST['text'], -1, $_POST['url'], $type, boolval((int)$hidden), boolval((int)$showMetadata));

					if ($edit) {
						$this->GuiHelper->contentAlert('Poprawnie zamodyfikowano post');
					} else {
						$this->GuiHelper->contentAlert('Błąd modyfikowania posta', 'danger');
					}
				}
			} else
				core::$model['gui']->alert('Tytuł posta musi posiadać przynajmniej 3 znaki');
		}
	}
}
?>