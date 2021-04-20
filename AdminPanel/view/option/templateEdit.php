<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edytor szablonów</h1>
            </div>
        </div>
    </div>
</div>

<div class='content'>
    <div class="container-fluid">
        <div class='card'>
            <div class='card-header'>
                Inforamcje
            </div>
            <div class="card-body">
                Nazwa szablonu: <?php echo $templateName ?><br />
                Folder szablonu: <?php echo $templateDir ?><br />
                Rozmiar szablonu: <?php echo $templateDirSize ?><br />
                Plików: <?php echo $templateDirFileCount ?>
            </div>
        </div>

        <div class='card'>
            <div class='card-header'>
                Wybór pliku do edycji
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label>Wybór pliku</label>
                        <select class="custom-select mb-3" name="file">
                            <?php
                            foreach ($templateDirFileList as $item) {
                                echo '<option value="' . $item . '">' . $item . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <button class="btn btn-primary">Wybierz plik do edycji</button>
                </form>
            </div>
        </div>

        <div class='card'>
            <div class='card-header'>
                Utworzenie pliku
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label>Nazwa pliku</label>
                        <input type="text" class="form-control" name="createFile" placeholder="Nazwa pliku" value="">
                    </div>
                    <button class="btn btn-primary">Utwórz plik</button>
                </form>
            </div>
        </div>

        <?php if (isset($fileEditName)) { ?>
            <div class='card'>
                <div class='card-header'>
                    Edycja pliku <b><?php echo $fileEditName ?></b>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input style="display: none;" type="text" class="form-control" name="file" value="<?php echo $fileEditName ?>">
                        <div class="form-group">
                            <textarea class="form-control" rows="25" name="fileData"><?php echo $fileEditContent; ?></textarea>
                        </div>
                        <button class="btn btn-primary">Zapis pliku</button>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
</div>