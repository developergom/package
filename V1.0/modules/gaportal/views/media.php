<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <?php echo heading(anchor($base . '/create/', '<i class="fa fa-plus"></i> Create New'), 3, 'class="box-title"') ?>
                <div class="box-tools pull-right">
                    <?php echo form_open('#', ['method' => 'GET']) ?>
                    <div class="input-group input-group-sm">
                        <?php echo form_input('search', '', 'class="form-control pull-right" placeholder="Search..."') ?>
                        <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <?php
                    for ($thumb = 0; $thumb < 11; $thumb++) {
                        ?>
                        <div class="col-xs-6 col-md-3 col-lg-2">
                            <a class="thumbnail" href="#">
                                <img class="img-responsive" src="http://placehold.it/150" alt="">
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php echo (isset($links)) ? $links : nbs() ?>
            </div>
        </div>
    </div>    
</div>