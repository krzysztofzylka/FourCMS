<?php
include('../core/core.php');
core::init([
	'autoCreatePath' => false,
	'showCoreError' => false,
	'saveCoreError' => false
]);
core::$library->database->connError = false;
core::loadModel('CMSInstaller');
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>FourCMS - Instalacja / Aktualizacja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container mt-3">
	<?php
	if (!file_exists('../file/db_config.php')
		|| (isset($_GET['type']) && $_GET['type'] === 'install')
	) {
		echo '<h1>Instalator</h1>';

		if (!isset($_POST['FourCMS'])) {
			include('page/connForm.php');
		} else {
			core::$library->database->connect([
				'type' => 'mysql',
				'host' => $_POST['db_host'],
				'name' => $_POST['db_name'],
				'user' => $_POST['db_username'],
				'password' => $_POST['db_password']
			]);

			if (core::$isError) {
				echo '<div class="alert alert-danger">Nie udało się połączyć z bazą danych</div>';
			} else {
				include('page/install.php');
			}
		}
	} else {
		core::$library->database->connect(include('../file/db_config.php'));
        echo '<h1>Aktualizator</h1>';

		if (!core::$isError && !isset($_POST['FourCMS'])) {
			echo '<div class="alert alert-primary">Wykryto sprawne połączenie z bazą danych, zostaw formularz pusty aby ich użyć w celu aktualizacji</div>';
			include('page/connForm.php');
		} else {
			if ($_POST['db_host'] !== '') {
				core::$library->database->connect([
					'type' => 'mysql',
					'host' => $_POST['db_host'],
					'name' => $_POST['db_name'],
					'user' => $_POST['db_username'],
					'password' => $_POST['db_password']
				]);
			}
			core::loadModel('config');
			include('page/update.php');
		}
	}
	?>
</div>
</body>
</html>