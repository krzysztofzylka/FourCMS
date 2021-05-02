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
                        ' . $this->GuiHelper->ajaxLink([
				'type' => 'ajaxLink',
				'url' => 'widget/posUp/' . $widget['id'],
				'name' => '<i class="nav-icon fas fa-arrow-up"></i>'
			]) . $this->GuiHelper->ajaxLink([
				'type' => 'ajaxLink',
				'url' => 'widget/posDown/' . $widget['id'],
				'name' => '<i class="nav-icon fas fa-arrow-down"></i>'
			]) . $this->GuiHelper->ajaxLink([
				'type' => 'ajaxLink',
				'url' => 'widget/delete/' . $widget['id'],
				'name' => '<i class="fas fa-trash text-danger"></i>'
			]) . '
                    </td>
                </tr>';
	}
	?>
    </tbody>
</table>

<h3 class="card-title">Dodanie nowego widgetu do panelu</h3>
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
                    <td>' . $this->GuiHelper->ajaxLink([
				'type' => 'ajaxLink',
				'url' => 'widget/add/' . $widget['uniqueID'],
				'name' => '<i class="fas fa-plus"></i>'
			]) . '</td>
                </tr>';
	}
	?>
    </tbody>
</table>