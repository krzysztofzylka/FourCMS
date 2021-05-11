<?php
return new class() {
	public function contentAlert(
		string $value,
		string $alertType = 'success',
		string $title = null
	) : void {
		core::setError();

		echo '<div class="content pt-2">
            <div class="alert alert-' . $alertType . '">
                ' . (($title !== null) ? '<h4 class="alert-heading">' . $title . '</h4>' : '') . '
                ' . $value . '
            </div>
        </div>';
	}

	public function alert(
		string $value,
		string $alertType = 'success',
		string $title = null
	) : void {
		core::setError();

		echo '<div class="alert alert-' . $alertType . '">
            ' . (is_null($title) ? '' : '<h4 class="alert-heading">' . $title . '</h4>') . $value . '
        </div>';
	}

	public function bootstrapFormLinkGenerator(
		$actual = '',
		$showList = ['post', 'module', 'link'],
		$inputName = 'link'
	) {
		core::setError();

		$explode = ($actual === '') ? ['', ''] : (explode('-', $actual, 2));

		//HTML
		echo '<div class="form-row">
			<div class="form-group col-md-4">
				<select class="form-control" id="linkGenerator_main">
					<option selected>Wybierz</option>
					' . (!is_bool(array_search('post', $showList)) ? '<option value="post">Post</option>' : '') . '
					' . (!is_bool(array_search('module', $showList)) ? '<option value="module">Moduł</option>' : '') . '
					' . (!is_bool(array_search('link', $showList)) ? '<option value="link">Link</option>' : '') . '
					' . (!is_bool(array_search('controller', $showList)) ? '<option value="controller">Kontroler</option>' : '') . '
				</select>
			</div>
			<div class="form-group col-md-8">
				<select class="custom-select" id="linkGenerator_slave"><option selected>#</option></select>
				<input type="text" class="form-control" id="linkGenerator_slave2" placeholder="Link" value="#">
				<input type="text" id="link" name="' . $inputName . '" value="#"/>
			</div>
		</div>';

		core::loadModel('Post');
		core::loadModel('Module');

		//JavaScript
		echo '<script>
		let auto1 = "' . ($explode[0] ?? 'Wybierz') . '";
        let auto2 = "' . (isset($explode[1]) ? $explode[0] . '-' . $explode[1] : '') . '";
		let controller_list = [';
		foreach (array_diff(scandir('../controller/'), ['.', '..', '.htaccess']) as $item) {
			echo '"' . str_replace('.php', '', $item) . '", ';
		}
		echo '];
		var post_list = [["#", "--- Pusty ---"],';
		foreach (core::$model->Post->list() as $item) {
			echo '["post-' . $item['id'] . '.html", "' . $item['title'] . '"],';
		}
		echo '];
        var module_list = [';
		foreach (core::$model->Module->moduleDisplayPageList() as $item) {
			echo '["module-' . $item['name'] . '.html", "' . $item['title'] . '"],';
		}
		echo '];
		</script>';

		//load javascript script
		echo file_exists('script/linkGenerator.js') ? '<script src="script/linkGenerator.js"></script>' : '<script src="../script/linkGenerator.js"></script>';
	}

	public function url(
		string $url,
		string $name,
		string $class = ''
	) {
		return '<a href="#" class="' . $class . '" ajax="' . $url . '">' . $name . '</a>';
	}

	public function toast(
		string $text,
		string $type = 'info'
	) {
		echo '<script>
			toastr.' . $type . '("' . $text . '");
		</script>';
	}
};