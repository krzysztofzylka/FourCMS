<main role="main" class="container">
    <div class="row">
        <div class="col-md-12 blog-main">
			<?php foreach ($posts as $post) { ?>
                <div class="blog-post">
                    <h2 class="blog-post-title"><?php echo $post['title'] ?></h2>
                    <p class="blog-post-meta">Utworzono: <?php echo $post['date'] ?>
                        przez <a href="#"><?php echo $post['userName'] ?></a>
                    </p>
                    <p>
						<?php
						if (strlen($post['text']) > 500) {
							echo substr($post['text'], 0, 500) . '...';
						} else {
							echo $post['text'];
						} ?>
                    </p>
					<?php if ($post['url'] <> '') { ?>
                        <p><a href="<?php echo $post['url'] ?>">Czytaj dalej...</a></p>
					<?php } ?>
                </div>
			<?php } ?>
        </div>
    </div>
</main>