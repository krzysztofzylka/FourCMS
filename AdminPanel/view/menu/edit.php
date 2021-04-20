<div class="container-fluid p-3">
    <div class='card'>
        <div class='card-header'>
			<?php echo $add ? 'Dodanie nowej pozycji menu' : 'Edycja menu' ?>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="form-group was-validated">
                    <label>Nazwa</label>
                    <input type="text" minlength="3" class="form-control" name="name" placeholder="Nazwa linka" value="<?php echo $add?'':$menu['name'] ?>" required>
                    <div class="invalid-feedback">Tytuł musi posiadać przynajmniej 3 znaki</div>
                </div>
                <div class="form-group">
                    <label>Link</label>
					<?php $this->GuiHelper->bootstrapFormLinkGenerator($add?'':$menu['link']); ?>
                </div>
                <button class="btn btn-primary"><?php echo $add ? 'Dodaj' : 'Zapisz' ?></button>
				<?php
				if (!$add) {
					echo '<a href="menuDelete-'.$menu['id'].'.html" class="btn btn-danger" onclick="return confirm(\'Czy na pewno chcesz usunąć ten element?\nTego nie da się cofnąć.\');">Usuń</a>';
				}
				?>
            </form>
        </div>
    </div>
</div>