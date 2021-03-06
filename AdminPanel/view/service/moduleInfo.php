<?php
$name = htmlspecialchars($_GET['name']);
$path = core::$path['module'] . $name . '/';
if (!file_exists($path . 'config.php'))
	header('location: 404.html');
$config = include($path . 'config.php');
?>
<div class="content-header">
	<div class="container-fluid">
		<h1 class="m-0 text-dark">Informacje o module <?php echo $name ?></h1>
	</div>
</div>
<div class="container-fluid p-3">
	<div class="row">
		<div class="col-md-2">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Wersja</h3>
				</div>
				<div class="card-body">
					<?php
					echo $config['version'];
					?>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">UniqueID</h3>
				</div>
				<div class="card-body">
					<?php
					echo $config['uniqueID'];
					?>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Rozmiar modułu</h3>
				</div>
				<div class="card-body">
					<?php
					echo core::$library->memory->formatBytes(core::$library->file->dirSize($path));
					?>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">MD5 Modułu</h3>
				</div>
				<div class="card-body">
					<?php
					echo core::$library->crypt->md5_dir($path);
					?>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Panel administracyjny</h3>
				</div>
				<div class="card-body">
					<?php
					echo isset($config['adminPanel']) ? '<a href="FrameworkModuleAP-' . $name . '.html"><button type="button" class="btn btn-primary btn-sm">Przejdź do panelu</button></a>' : 'NIE';
					?>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Debug</h3>
				</div>
				<div class="card-body">
					<a href="FrameworkModuleDebug-<?php echo $name ?>.html">Debug</a>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Konfiguracja</h3>
				</div>
				<div class="card-body" style="overflow: auto">
					<?php
					core::$library->debug->print_r($config);
					?>
				</div>
			</div>
		</div>
	</div>
</div>