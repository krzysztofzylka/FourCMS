<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Panel główny</h1>
			</div>
			<div class="col-sm-6 text-right">
				<a href="widget.html" class="btn btn-primary btn-sm">Zarządzaj widgetami</a>
			</div>
		</div>
	</div>
</div>
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<?php
			foreach($userWidgetsArray as $widgetHtml) { 
				echo $widgetHtml;
			}
			?>
		</div>
	</div>
</div>