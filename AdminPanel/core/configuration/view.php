<?php
return [
    'viewType' => [
        'prepend' => [
            'blankPage' => '<div class="content pt-2">',
            'page' => '<section class="content-header"><div class="container-fluid"><h1>{$pageTitle}</h1></div></section><div class="container-fluid">',
            'dialogbox' => '<div id="dialog_{$__randomGuiId}" title="{$title}">'
        ],
        'append' => [
            'blankPage' => '</div>',
            'page' => '</div>',
            'dialogbox' => '</div>
			<script>
				$( function() {
					$( "#dialog_{$__randomGuiId}" ).dialog({
						width: {$dialogBoxWidth|500}
					})
				} );
			</script>'
        ]
    ],
    'GuiHelperModel' => 'GuiHelper'
]
?>