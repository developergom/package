<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <?php echo heading('<a href="#form-media" data-toggle="modal"><i class="fa fa-plus"></i> Create New</a>', 3, 'class="box-title"') ?>
                <?php //echo heading(anchor($base . '/create', '<i class="fa fa-plus"></i> Create New'), 3, 'class="box-title"') ?>
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
                    foreach ($datagrid as $index => $row) {
                        $mimes = explode('/', $row->media_mime);
                        ?>
                        <div class="col-xs-6 col-md-3 col-lg-2">
                            <div class="thumbnail">
                                <div class="caption">
                                    <?php
                                    echo heading(nbs(), 4);
                                    echo sprintf('<p>%s</p>', ellipsize($row->media_description, 13));
                                    ?>
                                    <p>
                                        <?php echo anchor('#', '<i class="fa fa-search"></i>&nbsp;Details', 'class="label label-danger" rel="tooltip" title="Zoom"') ?>
                                    </p>
                                </div>
                                <?php
                                if (in_array('image', $mimes)) {
                                    $path = explode('/', $row->media_path);
                                    echo img('./' . $path[1] . '/' . $path[2] . '/thumbnails/' . $path[3], FALSE, 'class="img-responsive"');
                                } else if (str_pos($mimes[1], ['spreadsheet', 'ms-excel'])) {
                                    echo img(IMAGE_PATH . 'file-type/file-excel-o.png', FALSE, 'class="img-responsive"');
                                } else if (str_pos($mimes[1], ['wordprocessingml', 'ms-word'])) {
                                    echo img(IMAGE_PATH . 'file-type/file-word-o.png', FALSE, 'class="img-responsive"');
                                } else if (str_pos($mimes[1], ['presentationml', 'ms-powerpoint'])) {
                                    echo img(IMAGE_PATH . 'file-type/file-powerpoint-o.png', FALSE, 'class="img-responsive"');
                                } else if (str_pos($mimes[1], ['zip', 'rar'])) {
                                    echo img(IMAGE_PATH . 'file-type/file-zip-o.png', FALSE, 'class="img-responsive"');
                                } else if (in_array('plain', $mimes)) {
                                    echo img(IMAGE_PATH . 'file-type/file-text-o.png', FALSE, 'class="img-responsive"');
                                } else if (in_array('pdf', $mimes)) {
                                    echo img(IMAGE_PATH . 'file-type/file-pdf-o.png', FALSE, 'class="img-responsive"');
                                }
                                ?>
                            </div>
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
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="AldiraChena"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>