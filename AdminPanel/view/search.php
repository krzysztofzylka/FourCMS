<?php
foreach ($searchArray as $data) {
	if ($search === " " || strpos(' ' . $data['tags'], $search) !== false) {
		echo '<div class="post">
			<a href="' . $data['link'] . '">' . $data['name'] . '</a>
            <p>' . $data['description'] . '</p>
        </div>';
	}
}