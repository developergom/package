<div class="row">
    <div class="col-sm-12">
        <div class="box box-info">
            <div class="box-header">
                <?php echo heading('<i class="fa fa-pencil"></i> Form', 3, 'class="box-title"') ?>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        <?php echo form_open($action, 'class="dropzone needsclick dz-clickable" id="upload-widget" role="form"', isset($record) ? [$id => $record->{$id}] : []) ?>
                        <div class="fallback">
                            <?php echo form_upload('file') ?>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
                <br />
                <br />
            </div>
        </div>
    </div>
</div>

