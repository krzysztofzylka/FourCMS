<?php
return new class(){
	public function __construct(){
        $userID = isset($_GET['userID'])?(int)$_GET['userID']:(int)core::$module['account']->userData['id'];
        $userAcc = (int)$userID === (int)core::$module['account']->userData['id'];
        $userData = core::$module['account']->getData($userID);
        if(!$userData)
            header('location: index.php?page=404');
        //jezeli jest tutaj aktualny uzytkownik
        if($userAcc){
            if(isset($_POST['save_name'])){
                if(strlen(htmlspecialchars($_POST['name'])) < 6){
                    core::$model['gui']->alert('Nazwa użytkownika powinna zawierać <b>przynajmniej</b> 6 znaków', 'danger');
                }else{
                    core::$model['adminPanel/user']->changeName($userID, $_POST['name']);
                    core::$model['gui']->alert('Poprawnie zmieniono nazwę użytkownika', 'success');
                }
            }
            if(isset($_POST['save_email'])){
                if($_POST['email'] === core::$module['account']->userData['email']){
                    core::$model['gui']->alert('Taki adres e-mail jest już ustawiony', 'warning');
                }elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    core::$model['gui']->alert('Adres e-mail nie jest poprawny', 'danger');
                }else{
                    core::$model['adminPanel/user']->changeEMail($userID, $_POST['email']);
                    core::$model['gui']->alert('Poprawnie zmieniono adres E-Mail', 'success');
                }
            }
        }
        if(isset($_POST['save_permission'])){
            if(!core::$module['account']->checkPermission('permissionUserEdit'))
                core::$model['gui']->alert('Nie posiadasz uprawnień do zmiany tej opcji', 'danger');
            else{
                core::$module['account']->setUserPermission($userData['id'], (int)$_POST['permission']);
                core::$model['gui']->alert('Poprawnie zmieniono grupę uprawnień użytkownika', 'success');
            }
        }
        core::loadView('user');
    }
}
?>