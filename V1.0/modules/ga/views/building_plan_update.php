<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <?php echo form_open('ga/building_plan/edit/', 'class="form-horizontal"', [$id => $record->{$id}]) ?>
            <div class="box-header">
                <?php echo heading('<i class="fa fa-pencil"></i> Update A Building Plan', 3, 'class="box-title"') ?>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1"><?php echo validation_errors() ?></div>
                    <div class="form-group has-feedback">
                        <?php echo form_label('Unit', NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                        <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                            <?php echo form_dropdown('building_plan_unit', $building_plan_unit, $record->building_plan_unit, 'class="form-control select2"') ?>
                        </div>
                        <?php //echo form_label(form_error('mnme'), NULL, array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3')) ?>
                    </div>

                    <div class="form-group has-feedback">
                        <?php echo form_label('Level (floor)', NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                        <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                            <?php echo form_dropdown('building_plan_level', $building_plan_level, $record->building_plan_level, 'class="form-control select2"') ?>
                        </div>
                        <?php //echo form_label(form_error('mnme'), NULL, array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3')) ?>
                    </div>

                    <div class="form-group has-feedback">
                        <?php echo form_label('Description', NULL, ['class' => 'col-xs-4 col-sm-4 col-md-2 col-lg-2 control-label']) ?>
                        <div class="col-xs-4 col-sm-4 col-md-7 col-lg-7">
                            <?php echo form_textarea('building_plan_description', $record->building_plan_description, 'class="form-control" placeholder="Building Plan Description" data-bv-notempty="true"') ?>
                        </div>
                        <?php //echo form_label(form_error('mnme'), NULL, array('class' => 'col-xs-4 col-sm-4 col-md-3 col-lg-3')) ?>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <?php echo form_label(form_checkbox('building_plan_status', 'active', (bool) ($record->building_plan_status == 'active')) . nbs() . 'Is Active ?') ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span> Save It</button>
                        <?php echo anchor('ga/building_plan/index', '<span class="fa fa-undo"></span> Back', 'class="btn btn-default"') ?>
                    </div>
                </div>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>