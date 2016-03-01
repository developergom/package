<div class="row">
    <div class="col-sm-12">
        <div class="box box-info">
            <?php echo form_open_multipart($action, 'class="validate" role="form"', isset($record) ? ['post_id' => $record->post_id] : []) ?>
            <div class="box-header">
                <?php //echo heading('<i class="fa fa-pencil"></i> Form', 3, 'class="box-title"') ?>
            </div>
            <div class="box-body">
                <?php if (!empty(validation_errors())) { ?>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="alert alert-warning alert-dismissible">
                                <?php
                                echo form_button('button', '&times;', 'class="close" data-dismiss="alert" aria-hidden="true"');
                                echo heading('<i class="icon fa fa-info"></i> Alert!', 4);
                                echo validation_errors();
                                ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group has-feedback">
                                    <?php
                                    echo form_label('Post Title', 'post_title', ['class' => 'control-label']);
                                    echo form_input('post_title', isset($record->post_title) ? $record->post_title : set_value('post_title'), 'class="form-control" placeholder="Enter title here" data-bv-notempty="true"');
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <?php
                                if (isset($record)) {
                                    if ($record->post_status == 'draft') {
                                        echo form_button(['name' => 'post_status', 'value' => 'publish', 'type' => 'submit', 'class' => 'btn btn-primary', 'content' => '<span class="fa fa-globe"></span>&nbsp;Publish']);
                                        echo form_button(['name' => 'post_status', 'value' => 'save', 'type' => 'submit', 'class' => 'btn btn-info', 'content' => '<span class="fa fa-save"></span>&nbsp;Save']);
                                    } else {
                                        echo form_button(['name' => 'post_status', 'value' => 'save', 'type' => 'submit', 'class' => 'btn btn-primary', 'content' => '<span class="fa fa-save"></span>&nbsp;Save']);
                                        echo form_button(['name' => 'post_status', 'value' => 'draft', 'type' => 'submit', 'class' => 'btn btn-info', 'content' => '<span class="fa fa-inbox"></span>&nbsp;Save draft']);
                                    }
                                } else {
                                    echo form_button(['name' => 'post_status', 'value' => 'publish', 'type' => 'submit', 'class' => 'btn btn-primary', 'content' => '<span class="fa fa-globe"></span>&nbsp;Publish']);
                                    echo form_button(['name' => 'post_status', 'value' => 'draft', 'type' => 'submit', 'class' => 'btn btn-info', 'content' => '<span class="fa fa-inbox"></span>&nbsp;Save draft']);
                                }
                                echo anchor($base, '<span class="fa fa-undo"></span> Back', 'class="btn btn-default"')
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <?php
                                if (isset($record->post_slug)) {
                                    $url = 'portalga/article/read/' . $record->post_slug;
                                    echo sprintf('<p class="pull-right text-right">%s</p>', anchor($url, base_url($url), 'target="__blank"'));
                                }
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group has-feedback">
                                            <?php echo form_wysiwyg('post_content', isset($record->post_content) ? $record->post_content : set_value('post_content'), 'class="form-control" placeholder="Post Content" data-bv-notempty="true"') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <?php echo form_upload('post_featured_img[]', NULL, 'aria-describedby="helpBlock" multiple="multiple" class="filestyle" data-buttonText="&nbsp;Banner&nbsp;" data-iconName="fa fa-cloud-upload" data-input="false"') ?>
                                <span id="helpBlock" class="help-block">Max upload filesize <strong><?php echo byte_format(MAX_UPLOAD_SIZE) ?></strong></span>
                                <div class="clearfix">&nbsp;</div>
                                <div class="box box-default">
                                    <div class="box-header">
                                        <?php echo heading('Categories', 3, 'class="box-title"') ?>
                                        <div class="box-tools pull-right">
                                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <?php
                                        if (!empty($record->ptc)) {
                                            foreach ($record->ptc as $category)
                                                $ptc[] = $category->category_id;
                                        }
                                        echo form_multiselect('categories[]', $categories, isset($ptc) ? $ptc : set_select('categories[]'), 'class="form-control" data-placeholder="&nbsp;Select a Category" style="width: 100%;"');
                                        ?>
                                    </div>
                                </div>

                                <div class="box box-default">
                                    <div class="box-header">
                                        <?php echo heading('Tags', 3, 'class="box-title"') ?>
                                        <div class="box-tools pull-right">
                                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <?php
                                        if (!empty($record->ptt)) {
                                            foreach ($record->ptt as $tag)
                                                $ptt[$tag->tag_id] = $tags[$tag->tag_id];
                                        }
                                        echo form_textarea('tags', isset($ptt) ? implode(', ', $ptt) : set_value('tags'), 'class="form-control" placeholder="Separate by comma (,)"');
                                        ?>
                                    </div>
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