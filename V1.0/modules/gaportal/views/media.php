<div class="row">
    <div class="col-xs-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <?php echo heading('<a href="#form-media" data-toggle="modal"><i class="fa fa-plus"></i> Create New</a>', 3, 'class="box-title"') ?>
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
                                <?php echo img(IMAGE_PATH . 'avatar.png', TRUE, 'class="img-rounded img-responsive"') ?>
    <!--                                <img class="img-rounded img-responsive" src="http://placehold.it/150" alt="">-->
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


<div id="form-media" class="modal fade modal-primary">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo heading('New Media', 4, 'class="modal-title"') ?>
            </div>
            <div class="modal-body">
                <div class="AldiraChena"></div>
            </div>
<!--            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline">Save changes</button>
            </div>-->
        </div>
    </div>
</div>