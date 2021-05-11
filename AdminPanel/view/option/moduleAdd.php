<div class='content pt-3'>
    <div class="container-fluid">
        <div class="card card-info card-outline">
            <div class="card-header">
                Moduły dostępne do pobrania
            </div>
            <div class="card-body p-0">
                <table class="table">
					<?php
					if (is_array($APIData)) {
						foreach ($APIData as $uniqueID => $data) {
							$moduleLocalData = $data['moduleLocalData'];
							$checkVersion = $data['checkVersion'];
							echo '<tr>
                                <td>
                                    ' . $data['name'] . ' <a data-toggle="collapse" href="#collapseModule' . $data['name'] . '" role="button" aria-expanded="false" aria-controls="collapseModule' . $data['name'] . '"><i class="fas fa-info-circle"></i></a> <br />
                                    <small class="text-muted">' . base64_decode($data['description']) . '</small>
                                    <div class="collapse" id="collapseModule' . $data['name'] . '">
                                        <span class="text-primary font-weight-bold">Dodatkowe informacje</span><br />
                                        UniqueID: <span class="text-info">' . $uniqueID . '</span><br />
                                        Pobrań: <span class="text-success">' . $data['downloadCount'] . '</span>
                                    </div>
                                </td>
                                <td style="width: 150px">
                                    Wersja: <small class="badge badge-info">' . $data['version'] . '</small>
                                    <a href="module-add.html?installFromServer=' . $data['file']['filePath'] . '" class="btn btn-xs btn-' . ($checkVersion ? 'secondary' : ($moduleLocalData == false ? 'primary' : 'success')) . ' btn-block ' . ((is_null($data['file']) || $checkVersion) ? 'disabled' : '') . '">' . ($checkVersion ? 'Zainstalowane' : ($moduleLocalData == false ? 'Instaluj' : 'Aktualizuj')) . '</a>
                                </td>
                            </tr>';
						}
					}
					?>
                </table>
            </div>
        </div>
    </div>
</div>
<?php core::setError() ?>