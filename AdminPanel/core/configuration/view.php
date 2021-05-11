<?php
return [
	'viewType' => [
		'prepend' => [
			'hidden' => '',
			'blankPage' => '<div class="content pt-2">',
			'page' => '<section class="content-header"><div class="container-fluid"><h1>{$pageTitle}</h1></div></section><div class="container-fluid">',
			'dialogbox' => '<div id="dialog_{$__randomGuiId}" title="{$title}">'
		],
		'append' => [
			'hidden' => '',
			'blankPage' => '</div>',
			'page' => '</div>',
			'dialogbox' => '</div>
			<script>
				ajaxDialogbox({
					width: {$dialogBoxWidth|500}, 
					containerId: \'dialog_{$__randomGuiId}\',
					containerUrl: \'{$__controllerURL|}\',
					javascriptUrl: \'{$__javascriptURL|}\',
					controller: \'{$__controller|}\',
					data: \'{$__data}\'
				})
			</script>'
		]
	],
	'GuiHelperModel' => 'GuiHelper'
];