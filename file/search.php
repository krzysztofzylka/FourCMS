<?php
return [
	[
		'link' => 'userChangePassword.html',
		'name' => 'Zmiana hasła',
		'description' => 'Zmiana hasła użytkownika',
		'tags' => 'użytkownik|user|zmiana hasła|hasło|zmiana'
	],
	[
		'link' => 'index.html',
		'name' => 'Panel główny',
		'description' => 'Panel główny CMS',
		'tags' => 'panel|panel głowny|informacje'
	],
	[
		'link' => 'user.html',
		'name' => 'Użytkownik',
		'description' => 'Panel użytkownika oraz jego posty i ustawienia',
		'tags' => 'użytkownik|user|ustawienia'
	],
	[
		'link' => 'post.html',
		'name' => 'Posty',
		'description' => 'Podgląd postów na stronie',
		'tags' => 'post|posty',
		'permission' => 'post'
	],
	[
		'link' => 'postAdd.html',
		'name' => 'Dodanie posta',
		'description' => 'Dodanie nowego posta na stronę',
		'tags' => 'post|add|posty|dodaj posta|dodaj|strony',
		'permission' => 'option_usersAdd'
	],
	[
		'link' => 'menu.html',
		'name' => 'Menu',
		'description' => 'Podgląd menu',
		'tags' => 'menu|strony',
		'permission' => 'menu'
	],
	[
		'link' => 'menuAdd.html',
		'name' => 'Dodanie menu',
		'description' => 'Dodanie nowego menu do strony',
		'tags' => 'menu|dodaj|nowy|dodaj menu',
		'permission' => 'menu'
	],
	[
		'link' => 'jumbotron.html',
		'name' => 'Telebim',
		'description' => 'Ustawienia telebimu',
		'tags' => 'telebim|jumbotron|edycja|ustawienia',
		'permission' => 'jumbotron'
	],
	[
		'link' => 'config.html',
		'name' => 'Konfiguracja',
		'description' => 'Zmiana konfiguracji strony',
		'tags' => 'ustawienia|opcje|zmiana ustawień|konfiguracja',
		'permission' => 'option_editConfig'
	],
	[
		'link' => 'templateEdit.html',
		'name' => 'Edycja szablonu',
		'description' => 'Edycja szablonu strony',
		'tags' => 'szablon|template|edit|edycja|konfiguracja|ustawienia',
		'permission' => 'option_editTemplate'
	],
	[
		'link' => 'userAdmin.html',
		'name' => 'Użytkownicy',
		'description' => 'Podgląd listy użytkowników',
		'tags' => 'user|users|użytkownicy|lista użytkowników|podgląd użytkowników|użytkownik',
		'permission' => 'option_users'
	],
	[
		'link' => 'createNewUser.html',
		'name' => 'Dodanie użytkownika',
		'description' => 'Dodanie nowego użytkownika do serwisu',
		'tags' => 'user|users|użytkownicy|dodanie|add|dodanie użytkownika|użytkownik',
		'permission' => 'option_usersAdd'
	],
	[
		'link' => 'permission.html',
		'name' => 'Grupy uprawnień',
		'description' => 'Przegląd grup uprawnień',
		'tags' => 'permission|uprawnienia|group|grupy uprawnień',
		'permission' => 'option_permissionEdit'
	],
	[
		'link' => 'permissionAdd.html',
		'name' => 'Dodanie grupy uprawnień',
		'description' => 'Dodanie nowej grupy uprawnień',
		'tags' => 'permission|uprawnienia|group|grupy uprawnień|add|dodaj|dodanie grupy uprawnień|dodanie uprawnień',
		'permission' => 'option_permissionEdit'
	],
	[
		'link' => 'FrameworkLibrary.html',
		'name' => 'Biblioteki',
		'description' => 'Przegląd bibliotek',
		'tags' => 'library|service|serwis|biblioteki|fourframework',
		'permission' => 'service_library'
	],
	[
		'link' => 'FrameworkModule.html',
		'name' => 'Moduły - Debugowanie',
		'description' => 'Przegląd modułów',
		'tags' => 'module|moduł|moduły|fourframework|service|serwis',
		'permission' => 'service_module'
	],
	[
		'link' => 'logs.html',
		'name' => 'Logi',
		'description' => 'Logi',
		'tags' => 'log|logs|logi|fourframework|service|serwis',
		'permission' => 'service_logs'
	],
	[
		'link' => 'phpInfo.html',
		'name' => 'PHPInfo',
		'description' => 'Informacje o PHP',
		'tags' => 'phpinfo|php|info|fourframework|service|serwis',
		'permission' => 'service_phpinfo'
	],
	[
		'link' => 'userLogout.html',
		'name' => 'Wyloguj',
		'description' => 'Wyloguj użytkownika',
		'tags' => 'logout|wyloguj|użytkownik|user'
	],
	[
		'link' => 'siteTemplate.html',
		'name' => 'Szablony strony',
		'description' => 'Zmiana szablonu strony',
		'tags' => 'szablony|szablon|template|szablon strony|szablony strony',
		'permission' => 'option_template'
	],
	[
		'link' => 'module.html',
		'name' => 'Moduły',
		'description' => 'Zarządzanie modułami',
		'tags' => 'module|moduły|moduł|zarządzanie modułami',
		'permission' => 'option_module'
	],
	[
		'link' => 'module-add.html',
		'name' => 'Moduły - instalacja',
		'description' => 'Instalowanie modułów z API',
		'tags' => 'module|moduły|moduł|instalacja|instalacja modułów',
		'permission' => 'option_moduleAdd'
	]
];