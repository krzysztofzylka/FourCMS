<main role="main" class="container">
    <div class="row">
        <div class="col-md-12 blog-main">
            <div class="blog-post">
                <h2 class="blog-post-title"><?php echo $post['title'] ?></h2>
                <?php if ($post['showMetaData'] == 1) { ?>
                    <p class="blog-post-meta">Utworzono: <?php echo nl2br($post['date']) ?>
                        <?php if ($post['user'] <> '') { ?>
                            przez <a href="#"><?php echo nl2br($post['userName']) ?></a>
                        <?php } ?>
                    </p>
                <?php } ?>
                <p>
                <?php echo nl2br($post['text']) ?>
            </div>
        </div>
    </div>
</main>