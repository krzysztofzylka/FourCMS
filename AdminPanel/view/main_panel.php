<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Panel główny</h1>
            </div>
            <div class="col-sm-6 text-right">
				<?php
				echo $this->GuiHelper->url(
					'widget/view',
					'Menadżer widgetów',
					'btn btn-primary btn-sm'
				);
				?>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
			<?php
			foreach ($userWidgetsArray as $widgetHtml) {
				echo $widgetHtml;
			}
			?>
        </div>
    </div>
</div>