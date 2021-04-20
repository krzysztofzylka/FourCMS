<div class='content pt-3'>
	<div class="container-fluid">
		<form method="POST">
			<div class="row">
				<div class="col-md-8">
					<div class='card card-primary card-outline'>
						<div class='card-header'>
							<?php echo $addPost ? 'Dodanie posta' : 'Edycja posta' ?>
						</div>
						<div class='card-body'>
							<textarea id="textarea" name="text" placeholder="Tutaj umieść tekst" style="width: 100%; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $addPost ? '' : $post['text'] ?></textarea>
							<button class="btn btn-primary"><?php echo $addPost ? 'Dodaj' : 'Zapisz' ?></button>
							<?php if (!$addPost) echo '<a href="postDelete-' . $post['id'] . '.html" class="btn btn-danger" onclick="return confirm(\'Czy na pewno chcesz usunąć ten element?\nTego nie da się cofnąć.\');">Usuń</a>'; ?>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class='card card-secondary card-outline'>
						<div class='card-header'>
							<div class='card-title'>Dodatkowe opcje</div>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Ukryj/Pokaż"><i class="fas fa-minus"></i></button>
							</div>
						</div>
						<div class='card-body'>
							<div class="form-group was-validated">
								<label>Nazwa</label>
								<input type="text" minlength="3" class="form-control" name="title" placeholder="Tytuł posta" value="<?php echo $addPost ? '' : $post['title'] ?>" required>
								<div class="invalid-feedback">Tytuł musi posiadać przynajmniej 3 znaki</div>
							</div>
							<div class="form-group">
								<div class="custom-control custom-switch">
									<input type="checkbox" class="custom-control-input" name="hidden" id="hiddenPostCheckbox" <?php echo $addPost ? '' : (boolval($post['hidden']) ? 'checked' : '') ?>>
									<label class="custom-control-label" for="hiddenPostCheckbox">Ukryj post</label>
								</div>
							</div>
							<div class="form-group">
								<div class="custom-control custom-switch">
									<input type="checkbox" class="custom-control-input" name="showMetadata" id="showMetadataCheckbox" <?php echo $addPost ? '' : (boolval($post['showMetaData']) ? 'checked' : '') ?>>
									<label class="custom-control-label" for="showMetadataCheckbox">Wyświetl metadane</label>
									<small class="form-text text-muted">Zaznaczenie opcji umożliwia wyłączenie wyświetlenia użytkownika oraz daty dodania posta</small>
								</div>
							</div>
							<div class="form-group">
								<label>Odnośnik do posta</label>
								<div class="custom-control custom-switch">
									<input type="checkbox" class="custom-control-input" id="postURLAutoCheckbox" <?php echo $addPost ? 'checked' : ($post['url'] == 'auto' ? 'checked' : '') ?>>
									<label class="custom-control-label" for="postURLAutoCheckbox">Automatycznie generuj link</label>
								</div>
								<div id='postURLAutoDiv' style='<?php echo $addPost ? 'display: none;' : ($post['url'] == 'auto' ? 'display: none;' : '') ?>'>
									<input type="text" class="form-control" id="postURLAutoInput" name="url" placeholder="Link" value="<?php echo $addPost ? 'auto' : $post['url'] ?>">
									<small class="form-text text-muted">wartość <b>auto</b> oznacza automatyczne generowanie odnośnika do posta</small>
								</div>
							</div>
							<div class="form-group">
								<label>Zmiana typu posta</label>
								<div class="custom-control custom-switch">
									<input type="checkbox" class="custom-control-input" name="type_default" id="postTypeCheckbox" <?php echo ($addPost or $post['type'] == 'post') ? 'checked' : '' ?>>
									<label class="custom-control-label" for="postTypeCheckbox">Wyświetlaj jako treść</label>
								</div>
								<div id='postTypeForm' style="<?php echo ($addPost or $post['type'] == 'post') ? 'display: none;' : '' ?>">
									<?php echo $this->GuiHelper->bootstrapFormLinkGenerator($addPost ? '' : $post['type'], ['module'], 'type', 'post') ?>
								</div>
								<small class="form-text text-muted">Ta opcja pozwala zmienić rodzaju posta z tekstu na treść z wybranego modułu</small>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script src='script/editPost.js'></script>