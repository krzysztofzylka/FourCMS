<div class='content pt-3'>
    <div class="container-fluid">
        <div class="card card-info card-outline">
            <div class="card-header">
                Instalacja / Aktualizacja modułu z pliku
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="input-group mt-3">
                        <div class="custom-file">
                            <input name="file" type="file" class="custom-file-input">
                            <label class="custom-file-label">Wybierz moduł</label>
                        </div>
                    </div>
                    <small class="text-disabled">Maksymalny rozmiar pliku: <?php echo ini_get('upload_max_filesize') ?></small>
                </div>
                <div class="card-footer">
                    <input type="submit" value="Wgraj moduł" class="btn btn-primary" name="install" />
                    <a href="module-clearCache.html" class="btn btn-danger float-right">Wyczyść pliki tymczasowe</a>
                </div>
            </form>
        </div>

        <div class="card card-info card-outline">
            <div class="card-header">
                Moduły
            </div>
            <div class="card-body p-0">
                <table class="table">
                    <?php
                    foreach (core::$library->module->moduleList(true) as $list) {
                        if (!isset($list['config']['fourCMS'])) continue;
                        echo '<tr>
                            <td>
                                ' . (isset($list['config']['name']) ? $list['config']['name'] : $list['name']) . ' <a data-toggle="collapse" href="#collapseModule' . $list['name'] . '" role="button" aria-expanded="false" aria-controls="collapseModule' . $list['name'] . '"><i class="fas fa-info-circle"></i></a> <br />
                                <small class="text-muted">' . (isset($list['config']['description']) ? $list['config']['description'] : '') . '</small>
                                <div class="collapse" id="collapseModule' . $list['name'] . '">
                                    <span class="text-primary font-weight-bold">Dodatkowe informacje</span><br />
                                    UniqueID: <span class="text-info">' . $list['config']['uniqueID'] . '</span>
                                </div>
                            </td>
                            <td style="width: 150px">
                                Wersja: <small class="badge badge-info">' . $list['config']['version'] . '</small>
                            </td>
                        </tr>';
                    }
                    ?>
                </table>
            </div>
        </div>

        <div class="card card-info card-outline">
            <div class="card-header">
                Moduły dodatkowe
            </div>
            <div class="card-body p-0">
                <table class="table table-sm">
                    <?php
                    foreach (core::$library->module->moduleList(true) as $list) {
                        if (isset($list['config']['fourCMS'])) continue;
                        echo '<tr>
                            <td>
                                ' . (isset($list['config']['name']) ? $list['config']['name'] : $list['name']) . ' <a data-toggle="collapse" href="#collapseModule' . $list['name'] . '" role="button" aria-expanded="false" aria-controls="collapseModule' . $list['name'] . '"><i class="fas fa-info-circle"></i></a> <br />
                                <small class="text-muted">' . (isset($list['config']['description']) ? $list['config']['description'] : '') . '</small>
                                <div class="collapse" id="collapseModule' . $list['name'] . '">
                                    <span class="text-primary font-weight-bold">Dodatkowe informacje</span><br />
                                    UniqueID: <span class="text-info">' . $list['config']['uniqueID'] . '</span>
                                </div>
                            </td>
                            <td style="width: 150px">
                                Wersja: <small class="badge badge-info">' . $list['config']['version'] . '</small>
                            </td>
                        </tr>';
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    bsCustomFileInput.init()
</script>