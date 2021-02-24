<?php
return [
    [
        'link' => core::$model['link']->generate(['page' => 'user_changePassword']),
        'name' => 'Zmiana hasła',
        'description' => 'Zmiana hasła użytkownika',
        'tags' => 'użytkownik|user|zmiana hasła|hasło|zmiana'
    ],
    [
        'link' => 'index.php',
        'name' => 'Panel główny',
        'description' => 'Panel główny CMS',
        'tags' => 'panel|panel głowny|informacje'
    ],
    [
        'link' => core::$model['link']->generate(['page' => 'user']),
        'name' => 'Użytkownik',
        'description' => 'Panel użytkownika oraz jego posty i ustawienia',
        'tags' => 'użytkownik|user|ustawienia'
    ],
    [
        'link' => core::$model['link']->generate(['page' => 'post']),
        'name' => 'Posty',
        'description' => 'Podgląd postów na stronie',
        'tags' => 'post|posty'
    ],
    [
        'link' => core::$model['link']->generate(['page' => 'post', 'id' => 'dodaj']),
        'name' => 'Dodanie posta',
        'description' => 'Dodanie nowego posta na stronę',
        'tags' => 'post|add|posty|dodaj posta|dodaj|strony'
    ],
    [
        'link' => core::$model['link']->generate(['page' => 'menu']),
        'name' => 'Menu',
        'description' => 'Podgląd menu',
        'tags' => 'menu|strony'
    ],
    [
        'link' => core::$model['link']->generate(['page' => 'menu', 'type' => 'add']),
        'name' => 'Dodanie menu',
        'description' => 'Dodanie nowego menu do strony',
        'tags' => 'menu|dodaj|nowy|dodaj menu'
    ],
    [
        'link' => core::$model['link']->generate(['page' => 'jumbotron']),
        'name' => 'Telebim',
        'description' => 'Ustawienia telebimu',
        'tags' => 'telebim|jumbotron|edycja|ustawienia'
    ],
    [
        'link' => core::$model['link']->generate(['page' => 'fourcms_config']),
        'name' => 'Konfiguracja',
        'description' => 'Zmiana konfiguracji strony',
        'tags' => 'ustawienia|opcje|zmiana ustawień|konfiguracja'
    ],
    [
        'link' => core::$model['link']->generate(['page' => 'template_edit']),
        'name' => 'Edycja szablonu',
        'description' => 'Edycja szablonu strony',
        'tags' => 'szablon|template|edit|edycja|konfiguracja|ustawienia'
    ],
    [
        'link' => core::$model['link']->generate(['page' => 'fourcms_users']),
        'name' => 'Użytkownicy',
        'description' => 'Podgląd listy użytkowników',
        'tags' => 'user|users|użytkownicy|lista użytkowników|podgląd użytkowników|użytkownik'
    ],
    [
        'link' => core::$model['link']->generate(['page' => 'fourcms_users_addUser']),
        'name' => 'Dodanie użytkownika',
        'description' => 'Dodanie nowego użytkownika do serwisu',
        'tags' => 'user|users|użytkownicy|dodanie|add|dodanie użytkownika|użytkownik'
    ],
    [
        'link' => core::$model['link']->generate(['page' => 'fourcms_permission']),
        'name' => 'Grupy uprawnień',
        'description' => 'Przegląd grup uprawnień',
        'tags' => 'permission|uprawnienia|group|grupy uprawnień'
    ],
    [
        'link' => core::$model['link']->generate(['page' => 'fourcms_permission', 'editID' => 'addNew']),
        'name' => 'Dodanie grupy uprawnień',
        'description' => 'Dodanie nowej grupy uprawnień',
        'tags' => 'permission|uprawnienia|group|grupy uprawnień|add|dodaj|dodanie grupy uprawnień|dodanie uprawnień'
    ],
    [
        'link' => core::$model['link']->generate(['page' => 'fourframework_library']),
        'name' => 'Biblioteki',
        'description' => 'Przegląd bibliotek',
        'tags' => 'library|service|serwis|biblioteki|fourframework'
    ],
    [
        'link' => core::$model['link']->generate(['page' => 'fourframework_module']),
        'name' => 'Moduły',
        'description' => 'Przegląd modułów',
        'tags' => 'module|moduł|moduły|fourframework|service|serwis'
    ],
    [
        'link' => core::$model['link']->generate(['page' => 'fourframework_logs']),
        'name' => 'Logi',
        'description' => 'Logi',
        'tags' => 'log|logs|logi|fourframework|service|serwis'
    ],
    [
        'link' => core::$model['link']->generate(['page' => 'fourframework_phpinfo']),
        'name' => 'PHPInfo',
        'description' => 'Informacje o PHP',
        'tags' => 'phpinfo|php|info|fourframework|service|serwis'
    ],
    // [
    //     'link' => core::$model['link']->generate(['page' => '']),
    //     'name' => '',
    //     'description' => '',
    //     'tags' => ''
    // ]
];
?>