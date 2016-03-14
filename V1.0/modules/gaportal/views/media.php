<div class="modal fade" id="media-detail">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo heading('Media Details', 4, 'class="modal-title"') ?>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-8 col-lg-8">
                            <img class="img-responsive" />
                        </div>
                        <div class="col-sm-8 col-lg-4">
                            <div class="media-info">
                                <div class="media-details"></div>
                                <div class="media-setting"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (in_array('d', $this->sso_new->curr_access)) { ?>
                <div class="modal-footer">
                    <?php echo anchor('#', '<i class="fa fa-trash"></i>' . nbs() . 'Delete', 'class="btn btn-danger pull-left" title="Delete media" data-toggle="modal" data-target="#confirm-delete"') ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="modal fade modal-primary" id="form-media">
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
                            <div class="gnUpload"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <?php
                if (in_array('c', $this->sso_new->curr_access))
                    echo heading('<a href="#form-media" data-toggle="modal"><i class="fa fa-plus"></i> Create New</a>', 3, 'class="box-title"');
                ?>
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
                    if (!empty($datagrid)) {
                        foreach ($datagrid as $index => $row) {
                            ?>
                            <div class="col-xs-4 col-md-2 col-lg-2">
                                <div class="thumbnail">
                                    <div class="caption">
                                        <?php
                                        echo heading(nbs(), 4);
                                        echo sprintf('<p>%s</p>', empty($row->media_title) ? ellipsize($row->media_filename, 13) : $row->media_title);
                                        if (in_array('d', $this->sso_new->curr_access)) {
                                            ?>
                                            <button class="btn btn-outline" rel="tooltip" title="<?php echo isset($row->media_title) ? $row->media_title : 'Detail' ?>" data-toggle="modal" data-target="#media-detail" data-media="<?php echo $row->media_id ?>"><i class="fa fa-search"></i></button>
                                        <?php } ?>
                                    </div>
                                    <?php
                                    if ($row->media_is_image) {
                                        $media_url = explode('/', $row->media_url);
                                        echo img($media_url[0] . '/' . $media_url[1] . '/thumbnails/' . $media_url[2], TRUE, 'class="img-responsive" alt="' . $row->media_alt_text . '"');
                                    } else {
                                        echo img(IMAGE_PATH . 'file-type/' . thumb_file_type($row->media_mime), TRUE, 'class="img-responsive"');
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="col-xs-12 col-md-12 col-lg-12">Empty data...</div>
                        <?php
                    }
                    ?>
                </div>
                <?php echo (isset($links)) ? $links : nbs() ?>
            </div>
        </div>
    </div>    
</div>


