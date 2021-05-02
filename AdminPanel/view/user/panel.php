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
                            <img class="profile-user-img img-fluid img-circle" src="<?php echo $userAvatar ?>" alt="Avatar użytkownika">
                        </div>
                        <!-- name -->
                        <h3 class="profile-username text-center"><?php echo ($user['blocked'] ? '<s>' : '') . $user['name'] . ($user['blocked'] ? '</s>' : '') ?></h3>
                        <p class="text-center"><?php echo $userAccount ? '<a class="badge badge-primary" data-toggle="collapse" aria-expanded="false" aria-controls="collapseChangeName" href="#collapseChangeName">Zmień nazwę użytkownika</a>' : ''; ?></p>
                        <div class="collapse mt-1" id="collapseChangeName">
                            <div class="card card-body">
                                <form method="POST">
                                    <div class="form-group">
                                        <label>Nowa nazwa</label>
                                        <input type="text" name="name" class="form-control" placeholder="Nazwa" value="<?php echo $user['name'] ?>">
                                    </div>
                                    <button type="submit" name="save_name" class="btn btn-primary btn-block">Zmień nazwę</button>
                                </form>
                            </div>
                        </div>
                        <!-- login -->
                        <p class="text-muted text-center"><?php echo ($user['blocked'] ? '<s>' : '') . $user['login'] . ($user['blocked'] ? '</s>' : '') ?></p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <!-- permission -->
                            <li class="list-group-item">
                                <b>Uprawnienia <?php echo $permission['permissionUserEdit'] ? '<a class="badge badge-primary" data-toggle="collapse" aria-expanded="false" aria-controls="collapseChangePermission" href="#collapseChangePermission">Zmień</a>' : ''; ?></b>
                                <a class="float-right"><?php echo $user['permissionName']; ?></a>
                                <div class="clearfix"></div>
                                <div class="collapse mt-2" id="collapseChangePermission">
                                    <div class="card card-body">
                                        <form method="POST">
                                            <div class="form-group">
                                                <label>Zmiana uprawnień użytkownika</label>
                                                <select name="permission" class="custom-select">
													<?php
													foreach ($permissionList as $item)
														echo '<option value="' . $item['id'] . '" ' . ((int)$user['permission'] == (int)$item['id'] ? 'selected' : '') . '>' . $item['name'] . '</option>';
													?>
                                                </select>
                                            </div>
                                            <button type="submit" name="save_permission" class="btn btn-primary btn-block">Zmień uprawnienia</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                            <!-- email -->
                            <li class="list-group-item">
                                <b>Adres
                                    E-Mail <?php echo $userAccount ? '<a class="badge badge-primary" data-toggle="collapse" aria-expanded="false" aria-controls="collapseChangeEmail" href="#collapseChangeEmail">Zmień</a>' : ''; ?></b>
                                <a class="float-right"><?php echo $user['email'] ?></a>
                                <div class="clearfix"></div>
                                <div class="collapse mt-2" id="collapseChangeEmail">
                                    <div class="card card-body">
                                        <form method="POST">
                                            <div class="form-group">
                                                <label>Nowy adres E-Mail</label>
                                                <input type="text" name="email" class="form-control" placeholder="Nazwa" value="<?php echo $user['email'] ?>">
                                            </div>
                                            <button type="submit" name="save_email" class="btn btn-primary btn-block">Zmień nazwę</button>
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
							<?php echo $userAccount ? '<li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab" style="">Ustawienia</a></li>' : ''; ?>
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
								<?php echo $userAccount ? '<a href="userChangePassword.html" class="btn btn-secondary"><i class="nav-icon fas fa-key"></i> Zmiana hasła</a>' : ''; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>