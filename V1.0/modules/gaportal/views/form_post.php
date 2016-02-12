<div class="row">
    <div class="col-sm-12">
        <div class="box box-info">
            <?php echo form_open($action, 'class="validate" role="form"', isset($record) ? [$id => $record->{$id}] : []) ?>
            <div class="box-header">
                <?php echo heading('<i class="fa fa-pencil"></i> Form', 3, 'class="box-title"') ?>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <?php if (!empty(validation_errors())) { ?>
                            <div class="alert alert-warning alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-info"></i> Alert!</h4>
                                <?php echo validation_errors() ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-9">
                                <div class="form-group has-feedback">
                                    <?php
                                    //debug($record);
                                    ?>
                                    <?php echo form_input('post_title', isset($record->post_title) ? $record->post_title : NULL, 'class="form-control" placeholder="Enter title here" data-bv-notempty="true"') ?>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <?php
                                echo form_button(['name' => 'post_status', 'value' => 'publish', 'type' => 'submit', 'class' => 'btn btn-primary', 'content' => '<span class="fa fa-globe"></span>&nbsp;Publish']);
                                echo form_button(['name' => 'post_status', 'value' => 'draft', 'type' => 'submit', 'class' => 'btn btn-info', 'content' => '<span class="fa fa-inbox"></span>&nbsp;Save draft']);
                                echo anchor($base, '<span class="fa fa-undo"></span>', 'class="btn btn-default"')
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-9">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <?php echo form_button('modal', '<i class="fa fa-cloud-upload"></i>' . nbs(2) . 'Add Media', 'class="btn bg-olive" data-toggle="modal" data-target="#myModal"') ?>
                                    </div>
                                    <div class="col-xs-8">
                                        <?php
                                        if (isset($record->post_slug))
                                            echo sprintf('<p class="pull-right">%s</p>', anchor('portalga/article/' . $record->post_slug, base_url('portalga/article/' . $record->post_slug)));
                                        ?>
                                    </div>
                                </div>
                                <div class="clearfix">&nbsp;</div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group has-feedback">
                                            <?php
                                            echo form_wysiwyg('post_content', isset($record->post_content) ? $record->post_content : NULL, 'class="form-control" placeholder="Post Content" data-bv-notempty="true"');
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group has-feedback">
                                    <?php
                                    $ptc = [];
                                    if (!empty($record->ptc)) {
                                        foreach ($record->ptc as $category)
                                            $ptc[] = $category->category_id;
                                    }

                                    echo form_label('Categories', NULL, ['class' => 'control-label']);
                                    echo form_multiselect('categories[]', $categories, $ptc, 'class="form-control" data-placeholder="Select a Category" style="width: 100%;"');
                                    ?>
                                </div>
                                <div class="form-group has-feedback">
                                    <?php
                                    $ptt = [];
                                    if (!empty($record->ptt)) {
                                        foreach ($record->ptt as $tag)
                                            $ptt[$tag->tag_id] = $tags[$tag->tag_id];
                                    }
                                    echo form_label('Tags', NULL, ['class' => 'control-label']);
                                    echo form_textarea('tags', implode(', ', $ptt), 'class="form-control" placeholder="Separate by comma (,)"');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo heading(nbs(), 5, 'class="modal-title" id="myModalLabel"') ?>
            </div>
            <div class="modal-body">
                <!-- Custom Tabs (Pulled to the right) -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li><a href="#insert_from_url" data-toggle="tab">Insert from URL</a></li>
                        <li><a href="#upload_file" data-toggle="tab">Upload file</a></li>
                        <li class="active"><a href="#gallery" data-toggle="tab">Gallery</a></li>
                        <li class="pull-left header"><i class="fa fa-file"></i> Insert Media</li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="gallery"></div>
                        <div class="tab-pane" id="upload_file">
                            <?php
                            echo form_open('gaportal/media/upload');
                            echo form_upload('media', '', 'class="form-control filestyle" data-input="false" data-iconName="fa fa-inbox" data-buttonText="&nbsp;Find file"');
                            echo form_close();
                            ?>
                        </div>
                        <div class="tab-pane" id="insert_from_url">
                            <?php echo form_input('media', 'http://', 'class="form-control"') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Insert into post</button>
            </div>
        </div>
    </div>
</div>