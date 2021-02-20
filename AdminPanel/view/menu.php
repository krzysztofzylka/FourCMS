<div class='content pt-3'>
	<div class="container-fluid">
		<div class='card'>
			<div class='card-header'>
				<div class="float-left">Menu</div>
				<div class="float-right">
					<a href="<?php echo core::$model['link']->generate(['page', 'type' => 'add']); ?>"><i class="nav-icon fas fa-plus"></i></a>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="card-body p-0 table-responsive">
				<table class="table table-sm text-nowrap">
					<thead>
						<tr>
							<th style="width: 300px">Nazwa</th>
							<th>Link</th>
							<th style="width: 50px">Pozycja</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$menuList = core::$model['menu']->topMenu_readDBArray();
						foreach ($menuList as $item) {
							$item['name'] = strlen($item['name']) == 0 ? '--- Brak nazwy ---' : $item['name'];
							echo '<tr>
								<td><a href="' . core::$model['link']->generate(['page', 'id' => $item['id'], 'type' => 'edit']) . '">' . $item['name'] . '</a></td>
								<td>' . core::$model['interpreter']->showPrettyText($item['link']) . '</td>
								<td>
								<a href="' . core::$model['link']->generate(['page', 'id' => $item['id'], 'type' => 'positionUp']) . '"><i class="nav-icon fas fa-arrow-up"></i></a>
								<a href="' . core::$model['link']->generate(['page', 'id' => $item['id'], 'type' => 'positionDown']) . '"><i class="nav-icon fas fa-arrow-down"></i></a>
								</td>
							</tr>';
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>