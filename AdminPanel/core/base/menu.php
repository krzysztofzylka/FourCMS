<?php
return [
	[
		'href' => 'index.php',
		'icon' => 'fas fa-th',
		'name' => 'Panel główny',
	],
	'post' => [
		'href' => 'index.php?page=post',
		'name' => 'Posty',
		'icon' => 'fas fa-blog',
		'permission' => 'post'
	],
	'menu' => [
		'href' => 'index.php?page=menu',
		'name' => 'Menu',
		'icon' => 'fas fa-compass',
		'permission' => 'menu'
	],
	'jumbotron' => [
		'href' => 'index.php?page=jumbotron',
		'name' => 'Telebim',
		'icon' => 'fas fa-bullseye',
		'permission' => 'jumbotron'
	],
	'module' => [
		'href' => '#',
		'name' => 'Moduły',
		'icon' => 'fas fa-wrench',
		'menu' => []
	],
	'option' =>[
		'href' => '#',
		'icon' => 'fas fa-cogs',
		'name' => 'Ustawienia',
		'menu' => [
			[
				'href' => 'index.php?page=fourcms_config',
				'icon' => 'fas fa-database',
				'name' => 'Zmiana konfiguracji',
				'permission' => 'option_editConfig'
			],
			[
				'href' => 'index.php?page=template_edit',
				'icon' => 'fas fa-edit',
				'name' => 'Edycja szablonu',
				'permission' => 'option_editTemplate'
			],
			[
				'href' => 'index.php?page=fourcms_users',
				'icon' => 'fas fa-users',
				'name' => 'Użytkownicy',
				'permission' => 'option_users'
			],
		]
	],
	'service' => [
		'href' => '#',
		'icon' => 'fas fa-tools',
		'name' => 'Serwis',
		'permission' => 'service',
		'menu' => [
			[
				'href' => 'index.php?page=fourframework_library',
				'icon' => 'fas fa-puzzle-piece',
				'name' => 'Biblioteki',
				'permission' => 'service_library'
			],
			[
				'href' => 'index.php?page=fourframework_module',
				'icon' => 'fas fa-plug',
				'name' => 'Moduły',
				'permission' => 'service_module'
			],
			[
				'href' => 'index.php?page=fourframework_logs',
				'icon' => 'fas fa-file',
				'name' => 'Logi',
				'permission' => 'service_logs'
			],
			[
				'href' => 'index.php?page=fourframework_phpinfo',
				'icon' => 'fab fa-php',
				'name' => 'PHP Info',
				'permission' => 'service_phpinfo'
			]
		]
	],
	[
		'href' => 'index.php?page=user_logout',
		'icon' => 'fas fa-sign-out-alt',
		'name' => 'Wyloguj',
		'class' => 'bg-warning'
	]
];
?>