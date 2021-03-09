<?php
return new class(){
	public function __construct(){
		core::setError();
		if(!core::$module['account']->checkPermission('option_module'))
			header('location: 404.html');
		if(isset($_POST['install'])){
			if(isset($_FILES['file']['tmp_name'])){
				core::$model['module']->installModule($_FILES['file']['tmp_name']);
				if(core::$isError){
					switch((int)core::$error[0]){
						case 1:
							core::$model['gui']->alert('Nie znaleziono pliku ZIP', 'danger');
							break;
						case 2:
							core::$model['gui']->alert('Folder temp istnieje (jeżeli nic nie jest instalowane albo nastąpił błąd instalacji/aktualizacji użyj przycisku "Wyczyść pliki tymczasowe")', 'danger');
							break;
						case 3:
							core::$model['gui']->alert('Brak rozszerzenia do obsługi plików ZIP', 'danger');
							break;
						case 4:
							core::$model['gui']->alert('Błąd otwarcia pliku ZIP', 'danger');
							break;
						case 5:
							core::$model['gui']->alert('Nie znaleziono pliku konfiguracyjnego (config.php)', 'danger');
							break;
						case 6:
							core::$model['gui']->alert('Plik konfiguracyjny nie posiada danych moduleDirectory', 'danger');
							break;
						case 7:
							core::$model['gui']->alert('Plik ZIP nie zawiera folderu z modułem (moduleDirectory)', 'danger');
							break;
						case 8:
							core::$model['gui']->alert('Brak pliku wymaganego poczas aktualizacji (update.php)', 'danger');
							break;
						case 9:
							core::$model['gui']->alert('Brak pliku wymaganego poczas instalacji (install.php)', 'danger');
							break;
						case 10:
							core::$model['gui']->alert('Plik update.php zwrócił błąd', 'danger');
							break;
						case 11:
							core::$model['gui']->alert('Plik install.php zwrócił błąd', 'danger');
							break;
						default:
							core::$model['gui']->alert('Wystąpił nieznany błąd', 'danger');
							break;
					}
				}else{
					unlink($_FILES['file']['tmp_name']);
					core::$model['gui']->alert('Poprawnie zainstalowano/zaktualizowano moduł', 'success');
				}
			}else
				core::$model['gui']->alert('Błąd formularza', 'danger');
		}
		if(isset($_GET['clearInstallerCache']) and $_GET['clearInstallerCache'] == "true"){
			core::$library->file->rmdir(core::$path['temp'].'installModule'.DIRECTORY_SEPARATOR);
			core::$model['gui']->alert('Usunięto pliki cache', 'success');
		}
		core::loadView('option.module');
	}
}
?>