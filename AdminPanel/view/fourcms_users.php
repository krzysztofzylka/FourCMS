<div class='content pt-3'>
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Użytkownicy</h3>
                <div class="card-tools">
                    <!-- edycja uprawnień użytkownika -->
                    <a href="permission.html" type="button" class="btn btn-tool " data-toggle="tooltip" title="Uprawnienia użytkowników"><i class="far fa-object-group"></i></a>
                    <!-- dodanie użytkownika -->
                    <a href="createNewUser.html" type="button" class="btn btn-tool <?php echo !core::$module['account']->checkPermission('option_usersAdd') ? 'disabled' : '' ?>" data-toggle="tooltip" title="Dodanie nowego użytkownika"><i class="fas fa-user-plus"></i></a>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-sm text-nowrap dataTable">
                    <thead>
                        <tr>
                            <th style="width: 200px">Login</th>
                            <th style="width: 200px">Nazwa</th>
                            <th style="width: 250px">E-Mail</th>
                            <th>Opcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach (core::$module['account']->userList() as $item) {
                            echo '<tr>
                                <td>' . $item['login'] . '</td>
                                <td><a href="user-'.$item['id'].'.html">' . $item['name'] . '</a></td>
                                <td>' . $item['email'] . '</td>
                                <td></td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>