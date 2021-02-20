<?php
include('core/core.php');
core::init(['showCoreError' => false]);
if (isset($_POST['install'])) {
    echo '<h1>Instalacja</h1>';
    core::$library->database->connError = false;
    core::$library->database->connect([
        'type' => 'mysql',
        'host' => $_POST['host'],
        'name' => $_POST['name'],
        'user' => $_POST['login'],
        'password' => $_POST['password']
    ]);
    if (core::$isError) {
        echo '<span style="color: red">> Nie udało się połączyć z bazą danych</span><br />';
    } else {
        echo '<span style="color: green">> Poprawnie połączono z bazą danych</span><br />';
        $database = core::$library->database->conn;
        $database->exec("CREATE TABLE `AP_groupPermission` (
            `id` int(24) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `permission` text NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB;
        INSERT INTO `AP_groupPermission` (`id`, `name`, `permission`) VALUES
        (1, 'Administrator', '[\"all_granted\"]'),
        (2, 'Użytkownik', '[]');");
        
        $database->exec("CREATE TABLE `AP_user` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `login` varchar(30) NOT NULL,
            `password` varchar(50) NOT NULL,
            `email` varchar(50) DEFAULT NULL,
            `name` varchar(128) NOT NULL,
            `avatar` varchar(256) DEFAULT NULL,
            `permission` int(24) NOT NULL DEFAULT '1',
            `blocked` int(1) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        INSERT INTO `AP_user` (`id`, `login`, `password`, `email`, `name`, `avatar`, `permission`, `blocked`) VALUES
        (1, '".$_POST['admin_login']."', '".core::$library->crypt->hash($_POST['admin_password'])."', '', 'Administrator', NULL, 1, 0);");

        $database->exec("CREATE TABLE `config` (
            `id` int(24) NOT NULL AUTO_INCREMENT,
            `name` varchar(128) NOT NULL,
            `value` text NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        INSERT INTO `config` (`id`, `name`, `value`) VALUES
        (1, 'adminPanel_loginMessage', 'Zaloguj się do panelu administracyjnego <a href=\"https://krzysztofzylka.pl/\">FourCMS</a>'),
        (2, 'adminPanel_title', 'Admin Panel'),
        (3, 'APmenu_jumbotron', '1'),
        (4, 'APmenu_menu', '1'),
        (5, 'APmenu_serwis', '0'),
        (6, 'defaultUserPermissionGroup', '2'),
        (7, 'header_charset', 'utf-8'),
        (8, 'header_description', ''),
        (9, 'header_google_site_verification', ''),
        (10, 'header_keywords', 'FourCMS, FourFramework, Zarządzanie treścią'),
        (11, 'header_title', 'Nagłówek strony'),
        (12, 'mainPage', 'controller/post'),
        (13, 'menuCard_show', '1'),
        (14, 'menuCard_text', 'Tytuł'),
        (15, 'menuCard_title', 'Treść karty'),
        (16, 'template_name', 'defaultBlog'),
        (17, 'textarea_filePath', 'images/'),
        (18, 'title', 'Nagłówek');");

        $database->exec("CREATE TABLE `jumbotron` (
            `name` varchar(128) NOT NULL,
            `value` text NOT NULL,
            PRIMARY KEY (`name`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        INSERT INTO `jumbotron` (`name`, `value`) VALUES
        ('header', 'Nagłówek telebimu'),
        ('show', '1'),
        ('text', 'Treść telebimu'),
        ('url', '#');");

        $database->exec("CREATE TABLE `menu` (
            `id` int(12) NOT NULL AUTO_INCREMENT,
            `name` varchar(128) NOT NULL,
            `link` varchar(255) NOT NULL,
            `position` int(15) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        INSERT INTO `menu` (`id`, `name`, `link`, `position`) VALUES
        (1, 'Strona główna', 'index.php', 0);");
        
        $database->exec("CREATE TABLE `permissionList` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `permName` varchar(255) NOT NULL,
            `name` varchar(255) NOT NULL,
            `description` text NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        INSERT INTO `permissionList` (`id`, `permName`, `name`, `description`) VALUES
        (1, 'all_granted', 'Wszystkie uprawnienia', 'Wszystkie uprawnienia'),
        (2, 'post', 'Posty', 'Dostęp do wszystkich funkcji postów'),
        (3, 'jumbotron', 'Telebim', 'Dostęp do wszystkich funkcji telebimu'),
        (4, 'menu', 'Menu', 'Dostęp do wszystkich funkcji menu'),
        (5, 'permissionUserEdit', 'Edycja uprawnień użytkownika', 'Opcja ta zezwala użytkownikowi na edycję uprawnień innych użytkowników'),
        (6, 'option_editTemplate', 'Edycja szablonów', 'Opcja pozwala na edycję szablonów strony'),
        (7, 'option_editConfig', 'Edycja konfiguracji', 'Opcja ta pozwala na edycję konfiguracji strony'),
        (8, 'option_users', 'Użytkownicy', 'Dostęp do wszystkich funkcji strony Użytkownicy'),
        (9, 'option_usersAdd', 'Dodanie użytkowników', 'Dostęp do opcji dodania nowego użytkownika'),
        (10, 'option_permissionEdit', 'Zarządzanie uprawnieniami', 'Opcja umożliwiająca edycję/dodanie nowej grupy uprawnień'),
        (11, 'service', 'Serwis', 'Dostęp do wszystkich funkcji serwisu'),
        (12, 'service_library', 'Biblioteki', 'Dostęp do informacji o bibliotekach'),
        (13, 'service_module', 'Moduły', 'Dostęp do informacji o modułach'),
        (14, 'service_logs', 'Logi', 'Dostęp do logów serwisu'),
        (15, 'service_phpinfo', 'PHPInfo', 'Dostęp do informacji o PHP'),
        (16, 'module_projects_projects', 'Moduł projekty', 'Dostęp do modułu projekty'),
        (17, 'module_projects_projectsEdit', 'Edycja projektów', 'Dostęp do edycji projektów'),
        (18, 'module_projects_projectsAdd', 'Tworzenie projektów', 'Dostęp do tworzenia projektów'),
        (19, 'module', 'Moduły', 'Dostęp do Panelów Administracyjnych zainstalowanych modułów'),
        (20, 'module_projects_projectsAddActivity', 'Dodanie aktywności', 'Dodanie aktywności/wiadomości do projektu'),
        (21, 'module_projects_taskAdd', 'Dodanie zadania', 'Dodanie nowego zadania'),
        (22, 'module_projects_taskEdit', 'Edycja zadaniń', 'Edycja utworzonych zadań'),
        (23, 'otherUser', 'Przeglądanie użytkowników', 'Przeglądanie profili innych użytkowników'),
        (24, 'module_projects_payments', 'Płatności', 'Zarządzanie płatnościami projektu'),
        (25, 'module_projects_paymentsAdd', 'Dodanie płatności', 'Dodanie nowych płatności'),
        (26, 'module_projects_paymentsEdit', 'Edycja płatności', 'Edycja istniejących płatności'),
        (27, 'module_projects_files', 'Dostęp do plików', 'Dostęp do plików w projekcie'),
        (29, 'module_projects_filesAdd', 'Dodanie pliku', 'Dodanie nowego pliku do projektu');");
        
        $database->exec("CREATE TABLE `post` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(80) NOT NULL,
            `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `text` text NOT NULL,
            `user` int(24) NOT NULL,
            `url` varchar(128) NOT NULL,
            `type` varchar(255) NOT NULL DEFAULT 'post',
            `hidden` int(1) NOT NULL DEFAULT '0',
			`showMetaData` int(1) NOT NULL DEFAULT `1`,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        INSERT INTO `post` (`id`, `title`, `date`, `text`, `user`, `url`, `type`, `hidden`) VALUES
        (1, 'Strona główna', '0000-00-00 00-00-00', 'Witaj w pierwszym poście twojego CMSa', 1, 'auto', 'post', 0);");
        echo '<span style="color: green">> Wgrano bazę danych</span><br />';
        file_put_contents('file/db_config.php', '<?php return [\'type\' => \'mysql\', \'host\' => \''.$_POST['host'].'\', \'name\' => \''.$_POST['name'].'\', \'user\' => \''.$_POST['login'].'\', \'password\' => \''.$_POST['password'].'\']; ?>');
        echo '<span style="color: green">> Wgrano konfigurację</span><br />
        <span style="color: green; font-size: 25px;">Instalacja przebiegła pomyślnie<br />Nie zapomnij usunąć pliku <b>install.php</b></span>';
    }
}
?>
<h1>Instalator</h1>
<form method="POST">
    <b>Baza danych</b><br />
    Host<br />
    <input type="text" placeholder="Host" name="host" /><br />
    Nazwa bazy danych<br />
    <input type="text" placeholder="Nazwa bazy danych" name="name" /><br />
    Login<br />
    <input type="text" placeholder="Login" name="login" /><br />
    Hasło<br />
    <input type="text" placeholder="Hasło" name="password" /><br />
    <br />
    <b>Administrator</b><br />
    Login<br />
    <input type="text" placeholder="Login" name="admin_login" value="admin" /><br />
    Hasło<br />
    <input type="text" placeholder="Hasło" name="admin_password" /><br />
    <input type="submit" name="install" value="Instaluj" />
</form>