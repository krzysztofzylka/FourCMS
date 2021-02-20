<div class='content pt-3'>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Dodanie nowego użytkownika</div>
            </div>
            <form method="POST">
                <div class="card-body">
                    <div class="form-group">
                        <label>Login</label>
                        <input type="text" name="login" class="form-control" placeholder="Login użytkownika" value="<?php echo isset($_POST['login']) ? $_POST['login'] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Nazwa</label>
                        <input type="text" name="name" class="form-control" placeholder="Nazwa użytkownika" value="<?php echo isset($_POST['name']) ? $_POST['name'] : '' ?>">
                        <small class="form-text text-muted">Nazwa musi posiadać przynajmniej 6 znaków</small>
                    </div>
                    <div class="form-group">
                        <label>E-Mail</label>
                        <input type="email" name="email" class="form-control" placeholder="Adres E-Mail użytkownika" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
                    </div>
                    <div class="form-group">
                        <label>Hasło</label>
                        <input type="password" name="password" class="form-control" placeholder="Hasło użytkownika" value="<?php echo isset($_POST['password']) ? $_POST['password'] : '' ?>"><br />
                        <input type="password" name="password2" class="form-control" placeholder="Powtórz hasło użytkownika" value="<?php echo isset($_POST['password2']) ? $_POST['password2'] : '' ?>">
                        <small class="form-text text-muted">Hasło musi posiadać przynajmniej 6 znaków</small>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" name="addUser">Dodaj użytkownika</button>
                </div>
            </form>
        </div>
    </div>
</div>