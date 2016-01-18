<div class="row">
    <div class="col-sm-12">
        <div class="box box-info">
            <?php echo form_open($action, 'class="form-horizontal"', $key) ?>
            <div class="box-header">
                <?php echo heading('<i class="fa fa-pencil"></i> Form', 3, 'class="box-title"') ?>
            </div>
            <div class="box-body">
                <div class="row">
                    <!--<div class="col-md-10 col-md-offset-1"><?php //echo validation_errors()       ?></div>-->
                    
                </div>
            </div>
            <div class="box-footer clearfix">
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Save It</button>
                        <?php echo anchor($this->setting->uri_string(), '<span class="fa fa-undo"></span> Back', 'class="btn btn-default"') ?>
                    </div>
                </div>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>