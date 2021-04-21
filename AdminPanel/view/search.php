<div class='content pt-3'>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Wyszukiwanie frazy "<?php echo $search ?>"</div>
            </div>
            <div class="card-body">
                <form method="GET">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Wyszukiwarka" value="<?php echo $search ?>" name="searchMenu">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <?php
                foreach($searchArray as $data){
                    if(strpos(' '.$data['tags'], $search) != false){
                        echo '<div class="post">
                            <a href="'.$data['link'].'">'.$data['name'].'</a>
                            <p>'.$data['description'].'</p>
                        </div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>