<?php
return [
	'include' => [],
	'moduleFile' => 'main.php',
	'version' => '1.0', //wersja twojego modułu
	'uniqueID' => 'c6a7e85bf261167269e2de1d757104ec', //należy zmienić UniqueID na losowy w formacie MD5
	//'adminPanel' => 'adminPanel.php', //jeżeli brak linka w menu "Moduły"
	'adminPanel' => [ //ta tablica nie jest wymagana, jeżeli nie chcemy linka w menu "moduły" zamiast tablicy zamieszkamy nawę pliku dla panelu administratora np. "adminPanel.php"
		'path' => 'adminPanel.php',
		'menu' => [
			'name' => 'Pusty szablon modułu',
			'icon' => 'fas fa-circle',
            'htmlPage' => [
                'FrameworkModuleAP-emptyModule.html' //neleży podminić na linka na link do modułu np. FrameworkModuleAP-*nazwa modulu*.html
			]
		]
	],
	'fourCMS' => [ //link w menu głównym
        'menuItem' => [
            'name' => 'Pusty szablon modułu',
            'icon' => 'fas fa-circle',
            'htmlPage' => [
                'FrameworkModuleAP-emptyModule.html' //neleży podminić na linka na link do modułu np. FrameworkModuleAP-*nazwa modulu*.html
            ]
        ],
        'includeFile' => null, //url do pliku który jest uruchamiany na początku skryptu index.php panelu administratora
    ]
];
?>