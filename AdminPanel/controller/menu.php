<?php
return new class() extends core_controller {
	public function __construct() {
		core::setError();

		if (!core::$module->account->checkPermission('menu.list')) {
			header('location: 404.html');
		}

		$this->loadModel('Menu');
		$this->loadModel('Interpreter');
		$this->loadModel('GuiHelper');

		$this->view();
	}

	public function view() {
		core::setError();

		if (isset($_GET['type'])) {
			switch ($_GET['type']) {
				case 'add':
					if (isset($_POST['name'])) {
						if (strlen($_POST['name']) >= 3) {
							$add = $this->Menu->create($_POST['name'], $_POST['link']);

							if ($add) {
								$this->GuiHelper->contentAlert('Poprawnie dodano menu', 'success');
							} else {
								$this->GuiHelper->contentAlert('Błąd dodania menu', 'danger');
							}

							$this->view_list();
						} else {
							$this->GuiHelper->contentAlert('Nazwa menu musi posiadać minimum znaki', 'danger');
						}
					} else {
						$this->view_add();
					}
					break;
				case 'delete':
					$delete = $this->Menu->delete((int)$_GET['id']);

					if ($delete) {
						$this->GuiHelper->contentAlert('Poprawnie usunięto menu', 'success');
					} else {
						$this->GuiHelper->contentAlert('Błąd usuwania menu', 'danger');
					}

					$this->view_list();
					break;
				case 'edit':
					if (isset($_POST['name'])) {
						if (strlen($_POST['name']) >= 3) {
							$this->Menu->write((int)$_GET['id'], $_POST['name'], $_POST['link']);

							if (core::$isError) {
								$this->GuiHelper->contentAlert('Poprawnie zaktualizowano menu', 'success');
							} else {
								$this->GuiHelper->contentAlert('Błąd aktualizacji', 'danger');
							}
						} else {
							$this->GuiHelper->contentAlert('Nazwa musi posiadać przynajmniej 3 znaki', 'danger');
						}
					}
					$this->view_add();
					break;
				case 'positionUp':
					$this->Menu->positionUp((int)$_GET['id']);
					$this->view_list();
					break;
				case 'positionDown':
					$this->Menu->positionDown((int)$_GET['id']);
					$this->view_list();
					break;
				default:
					$this->view_list();
					break;
			}
		} else {
			$this->view_list();
		}
	}

	public function view_list() {
		core::setError();

		$menuList = $this->Menu->list();

		foreach ($menuList as $key => $array) {
			$menuList[$key]['prettyLink'] = $this->Interpreter->showPrettyText($array['link']);

			if ($array['name'] === '') {
				$menuList[$key]['name'] = '--- Brak nazwy ---';
			}
		}

		$this->viewSetVariable('menuList', $menuList);
		$this->loadView('menu.list');
	}

	public function view_add() {
		core::setError();

		$add = !isset($_GET['id']);

		if (!$add) {
			$getMenu = $this->Menu->read((int)$_GET['id']);
			$this->viewSetVariable('menu', $getMenu);
			$this->viewSetVariable('title', 'Edycja menu');
		} else {
			$this->viewSetVariable('title', 'Dodanie nowego menu');
		}

		$this->viewSetVariable('add', $add);
		$this->loadView('menu.edit');
	}

	public function submitForm() {
		core::setError();
	}
};