<div class="content pt-3">
	<div class="container-fluid">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Biblioteki</h3>
			</div>
			<div class="card-body p-0">
				<table class="table table-sm">
					<thead>
						<tr>
							<th>Nazwa</th>
							<th style="width: 40px">Wersja</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach($libraryList as $library){ //file loop
							echo '<tr>
								<td>'.$library['name'].'</td><td>'.$library['version'].'</td>
							</tr>';
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">API</h3>
			</div>
			<div class="card-body p-0">
				<table class="table table-sm">
					<thead>
						<tr>
							<th>Nazwa</th>
							<th style="width: 40px">Wersja</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach($apiList as $api){
							echo '<tr>
								<td>'.$api['name'].'</td><td>'.$api['version'].'</td>
							</tr>';
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
