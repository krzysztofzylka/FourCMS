<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Panel główny</h1>
			</div>
		</div>
	</div>
</div>
<div class="content">
	<div class="container-fluid">
		<div class="row">
            <?php
            foreach(core::$library->global->read('mainPanel') as $path){
                if(is_file($path))
                    include($path);
            }
            ?>
        </div>
	</div>
</div>