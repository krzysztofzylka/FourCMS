<form method="POST">
	<div class="form-group">
		<label>Host</label>
		<input type="text" name="db_host" class="form-control">
	</div>
	<div class="form-group">
		<label>Nazwa bazy danych</label>
		<input type="text" name="db_name" class="form-control">
	</div>
	<div class="form-group">
		<label>Użytkownk bazy danych</label>
		<input type="text" name="db_username" class="form-control">
	</div>
	<div class="form-group">
		<label>Hasło bazy danych</label>
		<input type="text" name="db_password" class="form-control">
	</div>

    <?php
	if (!file_exists('../file/db_config.php')
	    || (isset($_GET['type'])
	    && $_GET['type'] === 'install')
	) {
    ?>
    <h1>Użytkownik</h1>
    <div class="form-group">
        <label>Login administratora</label>
        <input type="text" name="admin_login" value="admin" class="form-control">
    </div>
    <div class="form-group">
        <label>Hasło administratora</label>
        <input type="text" name="admin_password" value="admin" class="form-control">
    </div>
    <?php
    }
    ?>
	<button type="submit" name="FourCMS" class="btn btn-primary btn-block">Dalej</button>
</form>