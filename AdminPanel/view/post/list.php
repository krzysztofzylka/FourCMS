<div class='content pt-3'>
    <div class="container-fluid">
        <div class='card'>
            <div class='card-header'>
                <div class="card-title">Posty</div>
                <div class="card-tools">
                    <a href="postAdd.html">
                        <button type="button" class="btn btn-tool" data-toggle="tooltip" data-placement="left" title="Dodaj posta"><i class="fas fa-plus"></i></button>
                    </a>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="dataTable table table-hover table-sm text-nowrap">
                    <thead>
                    <tr>
                        <th style="min-width: 300px;">Tytuł</th>
                        <th style="width: 300px">Data utworzenia</th>
                        <th style="width: 200px">Utworzone przez</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
					foreach ($postList as $post) {
						if (strlen($post['title']) < 1)
							$item['title'] = '- Brak tytułu -';
						echo '<tr>
								<td>
									<a href="postEdit-' . $post['id'] . '.html">' . $post['title'] . '</a>
									' . (boolval($post['hidden']) ? '<i class="far fa-eye-slash" data-toggle="tooltip" data-original-title="Post posiada status ukryty"></i>' : '') . ' 
									' . ($post['type'] <> 'post' ? '<i class="fas fa-cubes" data-toggle="tooltip" data-original-title="Post posiada inny typ"></i>' : '') . '
								</td>
								<td>
									' . $post['date'] . '
								</td>
								<td>
									<a href="user-' . $post['user'] . '.html">' . $post['userName'] . '</a>
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