<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <?php echo form_open('ga/item_type/edit/', 'class="form-horizontal"', ['item_type_id' => $item_type->item_type_id]) ?>
            <div class="box-header">
                <?php echo heading('<i class="fa fa-pencil"></i> Edit An Item Type', 3, 'class="box-title"') ?>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1"><?php echo validation_errors() ?></div>

                    <div class="form-group has-feedback">
                        <?php echo form_label('Name', NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                        <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                            <?php echo form_input('item_type_name', $item_type->item_type_name, 'class="form-control" placeholder="Item Type Name" data-bv-notempty="true"') ?>
                        </div>
                        <?php //echo form_label(form_error('mnme'), NULL, array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3')) ?>
                    </div>
                    
                    <div class="form-group has-feedback">
                        <?php echo form_label('Description', NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                        <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                            <?php echo form_textarea('item_type_desc', $item_type->item_type_desc, 'class="form-control" placeholder="Item Type Description" data-bv-notempty="true"') ?>
                        </div>
                        <?php //echo form_label(form_error('mnme'), NULL, array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3')) ?>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <?php echo form_label(form_checkbox('item_type_status', 'active', (bool) ($item_type->item_type_status == 'active')) . ' Is Active ?') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Save It</button>
                        <?php echo anchor('ga/item_type/index', '<span class="fa fa-undo"></span> Back', 'class="btn btn-default"') ?>
                    </div>
                </div>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>