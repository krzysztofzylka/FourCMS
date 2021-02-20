<?php
$userID = isset($_GET['userID']) ? (int)$_GET['userID'] : (int)core::$module['account']->userData['id'];
if(!core::$module['account']->checkPermission('otherUser') and $userID <> (int)core::$module['account']->userData['id']){
	$userID = (int)core::$module['account']->userData['id'];
    core::$model['gui']->alert('Nie posiadasz uprawnień do przeglądania profili użytkowników, wyświetlony zostanie aktualny profil użytkownika.');
}
$userAcc = (int)$userID === (int)core::$module['account']->userData['id'];
$userData = core::$module['account']->getData($userID);
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <h1>Użytkownik</h1>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <!-- avatar -->
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="<?php echo core::$model['adminPanel/user']->getAvatar($userID) ?>" alt="Avatar użytkownika">
                        </div>
                        <!-- name -->
                        <h3 class="profile-username text-center"><?php echo $userData['name'] ?></h3>
                        <p class="text-center"><?php echo $userAcc ? '<a class="badge badge-primary" data-toggle="collapse" aria-expanded="false" aria-controls="collapseChangeName" href="#collapseChangeName">Zmień nazwę użytkownika</a>' : ''; ?></p>
                        <div class="collapse" id="collapseChangeName">
                            <div class="card card-body">
                                <form method="POST">
                                    <div class="form-group">
                                        <label>Nowa nazwa</label>
                                        <input type="text" name="name" class="form-control" placeholder="Nazwa" value="<?php echo $userData['name'] ?>">
                                    </div>
                                    <button type="submit" name="save_name" class="btn btn-primary">Zmień nazwę</button>
                                </form>
                            </div>
                        </div>
                        <!-- login -->
                        <p class="text-muted text-center"><?php echo $userData['login'] ?></p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <!-- permission -->
                            <li class="list-group-item"><b>Uprawnienia <?php echo core::$module['account']->checkPermission('permissionUserEdit') ? '<a class="badge badge-primary" data-toggle="collapse" aria-expanded="false" aria-controls="collapseChangePermission" href="#collapseChangePermission">Zmień</a>' : ''; ?></b> <a class="float-right"><?php echo core::$module['account']->getPermissionName((int)$userData['permission']); ?></a>
                                <div class="collapse" id="collapseChangePermission">
                                    <div class="card card-body">
                                        <form method="POST">
                                            <div class="form-group">
                                                <label>Zmiana uprawnień użytkownika</label>
                                                <select name="permission" class="custom-select">
                                                    <?php
                                                    foreach(core::$module['account']->getPermissionList() as $item)
                                                        echo '<option value="'.$item['id'].'" '.((int)$userData['permission']==(int)$item['id']?'selected':'').'>'.$item['name'].'</option>';
                                                    ?>
                                                </select>
                                            </div>
                                            <button type="submit" name="save_permission" class="btn btn-primary">Zmień uprawnienia</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                            <!-- email -->
                            <li class="list-group-item">
                                <b>Adres E-Mail <?php echo $userAcc ? '<a class="badge badge-primary" data-toggle="collapse" aria-expanded="false" aria-controls="collapseChangeEmail" href="#collapseChangeEmail">Zmień</a>' : ''; ?></b> <a class="float-right"><?php echo $userData['email'] ?></a>
                                <div class="collapse" id="collapseChangeEmail">
                                    <div class="card card-body">
                                        <form method="POST">
                                            <div class="form-group">
                                                <label>Nowy adres E-Mail</label>
                                                <input type="text" name="email" class="form-control" placeholder="Nazwa" value="<?php echo $userData['email'] ?>">
                                            </div>
                                            <button type="submit" name="save_email" class="btn btn-primary">Zmień nazwę</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                            <!-- posts -->
                            <li class="list-group-item"><b>Postów</b> <a class="float-right">?</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#posts" data-toggle="tab" style="">Posty</a></li>
                            <?php echo $userAcc ? '<li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab" style="">Ustawienia</a></li>' : ''; ?>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <!-- posts -->
                            <div class="tab-pane active" id="posts">
                                <div class="alert alert-warning">Opcja będzie udostępniona w późniejszych wersjach</div>
                            </div>
                            <!-- setting -->
                            <div class="tab-pane" id="settings">
                                <?php echo $userAcc ? '<a href="index.php?page=user_changePassword" class="btn btn-secondary"><i class="nav-icon fas fa-key"></i> Zmiana hasła</a>' : ''; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>