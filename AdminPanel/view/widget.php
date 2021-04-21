<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Widgety</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body p-0 table-responsive">
        <table class="table table-sm text-nowrap">
            <thead>
            <tr>
                <th style="width: 200px">Nazwa</th>
                <th style="width: 200px">Moduł</th>
                <th>Opis</th>
                <th style="width: 100px">Opcje</th>
            </tr>
            </thead>
            <tbody>
			<?php
			foreach ($userWidget as $widget) {
				echo '<tr>
                    <td>' . $widget['widgetData']['name'] . '</td>
                    <td>' . $widget['widgetData']['moduleName'] . '</td>
                    <td>' . $widget['widgetData']['description'] . '</td>
                    <td>
                        ' . $this->GuiHelper->ajaxLink(
                            'widget/posUp',
                            '<i class="nav-icon fas fa-arrow-up"></i>',
                            'posUp=' . $widget['id'],
                        )
                        . $this->GuiHelper->ajaxLink(
                            'widget/posDown',
                            '<i class="nav-icon fas fa-arrow-down"></i>',
                            'posDown=' . $widget['id'],
                        )
                        . $this->GuiHelper->ajaxLink(
                            'widget/delete',
                            '<i class="fas fa-trash text-danger"></i>',
                            'delete=' . $widget['id'],
                        )
                        . '
                    </td>
                </tr>';
			}
			?>
            </tbody>
        </table>
    </div>
</div>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Dodanie nowego widgetu do panelu</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body p-0 table-responsive">
        <table class="table table-sm text-nowrap">
            <thead>
            <tr>
                <th style="width: 200px">Nazwa</th>
                <th>Moduł</th>
                <th>Opis</th>
                <th style="width: 100px">Opcje</th>
            </tr>
            </thead>
            <tbody>
			<?php
			foreach ($widgetList as $widget) {
				echo '<tr>
                    <td>' . $widget['name'] . '</td>
                    <td>' . $widget['moduleName'] . '</td>
                    <td>' . $widget['description'] . '</td>
                    <td>' . $this->GuiHelper->ajaxLink(
                            'widget/add',
                            '<i class="fas fa-plus"></i>',
                            'add=' . $widget['uniqueID'],
                        )
                    . '</td>
                </tr>';
			}
			?>
            </tbody>
        </table>
    </div>
</div>