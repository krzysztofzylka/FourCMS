<?php
return new class() extends core_controller {
	public function __construct(){
		core::setError();

		if(!core::$module->account->checkPermission('option_module')) {
			header('location: 404.html');
			return;
		}

		$this->loadModel('Config');
		$this->loadModel('GuiHelper');
		$this->loadModel('Module');

		$this->installFromPOSTData();
		$this->clearInstallerCacheFromGETData();
		$this->downloadAndinstallModuleFromGETData();
		$this->saveModuleKeyFromGETData();

		$this->view();
	}
	public function view(){
		core::setError();

		if (isset($_GET['page2']) && $_GET['page2'] == 'moduleAdd') {
			$this->view_moduleAdd();
		} else {
			$this->view_module();
		}
	}
	public function view_module(){
		core::setError();

		$moduleList = core::$library->module->moduleList(true);

		foreach($moduleList as $key => $data) {
			$moduleList[$key]['apiKey'] = $this->Config->read('moduleKey_'.$data['config']['uniqueID'], '');
		}

		if (isset($_GET['searchUpdate'])) {
			$uniqueID = $_GET['searchUpdate'];
			$APIData = $this->Module->API_getData($uniqueID, $this->Config->read('moduleKey_'.$uniqueID, null));

			if (!core::$isError && $APIData['status'] <> 'error') {
				$key = $this->Config->read('moduleKey_'.$uniqueID, null);
				$this->viewSetVariable('key', $key);
			}

			$this->viewSetVariable('uniqueID', $uniqueID);
			$this->viewSetVariable('APIData', $APIData);
		}

		$this->viewSetVariable('moduleList', $moduleList);
		$this->loadView('option.module');
	}
	public function view_moduleAdd(){
		core::setError();

		$APIData = $this->Module->API_getData();
		unset($APIData['status']);

		if(core::$isError) {
			$this->GuiHelper->contentAlert('Nie udało się połączyć z serwerem', 'danger');
		}

		if (is_array($APIData)) {
			foreach($APIData as $key => $data) {
				$APIData[$key]['moduleLocalData'] = core::$library->module->getConfig($data['name'], true);
				$APIData[$key]['checkVersion'] = $APIData[$key]['moduleLocalData']['version'] == $data['version'];
			}
		}

		$this->viewSetVariable('APIData', $APIData);
		$this->loadView('option.moduleAdd');
	}
	public function saveModuleKeyFromGETData(){
		core::setError();

		if (isset($_POST['keySave'])) {
			$this->Config->write('moduleKey_'.$_POST['keyUniqueID'], $_POST['key']);
			$this->GuiHelper->contentAlert('Poprawnie zapisano klucz dla modułu', 'success');
		}
	}
	public function installFromPOSTData() {
		core::setError();

		if(isset($_POST['install'])){
			$this->installModule();
		}
	}
	public function downloadAndinstallModuleFromGETData(){
		core::setError();

		if (isset($_GET['installFromServer'])) {
			$urlToFile = $_GET['installFromServer'];
			$tempFilePath = core::$path['temp'].'downloadModuleFile.zip';

			file_put_contents($tempFilePath, fopen($urlToFile, 'r'));

			$this->installModule($tempFilePath);

			if (file_exists($tempFilePath)) {
				unlink($tempFilePath);
			}
		}
	}
	public function installModule($file = null) {
		core::setError();

		$file = $file??$_FILES['file']['tmp_name'];

		if (core::$module->account->checkPermission('moduleInstall')) {
			if (isset($file)) {
				$this->Module->installModule($file);

				if (core::$isError) {
					switch ((int)core::$error['number']) {
						case 1:
							$this->GuiHelper->contentAlert('Nie znaleziono pliku ZIP', 'danger');
							break;
						case 2:
							$this->GuiHelper->contentAlert('Folder temp istnieje (jeżeli nic nie jest instalowane albo nastąpił błąd instalacji/aktualizacji użyj przycisku "Wyczyść pliki tymczasowe")', 'danger');
							break;
						case 3:
							$this->GuiHelper->contentAlert('Brak rozszerzenia do obsługi plików ZIP', 'danger');
							break;
						case 4:
							$this->GuiHelper->contentAlert('Błąd otwarcia pliku ZIP', 'danger');
							break;
						case 5:
							$this->GuiHelper->contentAlert('Nie znaleziono pliku konfiguracyjnego (config.php)', 'danger');
							break;
						case 6:
							$this->GuiHelper->contentAlert('Plik konfiguracyjny nie posiada danych moduleDirectory', 'danger');
							break;
						case 7:
							$this->GuiHelper->contentAlert('Plik ZIP nie zawiera folderu z modułem (moduleDirectory)', 'danger');
							break;
						case 8:
							$this->GuiHelper->contentAlert('Brak pliku wymaganego poczas aktualizacji (update.php)', 'danger');
							break;
						case 9:
							$this->GuiHelper->contentAlert('Brak pliku wymaganego poczas instalacji (install.php)', 'danger');
							break;
						case 10:
							$this->GuiHelper->contentAlert('Plik update.php zwrócił błąd', 'danger');
							break;
						case 11:
							$this->GuiHelper->contentAlert('Plik install.php zwrócił błąd', 'danger');
							break;
						default:
							$this->GuiHelper->contentAlert('Wystąpił nieznany błąd', 'danger');
							break;
					}
				} else {
					unlink($file);
					$this->GuiHelper->contentAlert('Poprawnie zainstalowano/zaktualizowano moduł', 'success');
				}
			} else {
				$this->GuiHelper->contentAlert('Błąd formularza', 'danger');
			}
		} else {
			$this->GuiHelper->contentAlert('Nie posiadasz uprawnień do wgrywania modułów z plików', 'danger');
		}
	}
	public function clearInstallerCacheFromGETData(){
		core::setError();

		if (isset($_GET['clearInstallerCache']) and $_GET['clearInstallerCache'] == "true") {
			core::$library->file->rmdir(core::$path['temp'].'installModule'.DIRECTORY_SEPARATOR);
			$this->GuiHelper->contentAlert('Usunięto pliki cache', 'success');
		}
	}
}
?>