<?php
$module = htmlspecialchars($_GET['modul']);
$config = core::$library->module->getConfig($module, true);
?>
<div class="content-header">
	<div class="container-fluid">
		
		<?php echo isset($config['adminPanel']['title'])?($config['adminPanel']['title']==false?'':"<h1 class='m-0 text-dark'>".$config['adminPanel']['title'].'</h1>'):"<h1 class='m-0 text-dark'>Panel administracyjny modułu ".$module."</h1>" ?>
		</h1>
	</div>
</div>
<div class="content">
	<div class="container-fluid">
		<?php
		core::$library->module->loadAdminPanel($module);
		if(core::$error[0] > -1){
			echo '<div class="card card-danger">
				<div class="card-header">
					<h3 class="card-title">Błąd</h3>
				</div>
				<div class="card-body">
					'.core::$error[1].'
				</div>
			</div>';
		}
		?>
	</div>
</div>